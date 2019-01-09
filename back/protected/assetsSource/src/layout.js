import {handleClick} from './handlers';

export const drawLayout = ({callback, data, props, structure}) => {
    const {layout} = data;

    if (layout) {
        const {src} = layout;
        const $container = document.querySelector(props.containerSelector);

        if ($container && src) {
            structure.container = {
                $: $container,
            };
            $container.innerHTML = src;

            const $layout = document.querySelector(props.layoutSelector);

            structure.layout = {
                $: $layout,
                ...layout,
            };
            document.addEventListener('click', (e) => handleClick({e, props, structure}), true);

            if (callback) {
                callback();
            }
        }
    }
};
