import * as React from 'react';
import {connect} from 'react-redux';
import {FormVk} from 'modules/common/containers/FormVk';

class Main extends React.Component {
    render() {
        return (
            <div className="D(f)">
                <div className="W(100%)--sm W(50%)--md Mstart(25%)--md P(20px)">
                    <p>
                        Специфичность Вашей активности в соцсетях может рассказать о том, к чему лежит Ваша душа, в частности: <b>гуманитарий</b> Вы
                        или <b>технарь</b>.
                    </p>
                    <section className="Mt(30px)">
                        <h4>Анализ ВКонтакте</h4>
                        <p>
                            Введите ссылку на ваш профиль:
                        </p>
                        <FormVk />
                    </section>
                </div>
            </div>
        );
    }
}

const MainWrapped = connect(
    (state) => ({}),
    {})(Main);

export {MainWrapped as Main};