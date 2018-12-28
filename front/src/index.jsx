import {ConnectedRouter, connectRouter, routerMiddleware} from 'connected-react-router';
import * as React from 'react';
import ReactDOM from 'react-dom';
import {IntlProvider} from 'react-intl';
import {Provider} from 'react-redux';
import {createBrowserHistory} from 'history';
import {Route, Switch} from 'react-router-dom';
import {mainReducer} from 'reducers';
import {applyMiddleware, compose, createStore} from 'redux';
import thunk from 'redux-thunk';

const history = createBrowserHistory();
const extraArgs = {};
const middlewares = [routerMiddleware(history), thunk.withExtraArgument(extraArgs)];
const store = createStore(
    connectRouter(history)(mainReducer),
    undefined,
    compose(
        applyMiddleware(...middlewares),
        'production' !== process.env.NODE_ENV && window.__REDUX_DEVTOOLS_EXTENSION__ ? window.__REDUX_DEVTOOLS_EXTENSION__() : (f) => f
    )
);

console.log(store);

(() => {
    ReactDOM.render(
        <Provider store={store}>
            <IntlProvider
                locale="en"
                messages={{}}
            >
                <ConnectedRouter history={history}>
                    <div>
                        <Switch>
                            <Route exact path="/" render={() => <div>Test</div>} />
                        </Switch>
                    </div>
                </ConnectedRouter>
            </IntlProvider>
        </Provider>,
        document.getElementById('root')
    );
})();
