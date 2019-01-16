import React from 'react';
import cn from 'classnames';
import injectSheet from 'react-jss';
import loader from './loader.svg';
import logo from './logo.svg';

const styles = () => ({
    container: {
        display: 'inline-block',
        height: '1em',
        width: '1em',
    },
    svg: {
        height: '100%',
        width: '100%',
    },
});

const RawSvgIcon = ({classes, className, src: {id}}) => (
    <i className={cn(classes.container, className)}>
        <svg className={classes.svg}>
            <use xlinkHref={`#${id}`} />
        </svg>
    </i>
);

const SvgIcon = injectSheet(styles)(RawSvgIcon);

export const LoaderSvg = (props) => <SvgIcon src={loader} {...props} />;
export const LogoSvg = (props) => <SvgIcon src={logo} {...props} />;
