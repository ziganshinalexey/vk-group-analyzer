import {Main} from 'modules/common/containers/Main';
import {Route} from 'modules/common/containers/Route';
import * as React from 'react';

export function CommonRoutes() {
    return (
        <Route exact path="/" component={Main} />
    );
}
