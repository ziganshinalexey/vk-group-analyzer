import {ACTION_TYPE} from 'modules/common/constants';
import {VK_PARAM} from 'modules/common/containers/FormVk';

export function saveToLocalStorage(name, value) {
    localStorage.setItem(name, value);
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
        dispatch(getVkResultStart());

        const {vkUrl} = options;

        if (vkUrl) {
            saveToLocalStorage(VK_PARAM.LOCAL_STORAGE_URL_NAME, vkUrl);
        }

        try {
            const accessToken = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN_NAME);
            const response = await fetch('http://person-analyzer.local/api/v1/analyze', {
                body: JSON.stringify({
                    ...options,
                    accessToken,
                }),
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
