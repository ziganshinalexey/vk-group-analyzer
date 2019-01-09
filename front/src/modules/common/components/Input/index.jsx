import * as React from 'react';
import cn from 'classnames';
import styles from './index.local.less';

export class Input extends React.Component {
    render() {
        const {className, ...restProps} = this.props;

        return (
            <input {...restProps} className={cn(styles.container, className)} />
        );
    }
}
