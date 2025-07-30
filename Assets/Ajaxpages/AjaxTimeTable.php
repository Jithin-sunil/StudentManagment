<?php
include("../Connection/Connection.php");
session_start();
$hour = $_GET["hour"];
$subject = $_GET["subject"];
$semester = $_GET["semester"];
$day = $_GET["day"];
$course_id = $_GET["course_id"];

// Verify if the subject belongs to the course
$selSubject = "SELECT * FROM tbl_subject WHERE subject_id='$subject' AND course_id='$course_id'";
$subjectResult = $Con->query($selSubject);
if ($subjectResult->num_rows == 0) {
    echo "Invalid subject for the selected course";
    exit;
}

$selQry = "SELECT * FROM tbl_timetable 
           WHERE timetable_day='$day' AND timetable_hour='$hour' 
           AND semester_id='$semester'";
$data = $Con->query($selQry);
if ($data->num_rows > 0) {
    $upQry = "UPDATE tbl_timetable 
              SET subject_id='$subject' 
              WHERE timetable_day='$day' AND timetable_hour='$hour' 
              AND semester_id='$semester'";
    if ($Con->query($upQry)) {
        echo "Updated";
    }
} else {
    $insQry = "INSERT INTO tbl_timetable(timetable_day, timetable_hour, semester_id, subject_id) 
               VALUES ('$day', '$hour', '$semester', '$subject')";
    if ($Con->query($insQry)) {
        echo "Inserted";
    }
}
?>