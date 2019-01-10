import './style/main.less';
import Clipboard from 'clipboard';

window.$ = $;
let $body = $('body');

$(function() {
    bindSidebarToggle();
    bindTabs();
    bindPopover();
    bindDatePicker();
    bindICheck();
    bindSelect2();
    bindCustomInputFile();
    bindModal();
    bindClipBoard();
});

function bindSidebarToggle() {
    $(document)
        .off('expanded.pushMenu.menuOpened collapsed.pushMenu.menuClosed')
        .on('expanded.pushMenu.menuOpened collapsed.pushMenu.menuClosed', () => {
            localStorage.setItem('sidebar', $body.hasClass('sidebar-collapse') ? 0 : 1);
        });

    if (0 === parseInt(localStorage.getItem('sidebar'), 10)) {
        $body.addClass('disable-animations sidebar-collapse');
        requestAnimationFrame(function() {
            $body.removeClass('disable-animations');
        });
    }
}

function bindCustomInputFile() {
    $(document)
        .off('change.inputFile')
        .on('change.inputFile', ':file', function() {
            let $input = $(this),
                numFiles = $input.get(0).files ? $input.get(0).files.length : 1,
                label = $input.val().replace(/\\/g, '/').replace(/.*\//, ''),
                inputText = $(this).parents('.input-group').find('.j-file-name'),
                log = 1 < numFiles ? numFiles + ' files selected' : label;
            $input.trigger('fileselect', [numFiles, label]);

            if (inputText.length) {
                inputText.val(log);
            } else if (log) {
                console.log(log);
            }
        });
}

function bindTabIndex() {
    $('.modal').removeAttr('tabindex');
}

function bindClipBoard() {
    let clipboard = new Clipboard('.j-copy');

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
}
function bindICheck() {
    $('.j-icheck').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%', // optional
    });
}

function bindSelect2() {
    let $inputSelect = $('.j-multi-select2-all-selected');
    let $optionsSelect = $inputSelect.find('option');
    $inputSelect.select2();
    $optionsSelect.prop('selected', 'selected');
    $inputSelect.trigger('change');
    $('.j-multi-select2').select2({
        width: '100%',
    });
    let $inputSelectNormal = $('.j-multi-select2-normal');
    $inputSelectNormal.select2({
        minimumResultsForSearch: Infinity,
        width: 'element',
    });
}

function bindTabs() {
    let tabSelector = '.nav-tabs a',
        hash = window.location.hash;

    if (hash) {
        $('ul.nav a[href="' + hash + '"]').tab('show');
    }

    $(tabSelector)
        .off('click.Tabs')
        .on('click.Tabs', function() {
            $(this).tab('show');
            let scrollMem = $('body').scrollTop() || $('html').scrollTop();
            window.location.hash = this.hash;
            $('html, body').scrollTop(scrollMem);
        });
}

function bindPopover() {
    $body.popover({
        container: 'body', // table support
        selector: '[data-toggle="table-popover"]',
        placement: 'bottom',
        trigger: 'hover',
        html: true,
        delay: 300,
        content: getPopoverContent,
    });
}

function getPopoverContent() {
    let content = '.table__popover-content';
    let $content = $(this).find(content);

    return 0 < $content.length ? $content.html() : content;
}

function bindDatePicker() {
    let $datePicker = $('.j-datepicker');

    $datePicker.each((key, element) => {
        let $element = $(element);
        if (undefined === $element.data('daterangepicker')) {
            $element.daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                },
            });
        }
    });
}

function destroyDatePicker($context) {
    let $datePicker = $('.j-datepicker', $context);

    $datePicker.each((key, element) => {
        let $element = $(element);

        let data = $element.data('daterangepicker');
        if (undefined !== data) {
            data.remove();
        }
    });
}

/**
 *
 */
function bindAjaxSubmit() {
    $(document)
        .off('click.bsModalAjaxSubmit', '.j-bs-modal-ajax-submit-btn')
        .on('click.bsModalAjaxSubmit', '.j-bs-modal-ajax-submit-btn', (e) => {
            e.preventDefault();

            const $submitBtn = $(e.target),
                $form = $submitBtn.closest('form'),
                $modal = $submitBtn.closest('.modal'),
                options = $submitBtn.data(),
                loaderSelector = options && options['loaderSelector'],
                failSelector = options && options['failSelector'],
                $loader = $modal.find(loaderSelector),
                $fail = $modal.find(failSelector);

            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method') || 'POST',
                data: $form.serialize(),
                beforeSend: () => {
                    // Prevent modal window close on outside-click
                    $modal.data('bs.modal').options.backdrop = 'static';
                    // Prevent modal window close on 'Esc'
                    $modal.data('bs.modal').options.keyboard = false;

                    // Visual changes to highlight loading process
                    $modal.find('.close').addClass('hidden');
                    $modal.find('.modal-footer').not(loaderSelector).addClass('hidden');
                    $modal.find('.modal-body').not(loaderSelector).addClass('hidden');
                    $loader.removeClass('hidden');
                },
            })
                .done(() => {
                    location.reload();
                })
                .fail(() => {
                    $loader.addClass('hidden');
                    $fail.removeClass('hidden');
                    $modal.find('.modal-footer').removeClass('hidden');
                    $modal.data('bs.modal').options.backdrop = true;
                    $modal.data('bs.modal').options.keyboard = true;
                });
        });
}

/**
 * Method for:
 * — widget Modal with 'forceUpdate' => true option and enabled client validation;
 * — submit button sends form if there are no errors and any successes (user passed validation);
 * — modal window closes together with form sending;
 */
function bindClientValidationSubmit() {
    const formSelector = '#report-dates-form';

    $(document)
        .off('afterValidate.downloadReport', formSelector)
        .on('afterValidate.downloadReport', formSelector, (e) => {
            const $modal = $(e.target).closest('.modal'),
                $selectVal = $modal.find('#reportform-configids option:selected').val(),
                $selectField = $modal.find('.j_field-reportform-configids'),
                $selectFieldHelpBlock = $selectField.find('.help-block');

            if (!$selectVal) {
                $selectField.addClass('has-error');
                $selectFieldHelpBlock.text('Included Scenarios cannot be blank.');
            } else {
                $selectField.removeClass('has-error');
                $selectFieldHelpBlock.text('');
            }

            if (!$modal.find('.has-error').length && $modal.find('.has-success').length) {
                $modal.modal('hide');
                $(formSelector).trigger('submit.downloadReport');
            } else {
                $(document)
                    .off('beforeSubmit.downloadReport', formSelector)
                    .on('beforeSubmit.downloadReport', formSelector, () => false);
            }
        });
}

function bindModal() {
    $(document)
        .off('hide.bs.modal.hideModal')
        .on('hide.bs.modal.hideModal', (e) => {
            destroyDatePicker($(e.target));
        })
        .off('loaded.bs.modal')
        .on('loaded.bs.modal', () => {
            bindTabIndex();
            bindDatePicker();
            bindICheck();
            bindSelect2();
            bindAjaxSubmit();
            bindClientValidationSubmit();
        });
    // принудительно обновлять контент для модальных окон
    $body
        .off('hidden.bs.modal.forceUpdate')
        .on('hidden.bs.modal.forceUpdate', '[data-force-update]', function() {
            $(this).removeData('bs.modal');
        });
}