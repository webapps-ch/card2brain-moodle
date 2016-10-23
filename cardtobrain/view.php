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

require_once('../../config.php');
require_once('lib.php');

// Course Module ID
$id = required_param('id', PARAM_INT);

// Load Course Module instance
if (!$cm = get_coursemodule_from_id('cardtobrain', $id)) {
    print_error('Course Module ID was incorrect');
}
// Load Course instance
if (!$course = $DB->get_record('course', array('id'=> $cm->course))) {
    print_error('course is misconfigured');
}
// Load cardtobrain instance
if (!$cardtobrain = $DB->get_record('cardtobrain', array('id'=> $cm->instance))) {
    print_error('course module is incorrect');
}

// Module requires logged in User
require_login($course, true, $cm);

// Print the page header.
$PAGE->set_url('/mod/cardtobrain/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($cardtobrain->name));
$PAGE->set_heading(format_string($course->fullname));

// Print page header
echo $OUTPUT->header();

// Print page title
echo $OUTPUT->heading($cardtobrain->name);

// Print intro of cardtobrain instance
cardtobrain_print_intro($cardtobrain, $cm, $course);
// Print iframe for box if enabled
if ($cardtobrain->showiframe == 1) {
    cardtobrain_print_box_iframe($cardtobrain);
}
// Print link/form to the box
cardtobrain_print_box_link($cardtobrain);

// Finish the page.
echo $OUTPUT->footer();
