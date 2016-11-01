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
 * French strings for cardtobrain
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
$string['modulenameplural'] = 'Fichiers card2brain';
$string['modulenamesingle'] = 'Fichier card2brain';
$string['pluginname'] = 'card2brain';
$string['cardtobrain'] = 'cardtobrain';
$string['cardtobrain:addinstance'] = 'Créer un fichier card2brain';
$string['cardtobrain:view'] = 'Afficher le fichier card2brain';
$string['pluginadministration'] = 'Gérer le plug-in card2brain';
$string['nocardtobrains'] = 'Aucun fichier card2brain';

// Module help text.
$string['modulename_help'] = 'Grâce au module SSO pour card2brain, tu peux établir un lien pour les fichiers d’apprentissage que tu as créés sur card2brain.ch afin que tes utilisateurs Moodle puissent y accéder sans s’inscrire ou se connecter sur card2brain.ch préalablement.';

// Module instance settings.
$string['boxname'] = 'Fichier';
$string['boxalias'] = 'Alias du fichier';
$string['boxalias_help'] = 'L’alias du fichier est la dernière partie de l’URL. Par exemple, dans "https://card2brain.ch/box/brain_test“, "brain_test" est l’alias.';
$string['boxtarget'] = 'Destination du lien';
$string['boxtarget_help'] = 'Ici, tu peux régler si le fichier devra s’ouvrir directement en mode d’apprentissage ou en affichant un aperçu des cartes d’apprentissage.';
$string['targetlearn'] = 'Apprendre';
$string['targetcards'] = 'Cartes d’apprentissage';
$string['showiframe'] = 'Afficher l’iFrame';
$string['boxintro'] = 'Description';
$string['boxlearn'] = 'Apprendre le fichier';
$string['boxview'] = 'Afficher les cartes';

// Module settings.
$string['enablesso'] = 'Activer SSO';
$string['enablessotext'] = 'Active Single-Sign-On pour les comptes card2brain pour écoles et entreprises.';
$string['apikey'] = 'Clé API';
$string['apikeytext'] = 'Clé API de la corporation card2brain. (Tu trouveras la clé API dans l’espace admin de ton compte card2brain pour écoles ou entreprises.)';
$string['apisecret'] = 'Secret API';
$string['apisecrettext'] = 'Secret API de la corporation card2brain. (Tu trouveras le secret API dans l’espace admin de ton compte card2brain pour écoles ou entreprises.)';
