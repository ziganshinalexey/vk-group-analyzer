export function defaultReducer(initialState, reducerList) {
    return (state = initialState, {type, payload}) => {
        const reducer = reducerList[type];

        if ('function' === typeof reducer) {
            return reducer(state, payload);
        }

        return state;
    };
}
