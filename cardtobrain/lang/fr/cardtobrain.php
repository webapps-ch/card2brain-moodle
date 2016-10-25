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

// Default module strings
$string['modulename'] = 'card2brain';
$string['modulenameplural'] = 'card2brain Karteien';
$string['modulenamesingle'] = 'card2brain Kartei';
$string['pluginname'] = 'card2brain';
$string['cardtobrain'] = 'cardtobrain';
$string['cardtobrain:addinstance'] = 'card2brain Kartei erstellen';
$string['cardtobrain:view'] = 'card2brain Kartei anzeigen';
$string['pluginadministration'] = 'card2brain Plugin verwalten';
$string['nocardtobrains'] = 'Keine card2brain Karteien';

// Module help text
$string['modulename_help'] = 'Mit dem SSO-Modul für card2brain kannst du Lernkarteien, die du auf card2brain.ch erstellt hast, so verlinken, dass deine Moodle-Benutzer direkt auf deine Lernkarten zugreifen können, ohne sich vorher bei card2brain.ch zu registrieren oder anzumelden.';

// Module instance settings
$string['boxname'] = 'Kartei';
$string['boxalias'] = 'Kartei Alias';
$string['boxalias_help'] = 'Das Kartei Alias ist der letzte Teil der URL. Z. B. bei "https://card2brain.ch/box/brain_test" ist "brain_test" das Alias.';
$string['boxtarget'] = 'Link Ziel';
$string['boxtarget_help'] = 'Hier kannst du einstellen, ob die Kartei direkt im Lernmodus oder in der Lernkartenansicht geöffnet werden soll.';
$string['targetlearn'] = 'Lernen';
$string['targetcards'] = 'Karten';
$string['showiframe'] = 'iFrame anzeigen';
$string['boxintro'] = 'Beschreibung';
$string['boxlearn'] = 'Kartei lernen';
$string['boxview'] = 'Karten anzeigen';

// Module settings
$string['enablesso'] = 'SSO aktivieren';
$string['enablessotext'] = 'Aktiviere Single-Sign-On für card2brain Schul- und Firmenkonten.';
$string['apikey'] = 'API Key';
$string['apikeytext'] = 'API Key der card2brain Corporation. (Den API Key findest du im Admin Bereich deines card2brain Schul- bzw. Firmenkontos.)';
$string['apisecret'] = 'API Secret';
$string['apisecrettext'] = 'API Secret der card2brain Corporation. (Das API Secret findest du im Admin Bereich deines card2brain Schul- bzw. Firmenkontos.)';
