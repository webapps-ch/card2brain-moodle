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
 * The main cardtobrain configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Your Name <your@email.address>
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

        $mform->addElement('text', 'name', get_string('boxname', 'cardtobrain'), array('size'=>'64'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('text', 'alias', get_string('boxalias', 'cardtobrain'), array('size'=>'64'));
        $mform->setType('alias', PARAM_TEXT);
        $mform->addRule('alias', null, 'required', null, 'client');

        $targetoptions = array(
            0 => get_string('targetlearn', 'cardtobrain'),
            1 => get_string('targetcards', 'cardtobrain')
        );
        $mform->addElement('select', 'target', get_string('boxtarget', 'cardtobrain'), $targetoptions);
        $mform->setDefault('target', 0);

        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
}
