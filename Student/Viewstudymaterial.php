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
       <td>SUBJECT</td>
      <td>CONTENT</td>
      <td>FILE</td>
     
    </tr>
    <?php
	$i=0;
	   $selQry="select * from tbl_studymaterial a inner join tbl_subject s on a.subject_id=s.subject_id where s.course_id='".$course."' AND s.semester_id = '".$semester."'";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
       <td><?php echo $row["subject_name"];?></td>
        <td><?php echo $row["studymaterial_content"];?></td>
   <td><a href="../Assets/Files/Studymaterial/<?php echo $row['studymaterial_file']?>">material</a> 
      
	 <?php
	}
	?>
	
  </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>