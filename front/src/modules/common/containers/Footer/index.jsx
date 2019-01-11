import * as React from 'react';

export class Footer extends React.Component {
    render() {
        return (
            <div className="Ta(c) Fz(12px) P(10px) Bgc(#ffa6bd)">Лазарев Г. М. @ 2018 – {new Date().getFullYear()}</div>
        );
    }
}
