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
 * The global cardtobrain configuration form
 *
 * Add sets of flashcards from card2brain.ch to your Moodle courses.
 * - link to flashcard list or learning view
 * - enable SSO Authentication for your corporate account
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Salim Hermidas <salim.hermidas@webapps.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once($CFG->dirroot.'/mod/cardtobrain/lib.php');

    // Enable SSO Authentication (requires apikey and apisecret).
    $settings->add(new admin_setting_configcheckbox('mod_cardtobrain/enablesso', get_string('enablesso', 'cardtobrain'),
        get_string('enablessotext', 'cardtobrain'), 0));

    // Apikey for card2brain.ch corporation.
    $settings->add(new admin_setting_configtext('mod_cardtobrain/apikey', get_string('apikey', 'cardtobrain'),
        get_string('apikeytext', 'cardtobrain'), '', PARAM_TEXT));

    // Apisecret for card2brain.ch corporation.
    $settings->add(new admin_setting_configtext('mod_cardtobrain/apisecret', get_string('apisecret', 'cardtobrain'),
        get_string('apisecrettext', 'cardtobrain'), '', PARAM_TEXT));

}