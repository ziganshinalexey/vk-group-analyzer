import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        backgroundColor: theme.COLOR_PRIMARY,
        border: `2px solid ${theme.COLOR_PRIMARY}`,
        color: theme.COLOR_TEXT,
        cursor: 'pointer',
        fontFamily: theme.FONT_FAMILY,
        fontSize: 14,
        fontWeight: 400,
        height: 40,
        padding: 10,
        textAlign: 'center',
        transition: `all .5s ease`,
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
        const {children, classes, disabled, theme, ...restProps} = this.props;

        return (
            <button
                {...restProps}
                disabled={disabled}
                className={classes.container}
            >
                {children}
            </button>
        );
    }
}

const styledButton = injectSheet(styles)(Button);

export {styledButton as Button};
