import * as React from 'react';
import cn from 'classnames';
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
        const {classes, className, children, component: Component, errors, ...restProps} = this.props;

        return (
            <div className={cn(classes.container, className)}>
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