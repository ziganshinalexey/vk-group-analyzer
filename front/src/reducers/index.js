import {commonInitialState, commonModuleName, commonReducer} from 'reducers/common';
import {combineReducers} from 'redux';
import {defaultReducer} from 'utils';

export const mainReducer = combineReducers({
    [commonModuleName]: defaultReducer(commonInitialState, commonReducer),
});
