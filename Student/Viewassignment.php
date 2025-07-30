<?php  
include("../Assets/Connection/Connection.php");
session_start();
 $SelQry = "SELECT * FROM tbl_student s INNER JOIN tbl_class c ON c.class_id = s.class_id INNER JOIN tbl_classsem cs ON c.class_id = cs.class_id 
WHERE s.student_id = '".$_SESSION['sid']."' 
  AND cs.classsem_id = (
      SELECT MAX(cs2.classsem_id) 
      FROM tbl_classsem cs2 
      WHERE cs2.class_id = c.class_id)";
	  
	$res=$Con->query($SelQry);
	$rows=$res->fetch_assoc();
	$semester = $rows['semester_id'];
	$course=$rows["course_id"];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
 <table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>subject</td>
        <td>submit date</td>
        <td>assignment topic</td>
      <td>FILE</td>
      <td>Action</td>
     
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_assignment a inner join tbl_subject s on a.subject_id=s.subject_id where s.course_id='".$course."' AND s.semester_id = '".$semester."'";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
			
	?>
  <tr>
    <td><?php echo $i ?></td>
       <td><?php echo $row["subject_name"];?></td>
     <td><?php echo $row["assignment_date"];?></td>
       <td><?php echo $row["assignment_question"];?></td>
   <td><a href="../Assets/Files/Studymaterial/<?php echo $row['assignment_questionfile']?>">Document</a> 
   <td>
   <?php
   		if($row['assignment_date'] > date('Y-m-d'))
		{
			?>
    <a href="Assignmentbody.php?aid=<?php echo $row['assignment_id']?>">upload file</a>
      
	 <?php
		}
		else
		{
			echo "Submission Ended.";
			
		}
		?>
   </td>
   
   <?php
	}
	?>
	
  </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>