import {changeSlide} from './carousel';
import {metricsClickInfoBlock} from './metrics';
import {clearModalContents, drawModalContents} from './modal';
import {findClosest} from './utils';

export const handleClick = ({e, props, structure}) => {
    const $target = e.target;
    const {
        modal: {$: $modal},
    } = structure;

    if ($modal) {
        let {
            modal: {$close, isOpened},
            sections,
        } = structure;
        const $infoBlock = findClosest($target, props.iBSelector);
        const isTargetInModal = !!findClosest($target, props.iBModalSelector);
        let target = {};

        Object.keys(sections).forEach((sectionKey) => {
            const section = sections[sectionKey];
            const {carousel} = section;

            if (carousel.$backward === $target) {
                target = {
                    infoBlock: undefined,
                    section,
                    type: 'backward',
                };
            }

            if (carousel.$forward === $target) {
                target = {
                    infoBlock: undefined,
                    section,
                    type: 'forward',
                };
            }

            if ($infoBlock) {
                const {infoBlocks} = carousel;
                const infoBlockKey = Object.keys(infoBlocks).find((key) => infoBlocks[key].$ === $infoBlock);

                if (infoBlockKey) {
                    const infoBlockData = infoBlocks[infoBlockKey];

                    target = {
                        infoBlock: infoBlockData,
                        section,
                        type: 'slide',
                    };
                }
            }
        });

        switch (true) {
            case !!(isOpened && ($target === $close || !isTargetInModal)):
                structure.modal.isOpened = false;
                $modal.setAttribute(props.iBModalAttrHidden, props.iBModalAttrHiddenTrue);
                clearModalContents({structure});

                break;
            case !!(!isOpened && target.infoBlock): {
                const {infoBlock} = target;

                drawModalContents({infoBlock, props, structure});
                structure.modal.isOpened = true;
                $modal.setAttribute(props.iBModalAttrHidden, props.iBModalAttrHiddenFalse);
                metricsClickInfoBlock({infoBlock, props});

                break;
            }
            case 'backward' === target.type: {
                const {section} = target;

                changeSlide({diff: -1, section});

                break;
            }
            case 'forward' === target.type: {
                const {section} = target;

                changeSlide({diff: 1, section});

                break;
            }
            default:
                break;
        }
    }
};
