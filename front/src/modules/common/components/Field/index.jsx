import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        marginBottom: 10,
    },
    error: {
        color: theme.COLOR_ERROR,
        fontSize: 12,
        marginTop: 5
    }
});

class Field extends React.Component {
    render() {
        const {classes, children, component: Component, errors, theme, ...restProps} = this.props;

        return (
            <div className={classes.container}>
                <Component {...restProps}>{children}</Component>
                {errors && (
                    <div className={classes.error}>{errors}</div>
                )}
            </div>
        );
    }
}

const styledField = injectSheet(styles)(Field);

export {styledField as Field};