<?php
// This file is part of moodle-mod_dmelearn for Moodle - http://moodle.org/
//
// moodle-mod_dmelearn is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// moodle-mod_dmelearn is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with moodle-mod_dmelearn. If not, see <http://www.gnu.org/licenses/>.
//
// This plug-in is based on mod_journal by David Monllaó (https://moodle.org/plugins/view/mod_journal).

/**
 * @package       mod_dmelearn
 * @author        Kien Vu, AJ Dunn
 * @copyright     2015 BrightCookie (http://www.brightcookie.com.au), Digital Media e-learning
 * @version       1.0.0
 * @license       http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once("lib.php");

$id = required_param('id', PARAM_INT); // Course Module ID.

if (!$coursemodule = get_coursemodule_from_id('dmelearn', $id)) {
    print_error("Course Module ID was incorrect");
}

if (!$course = $DB->get_record('course', array('id' => $coursemodule->course))) {
    print_error("Course is misconfigured");
}

$context = context_module::instance($coursemodule->id);

require_login($course->id, true, $coursemodule);

$canview = has_capability('mod/dmelearn:view', $context);

if (!$canview) {
    print_error('accessdenied', 'dmelearn');
}

if (!$elmo = $DB->get_record('dmelearn', array('id' => $coursemodule->instance))) {
    print_error("Course module is incorrect");
}

if (!$cw = $DB->get_record('course_sections', array('id' => $coursemodule->section))) {
    print_error("Course module is incorrect");
}

// Using newer logging method only for Moodle 2.7 or newer.
// If Moodle is 2.7.X or newer.
if ($CFG->version >= 2014051200) {
    // Use the new $event->trigger() for logging.
    $event = \mod_dmelearn\event\course_module_viewed::create(array(
        'objectid' => $PAGE->cm->instance,
        'context' => $PAGE->context,
    ));
    $event->add_record_snapshot('course', $PAGE->course);
    // In the next line you can use $PAGE->activityrecord if it is set, or skip this line if you don't have a record
    // $event->add_record_snapshot($PAGE->cm->modname, $activityrecord);
    $event->trigger();
} else {
    // Use the old method of logging (Moodle is 2.6 or older).
    add_to_log($course->id, "dmelearn", "view", "view.php?id=$coursemodule->id", $elmo->id, $coursemodule->id);
}

header("location: {$CFG->wwwroot}/mod/dmelearn/content/?id={$elmo->id}");
die();
