import * as React from 'react';
import {FormVk} from 'modules/common/containers/FormVk';
import injectSheet from 'react-jss';

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
                        Перед подростками старших классов стоит <b>проблема профессионального самоопределения</b>.<br />
                        Это напрямую связано с противоречием внешних стимулов и системы реально действующих мотивов старшеклассников.<br />
                        Количество различных специальностей на данный момент – несколько тысяч, у каждой есть своя специфика.<br />
                        Чтобы не запутаться во всем этом многообразии и сузить поиски идеального направления, предлагаем воспользоваться нашим сайтом.<br />
                        Надеемся, это поможет <b>сузить сферу поиска будущей профессии</b>!
                    </p>
                    <FormVk />
                </div>
            </div>
        );
    }
}

const MainWrapped = injectSheet(styles)(Main);

export {MainWrapped as Main};