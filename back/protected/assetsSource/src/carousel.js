import {getOrientationAffix} from './utils';

export const drawCarousel = ({props, section}) => {
    if (section) {
        const {$: $section, orientation} = section;
        const $carousel = document.createElement('div');
        const $track = document.createElement('div');
        const $inner = document.createElement('div');
        const $controls = document.createElement('div');
        const $forward = document.createElement('div');
        const $backward = document.createElement('div');
        const dynamicOrientationAffix = getOrientationAffix(orientation);

        $carousel.className = `${props.carouselClass} ${props.carouselClass}-${dynamicOrientationAffix}`;
        $track.className = props.carouselTrackClass;
        $inner.className = props.carouselInnerClass;
        $controls.className = props.carouselControlsClass;
        $backward.className = props.carouselControlBackwardClass;
        $forward.className = props.carouselControlForwardClass;
        $controls.appendChild($backward);
        $controls.appendChild($forward);
        $carousel.appendChild($controls);
        $track.appendChild($inner);
        $carousel.appendChild($track);
        $section.appendChild($carousel);
        section.carousel = {
            $: $carousel,
            $backward,
            $controls,
            $forward,
            $inner,
            blocked: props.carouselDefaultBlocked,
            infoBlocks: {},
            slide: props.carouselDefaultSlide,
        };
        checkCarousel({props, section});
    }
};

export const changeSlide = ({diff, section}) => {
    const {
        amount,
        carousel,
        carousel: {$inner, blocked, infoBlocks, slide},
        orientation,
    } = section;

    if (!blocked) {
        let axis = null;

        switch (orientation) {
            case 'horizontal':
                axis = 'X';

                break;
            case 'vertical':
                axis = 'Y';

                break;
            default:
                break;
        }

        const infoBlocksAmount = Object.keys(infoBlocks).length;
        const availableSlideAmount = Math.max(infoBlocksAmount - amount + 1, 1);
        const computedSlide = slide + diff;
        let newSlide = slide;

        switch (true) {
            case 0 > diff:
                newSlide = 1 === slide ? availableSlideAmount : computedSlide;

                break;
            case 0 < diff:
                newSlide = availableSlideAmount === slide ? 1 : computedSlide;

                break;
            default:
                break;
        }

        if (newSlide !== slide) {
            carousel.slide = newSlide;

            const offset = -(newSlide - 1) * (1 / amount) * 100;

            $inner.style.transform = `translate${axis}(${offset}%)`;
        }
    }
};

export const checkCarousel = ({props, section}) => {
    const {
        amount,
        carousel,
        carousel: {$: $carousel, $inner, blocked, infoBlocks},
    } = section;

    const infoBlocksAmount = Object.keys(infoBlocks).length;
    const isBlocked = infoBlocksAmount <= amount;

    if (blocked !== isBlocked) {
        carousel.blocked = isBlocked;

        if (isBlocked) {
            carousel.slide = props.carouselDefaultSlide;
            $inner.style.transform = null;
        }

        $carousel.setAttribute(props.iBSectionAttrBlocked, isBlocked ? props.iBSectionAttrBlockedTrue : props.iBSectionAttrBlockedFalse);
    }
};
