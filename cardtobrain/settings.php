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
 * Url module admin settings and defaults
 *
 * @package    mod_url
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once($CFG->dirroot.'/mod/cardtobrain/lib.php');

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configcheckbox('cardtobrain_enablesso', get_string('enablesso', 'cardtobrain'),
        get_string('enablessotext', 'cardtobrain'), 0));

    $settings->add(new admin_setting_configtext('cardtobrain_apikey', get_string('apikey', 'cardtobrain'),
        get_string('apikeytext', 'cardtobrain'), '', PARAM_TEXT));

    $settings->add(new admin_setting_configtext('cardtobrain_apisecret', get_string('apisecret', 'cardtobrain'),
        get_string('apisecrettext', 'cardtobrain'), '', PARAM_TEXT));


}