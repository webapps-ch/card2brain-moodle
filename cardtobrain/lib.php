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
 * Library of interface functions and constants for module cardtobrain
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 *
 * All the cardtobrain specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Konstanten für card2brain Plugin
 */
define('CARDTOBRAIN_BASE_URL', 'https://dev.webapps.ch/card2brain/');
define('CARDTOBRAIN_SSO_URL', 'https://dev.webapps.ch/card2brain/SSO/login');
define('CARDTOBRAIN_LANGUAGES', 'de-fr-en');
define('CARDTOBRAIN_DEFAULT_LANGUAGE', 'en');

/* Moodle core API */
/**
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
        case FEATURE_GRADE_HAS_GRADE:
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

    // You may have to add extra stuff in here.

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

    // You may have to add extra stuff in here.

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

    // Delete any dependent records here.

    $DB->delete_records('cardtobrain', array('id' => $cardtobrain->id));

    return true;
}

/**
 * @param $hashParams
 * @param $apiSecret
 * @return string
 */
function cardtobrain_sso_hash($hashParams, $apiSecret) {

    //Nach Name Sortieren
    ksort($hashParams);

    $encString = "";

    //Params zu String verbinden
    foreach ($hashParams as $key => $value) {
        if ($value != null && $value != ""){
            $encString .= (strtoupper($key) . "=" . $value . $apiSecret);
        }
    }

    //SHA256 Hash zurückgeben (Upper Case)
    return strtoupper(hash('sha256', $encString));
}

/**
 * Box Link anzeigen
 * Oder: Falls SSO aktiv: Formular mit SSO Login
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

    //Wurde SSO Aktiviert?
    $enableSSO = $CFG->cardtobrain_enablesso;
    if ($enableSSO == 1) {
        //SSO URL
        $ssoUrl = CARDTOBRAIN_SSO_URL;

        //Form: User Params
        $username = $USER->email;
        $firstname = $USER->firstname;
        $lastname = $USER->lastname;
        $lang = $USER->lang;
        //Verwende Default Language, falls Sprache nicht verfügbar ist:
        if (!in_array($lang, explode('-', CARDTOBRAIN_LANGUAGES))) {
            $lang = CARDTOBRAIN_DEFAULT_LANGUAGE;
        }

        //Form: API Params
        $apikey = $CFG->cardtobrain_apikey;
        $apisecret = $CFG->cardtobrain_apisecret;
        $timestamp = round(microtime(true) * 1000);

        //Form: Target Params
        if ($target == 0) {
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

        //Hash für SSO berechnen
        $hash = cardtobrain_sso_hash($hashParams, $apisecret);

        //Formular zum SSO Login und redirect zur Kartei
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
        //Zeige nur Link zur kartei, falls SSO nicht konfiguriert ist
        $url = CARDTOBRAIN_BASE_URL;

        if ($target == 0) {
            $url .= ("learn/".$alias."/normal");
        } else {
            $url .= ("box/".$alias);
        }

        //Link zur Kartei
        echo '<a href="'.$url.'" target="_blank">'.$linkText.'</a>';
    }
}
