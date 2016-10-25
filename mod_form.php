<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Add sets of flashcards from card2brain.ch to your Moodle courses.
 * - link to flashcard list or learning view
 * - enable SSO Authentication for your corporate account
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Salim Hermidas <salim.hermidas@webapps.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/cardtobrain/lib.php');

/**
 * Module instance settings form
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_cardtobrain_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG, $DB, $OUTPUT;

        $mform =& $this->_form;

        // Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // name for the cardtobrain instance
        $mform->addElement('text', 'name', get_string('boxname', 'cardtobrain'), array('size'=>'64'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // box alias
        $mform->addElement('text', 'alias', get_string('boxalias', 'cardtobrain'), array('size'=>'64'));
        $mform->setType('alias', PARAM_TEXT);
        $mform->addRule('alias', null, 'required', null, 'client');
        $mform->addHelpButton('alias', 'boxalias', 'cardtobrain');

        // target of link or form (card list or learning view)
        $targetoptions = array(
            0 => get_string('targetlearn', 'cardtobrain'),
            1 => get_string('targetcards', 'cardtobrain')
        );
        $mform->addElement('select', 'target', get_string('boxtarget', 'cardtobrain'), $targetoptions);
        $mform->setDefault('target', 0);
        $mform->addHelpButton('target', 'boxtarget', 'cardtobrain');

        // show an iframe of the box (use advcheckbox to allow disable option)
        $mform->addElement('advcheckbox', 'showiframe', get_string('showiframe', 'cardtobrain'), '', array(), array(0 , 1));

        // display default intro editor (description)
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements(get_string('boxintro', 'cardtobrain'));
            $element = $mform->getElement('introeditor');
            $attributes = $element->getAttributes();
            $attributes['rows'] = 5;
            $element->setAttributes($attributes);
        } else {
            $this->add_intro_editor();
        }

        // add default coursmodule settings
        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
}
