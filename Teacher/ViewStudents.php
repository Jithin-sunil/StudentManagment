<?php
include("../Assets/Connection/Connection.php");
session_start();

if (!isset($_SESSION['tid'])) {
    ?>
    <script>
        alert("Please log in to view student attendance.");
        window.location = "Login.php";
    </script>
    <?php
    exit;
}

$teacher_id = $_SESSION['tid'];

// Get the teacher's class
$selClass = "SELECT class_id, class_name FROM tbl_class WHERE teacher_id='$teacher_id'";
$resultClass = $Con->query($selClass);
if ($rowClass = $resultClass->fetch_assoc()) {
    $class_id = $rowClass['class_id'];
    $class_name = $rowClass['class_name'];
} else {
    ?>
    <script>
        alert("No class assigned to this teacher.");
        window.location = "Home.php";
    </script>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View Student Attendance</title>
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
        .form-container {
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Student Attendance for Class <?php echo $class_name; ?></h1>
    <div class="form-container">
        <form method="post" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required />
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required />
            <input type="submit" name="btn_filter" value="Filter" />
        </form>
    </div>
    <?php
    // Set default date range (e.g., current month) if not submitted
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t');

    // Validate date range
    if ($start_date > $end_date) {
        echo '<p class="error">Start date cannot be after end date.</p>';
    } else {
        // Get semesters for the class
        $selSemesters = "SELECT DISTINCT s.semester_id, s.semester_name 
                         FROM tbl_classsem cs 
                         INNER JOIN tbl_semester s ON cs.semester_id = s.semester_id 
                         WHERE cs.class_id='$class_id'";
        $resultSemesters = $Con->query($selSemesters);
        $semesters = [];
        while ($rowSemester = $resultSemesters->fetch_assoc()) {
            $semesters[] = $rowSemester;
        }

        if (empty($semesters)) {
            echo '<p class="error">No semesters found for this class.</p>';
        } else {
            // Get students in the class
            $selStudents = "SELECT student_id, student_name FROM tbl_student WHERE class_id='$class_id'";
            $resultStudents = $Con->query($selStudents);

            if ($resultStudents->num_rows > 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>Student Name</th>
                        <?php
                        foreach ($semesters as $semester) {
                            echo '<th>' . $semester['semester_name'] . ' (%)</th>';
                        }
                        ?>
                    </tr>
                    <?php
                    while ($student = $resultStudents->fetch_assoc()) {
                        $student_id = $student['student_id'];
                        echo '<tr>';
                        echo '<td>' . $student['student_name'] . '</td>';
                        foreach ($semesters as $semester) {
                            $semester_id = $semester['semester_id'];
                            // Calculate attendance percentage
                            $selAttendance = "SELECT 
                                                COUNT(*) AS total_sessions,
                                                SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) AS present_sessions
                                              FROM tbl_attendance 
                                              WHERE student_id='$student_id' 
                                              AND semester_id='$semester_id' 
                                              AND attendance_date BETWEEN '$start_date' AND '$end_date'";
                            $resultAttendance = $Con->query($selAttendance);
                            $attendance = $resultAttendance->fetch_assoc();
                            $total = $attendance['total_sessions'];
                            $present = $attendance['present_sessions'];
                            $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;
                            echo '<td>' . $percentage . '%</td>';
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
                <?php
            } else {
                echo '<p class="error">No students found in this class.</p>';
            }
        }
    }
    ?>
</div>
</body>
</html>