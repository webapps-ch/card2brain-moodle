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

/**
 * Constansts for the cardtobrain module
 * Change for development
 */
define('CARDTOBRAIN_BASE_URL', 'https://card2brain.ch/');
define('CARDTOBRAIN_SSO_URL', 'https://card2brain.ch/SSO/login');
define('CARDTOBRAIN_LANGUAGES', 'de-fr-en');
define('CARDTOBRAIN_DEFAULT_LANGUAGE', 'en');

/**
 * Moodle core API
 * Returns the information on whether the module supports a feature
 *
 * See {@link plugin_supports()} for more info.
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function cardtobrain_supports($feature) {

    switch($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the cardtobrain into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param stdClass $cardtobrain Submitted data from the form in mod_form.php
 * @param mod_cardtobrain_mod_form $mform The form instance itself (if needed)
 * @return int The id of the newly inserted cardtobrain record
 */
function cardtobrain_add_instance(stdClass $cardtobrain, mod_cardtobrain_mod_form $mform = null) {
    global $DB;

    $cardtobrain->timecreated = time();

    $cardtobrain->id = $DB->insert_record('cardtobrain', $cardtobrain);

    return $cardtobrain->id;
}

/**
 * Updates an instance of the cardtobrain in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param stdClass $cardtobrain An object from the form in mod_form.php
 * @param mod_cardtobrain_mod_form $mform The form instance itself (if needed)
 * @return boolean Success/Fail
 */
function cardtobrain_update_instance(stdClass $cardtobrain, mod_cardtobrain_mod_form $mform = null) {
    global $DB;

    $cardtobrain->timemodified = time();
    $cardtobrain->id = $cardtobrain->instance;

    $result = $DB->update_record('cardtobrain', $cardtobrain);

    return $result;
}

/**
 * Removes an instance of the cardtobrain from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function cardtobrain_delete_instance($id) {
    global $DB;

    if (! $cardtobrain = $DB->get_record('cardtobrain', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('cardtobrain', array('id' => $cardtobrain->id));

    return true;
}

/**
 * Generate SHA256 Hash for SSO Authentication
 *
 * @param $hashParams
 * @param $apiSecret
 * @return string: SHA256-Hash
 */
function cardtobrain_sso_hash($hashParams, $apiSecret) {

    // Sort params by name
    ksort($hashParams);

    $encString = "";

    // join params, values and apisecret
    foreach ($hashParams as $key => $value) {
        if ($value != null && $value != ""){
            $encString .= (strtoupper($key) . "=" . $value . $apiSecret);
        }
    }

    // return SHA256 Hash (upper case)
    return strtoupper(hash('sha256', $encString));
}

/**
 * Print box link or SSO Authentication form
 *
 * @param $cardtobrain
 */
function cardtobrain_print_box_link($cardtobrain) {
    global $CFG, $USER;

    $alias = $cardtobrain->alias;
    $target = $cardtobrain->target;

    if ($target == 0) {
        $linkText = get_string('boxlearn', 'cardtobrain');
    } else {
        $linkText = get_string('boxview', 'cardtobrain');
    }

    // Is SSO Authentication enabled?
    $enableSSO = $CFG->cardtobrain_enablesso;
    if ($enableSSO == 1) {
        // SSO URL
        $ssoUrl = CARDTOBRAIN_SSO_URL;

        // Form: user params
        $username = $USER->email;
        $firstname = $USER->firstname;
        $lastname = $USER->lastname;
        $lang = $USER->lang;
        // Use CARDTOBRAIN_DEFAULT_LANGUAGE if user language is not suported
        if (!in_array($lang, explode('-', CARDTOBRAIN_LANGUAGES))) {
            $lang = CARDTOBRAIN_DEFAULT_LANGUAGE;
        }

        // Form: API params
        $apikey = $CFG->cardtobrain_apikey;
        $apisecret = $CFG->cardtobrain_apisecret;
        $timestamp = round(microtime(true) * 1000);

        // Form: target params
        if ($target == 0) {
            $page = 'boxlearn';
        } else {
            $page = 'box';
        }
        $box = $alias;

        // Prepare hash params
        $hashParams = array(
            "username" => $username,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "lang" => $lang,
            "apikey" => $apikey,
            "timestamp" => $timestamp
        );

        // Calculate hash for SSO Authentication
        $hash = cardtobrain_sso_hash($hashParams, $apisecret);

        // print form for SSO Authentication
        echo '
        <form id="ctob_form_'.$alias.'" name="ctob_form_'.$alias.'" target="_blank" method="POST" action="'.$ssoUrl.'">
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
        // Only display a simple link to box
        $url = CARDTOBRAIN_BASE_URL;

        if ($target == 0) {
            $url .= ("learn/".$alias."/normal");
        } else {
            $url .= ("box/".$alias);
        }

        // Link to the box
        echo '<a href="'.$url.'" target="_blank">'.$linkText.'</a>';
    }
}

/**
 * Print box description/intro
 *
 * @param $cardtobrain
 * @param $cm
 * @param $course
 */
function cardtobrain_print_intro($cardtobrain, $cm, $course) {
    global $OUTPUT;

    if (trim(strip_tags($cardtobrain->intro))) {
        echo $OUTPUT->box_start('mod_introbox', 'cardtobrainintro');
        echo format_module_intro('cardtobrain', $cardtobrain, $cm->id);
        echo $OUTPUT->box_end();
        echo '<br/>';
    }
}

/**
 * Embed card2brain box.
 * Use JavaScript if SSO Authentication is enabled to Submit SSO form
 *
 * @param $cardtobrain
 */
function cardtobrain_print_box_iframe($cardtobrain) {
    global $CFG, $PAGE;

    $alias = $cardtobrain->alias;
    $url = CARDTOBRAIN_BASE_URL.'box/'.$alias.'/embed';
    $enableSSO = $CFG->cardtobrain_enablesso;

    // iFrame embedd code
    $br = '<br/>';
    $iframe = '<iframe id="ctob_iframe_'.$alias.'" src="'.$url.'" width="100%" height="150" scrolling="no" frameborder="0"></iframe>';

    // Is SSO Authentication enabled and Moodle Version >= 29?
    if ($enableSSO == 1 && $CFG->branch >= 29) {
        $containerSelector = 'div#ctob_container_'.$alias;
        $formSelector = 'form#ctob_form_'.$alias;

        // Include JavaScript
        $PAGE->requires->js_call_amd('mod_cardtobrain/ctob', 'setup', array("container" => $containerSelector, "form" => $formSelector));

        // Add container with overlying div
        $container = '
        <div style="position: relative; max-width: 780px;">
            <div id="ctob_container_'.$alias.'" style="background: transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;"></div>
            '.$iframe.'
        </div>';

        // print iFrame in container
        echo $container.$br;

    } else {
        // Add container without overlying div
        $container = '
        <div style="position: relative; max-width: 780px;">
            '.$iframe.'
        </div>';

        // print iFrame in container
        echo $container.$br;
    }
}
