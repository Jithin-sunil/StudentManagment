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
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td>SlNo</td>
      <td>student Detail</td>
      <td>Detail</td>
      <td>Date</td>
       <td>replay</td>
      
      <td>Action</td>
    </tr>
      <?php
    $i=0;
	$selQry = "Select * From tbl_complaint a inner join tbl_student s on a.student_id=s.student_id";
	$result = $Con->query($selQry);
	while ($row = $result->fetch_assoc())
	{
		$i++;
	?>
    <tr>
      <td><?php echo $i ?></td>
       <td> <?php echo $row["student_name"];?> 
	   <?php echo $row["student_contact"];?>
        <?php echo $row["student_email"];?></td>
      <td><?php echo $row["complaint_content"];?></td>
      <td><?php echo $row["complaint_date"];?></td>
       <td><?php echo $row["complaint_reply"];?></td>
       
      
      <td>
                    <a href="Reply.php?cid=<?php echo $row['complaint_id'] ?>">REPLY</td>
                  </td>
    </tr>
    <?php
	}
	?> 
  </table>
</form>
</body>
</html>