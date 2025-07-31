<?php
include("../Assets/Connection/Connection.php");
session_start();


$student_id = $_SESSION['sid'];

$selStudent = "SELECT class_id FROM tbl_student WHERE student_id='$student_id'";
$resultStudent = $Con->query($selStudent);
if ($rowStudent = $resultStudent->fetch_assoc()) {
    $class_id = $rowStudent['class_id'];
} else {
    ?>
    <script>
        alert("Student not found.");
        window.location = "Home.php";
    </script>
    <?php
    exit;
}

$selSemesters = "SELECT s.semester_id, s.semester_name, cs.classsem_id 
                 FROM tbl_classsem cs 
                 INNER JOIN tbl_semester s ON cs.semester_id = s.semester_id 
                 WHERE cs.class_id='$class_id' 
                 ORDER BY s.semester_id ASC";
$resultSemesters = $Con->query($selSemesters);
$semesters = [];
$current_semester_id = 0;
$max_classsem_id = 0;

while ($rowSemester = $resultSemesters->fetch_assoc()) {
    $semesters[] = $rowSemester;
    if ($rowSemester['classsem_id'] > $max_classsem_id) {
        $max_classsem_id = $rowSemester['classsem_id'];
        $current_semester_id = $rowSemester['semester_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Internal Marks</title>
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
        h2 {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Internal Marks</h1>
    <?php
    if (empty($semesters)) {
        echo '<p class="error">No semesters found for your class.</p>';
    } else {
        foreach ($semesters as $semester) {
            $semester_id = $semester['semester_id'];
            $semester_name = $semester['semester_name'];
            $is_current = ($semester_id == $current_semester_id) ? " (Current)" : "";
            ?>
            <h2><?php echo $semester_name . $is_current; ?></h2>
            <?php
            // Get internal marks for the student in this semester
            $selMarks = "SELECT s.subject_name, im.internalmark_mark 
                         FROM tbl_internalmark im 
                         INNER JOIN tbl_subject s ON im.subject_id = s.subject_id 
                         WHERE im.student_id='$student_id' AND im.semester_id='$semester_id'";
            $resultMarks = $Con->query($selMarks);

            if ($resultMarks->num_rows > 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>Subject</th>
                        <th>Internal Mark (Out of 50)</th>
                    </tr>
                    <?php
                    while ($rowMark = $resultMarks->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $rowMark['subject_name']; ?></td>
                            <td><?php echo number_format($rowMark['internalmark_mark'], 2); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                echo '<p class="error">No internal marks found for ' . $semester_name . '.</p>';
            }
        }
    }
    ?>
</div>
</body>
</html>