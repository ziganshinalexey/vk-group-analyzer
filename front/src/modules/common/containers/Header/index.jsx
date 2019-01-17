import {LogoSvg} from 'modules/common/components/Svg';
import * as React from 'react';
import injectSheet from 'react-jss';

const styles = (theme) => ({
    container: {
        alignItems: 'center',
        backgroundColor: theme.COLOR_PRIMARY,
        display: 'flex',
        flexShrink: 0,
        padding: 10,
    },
    logo: {
        height: 60,
        width: 60,
    },
    title: {
        flexGrow: 1,
        fontSize: 24,
        paddingLeft: 20,
        paddingRight: 20,
    },
});

class Header extends React.Component {
    render() {
        const {classes} = this.props;

        return (
            <div className={classes.container}>
                <LogoSvg className={classes.logo} />
                <div className={classes.title}>
                    Гуманитарий или технарь?
                </div>
            </div>
        );
    }
}

const styledHeader = injectSheet(styles)(Header);

export {styledHeader as Header};