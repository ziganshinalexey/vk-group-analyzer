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
        minHeight: 100,
        minWidth: 100,
        width: 100,
    },
    text: {
        fontSize: 14,
    }
});

class UserCard extends React.Component {
    render() {
        const {classes, id, facultyName, firstName, lastName, photo, universityName} = this.props;

        return (
            <section>
                <h4>Информация о профиле</h4>
                <div className={classes.info}>
                    {photo && (
                        <div className={classes.photo} style={{backgroundImage: `url(${photo})`}} />
                    )}
                    <div className={classes.text}>
                        {id && (
                            <div>Id: <b>{id}</b></div>
                        )}
                        {firstName && (
                            <div>Имя: <b>{firstName}</b></div>
                        )}
                        {lastName && (
                            <div>Фамилия: <b>{lastName}</b></div>
                        )}
                        {universityName && (
                            <div>ВУЗ: <b>{universityName}</b></div>
                        )}
                        {facultyName && (
                            <div>Факультет: <b>{facultyName}</b></div>
                        )}
                    </div>
                </div>
            </section>
        );
    }
}

const styledUserCard = injectSheet(styles)(UserCard);

export {styledUserCard as UserCard};