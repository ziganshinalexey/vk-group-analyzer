import {Notification} from 'modules/common/components/Notification';
import {ACTION_TYPE, VK_PARAM} from 'modules/common/constants';
import {CONFIG} from 'utils/constants';

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
            const backEndHost = getFromLocalStorage(CONFIG.LOCAL_STORAGE_BACK_END_HOST);

            if (!getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN)) {
                await dispatch(getVkAccessToken());
            }

            const accessToken = getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN);

            if (accessToken) {
                const {data, errors} = await (await fetch(`${backEndHost}/api/v1/analyze`, {
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
                })).json();

                if (!errors.length) {
                    dispatch(getVkResultFinish({payload: data}));
                } else {
                    dispatch(getVkResultFail({payload: errors[0]}));
                    Notification({noticeProps: {content: errors[0].title}});

                    return errors[0];
                }
            } else {
                dispatch(getVkResultFail({payload: {}}));
            }
        } catch (e) {
            console.warn(e);
            getVkResultFail({payload: e});
        }
    };
}

function getVkAccessTokenStart() {
    return {
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_START,
    };
}

function getVkAccessTokenFinish({payload}) {
    return {
        payload,
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_FINISH,
    };
}

function getVkAccessTokenFail({payload}) {
    return {
        payload,
        type: ACTION_TYPE.GET_ACCESS_TOKEN_VK_FAIL,
    };
}

function getVkAccessToken() {
    return async(dispatch) => {
        dispatch(getVkAccessTokenStart());

        try {
            const backEndHost = getFromLocalStorage(CONFIG.LOCAL_STORAGE_BACK_END_HOST);
            const {data, errors} = await (await fetch(`${backEndHost}/api/v1/access-token`, {
                body: JSON.stringify({
                    code: getFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE),
                    redirectUrl: window.location.origin,
                }),
                headers: {
                    'content-type': 'application/json',
                    'x-http-method-override': 'GET',
                },
                method: 'POST',
                mode: 'cors',
            })).json();

            if (!errors.length) {
                saveToLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN, data.accessToken);
                dispatch(getVkAccessTokenFinish({payload: data}));
            } else {
                dispatch(getVkAccessTokenFail({payload: errors[0]}));
                Notification({noticeProps: {content: errors[0].title}});
                removeFromLocalStorage(VK_PARAM.LOCAL_STORAGE_CODE);
                removeFromLocalStorage(VK_PARAM.LOCAL_STORAGE_ACCESS_TOKEN);

                return errors[0];
            }
        } catch (e) {
            console.warn(e);
            getVkAccessTokenFail({payload: e});
        }
    };
}
