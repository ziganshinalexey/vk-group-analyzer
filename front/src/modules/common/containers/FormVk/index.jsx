import {getFromLocalStorage, getVkAccessToken, getVkResult, removeFromLocalStorage, saveToLocalStorage} from 'modules/common/actions';
import {Button} from 'modules/common/components/Button';
import {Field} from 'modules/common/components/Field';
import {Input} from 'modules/common/components/Input';
import {UserCard} from 'modules/common/components/UserCard';
import {getCommonModuleIsLoading, getCommonModuleUser} from 'modules/common/selectors';
import {createForm} from 'rc-form';
import * as React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';
import {compose} from 'redux';
import {displayFormErrorsNotification} from 'utils';
import queryString from 'querystring';

export const VK_PARAM = {
    ACCESS_TOKEN_PATH: '/access_token',
    APP_ID: 6821075,
    AUTH_PATH: '/authorize',
    CODE: 'code',
    ERROR: 'error',
    LOCAL_STORAGE_CODE_NAME: 'vkCode',
    OAUTH_URL: 'https://oauth.vk.com',
    SECURE_KEY: 'ERF2VlmzlJZcGtu0oVpj',
    VERSION: '5.92',
};

class FormVk extends React.Component {
    handleSubmit = () => {
        const {form: {setFields, validateFields}} = this.props;

        validateFields(async(errors, values) => {
            console.log(errors, values);

            if (!errors) {
                const {getVkResult} = this.props;
                const errors = await getVkResult(values);

                displayFormErrorsNotification({errors, setFields});
            }
        });
    };

    handleAuthRedirect() {
        window.location.replace(`${VK_PARAM.OAUTH_URL}${VK_PARAM.AUTH_PATH}?${queryString.stringify({
            client_id: VK_PARAM.APP_ID,
            display: 'popup',
            redirect_uri: window.location.origin,
            response_type: 'code',
            scope: 'groups',
            v: VK_PARAM.VERSION,
        })}`);
    }

    componentDidMount() {
        const {
            getVkAccessToken,
            location: {search},
        } = this.props;
        const {[VK_PARAM.CODE]: code, [VK_PARAM.ERROR]: error} = queryString.parse(search.split('?')[1]);

        if (code) {
            saveToLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE_NAME, code);

            getVkAccessToken({
                code,
                redirectUrl: window.location.origin,
            });
        } else if (error) {
            removeFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE_NAME);
        }
    }

    render() {
        const {
            form: {
                getFieldProps,
                getFieldsError,
            },
            isLoading,
            location: {search},
            user,
        } = this.props;
        const errors = getFieldsError();
        const {[VK_PARAM.CODE]: urlCode} = queryString.parse(search.split('?')[1]);
        const code = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE_NAME) || urlCode;

        return (
            <div>
                <h4>Анализ ВКонтакте</h4>
                {!code && (
                    <React.Fragment>
                        <p>
                            Для детального анализа необходимо разрешение ВКонтакте:
                        </p>
                        <Button onClick={this.handleAuthRedirect}>Дать разрешение</Button>
                    </React.Fragment>
                )}
                {code && (
                    <React.Fragment>
                        <p>
                            Ссылка на анализируемый профиль:
                        </p>
                        < Field
                            component={Input}
                            errors={errors['vkUrl']}
                            type='text'
                            placeholder='https://vk.com/id'
                            {...getFieldProps('vkUrl', {
                                initialValue: getFromLocalStorage('vkUrl') || '',
                                rules: [{
                                    message: 'Это поле обязательное!',
                                    required: true,
                                }],
                            })}
                        />
                        <Button
                            disabled={isLoading}
                            onClick={this.handleSubmit}
                            type="button"
                        >
                            Анализировать
                        </Button>
                        {user && <UserCard {...user} />}
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
            user: getCommonModuleUser(state),
        }),
        {
            getVkAccessToken,
            getVkResult,
        },
    ),
    createForm(),
)(FormVk);

export {FormVkWrapped as FormVk};
