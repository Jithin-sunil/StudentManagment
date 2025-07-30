<?php
include("../Assets/Connection/Connection.php");
$dis_name="";
if(isset($_POST["btn_Submit"]))
{
	$name=$_POST["txt_name"];
	$email=$_POST["txt_email"];
	$password=$_POST["txt_pwd"];
	$hid=$_POST['hidden'];
	if($hid=="")
	{
	
	$insQry="insert into tbl_admin(admin_name,admin_email,admin_password)value('".$name."','".$email."','".$password."')";
	if($Con->query($insQry))
	{
	?>
    <script>
	alert("insert Succesfully");
	</script>
    <?php	
	}
}
else
{
	$upQry="update tbl_admin set admin_name='".$name."' where admin_id='".$hid."'";
	if($Con->query($upQry))
	{
	?>
    <script>
	alert("updated Succesfully");
	</script>
    <?php	
	}
}
}
	if(isset($_GET['did']))
	{
	$Delqry="delete from tbl_admin where admin_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete");
	window.location="AdminRegistration.php";
	</script>
	<?php	
	}		
}
$ad_id="";
	$ad_name="";
	$ad_email="";
if(isset($_GET['eid']))
{
	$selQry="select * from tbl_admin where admin_id='".$_GET['eid']."'";
	$result=$Con->query($selQry);
	$row=$result->fetch_assoc();
	
	$ad_id=$row['admin_id'];
	$ad_name=$row['admin_name'];
	$ad_email=$row['admin_email'];
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
      <td>Name</td>
      <td><label for="txt_name"></label>
       <input type="hidden" name="hidden" value="<?php echo $ad_id?>" />
        <input type="text" name="txt_name" id="txt_name" value="<?php echo $ad_name ?>"  /></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><label for="txt_email"></label>
        <input type="text" name="txt_email" id="txt_email" value="<?php echo $ad_email ?>" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><label for="txt_pwd"></label>
        <input type="password" name="txt_pwd" id="txt_pwd" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_Submit" id="btn_Submit" value="Submit" />
      </div></td>
    </tr>
  </table>
  <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>Name</td>
      <td>Email</td>
      <td>Action</td>
    </tr>
      <?php
	$i=0;
	$selQry="select * from tbl_admin";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row["admin_name"];?></td>
      <td><?php echo $row["admin_email"];?></td>
      
      <td><p><a href="AdminRegistration.php?did=<?php echo $row["admin_id"]?>">
      delete</a>  
      <a href="AdminRegistration.php?eid=<?php echo $row['admin_id']?>">  edit</a></p>      </tr>
    <?php
	}
	?>
    
  </table>
</form>
</body>
</html>