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
 * Redirect the user to the appropriate submission related page
 *
 * @package   mod_wooflash
 */

require_once __DIR__ . "/../../config.php";

$id = required_param('id', PARAM_INT); // Course module ID.

// Item number, may be != 0 for activities that allow more than one grade per user.
$itemnumber = optional_param('itemnumber', 0, PARAM_INT);
$userid = optional_param('userid', 0, PARAM_INT); // Graded user ID (optional).

$cm = get_coursemodule_from_id('wooflash', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, false, $cm);

$course_context = context_course::instance($cm->course);
$role = wooflash_get_role($course_context);

// For now, redirect both student and teacher to the same page.

if ($role == 'student') {
    redirect('view.php?id=' . $id);
} else {
    // We assume that $role == 'teacher'.
    redirect('view.php?id=' . $id);
}
