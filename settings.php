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
 * @package   block_statics
 * @copyright 2018, angelitr0 <angel@angelitro.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

	$settings->add(new admin_setting_heading(
	            'headerconfig',
	            get_string('headerconfig', 'block_statics'),
	            get_string('descconfig', 'block_statics')
	        ));
	 
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_images',
	            get_string('img', 'block_statics'),
	            get_string('descimg', 'block_statics'),
	            '1'
	        ));
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_docs',
	            get_string('doc', 'block_statics'),
	            get_string('descdoc', 'block_statics'),
	            '1'
	        ));
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_video',
	            get_string('vid', 'block_statics'),
	            get_string('descvid', 'block_statics'),
	            '1'
	        ));
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_audio',
	            get_string('au', 'block_statics'),
	            get_string('descau', 'block_statics'),
	            '1'
	        ));
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_comp',
	            get_string('comp', 'block_statics'),
	            get_string('desccomp', 'block_statics'),
	            '1'
	        ));
	$settings->add(new admin_setting_configcheckbox(
	            'statics/find_hoj',
	            get_string('hoj', 'block_statics'),
	            get_string('deschoj', 'block_statics'),
	            '0'
	        ));
}