<?php  
include("../Assets/Connection/Connection.php");

session_start();

if(isset($_GET['acc']))
{
	$upQry="update tbl_leave set leave_status='1' where leave_id='".$_GET['acc']."' ";
		if($Con->query($upQry))
		{
			
		?>
		<script>
		alert("Accepted");
		window.location="Viewleave.php";
		</script>
		<?php	
		}
}
	if(isset($_GET['rej']))
{
	$upQry="update tbl_leave set leave_status='2' where leave_id='".$_GET['rej']."' ";
		if($Con->query($upQry))
		{
			
		?>
		<script>
		alert("Rejected");
		window.location="Viewleave.php";
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

<body>
 <table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>NAME</td>
      <td>DATE</td>
      <td>FOR DATE</td>
      <td>CONTENT</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	   $selQry="select * from tbl_leave e inner join tbl_teacher t on e.teacher_id=t.teacher_id where e.teacher_id='".$_SESSION['tid']."' ";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
       <td><?php echo $row["teacher_name"];?></td>
    <td><?php echo $row["leave_date"];?></td>
     <td><?php echo $row["leave_fordate"];?></td>
      <td><?php echo $row["leave_content"];?></td>
      <?php
     if($row['leave_status'] == 0)
	 {
	 ?>
 <td><a href="Viewleave.php?acc=<?php echo $row["leave_id"]?>"?>
    Accept</a>
    <a href="Viewleave.php?rej=<?php echo $row["leave_id"]?>">
    Reject</a>
   </td>     
  </tr>
     <?php
	 }
	}
	?>
	
  </table>
</body>
</html>