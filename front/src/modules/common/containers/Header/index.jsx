import {LogoSvg} from 'modules/common/components/Svg';
import * as React from 'react';

export class Header extends React.Component {
    render() {
        return (
            <div className="D(f) Ai(c) P(10px) Bgc(cPrimary)">
                <div>
                    <LogoSvg className="H(60px) W(60px)" />
                </div>
                <div className="Fxg(1) Fz(24px) Pstart(20px) Pend(20px)">
                    Гуманитарий или технарь?
                </div>
            </div>
        );
    }
}