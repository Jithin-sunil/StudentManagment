<?php
include("../Connection/Connection.php");
$course_id = $_GET["course_id"];
$semester_id = $_GET["semester_id"];
$hour = $_GET["hour"];
$day = $_GET["day"];
$teacher_id = $_GET["teacher_id"];

$selQry = "SELECT s.subject_id, s.subject_name 
           FROM tbl_subject s 
           INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
           INNER JOIN tbl_timetable t ON s.subject_id = t.subject_id 
           WHERE a.semester_id='$semester_id' AND a.course_id='$course_id' 
           AND a.teacher_id='$teacher_id' 
           AND t.timetable_day='$day' AND t.timetable_hour='$hour'";
$result = $Con->query($selQry);
echo "<option value=''>Select Subject</option>";
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['subject_id'] . '">' . $row['subject_name'] . '</option>';
}
?>