import {ACTION_TYPE} from 'modules/common/constants';
import {defaultReducer} from 'utils';

export const initialState = {
    data: {},
    errors: {},
    isLoading: false,
};

const analyzeReducer = {
    [ACTION_TYPE.ANALYZE_VK_START](state) {
        return {
            ...state,
            data: {},
            errors: {},
            isLoading: true,
        };
    },
    [ACTION_TYPE.ANALYZE_VK_FINISH](state, payload) {
        return {
            ...state,
            data: {
                ...state.data,
                ...payload,
            },
            errors: {},
            isLoading: false,
        };
    },
    [ACTION_TYPE.ANALYZE_VK_FAIL](state, payload) {
        return {
            ...state,
            errors: payload,
            isLoading: false,
        };
    },
};

export const commonModuleReducer = defaultReducer(initialState, {
    ...analyzeReducer,
});