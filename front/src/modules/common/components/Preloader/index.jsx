import * as React from 'react';
import injectSheet from 'react-jss';

const styles = () => ({
    container: {
        alignItems: 'center',
        display: 'flex',
        height: '100%',
        justifyContent: 'center'
    },
});

class Preloader extends React.Component {
    state = {
        time: 0
    };

    count = () => {
        this.setState((prevState) => ({
            time: prevState.time + 1,
        }))
    };

    componentDidMount() {
        this.interval = setInterval(this.count, 500);
    }

    componentWillUnmount() {
        this.interval = null;
    }

    renderDots = () => {
        let dots = ['&nbsp;', '&nbsp;', '&nbsp;'];

        for (let i = 0, amount = this.state.time % 4; i < amount; i++) {
            dots[i] = '.'
        }

        return dots.join('');
    };

    render() {
        const {classes} = this.props;

        return (
            <div className={classes.container} dangerouslySetInnerHTML={{__html: `Loading${this.renderDots()}`}} />
        );
    }
}

const styledPreloader = injectSheet(styles)(Preloader);

export {styledPreloader as Preloader};
