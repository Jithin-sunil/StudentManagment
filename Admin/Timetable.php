<?php
include("../Assets/Connection/Connection.php");

function createSubjectOptions($Con, $semester, $course, $hour, $day) {
    $selQry = "SELECT * FROM tbl_subject s 
               INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
               WHERE a.semester_id='$semester' AND a.course_id='$course'";
    $result = $Con->query($selQry);
    while ($data = $result->fetch_assoc()) {
        $selQry1 = "SELECT * FROM tbl_timetable t 
                    INNER JOIN tbl_subject s ON t.subject_id = s.subject_id 
                    WHERE t.timetable_day='$day' AND t.timetable_hour='$hour' 
                    AND t.semester_id='$semester' AND s.course_id='$course' 
                    AND t.subject_id='" . $data['subject_id'] . "'";
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
    <title>Timetable</title>
    <style>
        #lunch {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Timetable</h1>
    <form id="form1" name="form1" method="get" action="">
        <table border="1">
            <tr>
                <td>Department</td>
                <td>
                    <select name="sel_department" id="sel_department" onchange="getCourse(this.value)">
                        <option value="">--Select--</option>
                        <?php
                        $selQry = "SELECT * FROM tbl_department";
                        $result = $Con->query($selQry);
                        while ($data = $result->fetch_assoc()) {
                            echo '<option value="' . $data['department_id'] . '">' . $data['department_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>Course</td>
                <td>
                    <select name="sel_course" id="sel_course">
                        <option value="">--Select--</option>
                    </select>
                </td>
                <td>Semester</td>
                <td>
                    <select name="sel_semester" id="sel_semester">
                        <option value="">--Select--</option>
                        <?php
                        $selQry = "SELECT * FROM tbl_semester";
                        $result = $Con->query($selQry);
                        while ($data = $result->fetch_assoc()) {
                            echo '<option value="' . $data['semester_id'] . '">' . $data['semester_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="submit" name="btn_submit" value="Submit" />
                </td>
                <td>
                    <input type="submit" name="btn_reset" value="Reset" onclick="window.location='Timetable.php'" />
                </td>
            </tr>
            <?php
            if (isset($_GET['btn_submit'])) {
                $course_id = $_GET["sel_course"];
                $semester = $_GET["sel_semester"];
                if ($course_id != "" && $semester != "") {
                    ?>
                    <tr>
                        <td>Day</td>
                        <td>9:30-10:30</td>
                        <td>10:30-11:30</td>
                        <td>11:45-12:45</td>
                        <td>12:45-1:45</td>
                        <td>1:45-2:30</td>
                        <td>2:30-3:30</td>
                    </tr>
                    <?php
                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                    foreach ($days as $day) {
                        echo '<tr>';
                        echo '<td height="38">' . $day . '</td>';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($day == 'Monday' && $i == 4) {
                                echo '<td rowspan="6"><div id="lunch"><p>L</p><p>U</p><p>N</p><p>C</p><p>H</p></div></td>';
                            } else {
                                echo '<td>';
                                echo "<select id='sel_subject' onchange='submitTimetable($i, $semester, this.value, \"$day\", $course_id)'>";
                                echo '<option value="">Select</option>';
                                createSubjectOptions($Con, $semester, $course_id, $i, $day);
                                echo '</select>';
                                echo '</td>';
                            }
                        }
                        echo '</tr>';
                    }
                } else {
                    ?>
                    <script>
                        alert("Select Course and Semester");
                        window.location = "Timetable.php";
                    </script>
                    <?php
                }
            }
            ?>
        </table>
    </form>
</div>
<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getCourse(did) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxCourse.php?did=" + did,
        success: function(result) {
            $("#sel_course").html(result);
        }
    });
}

function submitTimetable(hour, semester, subject, day, course_id) {
    $.ajax({
        url: "../Assets/AjaxPages/AjaxTimeTable.php?hour=" + hour + "&semester=" + semester + "&subject=" + subject + "&day=" + day + "&course_id=" + course_id,
        success: function(html) {
            window.location = "Timetable.php?sel_course=" + course_id + "&sel_semester=" + semester + "&btn_submit=Submit";
        }
    });
}
</script>
</body>
</html>