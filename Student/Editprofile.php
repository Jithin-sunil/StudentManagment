<?php  
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_student where student_id='".$_SESSION['sid']."' ";
	$row=$Con->query($selQry);
	$row=$row->fetch_assoc();
	
	if(isset($_POST['Update']))
	{
		$name=$_POST['txt_name'];
		$email=$_POST['txt_mail'];
		$Contact=$_POST['txt_contact'];
		$address=$_POST['txt_address'];
		
		$upQry="update tbl_student set student_name='".$name."',student_email='".$email."',student_contact='".$Contact."',student_address='".$address."' where student_id='".$_SESSION['sid']."' ";
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td><p>Name</p></td>
      <td><label for="txt_name"></label>
      <input type="text" name="txt_name" id="txt_name" value="  <?php echo $row['student_name'];  ?>"/></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><label for="txt_mail"></label>
      <input type="text" name="txt_mail" id="txt_mail" value="<?php echo $row['student_email']; ?>" /></td>
    </tr>
    <tr>
      <td>Contact</td>
      <td><label for="txt_contact"></label>
      <input type="text" name="txt_contact" id="txt_contact" value="<?php echo $row['student_contact']; ?>" /></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><label for="txt_address"></label>
      <textarea name="txt_address" id="txt_address" ><?php echo $row['student_address']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="Update" id="Update" value="Update" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>