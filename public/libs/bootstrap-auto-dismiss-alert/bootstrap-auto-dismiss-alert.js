
/*!
 * Bootstrap Auto-dismiss alerts
 * Mario Juárez <mario@mjp.one>
 * https://github.com/mariomka/bootstrap-auto-dismiss-alert
 * Licensed under the MIT license
 */

;(function ($) {

    'use strict';

    $('.alert[data-auto-dismiss]').each(function (index, element) {
        var $element = $(element),
            timeout  = $element.data('auto-dismiss') || 5000;

/*         setTimeout(function () {
            $element.alert('close');
        }, timeout); */

        //$element.hide({duration: 300, queue: true});
        $element.fadeIn()
        .animate({opacity: '+=0'}, 2000)   // Does nothing for 2000ms
        .fadeOut('fast');
    });

})(jQuery);