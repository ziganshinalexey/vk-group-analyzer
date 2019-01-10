import 'inputmask-multi/js/jquery.inputmask-multi.js';
import CODES from './phone-codes.json';

class MaskedInputMulti {
    constructor(blockEl) {
        this.$input = $(blockEl);

        this.init();
    }

    init() {
        let switchPlaceholdersOnFocus = !!this.$input.attr('placeholder');

        this.maskList = $.masksSort(CODES, ['#'], /[0-9]|#/, 'mask');
        this.maskOpts = {
            inputmask: {
                definitions: {
                    '#': {
                        validator: '[0-9]',
                        cardinality: 1,
                    },
                },
                showMaskOnHover: false,
                autoUnmask: true,
            },
            match: /[0-9]/,
            replace: '#',
            list: this.maskList,
            listKey: 'mask',
            onMaskChange() {
                if (!switchPlaceholdersOnFocus) {
                    $(this).attr('placeholder', $(this).inputmask('getemptymask'));
                }
            },
        };

        this.bind();
        this.$input.trigger('change.maskPhone');
    }

    bind() {
        this.$input
            .off('change.maskPhone')
            .on('change.maskPhone', () => {
                this.applyMask();
            });
    }

    applyMask() {
        this.$input.inputmasks(this.maskOpts);
    }
}

$.fn.extend({
    multiMaskedInput() {
        $(this).each(function() {
            new MaskedInputMulti(this);
        });
    },
});
