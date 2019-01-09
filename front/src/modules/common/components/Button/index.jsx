import * as React from 'react';
import cn from 'classnames';
import styles from './index.local.less';

export class Button extends React.Component {
    render() {
        const {children, className, ...restProps} = this.props;

        return (
            <button {...restProps} className={cn(styles.container, className)}>{children}</button>
        );
    }
}
