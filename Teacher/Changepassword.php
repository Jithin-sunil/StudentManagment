<?php  
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_teacher where teacher_id='".$_SESSION['tid']."' ";
	$row=$Con->query($selQry);
	$row=$row->fetch_assoc();
	
		if(isset($_POST['btn_changepassword']))
	{
		$oldpassword=$_POST['pwd_oldpassword'];
		$newpasswoed=$_POST['pwd_newpassword'];
		$retypepassword=$_POST['pwd_retypepassword'];
		
		if($oldpassword == $row['teacher_password'])
		{
			
			if($newpasswoed == $retypepassword)
			{
			 	$upQry="update tbl_teacher set teacher_password='".$newpasswoed."'  where teacher_id='".$_SESSION['tid']."' ";
				if($Con->query($upQry))
		{
			
		?>
		<script>
		alert("UPDATA SUCCESFULLY");
		window.location="MYprofile.php";
		</script>
		<?php	
		}
			}
			else
			{
				?>
                <script>
				alert("Password Mismatch");
				</script>
                <?php
			}
			
		}
		else
			{
				?>
                <script>
				alert("Password Incorrect");
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
    <tr>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
      <td><p>Old password</p></td>
      <td><label for="pwd_password1"></label>
      <input type="text" name="pwd_oldpassword" id="pwd_oldpassword" /></td>
    </tr>
    <tr>
      <td>New password</td>
      <td><label for="pwd_password2"></label>
      <input type="text" name="pwd_newpassword" id="pwd_newpassword" /></td>
    </tr>
    <tr>
      <td>Re-Type password</td>
      <td><label for="pwd_password3"></label>
      <input type="text" name="pwd_retypepassword" id="pwd_retypepassword" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_changepassword" id="btn_changepassword" value="Change password" />
        <input type="reset" name="btn_cancel" id="btn_cancel" value="Cancel" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>