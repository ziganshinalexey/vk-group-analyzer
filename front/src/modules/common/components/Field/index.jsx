import * as React from 'react';
import cn from 'classnames';

export class Field extends React.Component {
    render() {
        const {className, children, component: Component, errors, ...restProps} = this.props;

        return (
            <div className={cn('Mb(10px)', className)}>
                <Component {...restProps}>{children}</Component>
                {errors && (
                    <div className="Mt(5px) C(#ff0000) Fz(12px)">{errors}</div>
                )}
            </div>
        );
    }
}