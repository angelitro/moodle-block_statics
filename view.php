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
 
require_once('../../config.php');
require_once($CFG->dirroot.'/blocks/statics/lib/lib.php');
require_once('statics_form.php');
 
global $DB, $CFG, $COURSE, $PAGE;

$PAGE->requires->js('/blocks/statics/js/bootstrap.min.js', true);

$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);


 
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_statics', $courseid);
}
 
require_login($course);

$PAGE->set_url('/blocks/statics/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('titulo_grande', 'block_statics') . " de " . $course->shortname);
$PAGE->set_heading(get_string('titulo_grande', 'block_statics') . " de " . $course->shortname);



$statics = new statics_form();

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$statics->set_data($toform);

$site = get_site();

if($statics->is_cancelled()) {

    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);

} else if ($fromform = $statics->get_data()) {

    echo $OUTPUT->header();
    $statics->get_data();
    $statics->display();
    block_statics_print_page($fromform);
    echo $OUTPUT->footer();
    

} else {

    echo $OUTPUT->header();
    $statics->display();
    echo $OUTPUT->footer();

}

