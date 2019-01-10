import * as React from 'react';
import cn from 'classnames';
import styles from './index.local.less';

export class Button extends React.Component {
    render() {
        const {children, className, disabled, loading, ...restProps} = this.props;

        return (
            <button {...restProps} disabled={disabled || loading} className={cn(styles.container, className)}>{children}</button>
        );
    }
}
