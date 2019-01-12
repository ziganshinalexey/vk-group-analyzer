import * as React from 'react';
import cn from 'classnames';

export class Button extends React.Component {
    render() {
        const {children, className, disabled, ...restProps} = this.props;

        return (
            <button
                {...restProps}
                disabled={disabled}
                className={cn(
                    'Bgc(cPrimary) ' +
                    'Bdw(2px) ' +
                    'Bdc(cPrimary) ' +
                    'Bdc(cPrimaryDark):a ' +
                    'Bds(s) ' +
                    'Cur(p) ' +
                    'Cur(na):di ' +
                    'C(cText) ' +
                    'Ff(roboto) ' +
                    'Fz(14px) ' +
                    'Fw(400) ' +
                    'H(40px) ' +
                    'P(10px) ' +
                    'Ta(c) ' +
                    'Trsp(a) ' +
                    'Trsdu(.5s) ' +
                    'Trstf(e) ' +
                    'Op(.8):h ' +
                    'Op(.5)!:di ' +
                    'O(n):f',
                    className)}
            >
                {children}
            </button>
        );
    }
}
