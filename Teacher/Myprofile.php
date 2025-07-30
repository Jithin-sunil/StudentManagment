<?php  
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_teacher  where teacher_id='".$_SESSION['tid']."' ";
	$row=$Con->query($selQry);
	$row=$row->fetch_assoc();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<form id="form1" name="form1" method="post" action="">
</form>
<table width="200" border="1">
  <tr>
    
  <tr>
    <tr>
    <td colspan="2" align="center">
     <img src="../Assets/Files/teacher/<?php echo $row['teacher_photo']?>" width="150" height="150" /></td>
  </tr>
  </tr>
  <tr>
    <td>Email</td>
    <td> <?php echo $row['teacher_email']; ?></td>
  </tr>
  <tr>
    <td>Contact</td>
    <td><?php echo $row['teacher_contact']; ?></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><?php echo $row['teacher_address']; ?></td>
  </tr>
  
    <td colspan="2"><br />

<a href="Editprofile.php">Editprofile</a>  
<a href="Changepassword.php">Changepassword</a></td>
  </tr>
</table>
</body>
</html>