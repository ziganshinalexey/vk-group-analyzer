export const commonModuleName = 'common';

export const commonInitialState = {
    data: {},
    isLoading: false,
    list: [],
};

export const commonReducer = {
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