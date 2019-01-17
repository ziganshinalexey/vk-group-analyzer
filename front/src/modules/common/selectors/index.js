import {MODULE_NAME} from 'modules/common/constants';

export function getCommonModuleState(state) {
    return state[MODULE_NAME];
}

export function getCommonModuleIsLoading(state) {
    return getCommonModuleState(state).isLoading;
}

export function getCommonModuleData(state) {
    return getCommonModuleState(state).data;
}
