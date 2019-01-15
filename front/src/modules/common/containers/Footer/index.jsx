import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        backgroundColor: theme.COLOR_PRIMARY,
        textAlign: 'center',
        fontSize: 12,
        padding: 10,
    },
});

class Footer extends React.Component {
    render() {
        const {classes} = this.props;

        return (
            <div className={classes.container}>Лазарев Г. М. @ 2018 – {new Date().getFullYear()}</div>
        );
    }
}

const styledFooter = injectSheet(styles)(Footer);

export {styledFooter as Footer};