export function defaultReducer(initialState, reducerList) {
    return (state = initialState, {type, payload}) => {
        const reducer = reducerList[type];

        if ('function' === typeof reducer) {
            return reducer(state, payload);
        }

        return state;
    };
}

export function getXHRBody(xhr) {
    const text = xhr.responseText || xhr.response;

    if (!text) {
        return text;
    }

    try {
        return JSON.parse(text);
    } catch (e) {
        return text;
    }
}