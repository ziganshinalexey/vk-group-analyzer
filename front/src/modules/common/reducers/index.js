import {defaultReducer} from 'utils';

export const initialState = {
    data: {},
    isLoading: false,
    list: [],
};

const getReducer = {
    ['@common/get start'](state) {
        return {
            ...state,
            isLoading: true,
        };
    },
    ['@common/get finish'](state, payload) {
        return {
            ...state,
            data: {
                ...state.data,
                ...payload.data,
            },
            isLoading: false,
            list: [
                ...state.list,
                ...payload.list,
            ],
        };
    },
};

const sendReducer = {
    ['@common/send start'](state) {
        return {
            ...state,
            isLoading: true,
        };
    },
    ['@common/send finish'](state) {
        return {
            ...state,
            isLoading: false,
        };
    },
};

export const commonModuleReducer = defaultReducer(initialState, [
    getReducer,
    sendReducer,
]);