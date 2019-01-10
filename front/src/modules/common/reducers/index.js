import {ACTION_TYPE} from 'modules/common/constants';
import {defaultReducer} from 'utils';

export const initialState = {
    data: {},
    isLoading: false,
};

const analyzeReducer = {
    [ACTION_TYPE.ANALYZE_VK_START](state) {
        return {
            ...state,
            isLoading: true,
        };
    },
    [ACTION_TYPE.ANALYZE_VK_FINISH](state, payload) {
        console.log(payload);
        return {
            ...state,
            data: {
                ...state.data,
                ...payload,
            },
            isLoading: false,
        };
    },
};

export const commonModuleReducer = defaultReducer(initialState, {
    ...analyzeReducer,
});