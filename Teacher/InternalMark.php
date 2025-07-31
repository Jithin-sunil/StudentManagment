<?php
include("../Assets/Connection/Connection.php");
session_start();


$teacher_id = $_SESSION['tid'];
$subject_id = isset($_GET["sid"]) ? intval($_GET["sid"]) : 0;

if (isset($_POST['btn_save'])) {
    $subject_id = intval($_POST['subject_id']);
    $semester_id = intval($_POST['semester_id']);
    $course_id = intval($_POST['course_id']);
    $marks = $_POST['marks'];

    $selAssign = "SELECT * FROM tbl_assignsubject WHERE subject_id='$subject_id' AND teacher_id='$teacher_id'";
    $resultAssign = $Con->query($selAssign);
    if ($resultAssign->num_rows == 0) {
        ?>
        <script>
            alert("Unauthorized: You are not assigned to this subject.");
            window.location = "Home.php";
        </script>
        <?php
        exit;
    }

    foreach ($marks as $student_id => $mark) {
        $mark = floatval($mark);
        if ($mark < 0 || $mark > 50) {
            continue; 
        }
        $student_id = intval($student_id);

        $selMark = "SELECT internalmark_id FROM tbl_internalmark 
                    WHERE student_id='$student_id' AND subject_id='$subject_id' AND teacher_id='$teacher_id'";
        $resultMark = $Con->query($selMark);

        if ($resultMark->num_rows > 0) {
            $upQry = "UPDATE tbl_internalmark 
                      SET internalmark_mark='$mark' 
                      WHERE student_id='$student_id' AND subject_id='$subject_id' AND teacher_id='$teacher_id'";
            $Con->query($upQry);
        } else {
            $insQry = "INSERT INTO tbl_internalmark (student_id, teacher_id, subject_id, semester_id, course_id, internalmark_mark) 
                       VALUES ('$student_id', '$teacher_id', '$subject_id', '$semester_id', '$course_id', '$mark')";
            $Con->query($insQry);
        }
    }
    ?>
    <script>
        alert("Marks saved successfully.");
        window.location = "InternalMark.php?sid=<?php echo $subject_id; ?>";
    </script>
    <?php
    exit;
}

$selSubject = "SELECT s.subject_id, s.subject_name, s.semester_id, s.course_id, sem.semester_name 
               FROM tbl_subject s 
               INNER JOIN tbl_assignsubject a ON s.subject_id = a.subject_id 
               INNER JOIN tbl_semester sem ON s.semester_id = sem.semester_id 
               WHERE s.subject_id = '$subject_id' AND a.teacher_id = '$teacher_id'";
$resultSubject = $Con->query($selSubject);
if ($dataSubject = $resultSubject->fetch_assoc()) {
    $semester_name = $dataSubject["semester_name"];
    $subject_name = $dataSubject["subject_name"];
    $semester_id = $dataSubject["semester_id"];
    $course_id = $dataSubject["course_id"];
} else {
    ?>
    <script>
        alert("Invalid or unauthorized subject.");
        window.location = "Home.php";
    </script>
    <?php
    exit;
}

$selStudents = "SELECT s.student_id, s.student_name 
                FROM tbl_student s 
                INNER JOIN tbl_class c ON s.class_id = c.class_id 
                INNER JOIN tbl_classsem cs ON c.class_id = cs.class_id 
                WHERE c.course_id = '$course_id' AND cs.semester_id = '$semester_id'";
$resultStudents = $Con->query($selStudents);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Marks</title>
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
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
        }
        input[type=number] {
            width: 100px;
        }
    </style>
</head>
<body>
<div id="tab" align="center">
    <h1 align="center">Internal Marks</h1>
    <form method="post" action="">
        <table border="1">
            <tr> 
                <td>Semester</td>
                <td colspan="2"><?php echo $semester_name; ?></td>
            </tr>
            <tr> 
                <td>Subject</td>
                <td colspan="2"><?php echo $subject_name; ?></td>
            </tr>
            <tr> 
                <th>SL NO</th>
                <th>Student</th>
                <th>Mark (0-50)</th>
            </tr>
            <?php 
            $i = 0;
            while ($row = $resultStudents->fetch_assoc()) {
                $student_id = $row['student_id'];
                $mark = "0";

                // Check existing mark
                $selMark = "SELECT internalmark_mark 
                            FROM tbl_internalmark 
                            WHERE student_id='$student_id' AND subject_id='$subject_id' AND teacher_id='$teacher_id'";
                $resultMark = $Con->query($selMark);
                if ($rowMark = $resultMark->fetch_assoc()) {
                    $mark = $rowMark["internalmark_mark"];
                }

                $i++;
                ?>
                <tr> 
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row["student_name"]; ?></td>
                    <td>
                        <input type="number" name="marks[<?php echo $student_id; ?>]" id="mark_<?php echo $student_id; ?>" 
                               value="<?php echo $mark; ?>" placeholder="Enter Mark" 
                               min="0" max="50" step="0.01" required 
                               onkeyup="updateMark(this.value, <?php echo $subject_id; ?>, <?php echo $student_id; ?>, <?php echo $teacher_id; ?>)"/>
                    </td>
                </tr>
                <?php
            }
            if ($i == 0) {
                echo '<tr><td colspan="3" class="error">No students found for this subject and semester.</td></tr>';
            }
            ?>
            <tr>
                <td colspan="3">
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>" />
                    <input type="hidden" name="semester_id" value="<?php echo $semester_id; ?>" />
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                    <input type="submit" name="btn_save" value="Save All Marks" />
                </td>
            </tr>
        </table>
    </form>
</div>

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function updateMark(mark, sub, stud, teacher) {
    if (mark < 0 || mark > 50) {
        alert("Mark must be between 0 and 50.");
        document.getElementById('mark_' + stud).value = '';
        return;
    }
    $.ajax({
        url: "../Assets/AjaxPages/AjaxMark.php?mark=" + mark + "&sub=" + sub + "&stud=" + stud + "&teacher=" + teacher,
        success: function(html) {
            if (html.trim() === "success") {
                //alert("Mark updated successfully.");
            } else if (html.trim() !== "") {
                alert(html.trim());
            }
        },
       
    });
}
</script>
</body>
</html>