<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST["btn_login"]))
{
	
	$email=$_POST["txt_mail"];
	$password=$_POST["txt_password"];
	
	$selstudent="select * from tbl_student where student_email='".$email."' and student_password = '".$password."'";
	$studentrow=$Con->query($selstudent);
	
	echo $selteacher="select * from tbl_teacher where teacher_email='".$email."' and teacher_password = '".$password."'";
	$teacherrow=$Con->query($selteacher);
	
	
	if($studentdata=$studentrow->fetch_assoc())
	{
		$_SESSION['sid']=$studentdata['student_id'];
		$_SESSION['sname']=$studentdata['student_name'];
		header("location:../Student/Homepage.php");
	}
	else if($teacherdata=$teacherrow->fetch_assoc())
	{
		$_SESSION['tid']=$teacherdata['teacher_id'];
		$_SESSION['tname']=$teacherdata['teacher_name'];
		header("location:../Teacher/Homepage.php");
	}
	else
	{
		?>
		<script>
		//alert("invalid login");
		//window.location="Login.php";
		</script>
		<?php		
	}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="" method="post">
    <table align="center" border="1">
      <tr>
        <td>Email</td>
        <td><input type="email" name="txt_mail" required /></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="password" name="txt_password" required /></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="btn_login" value="Login" /></td>
      </tr>
    </table>
  </form>
</body>
</html>