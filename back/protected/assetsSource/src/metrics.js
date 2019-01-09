import {getUTCTime} from './utils';

export const metricsClickInfoBlock = ({infoBlock, props}) => {
    if (infoBlock) {
        const {channelId, layoutId, videoId} = props;
        const {blockName, infoBlockId, infoBlockScheduleId} = infoBlock;
        const xhr = new XMLHttpRequest();

        xhr.open('POST', `${props.host}/api/v1/info-block-click`, true);
        xhr.setRequestHeader('x-http-method-override', 'CREATE');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.withCredentials = true;
        xhr.send(
            JSON.stringify({
                blockName,
                channelId,
                clickDate: getUTCTime(),
                infoBlockId,
                infoBlockScheduleId,
                layoutId,
                videoId,
            })
        );
    }
};

export const metricsClickVideo = ({props, structure}) => {
    const {layout, video} = structure;

    if (layout && video) {
        const {channelId, userId, userAge, userLocation, platform} = props;
        const {id: layoutId} = layout;
        const {id: videoId} = video;
        const xhr = new XMLHttpRequest();

        xhr.open('POST', `${props.host}/api/v1/video-click`, true);
        xhr.setRequestHeader('x-http-method-override', 'CREATE');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.withCredentials = true;
        xhr.send(
            JSON.stringify({
                channelId,
                clickDate: getUTCTime(),
                layoutId,
                platform,
                userAge,
                userId,
                userLocation,
                videoId,
            })
        );
    }
};
