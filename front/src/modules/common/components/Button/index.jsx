import * as React from 'react';
import cn from 'classnames';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        backgroundColor: theme.COLOR_PRIMARY,
        borderColor: theme.COLOR_PRIMARY,
        borderStyle: 'solid',
        borderWidth: 2,
        color: theme.COLOR_TEXT,
        cursor: 'pointer',
        fontFamily: theme.FONT_FAMILY,
        fontSize: 14,
        fontWeight: 400,
        height: 40,
        padding: 10,
        textAlign: 'center',
        transitionDuration: 500,
        transitionProperty: 'all',
        transitionTimingFunction: 'ease',
        '&:active': {
            borderColor: theme.COLOR_PRIMARY_DARK,
        },
        '&:disabled': {
            cursor: 'not-allowed',
            opacity: 0.5,
            '&:hover': {
                opacity: 0.5
            },
        },
        '&:hover': {
            opacity: 0.8,
        },
        '&:focus': {
            outline: 'none',
        },
    },
});

class Button extends React.Component {
    render() {
        const {children, classes, className, disabled, ...restProps} = this.props;

        return (
            <button
                {...restProps}
                disabled={disabled}
                className={cn(classes.container, className)}
            >
                {children}
            </button>
        );
    }
}

const styledButton = injectSheet(styles)(Button);

export {styledButton as Button};
