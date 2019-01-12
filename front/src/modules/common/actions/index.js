import {ACTION_TYPE} from 'modules/common/constants';
import {getXHRBody} from 'utils';

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

export function getVkResult(data) {
    return (dispatch) => {
        const req = new XMLHttpRequest();

        dispatch(getVkResultStart());
        req.addEventListener('loadend', function() {
            const res = getXHRBody(req);
            let parsedRes = null;

            try {
                parsedRes = JSON.parse(res);
            } catch (e) {
                console.warn(e);
            }

            dispatch(getVkResultFinish({payload: parsedRes}));
        });
        req.open('POST', 'http://person-analyzer.local/api/v1/analyze');
        req.setRequestHeader('x-http-method-override', 'GET');
        req.withCredentials = true;
        req.send(JSON.stringify(data));
    };
}
