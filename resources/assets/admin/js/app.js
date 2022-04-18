$(document).ready(function () {
    GLOBAL_CONFIG.init();
});

window.GLOBAL_CONFIG = function () {
    return {
        toggleBuilder : () => {
            /*$('[data-toggle=confirmation]').confirmation({
                rootSelector   : '[data-toggle=confirmation]',
                title          : trans('message.confirm_delete'),
                btnOkLabel     : trans('message.yes'),
                btnCancelLabel : trans('message.no'),
                singleton      : true,
                popout         : true
            });*/

            $('[data-init-plugin="select2"]').each(function () {
                let config = {
                    theme: 'bootstrap4',
                    minimumResultsForSearch : -1,
                    disabled                : !!($(this).attr('readonly')),
                };

                $(this).select2(config);
            });

        },

        init : function () {
            this.toggleBuilder();
            //$('form.has_validate').formValidation();
        }
    };
}();
