<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_submit"]))
{
	
	$classname=$_POST["txt_classname"];
	$course=$_POST["sel_course"];
	$academicyear=$_POST["sel_academicyear"];
		$insQry="insert into tbl_class(academicyear_id,course_id,class_name,teacher_id)value('".$academicyear."','".$course."','".$classname."','".$_GET['tid']."')";
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
	$Delqry="delete from tbl_class where class_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete Succesfully");
	window.location="Assignclass.php?tid=<?php echo $_GET['tid']?>";
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
    <td>Department</td>
    <td><select name="sel_department" id="sel_department" onchange="getCourse(this.value)" >
      <option>--select--</option>
      <?php
		  $sel="Select * from tbl_department";
		  $result=$Con->query($sel);
		  while($row=$result->fetch_assoc())
		  {	
		  ?>
      <option value="<?php echo $row["department_id"]?>"> <?php echo $row["department_name"]?></option>
      <?php
			}
			?>
    </select></td>
  </tr>
  <tr>
      <td>Course</td>
      <td><label for="select"></label>
        <select name="sel_course" id="sel_course" >
          <option>--select--</option>
           
      </select></td>
    </tr>
   <td>Academicyear</td>
      <td><label for="sel_academicyear"></label>
        <select name="sel_academicyear" id="sel_academicyear">
 			<option>--select--</option>
           <?php
		   $sel="select * from tbl_academicyear";
		   $result=$Con->query($sel);
		   while($row=$result->fetch_assoc())
		   {
				?>
                <option value="<?php echo $row["academicyear_id"]?>">
                <?php echo $row ["academicyear_year"]?> </option>
                <?php
			}
			?>
      </select></td>
    </tr>
    <tr>
      <td>Class Name</td>
      <td><label for="txt_classname"></label>
      <input type="text" name="txt_classname" id="txt_classname" /></td>
    </tr>
   
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /> 
     </td>
    </tr>
  </table>
    </table>
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>COURSE</td>
      <td>academicyear</td>
      <td>CLASS NAME</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_class a
	 inner join tbl_course c on a.course_id=c.course_id 
	 inner join tbl_academicyear s on a.academicyear_id=s.academicyear_id ";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row["course_name"];?></td>
     <td><?php echo $row["academicyear_year"];?></td>
      <td><?php echo $row["class_name"];?></td>
    <td><a href="Assignclass.php?did=<?php echo $row["class_id"]?>&tid=<?php echo $_GET['tid']?>">
    delete</a> | 
    <a href="ClassSem.php?cid=<?php echo $row['class_id']?>">Add Semester</a>
   </td>
   
              
  </tr>
    <?php
	}
	?>
  </table
></form>
</body>
</html>

<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getCourse(did){
	$.ajax({
		url:"../Assets/AjaxPages/AjaxCourse.php?did="+did,
		success:function(result){
			$("#sel_course").html(result);
		}
	});
}
</script>