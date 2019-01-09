function getUTCTime(dateString) {
    const time = dateString ? new Date(dateString).getTime() : new Date().getTime();
    const offset = new Date().getTimezoneOffset() * 60000;

    return time - offset;
}

const OPTIONS = {
    channelId: 1,
    containerSelector: '#container',
    platform: 'PC',
    time: getUTCTime(),
    userAge: 25,
    userId: 1,
    userLocation: 'Tomsk',
};

function setCustomTime(dateString) {
    const customTime = getUTCTime(dateString);

    window.setTimeTouchTv(customTime, function() {
        console.warn('Set time: ' + customTime);
    });

    if (!window.customTimeTouchTvInterval) {
        window.customTimeTouchTvInterval = setInterval(function() {
            setCustomTime(dateString);
        }, 1000);
    }
}

window.onload = function() {
    const $container = document.querySelector(OPTIONS.containerSelector);

    if ($container) {
        const host = $container.getAttribute('data-host');

        if (host) {
            OPTIONS.host = host;

            const xhr = new XMLHttpRequest();

            xhr.open('GET', `${OPTIONS.host}/api/v1/player-option`, true);
            xhr.onreadystatechange = function() {
                if (4 === xhr.readyState) {
                    if (200 === xhr.status) {
                        const {
                            data: {path, jsPath, cssPath},
                        } = JSON.parse(xhr.responseText);
                        const $head = document.head;

                        if (path && jsPath) {
                            const $script = document.createElement('script');

                            $script.onload = function() {
                                window.initTouchTv(OPTIONS, function() {
                                    console.warn('Callback!');
                                });

                                setCustomTime();
                            };
                            $script.type = 'text/javascript';
                            $script.src = `${path}${jsPath}`;
                            $head.append($script);
                        }

                        if (path && cssPath) {
                            const $styles = document.createElement('link');

                            $styles.type = 'text/css';
                            $styles.rel = 'stylesheet';
                            $styles.href = `${path}${cssPath}`;
                            $head.append($styles);
                        }
                    }
                }
            };
            xhr.withCredentials = true;
            xhr.send();
        }
    }
};
