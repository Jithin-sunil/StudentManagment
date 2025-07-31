<?php
include("../Connection/Connection.php");

$mark = floatval($_GET["mark"]);
$subject_id = intval($_GET["sub"]);
$student_id = intval($_GET["stud"]);
$teacher_id = intval($_GET["teacher"]);

if ($mark < 0 || $mark > 50) {
    echo "Mark must be between 0 and 50.";
    exit;
}
$selSubject = "SELECT course_id, semester_id FROM tbl_subject WHERE subject_id='$subject_id'";
$resultSubject = $Con->query($selSubject);
if ($rowSubject = $resultSubject->fetch_assoc()) {
    $course_id = $rowSubject['course_id'];
    $semester_id = $rowSubject['semester_id'];
} else {
    echo "Invalid subject.";
    exit;
}

$selAssign = "SELECT * FROM tbl_assignsubject WHERE subject_id='$subject_id' AND teacher_id='$teacher_id'";
$resultAssign = $Con->query($selAssign);
if ($resultAssign->num_rows == 0) {
    echo "Unauthorized: You are not assigned to this subject.";
    exit;
}

$selMark = "SELECT internalmark_id FROM tbl_internalmark 
            WHERE student_id='$student_id' AND subject_id='$subject_id' AND teacher_id='$teacher_id'";
$resultMark = $Con->query($selMark);

if ($resultMark->num_rows > 0) {
    $upQry = "UPDATE tbl_internalmark 
              SET internalmark_mark='$mark' 
              WHERE student_id='$student_id' AND subject_id='$subject_id' AND teacher_id='$teacher_id'";
    if ($Con->query($upQry)) {
        echo "success";
    } else {
        echo "Error updating mark.";
    }
} else {
    $insQry = "INSERT INTO tbl_internalmark (student_id, teacher_id, subject_id, semester_id, course_id, internalmark_mark) 
               VALUES ('$student_id', '$teacher_id', '$subject_id', '$semester_id', '$course_id', '$mark')";
    if ($Con->query($insQry)) {
        echo "success";
    } else {
        echo "Error inserting mark.";
    }
}
?>