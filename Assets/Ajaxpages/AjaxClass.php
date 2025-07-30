<?php
include("../Connection/Connection.php");
$cid = $_GET["cid"];
$selQry = "SELECT * FROM tbl_class WHERE course_id='$cid'";
$result = $Con->query($selQry);
echo "<option value=''>--Select--</option>";
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['class_id'] . '">' . $row['class_name'] . '</option>';
}
?>