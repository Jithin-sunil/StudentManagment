<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_submit"]))
{
	
	$subjectname=$_POST["txt_subjectname"];
	$course=$_POST["sel_course"];
	$semester=$_POST["sel_semester"];
		  $insQry="insert into tbl_subject(semester_id,course_id,subject_name)value('".$semester."','".$course."','".$subjectname."')";
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
	$Delqry="delete from tbl_subject where subject_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete Succesfully");
	window.location="Subject.php";
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
      <td>Course</td>
      <td><label for="select"></label>
        <select name="sel_course" id="sel_course" >
          <option>--select--</option>
              <?php
		  $sel="Select * from tbl_course";
		  $result=$Con->query($sel);
		  while($row=$result->fetch_assoc())
		  {	
		  ?>
          <option value="<?php echo $row["course_id"]?>">
			<?php echo $row["course_name"]?></option>
			<?php
			}
			?>
      </select></td>
    </tr>
   <td>semester</td>
      <td><label for="sel_semester"></label>
        <select name="sel_semester" id="sel_semester">
 			<option>--select--</option>
           <?php
		   $sel="select * from tbl_semester";
		   $result=$Con->query($sel);
		   while($row=$result->fetch_assoc())
		   {
				?>
                <option value="<?php echo $row["semester_id"]?>">
                <?php echo $row ["semester_name"]?> </option>
                <?php
			}
			?>
      </select></td>
    </tr>
    <tr>
      <td>subject Name</td>
      <td><label for="txt_subjectname"></label>
      <input type="text" name="txt_subjectname" id="txt_subjectname" /></td>
    </tr>
   
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /> 
     </td>
    </tr>
  </table>
  <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>COURSE</td>
      <td>semester</td>
      <td>SUBJECT NAME</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_subject s inner join tbl_course c on c.course_id=s.course_id inner join tbl_semester se on s.semester_id=se.semester_id";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row["course_name"];?></td>
     <td><?php echo $row["semester_name"];?></td>
      <td><?php echo $row["subject_name"];?></td>
    <td><a href="Subject.php?did=<?php echo $row["subject_id"]?>">
    delete</a>
   
              
  </tr>
    <?php
	}
	?>
  </table>

</form>
</body>
</html>