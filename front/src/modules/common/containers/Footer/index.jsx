import * as React from 'react';

export class Footer extends React.Component {
    render() {
        return (
            <div className="ta-c fs-12 p-10 bgc-primary">Лазарев Г. М. @ 2018 – {new Date().getFullYear()}</div>
        );
    }
}