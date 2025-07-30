<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_submit"]))
{
	
	$course=$_POST["txt_course"];
	$department_id=$_POST["sel_department"];
	
		$insQry="insert into tbl_course(course_name,department_id)value('".$course."','".$department_id."')";
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
	$Delqry="delete from tbl_course where course_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete");
	window.location="course.php";
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
      <td><p>Department</p></td>
      <td><label for="sel_department"></label>
        <select name="sel_department" id="sel_department">
        <option>---select---</option>
        <?php
		  $sel="Select * from tbl_department";
		  $result=$Con->query($sel);
		  while($row=$result->fetch_assoc())
		  {	
		  ?>
          <option value="<?php echo $row["department_id"]?>">
			<?php echo $row["department_name"]?></option>
			<?php
			}
			?>
      </select></td>
    </tr>
    <tr>
    <tr>
      <td><p>course</p></td>
      <td><label for="txt_course"></label>
      
      <input type="text" name="txt_course" id="txt_course" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  <table width="200" border="1">
  <tr>
    <td>SlNo</td>
    <td>course</td>
    <td>department</td>
    <td>Action</td>
  </tr>
   <?php
	$i=0;
	$selQry="select * from tbl_course c  inner join tbl_department d on c.department_id = d.department_id ";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
     <td><?php echo $row["department_name"];?></td>
    <td><?php echo $row["course_name"];?></td>
    <td><a href="course.php?did=<?php echo $row["course_id"]?>">
    delete</a>
   
              
  </tr>
    <?php
	}
	?>
</table>

</form>
</body>
</html>

