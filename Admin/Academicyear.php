<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_submit"]))
{
	
	$academicyear=$_POST["txt_academicyear"];
	

	
		$insQry="insert into tbl_academicyear(academicyear_year)value('".$academicyear."')";
		if($Con->query($insQry))
		{
		?>
		<script>
		alert("insert Succesfully");
		</script>
		<?php	
		}
	

	
	
}
if(isset($_GET['did']))
	{
	$Delqry="delete from tbl_academicyear where academicyear_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete");
	window.location="Academicyear.php";
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
<body><form action="" method="post">
  <table width="200" border="1">
    <tr>
      <td><p>Academicyear</p></td>
      <td><label for="txt_academicyear"></label>
      
      <input type="text" name="txt_academicyear" id="txt_academicyear" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  <table width="200" border="1">
  <tr>
    <td>SlNo</td>
    <td>Academicyear</td>
    <td>Action</td>
  </tr>
   <?php
	$i=0;
	$selQry="select * from tbl_academicyear";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row["academicyear_year"];?></td>
    <td><a href="Academicyear.php?did=<?php echo $row["academicyear_id"]?>">
    delete</a>
   
              
  </tr>
    <?php
	}
	?>
</table>

</form>
</body>
</html>