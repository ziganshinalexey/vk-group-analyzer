import * as React from 'react';
import RcNotification from 'rc-notification';
import {THEME} from 'utils/constants';

const noticeStyle = {
    backgroundColor: THEME.COLOR_WHITE,
    boxShadow: `0 4px 12px ${THEME.COLOR_SHADOW}`,
    border: `1px solid ${THEME.COLOR_ERROR}`,
    color: THEME.COLOR_ERROR,
    fontSize: 16,
    minHeight: 50,
    minWidth: 300,
    padding: 20,
    position: 'fixed',
    right: 10,
    top: 90,
};

export const Notification = ({instanceProps = {}, noticeProps = {}}) => RcNotification.newInstance({...instanceProps}, (notification) => {
    notification.notice({
        duration: 3,
        style: noticeStyle,
        ...noticeProps
    });
});
