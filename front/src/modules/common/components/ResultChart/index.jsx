import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    chart: {
        margin: '30px 30px 45px',
        position: 'relative',
    },
    dash: {
        backgroundColor: theme.COLOR_ACCENT_COLD,
        bottom: -23,
        position: 'absolute',
        top: -5,
        width: 1,
    },
    item: {
        fontSize: 14,
    },
    pointer: {
        bottom: 0,
        position: 'absolute',
        transition: 'left 1s ease-in-out',
        top: 0,
        width: 1,
    },
    resultLeft: {
        fontSize: 14,
        position: 'absolute',
        right: 'calc(50% + 5px)',
        textAlign: 'right',
        top: 'calc(100% + 5px)',
        whiteSpace: 'nowrap',
    },
    resultRight: {
        fontSize: 14,
        left: 'calc(50% + 5px)',
        position: 'absolute',
        textAlign: 'left',
        top: 'calc(100% + 5px)',
        whiteSpace: 'nowrap',
    },
    scale: {
        background: `linear-gradient(90deg, ${theme.COLOR_ACCENT_WARM}, ${theme.COLOR_ACCENT_COOL})`,
        display: 'flex',
        justifyContent: 'space-between',
        padding: 10,
    },
});

class ResultChart extends React.Component {
    state = {
        duration: 0,
        percent: 50,
        start: false,
        total: 0,
        value: 50,
    };

    delay = 500;

    duration = 1000;

    step = 20;

    calculateValue = () => {
        this.setState((prevState) => {
            const {
                duration: prevDuration,
                percent: prevPercent,
                total: prevTotal,
                value: prevValue,
            } = prevState;

            if (prevDuration < this.duration) {
                return ({
                    duration: prevDuration + this.step,
                    value: prevTotal ? prevValue - prevPercent / (this.duration / this.step) / 2 : prevValue,
                });
            }
        });
    };

    animatePointer = () => {
        const {data} = this.props;
        const dataValues = Object.values(data);
        const total = dataValues.reduce((acc, {ratio}) => acc + ratio, 0);
        const percent = total ? 100 * dataValues[0].ratio / total : 50;

        this.setState({
            percent,
            start: true,
            total,
        });
        this.interval = setInterval(this.calculateValue, this.step);
    };

    componentDidMount() {
        this.timeout = setTimeout(this.animatePointer, this.delay);
    }

    componentWillUnmount() {
        if (this.interval) {
            clearInterval(this.interval);
        }

        if (this.timeout) {
            clearTimeout(this.timeout);
        }
    }

    render() {
        const {classes, data} = this.props;
        const {percent, start, total, value} = this.state;
        const leftValue = Math.round(value);
        const rightValue = 100 - leftValue;

        return (
            <div>
                <div className={classes.chart}>
                    <div className={classes.scale}>
                        {Object.entries(data).map(([id, {name}]) => (
                            <div className={classes.item} key={id}>
                                {name}
                            </div>
                        ))}
                    </div>
                    <div className={classes.pointer} style={{left: `${percent}%`}}>
                        <div className={classes.dash} />
                        <div className={classes.resultLeft}>{`${leftValue}%`}</div>
                        <div className={classes.resultRight}>{`${rightValue}%`}</div>
                    </div>
                </div>
                {start && !total && (
                    <div>Недостаточно данных для анализа типа личности :(</div>
                )}
            </div>
        );
    }
}

const styledResultChart = injectSheet(styles)(ResultChart);

export {styledResultChart as ResultChart};
