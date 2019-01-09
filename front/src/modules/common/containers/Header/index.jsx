import {LogoSvg} from 'modules/common/components/Svg';
import * as React from 'react';
import styles from './index.local.less';

export class Header extends React.Component {
    render() {
        return (
            <div className="d-f ai-c p-10 bgc-primary">
                <div>
                    <LogoSvg className={styles.logo} />
                </div>
                <div className="fg-1 fs-24 pl-20 pr-20">
                    Гуманитарий или технарь?
                </div>
            </div>
        );
    }
}