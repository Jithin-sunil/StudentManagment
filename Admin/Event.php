<?php
include("../Assets/Connection/Connection.php");

if (isset($_POST["btn_submit"])) {
    $event = $_POST['txt_content'];
    $fordate = $_POST['txt_fordate'];

    $photo = $_FILES["file_doc"]["name"];
    $path = $_FILES["file_doc"]["tmp_name"];

    if ($photo != "") {
        move_uploaded_file($path, '../Assets/Files/Event/' . $photo);
    }

    $insQry = "INSERT INTO tbl_event (event_content, event_date, event_file, event_fordate) 
               VALUES ('" . $event . "', CURDATE(), '" . $photo . "', '" . $fordate . "')";

    if ($Con->query($insQry)) {
        ?>
        <script>
            alert("Inserted Successfully");
            window.location = "Event.php";
        </script>
        <?php
    }
}

if (isset($_GET['did'])) {
    $Delqry = "DELETE FROM tbl_event WHERE event_id='" . $_GET['did'] . "'";
    if ($Con->query($Delqry)) {
        ?>
        <script>
            alert("Deleted Successfully");
            window.location = "Event.php";
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Event Management</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table border="1">
        <tr>
            <td>Content</td>
            <td><input type="text" name="txt_content" id="txt_content" required="required"/></td>
        </tr>
        <tr>
            <td>File</td>
            <td><input type="file" name="file_doc" id="file_doc" /></td>
        </tr>
        <tr>
            <td>For Date</td>
            <td><input type="date" name="txt_fordate" id="txt_fordate" required="required" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
        </tr>
    </table>

    <br><br>

    <table border="1">
        <tr>
            <th>SINO</th>
            <th>DATE</th>
            <th>CONTENT</th>
            <th>FILE</th>
            <th>FORDATE</th>
            <th>ACTION</th>
        </tr>

        <?php
        $i = 0;
        $selQry = "SELECT * FROM tbl_event";
        $result = $Con->query($selQry);

        while ($row = $result->fetch_assoc()) {
           
           

            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row["event_date"]; ?></td>
                <td><?php echo $row["event_content"]; ?></td>
                <td>
                <?php
				 if ($row['event_file'] == "") {
                
           		 }
				 else
				 {
					 ?>
                     <a href="../Assets/Files/Event/<?php echo $row['event_file']; ?>" target="_blank">View File</a>
                     <?php
				 }
				
				?>
                    
                </td>
                <td><?php echo $row["event_fordate"]; ?></td>
                <td><a href="Event.php?did=<?php echo $row["event_id"]; ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a></td>
            </tr>
            <?php
        }
        ?>
    </table>
</form>
</body>
</html>
