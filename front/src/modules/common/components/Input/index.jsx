import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        backgroundColor: theme.COLOR_WHITE,
        border: `2px solid ${theme.COLOR_PRIMARY}`,
        color: theme.COLOR_TEXT,
        cursor: 'text',
        fontFamily: theme.FONT_FAMILY,
        fontSize: 14,
        fontWeight: 300,
        height: 40,
        padding: 10,
        textAlign: 'left',
        transition: `all .5s ease`,
        width: '100%',
        '&:active': {
            borderColor: theme.COLOR_PRIMARY_DARK,
        },
        '&:disabled': {
            cursor: 'not-allowed',
            opacity: 0.5,
            '&:hover': {
                opacity: 0.5,
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

class Input extends React.Component {
    render() {
        const {classes, theme, ...restProps} = this.props;

        return (
            <input
                {...restProps}
                className={classes.container}
            />
        );
    }
}

const styledInput = injectSheet(styles)(Input);

export {styledInput as Input};
