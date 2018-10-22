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

class block_statics_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
 
        // Section header title according to language file.
       /* $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('blockstring', 'block_statics'));
        $mform->setDefault('config_text', 'Hola');
        $mform->setType('config_text', PARAM_RAW);

        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_statics'));
    	$mform->setDefault('config_title', 'Adios');
    	$mform->setType('config_title', PARAM_TEXT);        */
 
    }

    public function specialization() {
	    if (isset($this->config)) {
	        if (empty($this->config->title)) {
	            $this->title = get_string('defaulttitle', 'block_statics');            
	        } else {
	            $this->title = $this->config->title;
	        }
	 
	        if (empty($this->config->text)) {
	            $this->config->text = get_string('defaulttext', 'block_statics');
	        }    
    	}
    }

    
}