<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_submit"]))
{
	
	$subject=$_POST["sel_subject"];
	$course=$_POST["sel_course"];
	$semester=$_POST["sel_semester"];
		$insQry="insert into tbl_assignsubject(semester_id,course_id,subject_id,teacher_id)value('".$semester."','".$course."','".$subject."','".$_GET['tid']."')";
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
	window.location="Assignsubject.php";
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
    <td><select name="sel_department" id="sel_department" onChange="getCourse(this.value)" >
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
        <select name="sel_course" id="sel_course" onchange="getSubject()">
          <option>--select--</option>
           
      </select></td>
    </tr>
    <td>Semester</td>
    <td><label for="sel_semester"></label>
      <select name="sel_semester" id="sel_semester" onchange="getSubject()">
      <option>--Select--</option>
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
      <td>Subject</td>
     <td><label for="sel_subject"></label>
        <select name="sel_subject" id="sel_subject">
 			<option>--select--</option>
          
      </select></td>
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
      <td>SEMESTER</td>
      <td>SUBJECT</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_assignsubject a
	 inner join tbl_course c on a.course_id=c.course_id 
	 inner join tbl_semester s on a.semester_id=s.semester_id inner join tbl_subject b on a.subject_id=b.subject_id";
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
    <td><a href="Assignsubject.php?did=<?php echo $row["assignsubject_id"]?>">
    delete</a>
   
              
  </tr>
    <?php
	}
	?>
  </table>
</form>
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
function getSubject(){
	cid = document.getElementById("sel_course").value
	sid = document.getElementById("sel_semester").value
	$.ajax({
		url:"../Assets/AjaxPages/AjaxAssignSubject.php?cid="+cid+"&sid="+sid,
		success:function(result){
			$("#sel_subject").html(result);
		}
	});
}
</script>