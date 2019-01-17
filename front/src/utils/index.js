import {Notification} from 'modules/common/components/Notification';

export function defaultReducer(initialState, reducerList) {
    return (state = initialState, {type, payload}) => {
        const reducer = reducerList[type];

        if ('function' === typeof reducer) {
            return reducer(state, payload);
        }

        return state;
    };
}

function normalizeFormErrors(errors) {
    return Object.entries(errors).reduce((acc, [name, error]) => ({
        ...acc,
        [name]: {
            errors: [error],
        },
    }), {});
}


export function displayFormErrorsNotification({errors, setFields}) {
    if (errors) {
        const isFieldErrors = !!Object.entries(errors.data).length;

        if (isFieldErrors) {
            setFields(normalizeFormErrors(errors.data));
        } else if (errors.title) {
            Notification({noticeProps: {content: errors.title}});
        }
    }
}

export function parseHash(hash = '') {
    return hash.split('#')[1];
}
