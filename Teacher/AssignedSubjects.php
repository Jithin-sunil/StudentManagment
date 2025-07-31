<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
include("../Assets/Connection/Connection.php");
session_start();
?>
<body>
<div id="tab" align="center">
<h1 align="center">Assigned Subjects</h1>
<form id="form1" name="form1" method="post" action="">
<?php

$selqry="select * from tbl_assignsubject a inner join tbl_semester s on s.semester_id=a.semester_id inner join tbl_subject su on su.subject_id=a.subject_id where a.teacher_id='".$_SESSION['tid']."'";
$res=$Con->query($selqry);
  if($res->num_rows>0)
  {
  ?>
  <table border="1">
    <tr>
      <td>Sl.No</td>
      <td>Semester</td>
      <td>Subject</td>
      <td>Action</td>
    </tr>
    <?php
	while($data=$res->fetch_assoc())
	{
		$i=0;
		$i++;
	?>
    <tr>
      <td><?php echo $i ; ?></td>
      <td><?php echo $data['semester_name']; ?></td>
      <td><?php echo $data['subject_name']; ?></td>
       <td><a href="InternalMark.php?sid=<?php echo $data['subject_id']; ?>">InternalMark</a></td>
    </tr>
    <?php
	}
	?>
  </table>
  <?php
  }
  ?>
</form>
</div>
</body>
</html>
