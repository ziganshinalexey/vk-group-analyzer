import {Footer} from 'modules/common/containers/Footer';
import {Header} from 'modules/common/containers/Header';
import * as React from 'react';
import injectSheet from 'react-jss';

const styles = () => ({
    container: {
        display: 'flex',
        flexDirection: 'column',
        height: '100%',
    },
    content: {
        flexGrow: 1,
    }
});

class Layout extends React.Component {
    render() {
        const {children, classes} = this.props;

        return (
            <div className={classes.container}>
                <Header />
                <div className={classes.content}>{children}</div>
                <Footer />
            </div>
        );
    }
}

const styledLayout = injectSheet(styles)(Layout);

export {styledLayout as Layout};