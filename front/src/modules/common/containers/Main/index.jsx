import {Button} from 'modules/common/components/Button';
import {Input} from 'modules/common/components/Input';
import * as React from 'react';

export class Main extends React.Component {
    state = {
        idVk: '',
    };

    handleVkIdChange = (e) => {
        this.setState({
            idVk: e.target.value,
        })
    };

    handleVkSearch = () => {
        console.log(this.state.idVk);
    };

    render() {
        const {idVk} = this.state;

        return (
            <div className="row">
                <div className="col-xs-24 col-xl-12 col-offset-xl-6 p-20">
                    <p>
                        Специфичность Вашей активности в соцсетях может рассказать о том, к чему лежит Ваша душа, в частности: <b>гуманитарий</b> Вы
                        или
                        <b>технарь</b>.
                    </p>
                    <section className="mt-30">
                        <h4>Анализ ВКонтакте</h4>
                        <p>
                            Введите свой <b>id</b> (идентификатор пользователя) для анализа:
                        </p>
                        <p>
                            <Input type="text" onChange={this.handleVkIdChange} value={idVk} />
                        </p>
                        <p>
                            <Button type="button" onClick={this.handleVkSearch}>OK</Button>
                        </p>
                    </section>
                </div>
            </div>
        );
    }
}