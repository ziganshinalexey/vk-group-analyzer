const selector = {
    drop: '.j-active-drop-up',
};

class DateRangePicker {
    constructor() {
        this.$drop = $(selector.drop);
        this.bind();
    }

    bind() {
        this.$drop
            .off('showCalendar.daterangepicker')
            .on('showCalendar.daterangepicker', (ev, picker) => this.dropDateRangePicker(ev, picker));
    }

    dropDateRangePicker(/*ev, picker*/) {
        // Timur Togyzbaev - Закомментировал, не знаю зачем это надо, без него вроде работает, оставляю на время тестирования
        // Убрал потому что расчитывается неправильно и пикер вылазеет за страницу
        // if (picker.element.offset().top - $(window).scrollTop() + picker.container.outerHeight() > $(window).height()) {
        //     picker.drops = 'up';
        // } else {
        //     picker.drops = 'down';
        // }

    }
}

$.fn.extend({
    usDateRangePicker() {
        this.each(function() {
            new DateRangePicker(this);
        });
    },
});