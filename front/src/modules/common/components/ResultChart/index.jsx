import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    chart: {
        margin: '30px 20px 45px',
        position: 'relative',
    },
    dash: {
        backgroundColor: theme.COLOR_ACCENT_COLD,
        bottom: -5,
        left: '50%',
        position: 'absolute',
        top: -5,
        width: 1,
    },
    item: {
        fontSize: 14,
    },
    pointer: {
        bottom: 0,
        left: 0,
        position: 'absolute',
        transform: 'translateX(-50%)',
        transition: 'left 1s ease-in-out',
        top: 0,
        width: 40,
    },
    result: {
        fontSize: 14,
        position: 'absolute',
        textAlign: 'center',
        top: 'calc(100% + 5px)',
        width: '100%',
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
        percent: 0,
        total: 0,
        value: 0,
    };

    delay = 500;

    duration = 1000;

    step = 20;

    calculateValue = () => {
        const {duration} = this.state;

        if (duration < this.duration) {
            this.setState((prevState) => ({
                duration: prevState.duration + this.step,
                value: prevState.value + prevState.percent / (this.duration / this.step),
            }));
        }
    };

    animatePointer = () => {
        const {data} = this.props;
        const dataValues = Object.values(data);
        const total = dataValues.reduce((acc, {ratio}) => acc + ratio, 0);
        const percent = total ? 100 * dataValues[0].ratio / total : 0;

        this.setState({
            percent,
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
        const {percent, total, value} = this.state;

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
                        <div className={classes.result}>{`${Math.round(value)}%`}</div>
                    </div>
                </div>
                {!total && (
                    <div>Недостаточно данных для анализа типа личности :(</div>
                )}
            </div>
        );
    }
}

const styledResultChart = injectSheet(styles)(ResultChart);

export {styledResultChart as ResultChart};
