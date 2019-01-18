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
import {displayFormErrorsNotification} from 'utils';
import queryString from 'querystring';

class FormVk extends React.Component {
    handleSubmit = (e) => {
        e.preventDefault();

        const {form: {setFields, validateFields}} = this.props;

        validateFields(async(errors, values) => {
            if (!errors) {
                const {getVkResult} = this.props;
                const errors = await getVkResult(values);

                displayFormErrorsNotification({errors, setFields});
            }
        });
    };

    handleAuthRedirect() {
        const apiVersion = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_API_VERSION);
        const applicationId = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_APPLICATION_ID);
        const oauthUrl = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_OAUTH_URL);

        if (apiVersion && applicationId && oauthUrl) {
            window.location.replace(`${oauthUrl}?${queryString.stringify({
                client_id: applicationId,
                display: 'page',
                redirect_uri: window.location.origin,
                response_type: 'code',
                scope: 'groups',
                v: apiVersion,
            })}`);
        }
    }

    componentDidMount() {
        const {
            history: {push},
            location: {search},
        } = this.props;
        const {[VK_PARAM.URL_CODE]: code, [VK_PARAM.URL_ERROR]: error} = queryString.parse(search.split('?')[1]);

        if (code) {
            saveToLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE, code);
            push('/');
        } else if (error) {
            removeFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE);
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
            userData,
        } = this.props;
        const errors = getFieldsError();
        const {[VK_PARAM.URL_CODE]: urlCode} = queryString.parse(search.split('?')[1]);
        const code = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE) || urlCode;

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
