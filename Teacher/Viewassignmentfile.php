<?php  
include("../Assets/Connection/Connection.php");


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
       <td>student details</td>
        <td>submit date</td>
      <td>uploaded file</td>
     <td>mark</td>
      <td>Action</td>
     
    </tr>
    <?php
	$i=0;
	  $selQry = "select * from tbl_assignmentbody a inner join tbl_student s on s.student_id=a.student_id where a.assignment_id=".$_GET['aid'];

	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
     <td><?php echo $row["student_name"];?></td>
    
     <td><?php echo $row["assignmentbody_date"];?></td>
     
        <td><?php echo $row["assignmentbody_file"];?>
        <a href="../Assets/Files/Studymaterial/<?php echo $row['assignmentbody_file']?>">file	</a></td>
        <td><?php echo $row['assignmentbody_mark']?> </td>
        
       
   <td>
   <?php
	   if($row['assignmentbody_status']==0)
	   {
  				 ?> <a href="Mark.php?asid=<?php echo $row['assignmentbody_id']?>&aid=<?php echo $_GET['aid']?>">MARk</a>  
   <?php
	   }
	   else
	   {
		   echo "Mark Added.";
	   }
	   ?>
       </td>
       </tr>
       <?php
	}
	?>
	
  </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>