<?php
include("../Assets/Connection/Connection.php");
session_start();

function getSubjectOptions($Con, $semester, $course, $hour, $day, $teacher_id) {
    $selQry = "SELECT s.subject_id, s.subject_name 
               FROM tbl_subject s 
               INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
               WHERE a.semester_id='$semester' AND a.course_id='$course' AND a.teacher_id='$teacher_id'";
    $result = $Con->query($selQry);
    echo "<option value=''>Select Subject</option>";
    while ($data = $result->fetch_assoc()) {
        $selQry1 = "SELECT * FROM tbl_timetable t 
                    WHERE t.timetable_day='$day' AND t.timetable_hour='$hour' 
                    AND t.semester_id='$semester' AND t.subject_id='" . $data['subject_id'] . "'";
        $data1 = $Con->query($selQry1);
        if ($row1 = $data1->fetch_assoc()) {
            echo '<option selected value="' . $data['subject_id'] . '">' . $data['subject_name'] . '</option>';
        } else {
            echo '<option value="' . $data['subject_id'] . '">' . $data['subject_name'] . '</option>';
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Set Attendance</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Set Student Attendance</h1>
    <?php
    if (!isset($_SESSION['tid'])) {
        ?>
        <script>
            alert("Please log in to set attendance.");
            window.location = "Login.php";
        </script>
        <?php
        exit;
    }
    $teacher_id = $_SESSION['tid'];
    $selTeacher = "SELECT department_id FROM tbl_teacher WHERE teacher_id='$teacher_id'";
    $resultTeacher = $Con->query($selTeacher);
    if ($rowTeacher = $resultTeacher->fetch_assoc()) {
        $department_id = $rowTeacher['department_id'];
    } else {
        ?>
        <script>
            alert("Teacher not found.");
            window.location = "Login.php";
        </script>
        <?php
        exit;
    }
    ?>
    <form id="form1" name="form1" method="post" action="">
        <table border="1">
            <tr>
                <td>Course</td>
                <td>
                    <select name="sel_course" id="sel_course" onchange="getSemester(this.value)">
                        <option value="">--Select--</option>
                        <?php
                        $selQry = "SELECT * FROM tbl_course WHERE department_id='$department_id'";
                        $result = $Con->query($selQry);
                        while ($data = $result->fetch_assoc()) {
                            echo '<option value="' . $data['course_id'] . '">' . $data['course_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>Semester</td>
                <td>
                    <select name="sel_semester" id="sel_semester" onchange="updateSubjects()">
                        <option value="">--Select--</option>
                    </select>
                </td>
                <td>Date</td>
                <td>
                    <input type="date" name="attendance_date" id="attendance_date"  onchange="updateSubjects()" />
                </td>
                <td>Hour</td>
                <td>
                    <select name="sel_hour" id="sel_hour" onchange="updateSubjects()">
                        <option value="">--Select--</option>
                        <option value="1">9:30-10:30</option>
                        <option value="2">10:30-11:30</option>
                        <option value="3">11:45-12:45</option>
                        <option value="4">12:45-1:45</option>
                        <option value="5">1:45-2:30</option>
                        <option value="6">2:30-3:30</option>
                    </select>
                </td>
                <td>Subject</td>
                <td>
                    <select name="sel_subject" id="sel_subject" >
                        <option value="">--Select--</option>
                    </select>
                </td>
                <td>
                    <input type="submit" name="btn_submit" value="Submit" />
                </td>
            </tr>
        </table>
        <?php
        if (isset($_POST['btn_submit']) && !isset($_POST['btn_save'])) {
            $course_id = $_POST['sel_course'];
            $semester_id = $_POST['sel_semester'];
            $attendance_date = $_POST['attendance_date'];
            $hour = $_POST['sel_hour'];
            $subject_id = $_POST['sel_subject'];

            if ($course_id != "" && $semester_id != "" && $attendance_date != "" && $hour != "" && $subject_id != "") {
                // Verify course belongs to teacher's department
                $selCourse = "SELECT * FROM tbl_course WHERE course_id='$course_id' AND department_id='$department_id'";
                $resultCourse = $Con->query($selCourse);
                if ($resultCourse->num_rows == 0) {
                    echo '<p class="error">Invalid course for your department.</p>';
                    exit;
                }

                // Verify subject belongs to course, semester, and teacher
                $selSubject = "SELECT * FROM tbl_subject s 
                               INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
                               WHERE s.subject_id='$subject_id' AND a.course_id='$course_id' 
                               AND a.semester_id='$semester_id' AND a.teacher_id='$teacher_id'";
                $resultSubject = $Con->query($selSubject);
                if ($resultSubject->num_rows == 0) {
                    echo '<p class="error">Invalid subject for the selected course, semester, or teacher.</p>';
                    exit;
                }

                // Verify subject is scheduled in timetable
                $day = date('l', strtotime($attendance_date));
                $selTimetable = "SELECT * FROM tbl_timetable 
                                 WHERE timetable_day='$day' AND timetable_hour='$hour' 
                                 AND semester_id='$semester_id' AND subject_id='$subject_id'";
                $resultTimetable = $Con->query($selTimetable);
                if ($resultTimetable->num_rows == 0) {
                    echo '<p class="error">Selected subject is not scheduled for this day and hour.</p>';
                    exit;
                }

                // Get class_id for the selected course and latest semester
                $selClass = "SELECT c.class_id 
                             FROM tbl_class c 
                             INNER JOIN tbl_classsem cs ON c.class_id = cs.class_id 
                             WHERE c.course_id='$course_id' AND cs.semester_id='$semester_id' 
                             ORDER BY cs.classsem_id DESC LIMIT 1";
                $resultClass = $Con->query($selClass);
                if ($rowClass = $resultClass->fetch_assoc()) {
                    $class_id = $rowClass['class_id'];
                } else {
                    echo '<p class="error">No class found for the selected course and semester.</p>';
                    exit;
                }

                // Fetch students in the class
                $selStudents = "SELECT s.student_id, s.student_name 
                                FROM tbl_student s 
                                WHERE s.class_id='$class_id'";
                $resultStudents = $Con->query($selStudents);

                if ($resultStudents->num_rows > 0) {
                    ?>
                    <h3>Mark Attendance for <?php echo $attendance_date; ?> (Hour: <?php echo $hour; ?>)</h3>
                    <table border="1">
                        <tr>
                            <th>Student Name</th>
                            <th>Attendance Status</th>
                        </tr>
                        <?php
                        while ($student = $resultStudents->fetch_assoc()) {
                            $student_id = $student['student_id'];
                            // Check existing attendance
                            $selAttendance = "SELECT attendance_status 
                                              FROM tbl_attendance 
                                              WHERE student_id='$student_id' 
                                              AND teacher_id='$teacher_id' 
                                              AND attendance_date='$attendance_date' 
                                              AND attendance_hour='$hour'";
                            $resultAttendance = $Con->query($selAttendance);
                            $status = $resultAttendance->fetch_assoc()['attendance_status'] ?? '';
                            ?>
                            <tr>
                                <td><?php echo $student['student_name']; ?></td>
                                <td>
                                    <select name="attendance[<?php echo $student_id; ?>]" >
                                        <option value="Present" <?php echo $status == 'Present' ? 'selected' : ''; ?>>Present</option>
                                        <option value="Absent" <?php echo $status == 'Absent' ? 'selected' : ''; ?>>Absent</option>
                                    </select>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                                <input type="hidden" name="semester_id" value="<?php echo $semester_id; ?>" />
                                <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>" />
                                <input type="hidden" name="attendance_hour" value="<?php echo $hour; ?>" />
                                <input type="submit" name="btn_save" value="Save Attendance" />
                            </td>
                        </tr>
                    </table>
                    <?php
                } else {
                    echo '<p class="error">No students found for this class.</p>';
                }
            } else {
                echo '<p class="error">Please select course, semester, date, hour, and subject.</p>';
            }
        }

        if (isset($_POST['btn_save'])) {
            $course_id = $_POST['course_id'];
            $semester_id = $_POST['semester_id'];
            $attendance_date = $_POST['attendance_date'];
            $hour = $_POST['attendance_hour'];
            $attendance = $_POST['attendance'];

            foreach ($attendance as $student_id => $status) {
                // Check if attendance record exists
                $selAttendance = "SELECT attendance_id 
                                  FROM tbl_attendance 
                                  WHERE student_id='$student_id' 
                                  AND teacher_id='$teacher_id' 
                                  AND attendance_date='$attendance_date' 
                                  AND attendance_hour='$hour'";
                $resultAttendance = $Con->query($selAttendance);
                if ($resultAttendance->num_rows > 0) {
                    // Update existing record
                    $upQry = "UPDATE tbl_attendance 
                              SET attendance_status='$status' 
                              WHERE student_id='$student_id' 
                              AND teacher_id='$teacher_id' 
                              AND attendance_date='$attendance_date' 
                              AND attendance_hour='$hour'";
                    $Con->query($upQry);
                } else {
                    // Insert new record
                    $insQry = "INSERT INTO tbl_attendance (student_id, teacher_id, semester_id, course_id, attendance_date, attendance_hour, attendance_status) 
                               VALUES ('$student_id', '$teacher_id', '$semester_id', '$course_id', '$attendance_date', '$hour', '$status')";
                    $Con->query($insQry);
                }
            }
            ?>
            <script>
                alert("Attendance saved successfully.");
                window.location = "Attandance.php";
            </script>
            <?php
        }
        ?>
    </form>
</div>
<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getSemester(course_id) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxSemester.php?course_id=" + course_id,
        success: function(result) {
            $("#sel_semester").html(result);
            updateSubjects();
        }
    });
}

function updateSubjects() {
    var course_id = $("#sel_course").val();
    var semester_id = $("#sel_semester").val();
    var hour = $("#sel_hour").val();
    var date = $("#attendance_date").val();
    if (course_id && semester_id && hour && date) {
        var day = new Date(date).toLocaleDateString('en-US', { weekday: 'long' });
        $.ajax({
            url: "../Assets/AjaxPages/AjaxSub.php?course_id=" + course_id + "&semester_id=" + semester_id + "&hour=" + hour + "&day=" + day + "&teacher_id=<?php echo $teacher_id; ?>",
            success: function(result) {
                $("#sel_subject").html(result);
            }
        });
    } else {
        $("#sel_subject").html("<option value=''>Select Subject</option>");
    }
}
</script>
</body>
</html>