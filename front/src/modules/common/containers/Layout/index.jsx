import {Footer} from 'modules/common/containers/Footer';
import {Header} from 'modules/common/containers/Header';
import * as React from 'react';

export class Layout extends React.Component {
    render() {
        return (
            <div className="d-f fd-c h-full">
                <Header />
                <div className="fg-1">{this.props.children}</div>
                <Footer />
            </div>
        );
    }
}