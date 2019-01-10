import {getVkResult} from 'modules/common/actions';
import {Button} from 'modules/common/components/Button';
import {Input} from 'modules/common/components/Input';
import {getCommonModuleIsLoading, getCommonModuleState} from 'modules/common/selectors';
import * as React from 'react';
import {connect} from 'react-redux';

class Main extends React.Component {
    state = {
        linkVk: '',
    };

    handleVkLinkChange = (e) => {
        this.setState({
            linkVk: e.target.value,
        });
    };

    handleVkSearch = () => {
        const {getVkResult} = this.props;
        const {linkVk} = this.state;

        getVkResult({link: linkVk});
    };

    render() {
        const {isLoading} = this.props;
        const {linkVk} = this.state;

        return (
            <div className="row">
                <div className="col-xs-24 col-xl-12 col-offset-xl-6 p-20">
                    <p>
                        Специфичность Вашей активности в соцсетях может рассказать о том, к чему лежит Ваша душа, в частности: <b>гуманитарий</b> Вы
                        или <b>технарь</b>.
                    </p>
                    <section className="mt-30">
                        <h4>Анализ ВКонтакте</h4>
                        <p>
                            Введите ссылку на ваш профиль:
                        </p>
                        <p>
                            <Input type="text" onChange={this.handleVkLinkChange} value={linkVk} />
                        </p>
                        <p>
                            <Button
                                disabled={!linkVk.trim().length}
                                loading={isLoading}
                                onClick={this.handleVkSearch}
                                type="button"
                            >
                                Анализировать
                            </Button>
                        </p>
                    </section>
                </div>
            </div>
        );
    }
}

const MainWrapped = connect(
    (state) => ({
        isLoading: getCommonModuleIsLoading(state),
    }),
    {
        getVkResult,
    })(Main);

export {MainWrapped as Main};