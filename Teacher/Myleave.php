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

<body>
 <table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      
      <td>DATE</td>
      <td>FOR DATE</td>
      <td>CONTENT</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	
	   $selQry="select * from tbl_leave   where teacher_id='".$_SESSION['tid']."' ";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
      
    <td><?php echo $row["leave_date"];?></td>
     <td><?php echo $row["leave_fordate"];?></td>
      <td><?php echo $row["leave_content"];?></td>
    <td>
    <?php
    if($row['leave_status'] == 0)
	{
		echo "Pending..";
	}
	else if ($row['leave_status']==1)
	{
		echo "Accepted";	
	}
	
	else if ($row['leave_status']==2)
	{
		echo "Rejected";	
	}
	?>
   </td>
              
  </tr>
    <?php
	}
	?>
  </table>
</body>
</html>