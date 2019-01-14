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
 * @copyright 2018, angelitr0 <angelluisfraile@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();


function block_statics_print_page($fromform, $return = false) {

	global $COURSE, $DB;

	
	$query="SELECT DISTINCT course.filename, course.filesize, course.contextid, course.component, course.filearea, course.itemid, course.filepath
			FROM (

			SELECT c.id, c.fullname, c.shortname, cx.contextlevel, f.component, f.filearea, f.filename, f.filesize, f.contextid, f.itemid, f.filepath
			FROM {context} cx
			JOIN {course} c ON cx.instanceid=c.id
			JOIN {files} f ON cx.id=f.contextid
			WHERE f.filename <> '.'
			AND f.component NOT IN ('private', 'automated', 'backup','draft', 'question')
			AND f.filearea NOT IN ('draft', 'stamps', 'preview', 'intro', 'overviewfiles')
			
			UNION

			SELECT cm.course, c.fullname, c.shortname, cx.contextlevel,f.component, f.filearea, f.filename, f.filesize, f.contextid, f.itemid, f.filepath
			FROM {files} f
			JOIN {context} cx ON f.contextid = cx.id
			JOIN {course_modules} cm ON cx.instanceid=cm.id
			JOIN {course} c ON cm.course=c.id
			WHERE f.filename <> '.'
			AND f.component NOT IN ('private', 'automated', 'backup','draft', 'question')
			AND f.filearea NOT IN ('draft', 'stamps', 'preview', 'intro', 'overviewfiles')

			UNION

			SELECT c.id, c.shortname, c.fullname, cx.contextlevel, f.component, f.filearea, f.filename, f.filesize, f.contextid, f.itemid, f.filepath
			from {block_instances} bi
			join {context} cx on (cx.contextlevel=80 and bi.id = cx.instanceid)
			join {files} f on (cx.id = f.contextid)
			join {context} pcx on (bi.parentcontextid = pcx.id)
			join {course} c on (pcx.instanceid = c.id)
			where f.filename <> '.'
			AND f.component NOT IN ('private', 'automated', 'backup','draft', 'question')
			AND f.filearea NOT IN ('draft', 'stamps', 'preview', 'intro', 'overviewfiles')

			) AS course WHERE course.id=? AND filename LIKE ? GROUP BY course.filename ORDER BY course.filename ASC";


	$display=NULL;
	$displayno = NULL;


	$tiposFicheros = Array ();
	$ficherosIma = Array("Imagen1"=>"PNG", "Imagen2"=>"JPG", "Imagen3"=>"GIF", "Imagen4"=>"BMP", "Imagen5"=>"EPS", "Imagen5"=>"PCX");
	$ficherosDoc = Array("Documento1"=>"DOC", "Documento2"=>"DOCX", "Documento3"=>"ODT", "Documento4"=>"PDF", "Documento5"=>"TXT", "Documento6"=>"RTF");
	$ficherosVid = Array("Video1"=>"AVI","Video2"=>"MPG", "Video3"=>"MP4", "Video4"=>"OGG", "Video5"=>"MOV", "Video5"=>"OGV",  "Video6"=>"WMV",  "Video7"=>"MKV",  "Video8"=>"FLV", "Video9"=>"3GP", "Video10"=>"WEBM");
	$ficherosAud = Array("Audio1"=>"MP3", "Audio2"=>"WMA", "Audio3"=>"AIFF", "Audio4"=>"AU", "Audio5"=>"OGG", "Audio6"=>"AAC", "Audio7"=>"WAV", "Audio8"=>"MIDI");
	$ficherosCom = Array("Comprimidos1"=>"ZIP", "Comprimidos2"=>"RAR", "Comprimidos3"=>"7Z");
	$ficherosHoj = Array("HojasCalculo1"=>"XLS", "HojasCalculo2"=>"XLSX", "HojasCalculo3"=>"OTS", "HojasCalculo4"=>"SDC");



	foreach ($fromform as $check => $valor) {
		switch ($check) {
			    case "imagenes":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosIma);
			        break;
			    case "videos":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosVid);
			        break;
			    case "audios":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosAud);
			        break;
				case "documentos":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosDoc);
			        break;
				case "archivosComprimidos":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosCom);
			        break;		        
			    case "hojasCalculo":
			        $tiposFicheros=array_merge($tiposFicheros,$ficherosHoj);
			        break;		        
			}


	       
	}

	foreach ($tiposFicheros as $tipo => $valor) {
		
		$result = $DB->get_records_sql($query, array($COURSE->id, '%.'.$valor));


		$tip = substr($tipo, 0, 3);

			switch ($tip) {
			    case "Ima":
			        $tipo=get_string('img', 'block_statics');
			        break;
			    case "Doc":
			    	$tipo=get_string('doc', 'block_statics');
			        break;
			    case "Vid":
			        $tipo=get_string('vid', 'block_statics');
			        break;
				case "Aud":
					$tipo=get_string('au', 'block_statics');
			        break;
				case "Com":
					$tipo=get_string('comp', 'block_statics');
			        break;		        
				case "Hoj":
					$tipo=get_string('hoj', 'block_statics');
			        break;		        			        

			}


		if ($result){
			
		    $display .= html_writer::start_tag('div', array('class' => 'block_statics cont'));
		    $display .= html_writer::start_tag('h4');
			$display .= clean_text($tipo." / ".$valor);
			$display .= html_writer::end_tag('h4');
		    $display .= html_writer::start_tag('table', array('class' => 'table table-hover', 'id' => 'archivos'));
		   
			foreach($result as $res){

				$enlace = moodle_url::make_pluginfile_url($res->contextid, $res->component, $res->filearea, $res->itemid, $res->filepath, $res->filename);

				if ($enlace){

					$display .= html_writer::start_tag('tr', array('id' => $res->filename));
					$display .= html_writer::start_tag('td');		
					$display .= clean_text("<a href='".$enlace. "'> ".$res->filename ."</a>");
					$display .= html_writer::end_tag('td');
					$display .= html_writer::start_tag('td');
					$display .= $res->filesize>1023 ? clean_text(round($res->filesize/1024) . " KB</td>") : clean_text(round($res->filesize) . " B</td>");	
				
					$display .= html_writer::end_tag('td');
					$display .= html_writer::end_tag('tr');
				}	
				
			}

			$display .= html_writer::end_tag('table');
			$display .= html_writer::end_tag('div');

		} else {

			
		    $displayno .= clean_text($valor.", ");
			

		}


	} //end foreach

	if ($displayno){
		$displayno = substr($displayno, 0, strlen($displayno)-2);
		$display .= html_writer::start_tag('div', array('class' => 'clearfix'));
		$display .= html_writer::end_tag('div');
		$display .= html_writer::start_tag('div', array('class' => 'block_statics vacios'));
		$display .= html_writer::start_tag('h6');
		$display .= clean_text(get_string('noex', 'block_statics')."<b>".$displayno."</b>");
		$display .= html_writer::end_tag('h6');
		$display .= html_writer::end_tag('div');

	}
	

	if($return) {
	    return $display;
	} else {
	    echo $display;
	}

}