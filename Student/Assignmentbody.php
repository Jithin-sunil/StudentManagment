<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST['btn_submit']))
{
	 $file = $_FILES["file_doc"]["name"];
    $tmpName = $_FILES["file_doc"]["tmp_name"];
   
    move_uploaded_file($tmpName, '../Assets/Files/Studymaterial/'.$file);	
	
	$insQry="insert into tbl_assignmentbody (assignmentbody_file,assignment_id,student_id,assignmentbody_date)value('".$file."','".$_GET['aid']."','".$_SESSION['sid']."',curdate())";
	if($Con->query($insQry))
	{	
		?>
		<script>
        alert=("uploaded");
		window.location="Viewassignment.php";
        </script>	
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="200" border="1">
    <tr>
      <td>upload file</td>
      <td><label for="file_doc"></label>
      <input type="file" name="file_doc" id="file_doc" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>