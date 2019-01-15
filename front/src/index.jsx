import {commonModuleReducer} from 'modules/common/reducers';
import {CommonRoutes} from 'modules/common/routes';
import {MODULE_NAME as commonModuleName} from 'modules/common/constants';
import * as React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import {createBrowserHistory} from 'history';
import {Router} from 'react-router';
import {Switch} from 'react-router-dom';
import {applyMiddleware, combineReducers, compose, createStore} from 'redux';
import thunk from 'redux-thunk';
import {THEME} from 'utils/constants';
import {ThemeProvider} from 'react-jss';

const history = createBrowserHistory();
const mainReducer = combineReducers({
    [commonModuleName]: commonModuleReducer,
});
const store = createStore(
    mainReducer,
    undefined,
    compose(
        applyMiddleware(thunk.withExtraArgument({})),
        'production' !== process.env.NODE_ENV && window.__REDUX_DEVTOOLS_EXTENSION__ ? window.__REDUX_DEVTOOLS_EXTENSION__() : (f) => f,
    ),
);

// const LazyCommonRoutes = React.lazy(() => import('modules/common/routes'));
// const SuspenseCommonRoutes = () => (
//     <React.Suspense fallback={<Preloader />}>
//         <LazyCommonRoutes />
//     </React.Suspense>
// );

ReactDOM.render(
    <Provider store={store}>
        <ThemeProvider theme={THEME}>
            <Router history={history}>
                <Switch>
                    <CommonRoutes />
                </Switch>
            </Router>
        </ThemeProvider>
    </Provider>,
    document.getElementById('root'),
);
