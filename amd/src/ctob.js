/**
 * Submit SSO Authentication form when clicking on iFrame
 *
 * @module     mod_cardtobrain/ctob
 * @package    mod_cardtobrain
 * @copyright  2016 Salim Hermidas <salim.hermidas@webapps.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery'], function($) {
    var ctob = {
        box: {},

        form: {},

        openBox: function(event) {
            event.preventDefault();
            // Submit SSO Authentication form
            ctob.form.submit();
        },

        setup: function(container, form) {
            var body = $('body');
            ctob.box = body.find(container);
            ctob.form = body.find(form);
            ctob.box.on('click', ctob.openBox);
        }
    };

    return {
        setup: ctob.setup
    };
});