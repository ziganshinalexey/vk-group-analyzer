const SELECTORS = {
    // form: '.j-active-form',
    submit: '.j-active-form-submit',
    reset: '.j-active-form-reset',
};

// хак для инициализации jQuery плагинов
const DELAY = 100;

class ActiveForm {
    constructor(form) {
        this.$form = $(form);
        this.$submit = this.$form.find(SELECTORS.submit);
        this.$submitHide = this.$submit.filter('[data-active-form-hide="1"]');
        this.$reset = this.$form.find(SELECTORS.reset);
        this.$fields = this.$form.find('input, textarea, select');

        this.timeoutReset = null;
        this.timeoutSubmit = null;

        this.init();
    }

    init() {
        this.bindSubmitEvents();
        this.bindResetEventsEvents();
    }

    bindSubmitEvents() {
        this.$form
            .off('beforeValidate.formValidate')
            .on('beforeValidate.formValidate', this.beforeValidate.bind(this))
            .off('afterValidate.formValidate')
            .on('afterValidate.formValidate', this.afterValidate.bind(this));
    }

    bindResetEventsEvents() {
        this.$form
            .off('reset.formReset')
            .on('reset.formReset', () => {
                clearTimeout(this.timeoutReset);
                this.timeoutReset = setTimeout(this.resetForm.bind(this), DELAY);
            });

        // jQuery плагины могут создавать свои инпуты, так что нужно повесить обработчики событий до их инициализации (например select2).
        this.$fields
            .off('keyup.checkActiveFormInputs change.checkActiveFormInputs paste.checkActiveFormInputs')
            .on('keyup.checkActiveFormInputs change.checkActiveFormInputs paste.checkActiveFormInputs', this.showSubmitButton.bind(this))
            // jQuery.iCheck
            .off('ifChanged.checkActiveFormInputs')
            .on('ifChanged.checkActiveFormInputs', this.showSubmitButton.bind(this));
    }

    beforeValidate() {
        this.lockButtons();
    }

    afterValidate(event, attribute, messages) {
        clearTimeout(this.timeoutSubmit);

        if (!$(messages).length) {
            this.timeoutSubmit = setTimeout(this.lockButtons.bind(this), DELAY);
        } else {
            this.unlockButtons();
        }
    }

    resetForm() {
        this.$fields.each((i, field) => {
            const $field = $(field);
            const data = $field.data();

            if (data['select2']) {
                $field.select2();
            } else if (data['iCheck']) {
                $field.iCheck('update');
            }
        });

        this.hideSubmitButton();
    }

    lockButtons() {
        this.$submit.attr('disabled', true);
        this.$reset.attr('disabled', true);
    }

    unlockButtons() {
        this.$submit.attr('disabled', false);
        this.$reset.attr('disabled', false);
    }

    hideSubmitButton() {
        this.$submitHide.addClass('hide');
    }

    showSubmitButton() {
        this.$submitHide.removeClass('hide');
    }
}

$.fn.extend({
    usActiveForm() {
        this.each(function() {
            new ActiveForm(this);
        });
    },
});
