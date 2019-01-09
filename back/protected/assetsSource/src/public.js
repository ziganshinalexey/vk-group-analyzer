import {drawCarousel} from './carousel';
import {DEFAULT_OPTIONS} from './constants';
import {handleInfoBlock} from './info-block';
import {drawLayout} from './layout';
import {drawModal} from './modal';
import {getDataAttrName} from './utils';
import {metricsClickVideo} from './metrics';

const initTouchTv = (options, callback) => {
    const props = {
        ...DEFAULT_OPTIONS,
        ...options,
    };
    const structure = {
        container: {},
        infoBlockList: [],
        infoBlockScheduleList: [],
        layout: {},
        modal: {},
        sections: {},
        video: {},
    };

    const handleMainRequest = (data) => {
        const {layout} = structure;

        if (layout) {
            const {$: $layout} = layout;
            const {infoBlockList, infoBlockScheduleList, video} = data;

            structure.infoBlockList = infoBlockList;
            structure.infoBlockScheduleList = infoBlockScheduleList;

            if (!Object.keys(structure.video).length) {
                structure.video = video;
                metricsClickVideo({props, structure});
            }

            if (!Object.keys(structure.modal).length) {
                drawModal({props, structure});
            }

            if (!Object.keys(structure.sections).length) {
                const $$sections = $layout.querySelectorAll(props.iBSectionSelector);

                if ($$sections) {
                    $$sections.forEach(($section) => {
                        const amount = $section.getAttribute(getDataAttrName(props.iBSectionAttrAmount));
                        const id = $section.getAttribute(getDataAttrName(props.iBSectionAttrId));
                        const orientation = $section.getAttribute(getDataAttrName(props.iBSectionAttrOrientation));
                        const section = {
                            $: $section,
                            amount,
                            id,
                            orientation,
                        };

                        structure.sections[id] = section;
                        drawCarousel({props, section});
                    });
                }
            }

            infoBlockScheduleList.forEach((infoBlock) => {
                handleInfoBlock({infoBlock, props, structure});
            });

            if (!window.iBRefresh) {
                window.iBRefresh = window.setInterval(() => {
                    handleMainRequest(data);
                }, props.iBRefreshInterval);
            }
        }
    };

    const xhr = new XMLHttpRequest();

    xhr.open('POST', `${props.host}/api/v1/layout/current`, true);
    xhr.setRequestHeader('x-http-method-override', 'GET');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = () => {
        if (4 === xhr.readyState) {
            if (200 === xhr.status) {
                const {data} = JSON.parse(xhr.responseText);

                if (window.iBRefresh) {
                    window.clearInterval(window.iBRefresh);
                }

                window.iBRefresh = null;

                if (data) {
                    drawLayout({
                        callback: () => {
                            handleMainRequest(data);

                            if (callback) {
                                callback();
                            }
                        },
                        data,
                        props,
                        structure,
                    });
                }
            }
        }
    };
    xhr.withCredentials = true;
    xhr.send(
        JSON.stringify({
            channelId: props.channelId,
            time: props.time,
        })
    );
};

const destroyTouchTv = (options, callback) => {
    const props = {
        ...DEFAULT_OPTIONS,
        ...options,
    };

    window.iBRefresh = null;

    const $container = document.querySelector(props.containerSelector);

    if ($container) {
        $container.innerHTML = '';

        if (callback) {
            callback();
        }
    }
};

const setTimeTouchTv = (time, callback) => {
    window.timeTouchTv = time;

    if (callback) {
        callback();
    }
};

window.initTouchTv = initTouchTv;
window.destroyTouchTv = destroyTouchTv;
window.setTimeTouchTv = setTimeTouchTv;
