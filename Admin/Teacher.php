<?php
include("../Assets/Connection/Connection.php");

if (isset($_POST["btn_register"])) {
    $name = $_POST["txt_name"];
    $email = $_POST["txt_mail"];
    $Contact = $_POST["txt_contact"];
    $address = $_POST["txt_address"];
    $gender = $_POST["rd_gender"];
    $password = $_POST["pws_password"];
    $department = $_POST["sel_department"];
    $designation = $_POST["radio"];

    // Handle photo upload
    if (isset($_FILES["file_photo"]) && $_FILES["file_photo"]["error"] == 0) {
        $photo = $_FILES["file_photo"]["name"];
        $path = $_FILES["file_photo"]["tmp_name"];
		
        $ext = pathinfo($photo, PATHINFO_EXTENSION);
        $newPhotoName = uniqid("teacher_") . "." . $ext;
        move_uploaded_file($path, "../Assets/Files/Teacher/" . $newPhotoName);
    } else {
        $newPhotoName = ""; // Set empty if file not uploaded
    }

    $insQry = "INSERT INTO tbl_teacher (
        teacher_name, teacher_email, teacher_contact, teacher_address, 
        teacher_gender, teacher_password, department_id, teacher_designation, teacher_photo
    ) VALUES (
        '$name', '$email', '$Contact', '$address',
        '$gender', '$password', '$department', '$designation', '$newPhotoName'
    )";

    if ($Con->query($insQry))
	 {
		 
     ?>
        <script>
		alert("insert Seccesfully");
		window.location="teacher.php";
		</script>
        <?php
}
}
if (isset($_GET['did'])) {
    $Delqry = "DELETE FROM tbl_teacher WHERE teacher_id='" . $_GET['did'] . "'";
    if ($Con->query($Delqry)) {
        echo "<script>alert('Deleted Successfully'); window.location='Teacher.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Registration</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <table border="1">
        <tr><td>Name</td>
            <td><input type="text" name="txt_name" required pattern="^[A-Z][a-zA-Z ]*$" title="Name must start with a capital letter and contain only letters and spaces"></td>
        </tr>
        <tr><td>Email</td>
            <td><input type="email" name="txt_mail" required></td>
        </tr>
        <tr><td>Contact</td>
            <td><input type="text" name="txt_contact" required pattern="[6-9]{1}[0-9]{9}" title="Must start with 6-9 and be 10 digits"></td>
        </tr>
        <tr><td>Address</td>
            <td><textarea name="txt_address" required></textarea></td>
        </tr>
        <tr><td>Designation</td>
            <td>
                <input type="radio" name="radio" value="HOD" required> HOD
                <input type="radio" name="radio" value="Assistant professor"> Assistant Professor
            </td>
        </tr>
        <tr><td>Department</td>
            <td>
                <select name="sel_department" required>
                    <option value="">---select---</option>
                    <?php
                    $sel = "SELECT * FROM tbl_department";
                    $result = $Con->query($sel);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["department_id"] . "'>" . $row["department_name"] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr><td>Gender</td>
            <td>
                <input type="radio" name="rd_gender" value="Male" required> Male
                <input type="radio" name="rd_gender" value="Female"> Female
            </td>
        </tr>
        <tr><td>Photo</td>
            <td><input type="file" name="file_photo" accept="image/*" required></td>
        </tr>
        <tr><td>Password</td>
            <td>
                <input type="password" name="pws_password" required
                    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}"
                    title="Must be 8+ characters with at least 1 uppercase, 1 lowercase, and 1 number">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="btn_register" value="REGISTER">
            </td>
        </tr>
    </table>

    <br>

    <table border="1">
        <tr>
            <th>S.No</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Department</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 0;
        $selQry = "SELECT * FROM tbl_teacher t 
                   INNER JOIN tbl_department d ON t.department_id = d.department_id";
        $result = $Con->query($selQry);
        while ($row = $result->fetch_assoc()) {
            $i++;
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td><img src='../Assets/Files/Teacher/" . $row["teacher_photo"] . "' width='100' height='100'></td>";
            echo "<td>" . $row["teacher_name"] . "</td>";
            echo "<td>" . $row["teacher_email"] . "</td>";
            echo "<td>" . $row["teacher_contact"] . "</td>";
            echo "<td>" . $row["teacher_address"] . "</td>";
            echo "<td>" . $row["teacher_gender"] . "</td>";
            echo "<td>" . $row["department_name"] . "</td>";
            echo "<td>" . $row["teacher_password"] . "</td>";
            echo "<td><a href='Teacher.php?did=" . $row["teacher_id"] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</form>
</body>
</html>
