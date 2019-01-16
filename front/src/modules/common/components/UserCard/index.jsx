import * as React from 'react';
import injectSheet from 'react-jss';

const styles = () => ({
    info: {
        display: 'flex',
        marginBottom: 10,
        marginTop: 10,
    },
    photo: {
        background: 'no-repeat center/cover',
        height: 100,
        marginRight: 10,
        width: 100,
    },
});

class UserCard extends React.Component {
    render() {
        const {classes, id, firstName, lastName, photo} = this.props;

        return (
            <section>
                <h4>Информация о профиле</h4>
                <div className={classes.info}>
                    {photo && (
                        <div className={classes.photo} style={{backgroundImage: `url(${photo})`}} />
                    )}
                    <div>
                        {id && (
                            <div>Id: <b>{id}</b></div>
                        )}
                        {firstName && (
                            <div>Имя: <b>{firstName}</b></div>
                        )}
                        {lastName && (
                            <div>Фамилия: <b>{lastName}</b></div>
                        )}
                    </div>
                </div>
            </section>
        );
    }
}

const styledUserCard = injectSheet(styles)(UserCard);

export {styledUserCard as UserCard};