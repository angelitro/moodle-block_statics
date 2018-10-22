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



class block_statics extends block_base {



    function init(){
        $this->title = get_string('title','block_statics');
    }

	public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values
        $attributes['class'] .= ' block_'. $this->name(); // Append our class to class attribute
        return $attributes;
	}

    public function instance_allow_multiple() {
         return true;
    }

    function has_config() {return true;}
    

	public function get_content() {

        global $DB, $COURSE;

        
        $this->content = new stdClass;
        $this->content->text = '';


        if (!isloggedin()) {
            return $this->content;
        }

        $course = $DB->get_record('course', array('id' => $COURSE->id));

        if (!$course) {
            print_error('coursedoesnotexists');
        }

        if ($course->id == SITEID) {
            $context = context_system::instance();
        } else {
            $context = context_course::instance($course->id);
        }



        if (!empty($this->config->text)) {
           $this->content->text = $this->config->text;
        }

        $context = context_course::instance($COURSE->id);

            
        $canview = has_capability('block/statics:viewstatics', $context);
 
          
        if ($canview) {

            $url = new moodle_url('/blocks/statics/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
            $this->content->text = html_writer::link($url, get_string('entrar', 'block_statics'));
        }
       

    
        return $this->content;

	}
}