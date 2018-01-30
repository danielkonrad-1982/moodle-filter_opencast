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
 * Plugin administration pages are defined here.
 *
 * @package     filter_opencast
 * @category    admin
 * @copyright   2017 Daniel Konrad <daniel.konrad@tu-ilmenau.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
   // TODO: Define the plugin settings page.
   // https://docs.moodle.org/dev/Admin_settings
   $settings->add(new admin_setting_configtext('filter_opencast/baseurl',
        get_string('baseurl', 'filter_opencast'),
        get_string('baseurl_desc', 'filter_opencast'), 'https://youropencastserver.org', PARAM_NOTAGS));
	
	$settings->add(new admin_setting_configtext('filter_opencast/keyId',
        get_string('keyId', 'filter_opencast'),
        get_string('keyId_desc', 'filter_opencast'), 'demoKeyOne', PARAM_NOTAGS));
		
		$settings->add(new admin_setting_configtext('filter_opencast/Key',
        get_string('Key', 'filter_opencast'),
        get_string('Key_desc', 'filter_opencast'), '6EDB5EDDCF994B7432C371D7C274F', PARAM_NOTAGS));
}
