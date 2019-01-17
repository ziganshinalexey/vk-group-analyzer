export const MODULE_NAME = 'common';

export const ACTION_TYPE = {
    ANALYZE_VK_FAIL: '@common/analyze VK fail',
    ANALYZE_VK_FINISH: '@common/analyze VK finish',
    ANALYZE_VK_START: '@common/analyze VK start',
    GET_ACCESS_TOKEN_VK_FAIL: '@common/get access token VK fail',
    GET_ACCESS_TOKEN_VK_FINISH: '@common/get access token VK finish',
    GET_ACCESS_TOKEN_VK_START: '@common/get access token VK start',
    FORM_STORE_FIELDS: '@common/form store fields',
    FORM_STORE_VALUES: '@common/form store values',
};

export const VK_PARAM = {
    APP_ID: 6822629,
    AUTH_PATH: '/authorize',
    URL_ACCESS_TOKEN: 'access_token',
    URL_ERROR: 'error',
    LOCAL_STORAGE_ACCESS_TOKEN_NAME: 'vkAccessToken',
    LOCAL_STORAGE_URL_NAME: 'vkUrl',
    OAUTH_URL: 'https://oauth.vk.com',
    VERSION: '5.92',
};
