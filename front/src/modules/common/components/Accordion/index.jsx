import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        width: '100%',
    },
    content: {
        marginTop: 15,
    },
    contentHidden: {
       display: 'none',
    },
    contentVisible: {
       display: 'block',
    },
    title: {
        color: theme.COLOR_TEXT,
        fontFamily: theme.FONT_FAMILY,
        fontSize: 14,
        fontWeight: 400,
        marginLeft: 12,
    },
    toggler: {
        alignItems: 'center',
        backgroundColor: theme.COLOR_PRIMARY,
        border: `2px solid ${theme.COLOR_PRIMARY}`,
        cursor: 'pointer',
        display: 'flex',
        height: 40,
        padding: 10,
        transition: `all .5s ease`,
        width: '100%',
        '&:active': {
            borderColor: theme.COLOR_PRIMARY_DARK,
        },
        '&:disabled': {
            cursor: 'not-allowed',
            opacity: 0.5,
            pointerEvents: 'none',
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
    togglerIcon: {
        borderWidth: [0, 0, 2, 2],
        borderColor: theme.COLOR_TEXT,
        borderStyle: 'solid',
        height: 10,
        transition: `all .5s ease`,   
        width: 10,
    },
    togglerIconClose: {
        marginBottom: -5,
        transform: `rotate(135deg)`,
    },
    togglerIconShow: {
        marginTop: -5,
        transform: `rotate(-45deg)`,
    }
});

class Accordion extends React.Component {
    static defaultProps = {
        show: false,
    };

    constructor(props) {
        super(props);

        this.state.show = props.show;
    }

    state = {
        show: false,
    };

    handleToggler = () => {
        this.setState((prevState) => ({show: !prevState.show}));
    }

    render() {
        const {children, classes, title} = this.props;
        const {show} = this.state;
        const contentClassList = [classes.content];
        const togglerIconClassList = [classes.togglerIcon];

        if (!show) {
            contentClassList.push(classes.contentHidden);
            togglerIconClassList.push(classes.togglerIconShow);
        } else {
            contentClassList.push(classes.contentVisible);
            togglerIconClassList.push(classes.togglerIconClose);
        }

        return (
            <div className={classes.container}>
                <div className={classes.toggler} onClick={this.handleToggler}>
                    <div className={togglerIconClassList.join(' ')} />
                    <div className={classes.title}>{title}</div>
                </div>
                <div className={contentClassList.join(' ')}>
                    {children}
                </div>
            </div>
        );
    }
}

const styledAccordion = injectSheet(styles)(Accordion);

export {styledAccordion as Accordion};
