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
require_once('./lib.php');

$id = required_param('id', PARAM_INT); // Course.

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

$strname = get_string('modulenameplural', 'cardtobrain');
$strnametable = get_string('modulenamesingle', 'cardtobrain');
$strnameintro = get_string('boxintro', 'cardtobrain');

$PAGE->set_url('/mod/cardtobrain/index.php', array('id' => $id));
$PAGE->navbar->add($strname);
$PAGE->set_title("$course->shortname: $strname");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('incourse');

echo $OUTPUT->header();
echo $OUTPUT->heading($strname);

if (!$cardtobrains = get_all_instances_in_course('cardtobrain', $course)) {
    notice(get_string('nocardtobrains', 'cardtobrain'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strnametable, $strnameintro);
    $table->align = array ('left', 'left', 'left');
} else {
    $table->head  = array ($strnametable, $strnameintro);
    $table->align = array ('left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($cardtobrains as $cardtobrain) {
    $cm = $modinfo->instances['cardtobrain'][$cardtobrain->id];

    $row = array();
    if ($usesections) {
        if ($cm->sectionnum !== $currentsection) {
            if ($cm->sectionnum) {
                $row[] = get_section_name($course, $cm->sectionnum);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $cm->sectionnum;
        } else {
            $row[] = '';
        }
    }

    $class = $cm->visible ? null : array('class' => 'dimmed');

    $icon = '<img src="'.$OUTPUT->pix_url($cm->icon, 'cardtobrain').'icon" class="iconlarge activityicon" alt="'.get_string('modulename', 'cardtobrain').'" style="margin-right: 5px;"/>';
    $link = '<span class="instancename">'.$cm->get_formatted_name().'</span>';

    $row[] = html_writer::link(new moodle_url('view.php', array('id' => $cm->id)),
        $icon.$link, $class);

    $row[] = format_module_intro('cardtobrain', $cardtobrain, $cm->id);

    $table->data[] = $row;
}

echo html_writer::table($table);

echo $OUTPUT->footer();
