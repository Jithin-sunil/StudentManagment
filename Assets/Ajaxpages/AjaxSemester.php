<?php
include("../Connection/Connection.php");
$course_id = $_GET["course_id"];
$selQry = "SELECT s.semester_id, s.semester_name 
           FROM tbl_classsem cs 
           INNER JOIN tbl_semester s ON cs.semester_id = s.semester_id 
           INNER JOIN tbl_class c ON cs.class_id = c.class_id 
           WHERE c.course_id='$course_id' 
           ORDER BY cs.classsem_id DESC";
$result = $Con->query($selQry);
echo "<option value=''>--Select--</option>";
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['semester_id'] . '">' . $row['semester_name'] . '</option>';
}
?>