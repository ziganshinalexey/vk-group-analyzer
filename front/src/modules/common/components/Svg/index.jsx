import React from 'react';
import cn from 'classnames';
import styles from './index.local.less';
import loader from './loader.svg';
import logo from './logo.svg';

const SvgIcon = ({className, src: {id}}) => (
    <i className={cn(styles.container, className)}>
        <svg>
            <use xlinkHref={`#${id}`} />
        </svg>
    </i>
);

export const LoaderSvg = (props) => <SvgIcon src={loader} {...props} />;
export const LogoSvg = (props) => <SvgIcon src={logo} {...props} />;
