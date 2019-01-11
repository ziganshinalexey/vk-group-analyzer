import React from 'react';
import cn from 'classnames';
import loader from './loader.svg';
import logo from './logo.svg';

const SvgIcon = ({className, src: {id}}) => (
    <i className={cn('D(ib) H(1em) W(1em)', className)}>
        <svg className="H(100%) W(100%)">
            <use xlinkHref={`#${id}`} />
        </svg>
    </i>
);

export const LoaderSvg = (props) => <SvgIcon src={loader} {...props} />;
export const LogoSvg = (props) => <SvgIcon src={logo} {...props} />;
