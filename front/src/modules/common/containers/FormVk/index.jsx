import {getVkResult} from 'modules/common/actions';
import {Button} from 'modules/common/components/Button';
import {Field} from 'modules/common/components/Field';
import {Input} from 'modules/common/components/Input';
import {getCommonModuleIsLoading} from 'modules/common/selectors';
import {createForm} from 'rc-form';
import * as React from 'react';
import {connect} from 'react-redux';
import {compose} from 'redux';

class FormVk extends React.Component {
    handleSubmit = () => {
        this.props.form.validateFields((errors, values) => {
            console.log(errors, values);

            if (!errors) {
                const {getVkResult} = this.props;

                getVkResult(values);
            }
        });
    };

    render() {
        const {
            form: {
                getFieldProps,
                getFieldsError,
            },
            isLoading,
        } = this.props;
        const errors = getFieldsError();

        return (
            <div>
                <Field
                    component={Input}
                    errors={errors['vkUrl']}
                    type="text"
                    placeholder="https://vk.com/id"
                    {...getFieldProps('vkUrl', {
                        initialValue: '',
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
            </div>
        );
    }
}

const FormVkWrapped = compose(
    connect(
        (state) => ({
            isLoading: getCommonModuleIsLoading(state),
        }),
        {
            getVkResult,
        },
    ),
    createForm(),
)(FormVk);

export {FormVkWrapped as FormVk};
