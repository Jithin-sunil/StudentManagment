<?php
include("../Connection/Connection.php");
$did = $_GET["did"];
$selQry = "SELECT * FROM tbl_course WHERE department_id='$did'";
$result = $Con->query($selQry);
echo "<option value=''>--Select--</option>";
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
}
?>