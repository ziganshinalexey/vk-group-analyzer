import * as React from 'react';
import cn from 'classnames';

export class Input extends React.Component {
    render() {
        const {className, ...restProps} = this.props;

        return (
            <input
                {...restProps}
                className={cn(
                    'Bgc(#ffffff) ' +
                    'Bdw(2px) ' +
                    'Bdc(cPrimary) ' +
                    'Bdc(cPrimaryDark):a ' +
                    'Bds(s) ' +
                    'Cur(t) ' +
                    'C(cText) ' +
                    'Ff(roboto) ' +
                    'Fz(14px) ' +
                    'Fw(300) ' +
                    'H(40px) ' +
                    'P(10px) ' +
                    'Ta(start) ' +
                    'Trsp(a) ' +
                    'Trsdu(.5s) ' +
                    'Trstf(e) ' +
                    'Miw(300px) ' +
                    'Op(.8):h ' +
                    'Op(.5)!:di ' +
                    'O(n):f',
                    className)}
            />
        );
    }
}
