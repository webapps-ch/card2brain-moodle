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

defined('MOODLE_INTERNAL') || die;

/**
 * Define the complete cardtobrain structure for backup, with file and id annotations
 *
 * @package    mod_cardtobrain
 * @category   backup
 * @copyright  2016 Salim Hermidas <salim.hermidas@webapps.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_cardtobrain_activity_structure_step extends backup_activity_structure_step {

    /**
     * Defines the backup structure of the module
     *
     * @return backup_nested_element
     */
    protected function define_structure() {

        // Get know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');

        // Define the root element describing the cardtobrain instance.
        $cardtobrain = new backup_nested_element('cardtobrain', array('id'), array(
            'course', 'name', 'intro', 'introformat', 'alias', 'target', 'showiframe', 'timecreated', 'timemodified'));

        // Define data sources.
        $cardtobrain->set_source_table('cardtobrain', array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations (we do not use itemid in this example).
        $cardtobrain->annotate_files('mod_cardtobrain', 'intro', null);

        // Return the root element (cardtobrain), wrapped into standard activity structure.
        return $this->prepare_activity_structure($cardtobrain);
    }
}
