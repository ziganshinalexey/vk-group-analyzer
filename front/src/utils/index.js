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
        }
    }
}
