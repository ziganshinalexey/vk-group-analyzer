import {Layout} from 'modules/common/containers/Layout';
import * as React from 'react';
import {Route as ReactRoute} from 'react-router-dom';

export class Route extends React.Component {
    componentRender = () => {
        const {component: Component} = this.props;

        return (
            <Layout {...this.props}>
                <Component />
            </Layout>
        );
    };

    render() {
        const {component, restProps} = this.props;

        return (
            <ReactRoute {...restProps} render={this.componentRender} />
        );
    }
}
