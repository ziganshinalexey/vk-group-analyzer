import * as React from 'react';
import cn from 'classnames';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        backgroundColor: theme.COLOR_WHITE,
        borderColor: theme.COLOR_PRIMARY,
        borderStyle: 'solid',
        borderWidth: 2,
        color: theme.COLOR_TEXT,
        cursor: 'text',
        fontFamily: theme.FONT_FAMILY,
        fontSize: 14,
        fontWeight: 300,
        height: 40,
        minWidth: 300,
        padding: 10,
        textAlign: 'left',
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
        const {classes, className, ...restProps} = this.props;

        return (
            <input
                {...restProps}
                className={cn(classes.container, className)}
            />
        );
    }
}

const styledInput = injectSheet(styles)(Input);

export {styledInput as Input};
