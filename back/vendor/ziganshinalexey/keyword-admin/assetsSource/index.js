"use strict";

function _defineProperty(obj, key, value) {
    if (key in obj) {
        Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true
        });
    } else {
        obj[key] = value;
    }
    return obj;
}

window.onload = function() {
    document.addEventListener("click", handleBtnGroupClick, true);
};

function handleBtnGroupClick(e) {
    var $target = e.target;
    var $parent = findClosest($target, ".j-custom-btn-group");

    if ("radio" === $target.type && $parent) {
        var $entry = findClosest($target, ".j-entry");

        if ($entry) {
            var entryId = $entry.getAttribute("data-key");

            if (entryId) {
                var $$td = $entry.querySelectorAll(".j-entry-item");

                if ($$td) {
                    var customBtnGroupName = $parent.getAttribute("data-name");
                    var customBtnGroupValue = $parent.querySelector(
                        ".j-custom-btn-group-item:checked"
                    ).value;

                    if (customBtnGroupName) {
                        var formData = _defineProperty(
                            {},
                            customBtnGroupName,
                            customBtnGroupValue ? customBtnGroupValue : null
                        );

                        $$td.forEach(function($td) {
                            var name = $td.getAttribute("data-name");
                            var value = $td.getAttribute("data-value");

                            if (name && value && name !== customBtnGroupName) {
                                formData[name] = value;
                            }
                        });

                        // console.log(formData, '/api/v1/keyword');

                        var req = new XMLHttpRequest();

                        req.open("POST", "/api/v1/keyword/" + entryId, true);
                        req.setRequestHeader("x-http-method-override", "PUT");
                        req.setRequestHeader("Content-Type", "application/json");
                        req.withCredentials = true;
                        req.send(JSON.stringify(formData));
                    }
                }
            }
        }
    }
}

function hasClass($el, className) {
    return -1 < (" " + $el.className + " ").indexOf(" " + className + " ");
}

function findClosest($el, selector) {
    var $$targets = document.querySelectorAll(selector);
    var $tempEl = $el;

    while ($tempEl) {
        var $found = null;

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
