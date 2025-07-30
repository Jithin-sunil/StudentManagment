<?php  
include("../Assets/Connection/Connection.php");
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<table width="200" border="1">
    <table width="399" height="102" border="1">
    <tr>
      <td >SINO</td>
      <td >date</td>
       <td >Student details</td>
      <td >Event details</td>
        <td >FOE DATE</td>
      	
    </tr>
   <?php
	$i=0;
	   $selQry="select * from tbl_eventregistration e inner join tbl_event ev on e.event_id = ev.event_id inner join tbl_student s on e.student_id = s.student_id";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
     <td><?php echo $row["event_date"];?></td>
      <td><?php echo $row["student_name"];?></td>
       <td><?php echo $row["event_content"];?>
       <a href="../Assets/Files/Event/<?php echo $row['event_file']?>">Document</a></td>
     <td><?php echo $row["event_fordate"];?></td>
     
      
	 <?php
	}
	?>
  </table>
</body>
</html>
