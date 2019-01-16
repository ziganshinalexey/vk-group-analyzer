import * as React from 'react';
import {connect} from 'react-redux';
import {FormVk} from 'modules/common/containers/FormVk';
import injectSheet from 'react-jss';
import {compose} from 'redux';

const styles = () => ({
    container: {
        display: 'flex',
    },
    wrapper: {
        padding: 20,
        width: '100%',
    },
    '@media (min-width: 1024px)': {
        wrapper: {
            marginLeft: '25%',
            width: '50%',
        },
    },
});

class Main extends React.Component {
    render() {
        const {classes} = this.props;

        return (
            <div className={classes.container}>
                <div className={classes.wrapper}>
                    <p>
                        Специфичность Вашей активности в соцсетях может рассказать о том, к чему лежит Ваша душа, в частности: <b>гуманитарий</b> Вы
                        или <b>технарь</b>.
                    </p>
                    <FormVk />
                </div>
            </div>
        );
    }
}

const MainWrapped = compose(
    connect(
        (state) => ({}),
        {},
    ),
    injectSheet(styles),
)(Main);

export {MainWrapped as Main};