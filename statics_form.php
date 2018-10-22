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

require_once("{$CFG->libdir}/formslib.php");
require_once($CFG->dirroot.'/blocks/statics/lib/lib.php');
 
class statics_form extends moodleform {
 
    function definition() {

    	$find_images = get_config('statics', 'find_images');
    	$find_docs = get_config('statics', 'find_docs');
    	$find_video = get_config('statics', 'find_video');
    	$find_audio = get_config('statics', 'find_audio');
    	$find_comp = get_config('statics', 'find_comp');
    	$find_hoj = get_config('statics', 'find_hoj');

        $mform =& $this->_form;
		

        $mform->addElement('header','displayimagenes', get_string('loquever', 'block_statics'));

        $mform->addElement('html', '<div class="cont">');
        $mform->addElement('static', 'description', get_string('enumsel', 'block_statics'));
        //$mform->addElement('html', '<h5>Selecciona los tipos de archivos que deseas visualizar...</h5>');
        

        if ($find_images) {$mform->addElement('checkbox', 'imagenes', get_string('img', 'block_statics'));}
		if ($find_video) {$mform->addElement('checkbox', 'videos', get_string('vid', 'block_statics'));}
		if ($find_audio) {$mform->addElement('checkbox', 'audios', get_string('au', 'block_statics'));}
		if ($find_docs) {$mform->addElement('checkbox', 'documentos', get_string('doc', 'block_statics'));}
		if ($find_comp) {$mform->addElement('checkbox', 'archivosComprimidos', get_string('comp', 'block_statics'));}
		if ($find_hoj) {$mform->addElement('checkbox', 'hojasCalculo', get_string('hoj', 'block_statics'));}
		

		$mform->addElement('html', '</div>');
		$mform->addElement('html', '<div class="clearfix"></div>');          		                		
				
		$buttonarray=array();
		$buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('savechanges'));
		$buttonarray[] = $mform->createElement('cancel');
		$mform->addGroup($buttonarray, 'buttonar', '', ' ', false); 

        		
		$mform->addElement('hidden', 'blockid');
		$mform->setType('blockid', PARAM_INT);
		$mform->addElement('hidden', 'courseid');
		$mform->setType('courseid', PARAM_INT);
		

    }
}