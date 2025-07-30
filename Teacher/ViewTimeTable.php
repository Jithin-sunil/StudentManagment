<?php
include("../Assets/Connection/Connection.php");
session_start();

function createSubjectDisplay($Con, $semester, $course, $hour, $day) {
    $selQry = "SELECT s.subject_name 
               FROM tbl_timetable t 
               INNER JOIN tbl_subject s ON t.subject_id = s.subject_id 
               INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
               WHERE t.timetable_day='$day' AND t.timetable_hour='$hour' 
               AND t.semester_id='$semester' AND a.course_id='$course'";
    $result = $Con->query($selQry);
    if ($data = $result->fetch_assoc()) {
        return $data['subject_name'];
    }
    return "Free";
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Teacher Timetable</title>
    <style>
        #lunch {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
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
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Teacher Timetable</h1>
    <?php
    if (!isset($_SESSION['tid'])) {
        ?>
        <script>
            alert("Please log in to view the timetable.");
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
    <form id="form1" name="form1" method="get" action="">
        <table border="1">
            <tr>
                <td>Course</td>
                <td>
                    <select name="sel_course" id="sel_course">
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
                    <input type="submit" name="btn_reset" value="Reset" onclick="window.location='ViewTimetable.php'" />
                </td>
            </tr>
            <?php
            if (isset($_GET['btn_submit'])) {
                $course_id = $_GET["sel_course"];
                $semester = $_GET["sel_semester"];
                if ($course_id != "" && $semester != "") {
                    // Verify course belongs to teacher's department
                    $selCourse = "SELECT * FROM tbl_course WHERE course_id='$course_id' AND department_id='$department_id'";
                    $resultCourse = $Con->query($selCourse);
                    if ($resultCourse->num_rows == 0) {
                        ?>
                        <script>
                            alert("Invalid course for your department.");
                            window.location = "ViewTimetable.php";
                        </script>
                        <?php
                        exit;
                    }
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
                                echo createSubjectDisplay($Con, $semester, $course_id, $i, $day);
                                echo '</td>';
                            }
                        }
                        echo '</tr>';
                    }
                } else {
                    ?>
                    <script>
                        alert("Select Course and Semester");
                        window.location = "ViewTimetable.php";
                    </script>
                    <?php
                }
            }
            ?>
        </table>
    </form>
</div>
</body>
</html>