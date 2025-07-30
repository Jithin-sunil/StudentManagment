<?php
include("../Assets/Connection/Connection.php");
session_start();

function createSubjectDisplay($Con, $semester, $course, $hour, $day) {
    $selQry = "SELECT s.subject_name 
               FROM tbl_timetable t 
               INNER JOIN tbl_subject s ON t.subject_id = s.subject_id 
               WHERE t.timetable_day='$day' AND t.timetable_hour='$hour' 
               AND t.semester_id='$semester' AND s.course_id='$course'";
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
    <title>Student Timetable</title>
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
    <h1 align="center">Your Timetable</h1>
    <?php
    if (!isset($_SESSION['sid'])) {
        ?>
        <script>
            alert("Please log in to view your timetable.");
            window.location = "Login.php";
        </script>
        <?php
        exit;
    }
    $student_id = $_SESSION['sid'];
    
    // Get student's class_id
    $selStudent = "SELECT class_id FROM tbl_student WHERE student_id='$student_id'";
    $resultStudent = $Con->query($selStudent);
    if ($rowStudent = $resultStudent->fetch_assoc()) {
        $class_id = $rowStudent['class_id'];
    } else {
        ?>
        <script>
            alert("Student not found.");
            window.location = "Login.php";
        </script>
        <?php
        exit;
    }
    
    // Get the latest semester_id for the class
    $selClassSem = "SELECT semester_id FROM tbl_classsem WHERE class_id='$class_id' ORDER BY classsem_id DESC LIMIT 1";
    $resultClassSem = $Con->query($selClassSem);
    if ($rowClassSem = $resultClassSem->fetch_assoc()) {
        $semester_id = $rowClassSem['semester_id'];
    } else {
        ?>
        <script>
            alert("No semester found for your class.");
            window.location = "Home.php";
        </script>
        <?php
        exit;
    }
    
    // Get course_id for the class
    $selClass = "SELECT course_id FROM tbl_class WHERE class_id='$class_id'";
    $resultClass = $Con->query($selClass);
    if ($rowClass = $resultClass->fetch_assoc()) {
        $course_id = $rowClass['course_id'];
    } else {
        ?>
        <script>
            alert("Class information not found.");
            window.location = "Home.php";
        </script>
        <?php
        exit;
    }
    
    // Get semester name for display
    $selSemester = "SELECT semester_name FROM tbl_semester WHERE semester_id='$semester_id'";
    $resultSemester = $Con->query($selSemester);
    $semester_name = $resultSemester->fetch_assoc()['semester_name'];
    
    // Get course name for display
    $selCourse = "SELECT course_name FROM tbl_course WHERE course_id='$course_id'";
    $resultCourse = $Con->query($selCourse);
    $course_name = $resultCourse->fetch_assoc()['course_name'];
    ?>
    
    <h3>Timetable for <?php echo $course_name; ?> - Semester <?php echo $semester_name; ?></h3>
    <table border="1">
        <tr>
            <th>Day</th>
            <th>9:30-10:30</th>
            <th>10:30-11:30</th>
            <th>11:45-12:45</th>
            <th>12:45-1:45</th>
            <th>1:45-2:30</th>
            <th>2:30-3:30</th>
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
                    echo createSubjectDisplay($Con, $semester_id, $course_id, $i, $day);
                    echo '</td>';
                }
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>
</body>
</html>