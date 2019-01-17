import {ACTION_TYPE} from 'modules/common/constants';

export function saveToLocalStorage(name, value) {
    localStorage.setItem(name, value);
}

export function saveMultipleToLocalStorage(list) {
    list.forEach((item) => {
        if (item[0]) {
            localStorage.setItem(item[0], item[1]);
        }
    });
}

export function getFromLocalStorage(name) {
    return localStorage.getItem(name);
}

export function removeFromLocalStorage(name) {
    localStorage.removeItem(name);
}

function getVkResultStart() {
    return {
        type: ACTION_TYPE.ANALYZE_VK_START,
    };
}

function getVkResultFinish({payload}) {
    return {
        payload,
        type: ACTION_TYPE.ANALYZE_VK_FINISH,
    };
}

function getVkResultFail({payload}) {
    return {
        payload,
        type: ACTION_TYPE.ANALYZE_VK_FAIL,
    };
}

export function getVkResult(options) {
    return async(dispatch) => {
        saveMultipleToLocalStorage(Object.entries(options));
        dispatch(getVkResultStart());

        try {
            const response = await fetch('http://person-analyzer.local/api/v1/analyze', {
                body: JSON.stringify(options),
                headers: {
                    'content-type': 'application/json',
                    'x-http-method-override': 'GET',
                },
                method: 'POST',
                mode: 'cors',
            });
            const {data, errors} = await response.json();

            if (!errors.length) {
                dispatch(getVkResultFinish({payload: data}));
            } else {
                dispatch(getVkResultFail({payload: errors[0]}));

                return errors[0];
            }
        } catch (e) {
            console.warn(e);
        }
    };
}

function getVkAccessTokentStart() {
    return {
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_START,
    };
}

function getVkAccessTokentFinish({payload}) {
    return {
        payload,
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_FINISH,
    };
}

function getVkAccessTokentFail({payload}) {
    return {
        payload,
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_FAIL,
    };
}

export function getVkAccessToken(options) {
    return async(dispatch) => {
        dispatch(getVkAccessTokentStart());

        try {
            const response = await fetch('http://person-analyzer.local/api/v1/access-token', {
                body: JSON.stringify(options),
                headers: {
                    'content-type': 'application/json',
                    'x-http-method-override': 'GET',
                },
                method: 'POST',
                mode: 'cors',
            });
            const {data, errors} = await response.json();

            if (!errors.length) {
                dispatch(getVkAccessTokentFinish({payload: data}));
            } else {
                dispatch(getVkAccessTokentFail({payload: errors[0]}));

                return errors[0];
            }
        } catch (e) {
            console.warn(e);
        }
    };
}
