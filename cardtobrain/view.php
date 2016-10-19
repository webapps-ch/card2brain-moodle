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
 * Prints a particular instance of cardtobrain
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace cardtobrain with the name of your module and remove this line.

require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT);    // Course Module ID

if (!$cm = get_coursemodule_from_id('cardtobrain', $id)) {
    print_error('Course Module ID was incorrect'); // NOTE this is invalid use of print_error, must be a lang string id
}
if (!$course = $DB->get_record('course', array('id'=> $cm->course))) {
    print_error('course is misconfigured');  // NOTE As above
}
if (!$cardtobrain = $DB->get_record('cardtobrain', array('id'=> $cm->instance))) {
    print_error('course module is incorrect'); // NOTE As above
}

require_login($course, true, $cm);

$ssoUrl = '';


// Print the page header.
$PAGE->set_url('/mod/cardtobrain/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($cardtobrain->name));
$PAGE->set_heading(format_string($course->fullname));

// Output starts here.
echo $OUTPUT->header();

// Replace the following lines with you own code.
echo $OUTPUT->heading($cardtobrain->name);

$alias = $cardtobrain->alias;
$target = $cardtobrain->target;
$linkText = '';

if ($target = 0) {
    $linkText = get_string('boxlearn', 'cardtobrain');
} else {
    $linkText = get_string('boxview', 'cardtobrain');
}

//Wurde SSO Aktiviert?
$enableSSO = $CFG->cardtobrain_enablesso;
if ($enableSSO == 1) {
    //SSO URL
    $ssoUrl = CARDTOBRAIN_SSO_URL;

    //Form Params
    $username = $USER->email;
    $firstname = $USER->firstname;
    $lastname = $USER->lastname;
    $lang = 'de';
    $apikey = $CFG->cardtobrain_apikey;
    $apisecret = $CFG->cardtobrain_apisecret;
    $timestamp = round(microtime(true) * 1000);
    $page = '';
    if ($target = 0) {
        $page = 'boxlearn';
    } else {
        $page = 'box';
    }
    $box = $alias;

    //Hash Params aufbereiten
    $hashParams = array(
        "username" => $username,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "lang" => $lang,
        "apikey" => $apikey,
        "timestamp" => $timestamp
    );

    $hash = cardtobrain_sso_hash($hashParams, $apisecret);

    echo '
    <form id="card2brainssoform" name="card2brainssoform" target="_blank" method="POST" action="'.$ssoUrl.'">
        <input type="hidden" name="timestamp" value="'.$timestamp.'" />
        <input type="hidden" name="username" value="'.$username.'" />
        <input type="hidden" name="firstname" value="'.$firstname.'" />
        <input type="hidden" name="lastname" value="'.$lastname.'" />
        <input type="hidden" name="lang" value="'.$lang.'" />
        <input type="hidden" name="apikey" value="'.$apikey.'" />
        <input type="hidden" name="hash" value="'.$hash.'" />
        <input type="hidden" name="page" value="'.$page.'" />
        <input type="hidden" name="box" value="'.$box.'" />
        <input type="submit" value="'.$linkText.'" />
    </form>
    ';

} else {
    $url = CARDTOBRAIN_BASE_URL;
    if ($target = 0) {
        $url .= ("learn/".$alias."/normal");
    } else {
        $url .= ("box/".$alias);
    }
    echo '<a href="'.$url.'" target="_blank">'.$linkText.'</a>';
}

// Finish the page.
echo $OUTPUT->footer();
