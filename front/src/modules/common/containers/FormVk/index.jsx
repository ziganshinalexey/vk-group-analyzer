import {
    getFromLocalStorage,
    getVkResult,
    removeFromLocalStorage,
    saveToLocalStorage,
} from 'modules/common/actions';
import {Button} from 'modules/common/components/Button';
import {Field} from 'modules/common/components/Field';
import {Input} from 'modules/common/components/Input';
import {Preloader} from 'modules/common/components/Preloader';
import {ResultChart} from 'modules/common/components/ResultChart';
import {UserCard} from 'modules/common/components/UserCard';
import {VK_PARAM} from 'modules/common/constants';
import {getCommonModuleData, getCommonModuleIsLoading} from 'modules/common/selectors';
import {createForm} from 'rc-form';
import * as React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';
import {compose} from 'redux';
import {displayFormErrorsNotification, parseHash} from 'utils';
import queryString from 'querystring';

class FormVk extends React.Component {
    handleSubmit = (e) => {
        e.preventDefault();

        const {form: {setFields, validateFields}} = this.props;

        validateFields(async(errors, values) => {
            if (!errors) {
                const {getVkResult} = this.props;
                const errors = await getVkResult({
                    accessToken: getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN_NAME),
                    ...values,
                });

                displayFormErrorsNotification({errors, setFields});
            }
        });
    };

    handleAuthRedirect() {
        window.location.replace(`${VK_PARAM.OAUTH_URL}${VK_PARAM.AUTH_PATH}?${queryString.stringify({
            client_id: VK_PARAM.APP_ID,
            display: 'page',
            redirect_uri: window.location.origin,
            response_type: 'token',
            scope: 'groups',
            v: VK_PARAM.VERSION,
        })}`);
    }

    componentDidMount() {
        const {
            history: {push},
            location: {hash},
        } = this.props;
        const {[VK_PARAM.URL_ACCESS_TOKEN]: accessToken, [VK_PARAM.URL_ERROR]: error} = queryString.parse(parseHash(hash));

        if (accessToken) {
            saveToLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN_NAME, accessToken);
            push('/');
        } else if (error) {
            removeFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN_NAME);
        }
    }

    render() {
        const {
            form: {
                getFieldProps,
                getFieldsError,
            },
            isLoading,
            location: {hash},
            userData,
        } = this.props;
        const errors = getFieldsError();
        const {[VK_PARAM.URL_ACCESS_TOKEN]: urlAccessToken} = queryString.parse(parseHash(hash));
        const accessToken = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN_NAME) || urlAccessToken;

        return (
            <div>
                <h4>Анализ ВКонтакте</h4>
                {!accessToken && (
                    <React.Fragment>
                        <p>
                            Для детального анализа необходимо разрешение ВКонтакте:
                        </p>
                        <Button onClick={this.handleAuthRedirect}>Дать разрешение</Button>
                    </React.Fragment>
                )}
                {accessToken && (
                    <React.Fragment>
                        <form onSubmit={this.handleSubmit}>
                            <p>
                                Ссылка на анализируемый профиль:
                            </p>
                            <Field
                                component={Input}
                                errors={errors['vkUrl']}
                                name="vkUrl"
                                type="text"
                                placeholder='https://vk.com/id'
                                {...getFieldProps('vkUrl', {
                                    initialValue: getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_URL_NAME) || '',
                                    rules: [{
                                        message: 'Это поле обязательное!',
                                        required: true,
                                    }],
                                })}
                            />
                            <Button disabled={isLoading}>Анализировать</Button>
                        </form>
                        {isLoading && <Preloader />}
                        {userData && userData.user && <UserCard {...userData.user} />}
                        {userData && userData.analyzeResult && <ResultChart data={userData.analyzeResult} />}
                    </React.Fragment>
                )}
            </div>
        );
    }
}

const FormVkWrapped = compose(
    withRouter,
    connect(
        (state) => ({
            isLoading: getCommonModuleIsLoading(state),
            userData: getCommonModuleData(state),
        }),
        {
            getVkResult,
        },
    ),
    createForm(),
)(FormVk);

export {FormVkWrapped as FormVk};
