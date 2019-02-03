import * as React from 'react';
import injectSheet from 'react-jss';
import { Accordion } from 'modules/common/components/Accordion';

const styles = (theme) => ({
    chart: {
        margin: '30px 30px 45px',
        position: 'relative',
    },
    dash: {
        backgroundColor: theme.COLOR_ACCENT_COLD,
        bottom: -23,
        position: 'absolute',
        top: -5,
        width: 1,
    },
    item: {
        fontSize: 14,
    },
    pointer: {
        bottom: 0,
        position: 'absolute',
        transition: 'left 1s ease-in-out',
        top: 0,
        width: 1,
    },
    resultLeft: {
        fontSize: 14,
        position: 'absolute',
        right: 'calc(50% + 5px)',
        textAlign: 'right',
        top: 'calc(100% + 5px)',
        whiteSpace: 'nowrap',
    },
    resultRight: {
        fontSize: 14,
        left: 'calc(50% + 5px)',
        position: 'absolute',
        textAlign: 'left',
        top: 'calc(100% + 5px)',
        whiteSpace: 'nowrap',
    },
    scale: {
        background: `linear-gradient(90deg, ${theme.COLOR_ACCENT_WARM}, ${theme.COLOR_ACCENT_COOL})`,
        display: 'flex',
        justifyContent: 'space-between',
        padding: 10,
    },
});

class ResultChart extends React.Component {
    state = {
        duration: 0,
        left: 50,
        start: false,
        total: 0,
        valueLeft: 50,
        valueRight: 50,
    };

    delay = 500;

    duration = 1000;

    offset = 50;

    step = 20;

    framesCount = this.duration / this.step;

    calculateValue = () => {
        this.setState((prevState) => {
            const {
                duration: prevDuration,
                left: prevLeft,
                total: prevTotal,
                valueLeft: prevValueLeft,
                valueRight: prevValueRight,
            } = prevState;

            if (prevDuration < this.duration) {
                const delta = (this.offset - prevLeft) / this.framesCount;

                return ({
                    duration: prevDuration + this.step,
                    valueLeft: prevTotal ? prevValueLeft + delta : prevValueLeft,
                    valueRight: prevTotal ? prevValueRight - delta : prevValueRight,
                });
            }
        });
    };

    animatePointer = () => {
        const {data} = this.props;
        const dataValues = Object.values(data);
        const total = dataValues.reduce((acc, {ratio}) => acc + ratio, 0);
        const left = total ? 100 * dataValues[1].ratio / total : this.offset;

        this.setState({
            left,
            start: true,
            total,
        });
        this.interval = setInterval(this.calculateValue, this.step);
    };

    componentDidMount() {
        this.timeout = setTimeout(this.animatePointer, this.delay);
    }

    componentWillUnmount() {
        if (this.interval) {
            clearInterval(this.interval);
        }

        if (this.timeout) {
            clearTimeout(this.timeout);
        }
    }

    render() {
        const {classes, data} = this.props;
        const {duration, left, start, total, valueLeft, valueRight} = this.state;        

        return (
            <div>
                <div className={classes.chart}>
                    <div className={classes.scale}>
                        {Object.entries(data).map(([id, {name}]) => (
                            <div className={classes.item} key={id}>
                                {name}
                            </div>
                        ))}
                    </div>
                    <div className={classes.pointer} style={{left: `${left}%`}}>
                        <div className={classes.dash} />
                        <div className={classes.resultLeft}>{`${Math.round(valueLeft)}%`}</div>
                        <div className={classes.resultRight}>{`${Math.round(valueRight)}%`}</div>
                    </div>
                </div>
                {start && !total && (
                    <div>Недостаточно данных для анализа типа личности :(</div>
                )}
                {duration === this.duration && (
                    <Accordion title="Список актуальных профессий">
                    <h4>Гуманитарий</h4>
                    <ul>
                        <li>
                            <h5>Конструкторы команд</h5>
                            До четверти работников, трудящихся в наши дни на полную ставку, через восемь лет будут работать «по запросу». Востребованы будут коммуникаторы-управленцы, способные быстро объединять фрилансеров из разных точек мира в слаженно работающие проектные команды
                        </li>
                        <li>
                            <h5>Преподаватели — инженеры опыта</h5>
                            Сама методика преподавания часто будет предлагать создание окружения, в том числе с использованием VR, где обстановка будет приближена к реальной
                        </li>
                        <li>
                            <h5>Дизайнер виртуальной среды обитания</h5>
                            Дизайнер виртуальной среды обитания займется проектированием виртуальных миров, создавая подходящие условия для деловых встреч или, скажем, VR-музеи
                        </li>
                        <li>
                            <h5>Адвокат по робоэтике</h5>
                            Адвокат по робоэтике выступит в качестве посредника между людьми, роботами и искусственным интеллектом, устанавливая моральные и этические законы, по которым машины будут трудиться среди живых существ
                        </li>
                        <li>
                            <h5>Digital-комментатор культуры</h5>
                            Digial-комментаторы помогут аудитории будущего понять мировое художественное наследие прошлых веков в максимально доступной форме — с помощью современных технологий
                        </li>
                        <li>
                            <h5>Инженер по восстановлению окружающей среды</h5>
                            Инженеры по восстановлению окружающей среды займутся реабилитацией экосистем в местах с угнетенной экологией, используя образцы флоры и фауны со всего мира. Кроме того, подобные специалисты будут восстанавливать вымершие виды растений и животных
                        </li>
                    </ul>
                    <h4>Технарь</h4>
                    <ul>
                        <li>
                            <h5>Разработчики (в том числе веб-разработчики, создатели приложений), специалисты по маркетингу и анализу рынка</h5>
                        </li>
                        <li>
                            <h5>Специалист 3D-моделирования</h5>
                            Совмещает в себе навыки визуализатора и модельера. В обязанности специалиста входит разработка трёхмерных моделей робототехники
                        </li>
                        <li>
                            <h5>Инженеры-робототехники</h5>
                            Это будут специалисты, которые смогут как создавать, так и программировать роботов. Робототехник одновременно является инженером, программистом и кибернетиком, должен иметь знания в области механики, теории проектирования и управления автоматическими системами
                        </li>
                        <li>
                            <h5>Агрокибернетики</h5>
                            Контролируют эффективность хозяйства как единой системы, отслеживают и используют в работе большие данные, получаемые с датчиков «в поле»
                        </li>
                        <li>
                            <h5>Биохакер на фрилансе</h5>
                            Энтузиасты любительских исследований в сфере молекулярной биологии, будут работать над поиском методов для лечения депрессии, аутизма, шизофрении и болезни Альцгеймера
                        </li>
                        <li>
                            <h5>Аналитик данных «Интернета вещей»</h5>
                            Они изучат большое количество данных, генерируемых домашней техникой, устройствами из офиса или автомобиля, чтобы понять, что вся эта информация говорит о нас, на пример для поиска новых способов взаимодействия между электронными приборами
                        </li>
                        <li>
                            <h5>Дизайнер человеческого тела</h5>
                            Они изучат большое количество данных, генерируемых домашней техникой, устройствами из офиса или автомобиля, чтобы понять, что вся эта информация говорит о нас, на пример для поиска новых способов взаимодействия между электронными приборами
                        </li>
                        <li>
                            <h5>Разработчик средств постоянного питания</h5>
                            это специалисты с познаниями в таких областях, как химия и материаловедение. Под их руководством начнется разработка нового поколения батарей, способных справиться с потребностями населения будущего, все более зависимого от «Интернета вещей»
                        </li>
                    </ul>
                    </Accordion>
                )}
            </div>
        );
    }
}

const styledResultChart = injectSheet(styles)(ResultChart);

export {styledResultChart as ResultChart};
