import {Footer} from 'modules/common/containers/Footer';
import {Header} from 'modules/common/containers/Header';
import * as React from 'react';

export class Layout extends React.Component {
    render() {
        return (
            <div className="D(f) Fxd(c) H(100%)">
                <Header />
                <div className="Fxg(1)">{this.props.children}</div>
                <Footer />
            </div>
        );
    }
}