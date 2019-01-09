import {checkCarousel} from './carousel';
import {metricsClickInfoBlock} from './metrics';
import {findElLastParentNode, getOrientationAffix, normalizeDate} from './utils';

export const handleInfoBlock = ({infoBlock, props, structure}) => {
    const {sections} = structure;
    const {id: infoBlockScheduleId, ...restInfoBlockScheduleData} = infoBlock;
    const {blockName, infoBlockId, from, to} = restInfoBlockScheduleData;
    const sectionKey = Object.keys(sections).find((key) => sections[key].id === blockName);

    if (sectionKey) {
        const section = sections[sectionKey];
        const {carousel} = section;

        if (carousel) {
            const {$inner, infoBlocks} = carousel;
            const structureInfoBlockKey = Object.keys(infoBlocks).find((key) => infoBlocks[key].infoBlockScheduleId === infoBlockScheduleId);
            const momentNow = window.timeTouchTv ? new Date(window.timeTouchTv) : new Date();
            const momentFrom = new Date(normalizeDate(from));
            const momentTo = new Date(normalizeDate(to));

            if (momentNow > momentFrom && momentNow < momentTo) {
                if (!structureInfoBlockKey) {
                    const {amount, orientation} = section;
                    const $infoBlock = document.createElement('div');
                    const $infoBlockWrapper = document.createElement('div');
                    const dynamicOrientationAffix = getOrientationAffix(orientation);
                    const dynamicClass = `col col-${dynamicOrientationAffix}-xs-${Math.round(24 / amount)}`;
                    const infoBlockData = structure.infoBlockList.find((infoBlockDataItem) => infoBlockDataItem.id === infoBlockId);
                    let {id, ...extInfoBlockData} = infoBlockData;

                    extInfoBlockData = {blockName, infoBlockId, infoBlockScheduleId, ...extInfoBlockData};
                    $infoBlockWrapper.className = props.iBWrapperClass + ' ' + props.carouselSlideClass + ' ' + dynamicClass;
                    $infoBlock.className = props.iBClass;
                    $infoBlockWrapper.appendChild($infoBlock);
                    $inner.appendChild($infoBlockWrapper);

                    const newInfoBlock = {
                        $: $infoBlock,
                        ...extInfoBlockData,
                    };

                    carousel.infoBlocks[infoBlockScheduleId] = newInfoBlock;
                    drawInfoBlockContents({infoBlock: newInfoBlock, props});
                    checkCarousel({props, section});
                    metricsClickInfoBlock({infoBlock: newInfoBlock, props});
                }
            } else {
                if (structureInfoBlockKey) {
                    removeInfoBlock({infoBlock: infoBlocks[structureInfoBlockKey], props, section});
                }
            }
        }
    }
};

const removeInfoBlock = ({infoBlock, props, section}) => {
    const {
        carousel,
        carousel: {$inner, infoBlocks},
    } = section;
    const {$: $infoBlock, infoBlockScheduleId: currInfoBlockScheduleId} = infoBlock;
    const $infoBlockNode = findElLastParentNode($infoBlock, $inner);

    if ($infoBlockNode) {
        $inner.removeChild($infoBlockNode);
        carousel.infoBlocks = Object.keys(infoBlocks).reduce(
            (acc, infoBlockScheduleKey) =>
                infoBlocks[infoBlockScheduleKey].infoBlockScheduleId !== currInfoBlockScheduleId
                    ? {
                          ...acc,
                          [infoBlockScheduleKey]: infoBlocks[infoBlockScheduleKey],
                      }
                    : acc,
            {}
        );
        checkCarousel({props, section});
    }
};

const drawInfoBlockContents = ({infoBlock, props}) => {
    if (infoBlock) {
        const {$: $infoBlock, image, shortDescription, title} = infoBlock;
        const withTitle = !!title;
        const withDescription = !!shortDescription;

        if (image) {
            $infoBlock.style.backgroundImage = `url(${image})`;
        } else {
            $infoBlock.style.backgroundColor = props.iBBgColor;
        }

        if (withTitle || withDescription) {
            const $backdrop = document.createElement('div');
            let dynamicBackdropClass = props.iBBackdropClass;

            if (withDescription) {
                dynamicBackdropClass = `${dynamicBackdropClass} ${props.iBBackdropClassFull}`;
            }

            $backdrop.className = dynamicBackdropClass;
            $infoBlock.appendChild($backdrop);
        }

        if (withTitle) {
            const $title = document.createElement('div');
            const $titleInner = document.createElement('div');
            let dynamicTitleClass = props.iBTitleClass;

            if (!withDescription) {
                dynamicTitleClass = `${dynamicTitleClass} ${props.iBTitleClassAlign}`;
                $titleInner.className = props.iBTitleInnerClass;
            }

            $title.className = dynamicTitleClass;
            $titleInner.textContent = title;
            $title.appendChild($titleInner);
            $infoBlock.appendChild($title);
        }

        if (withDescription) {
            const $shortDescription = document.createElement('div');

            $shortDescription.className = props.iBShortDescriptionClass;
            $shortDescription.textContent = shortDescription;
            $infoBlock.appendChild($shortDescription);
        }
    }
};
