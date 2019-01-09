export const drawModal = ({props, structure}) => {
    const {modal} = structure;

    if (modal) {
        const $modal = document.querySelector(props.iBModalSelector);

        if ($modal) {
            const $close = document.createElement('div');
            const $content = document.createElement('div');

            $modal.setAttribute('hidden', 'true');
            $close.className = props.iBModalCloseClass;
            $content.className = props.iBModalContentClass;
            $modal.appendChild($close);
            $modal.appendChild($content);
            structure.modal = {
                $: $modal,
                $close,
                $content,
                isOpened: false,
            };
        }
    }
};

export const drawModalContents = ({infoBlock, props, structure}) => {
    if (infoBlock) {
        const {
            modal: {$content},
        } = structure;

        if ($content) {
            const {title, fullDescription, shortDescription} = infoBlock;

            if (title) {
                const $title = document.createElement('div');

                $title.className = props.iBModalTitleClass;
                $title.innerHTML = title;
                $content.appendChild($title);
            }

            if (shortDescription) {
                const $shortDescription = document.createElement('div');

                $shortDescription.className = props.iBModalShortDescriptionClass;
                $shortDescription.innerHTML = shortDescription;
                $content.appendChild($shortDescription);
            }

            if (fullDescription) {
                const $fullDescription = document.createElement('div');

                $fullDescription.className = props.iBModalFullDescriptionClass;
                $fullDescription.innerHTML = fullDescription;
                $content.appendChild($fullDescription);
            }
        }
    }
};

export const clearModalContents = ({structure}) => {
    const {
        modal: {$content},
    } = structure;

    if ($content) {
        $content.innerHTML = null;
    }
};
