import * as React from 'react';

export class Preloader extends React.Component {
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
        return (
            <div className="H(100%) D(f) Ai(c) Jc(c)" dangerouslySetInnerHTML={{__html: `Loading${this.renderDots()}`}} />
        );
    }
}
