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
      <td>SINO</td>
      <td>NAME</td>
      <td>EMAIL</td>
      <td>CONTACT</td>
      <td>ADDRESS</td>
      <td>GENDER</td>
      <td>Department</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
   	$selQry="select * from tbl_teacher t inner join tbl_department d on t.department_id = d.department_id";

	$res=$Con->query($selQry);
	while($row=$res->fetch_assoc())
	{
	$i++;
	?>
    <tr>
     <td><?php echo $i;  ?></td>
      <td><?php echo $row['teacher_name'];?></td>
      <td><?php echo $row['teacher_email'];  ?></td>
      <td><?php echo $row['teacher_contact'];  ?></td>
      <td><?php echo $row['teacher_address'];  ?></td>
      <td><?php echo $row['teacher_gender'];  ?></td>
      <td><?php echo $row["department_name"];?></td>
      <td><a href="Assignclass.php?tid=<?php echo $row['teacher_id']?>">Class</a>  
<a href="assignsubject.php?tid=<?php echo $row['teacher_id']?>">Subject</a></td>
<?php
	}
	?>
  </table>
</form>
</body>
</html>