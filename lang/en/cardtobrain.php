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
 * English strings for cardtobrain
 *
 * Add sets of flashcards from card2brain.ch to your Moodle courses.
 * - link to flashcard list or learning view
 * - enable SSO Authentication for your corporate account
 *
 * @package    mod_cardtobrain
 * @copyright  2016 Salim Hermidas <salim.hermidas@webapps.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Default module strings.
$string['modulename'] = 'card2brain';
$string['modulenameplural'] = 'card2brain sets of flashcards';
$string['modulenamesingle'] = 'card2brain set of flashcards';
$string['pluginname'] = 'card2brain';
$string['cardtobrain'] = 'cardtobrain';
$string['cardtobrain:addinstance'] = 'Create card2brain set of flashcards';
$string['cardtobrain:view'] = 'Show card2brain set of flashcards';
$string['pluginadministration'] = 'Manage the card2brain plugin';
$string['nocardtobrains'] = 'No card2brain sets of flashcards';

// Module help text.
$string['modulename_help'] = 'The SSO module for card2brain enables you to establish a link to the sets of flashcards you created on card2brain.ch so that your Moodle users can access them directly without having to register or log on to cardbrain.ch first.';

// Module instance settings.
$string['boxname'] = 'Set of flashcards';
$string['boxalias'] = 'Set of flashcards alias';
$string['boxalias_help'] = 'The set of flashcards alias is the last part of the URL. For instance, in "https://card2brain.ch/box/brain_test“, the alias is "brain_test".';
$string['boxtarget'] = 'Link target';
$string['boxtarget_help'] = 'Here, you can set whether the set of flashcards shall be opened directly in study mode or in flashcard view mode.';
$string['targetlearn'] = 'Study';
$string['targetcards'] = 'Cards';
$string['showiframe'] = 'Show iFrame';
$string['boxintro'] = 'Description';
$string['boxlearn'] = 'Study set of flashcards';
$string['boxview'] = 'Show flashcards';

// Module settings.
$string['enablesso'] = 'Enable SSO';
$string['enablessotext'] = 'Enable Single-Sign-On for card2brain school and company accounts.';
$string['apikey'] = 'API Key';
$string['apikeytext'] = 'API Key of card2brain Corporation. (You can find the API Key in the Admin section of your card2brain school or company account.)';
$string['apisecret'] = 'API Secret';
$string['apisecrettext'] = 'API Secret of card2brain Corporation. (You can find the API Secret in the Admin section of your card2brain school or company account.)';
