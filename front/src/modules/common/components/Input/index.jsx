import * as React from 'react';
import cn from 'classnames';

export class Input extends React.Component {
    render() {
        const {className, ...restProps} = this.props;

        return (
            <input
                {...restProps}
                className={cn('Bgc(#ffffff) ' +
                    'Bdw(2px) ' +
                    'Bdc(#ffa6bd) ' +
                    'Bdc(#cc8598):a ' +
                    'Bds(s) ' +
                    'Cur(t) ' +
                    'C(#000000) ' +
                    'Ff("Roboto", sans-serif) ' +
                    'Fz(14px) ' +
                    'Fw(300) ' +
                    'H(40px) ' +
                    'P(10px) ' +
                    'Ta(l) ' +
                    'Trs("opacity 0.5s ease") ' +
                    'Miw(300px) ' +
                    'Op(.8):h ' +
                    'O(n):f' +
                    '', className)}
            />
        );
    }
}
