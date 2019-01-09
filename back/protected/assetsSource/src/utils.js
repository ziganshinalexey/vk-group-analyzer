export function findClosest($el, selector) {
    const $$targets = document.querySelectorAll(selector);
    let $tempEl = $el;

    while ($tempEl) {
        let $found = null;

        $$targets.forEach(function($target) {
            if ($tempEl === $target) {
                $found = $target;
            }
        });

        if ($found) {
            return $tempEl;
        } else {
            $tempEl = $tempEl.parentNode;
        }
    }

    return null;
}

export function findElLastParentNode($el, $target) {
    let $tempEl = $el;

    while ($tempEl && $tempEl.parentNode) {
        const nextNode = $tempEl.parentNode;

        if (nextNode === $target) {
            return $tempEl;
        } else {
            $tempEl = nextNode;
        }
    }

    return null;
}

export function getDataAttrName(name) {
    return name ? 'data-' + name : null;
}

export function selectWithAttr(attrName, attrValue) {
    return attrName ? '[' + attrName + '="' + attrValue + '"]' : '';
}

export function getUTCTime() {
    const time = new Date().getTime();
    const offset = new Date().getTimezoneOffset() * 60000;

    return time - offset;
}

export function normalizeDate(date) {
    return date.replace(/-/g, '/');
}

export function getOrientationAffix(orientation) {
    switch (orientation) {
        case 'horizontal':
            return 'h';
        case 'vertical':
            return 'v';
        default:
            return '';
    }
}
