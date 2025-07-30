<?php
 include("../Assets/Connection/Connection.php");
 session_start();
 if(isset($_POST['btn_submit']))

 
 	{
		$fordate=$_POST["txt_fordate"];
		$Contect=$_POST["txt_content"];
	
		 $insQry="insert into tbl_leave(leave_content,leave_date,leave_fordate,teacher_id)value('".$Contect."',curdate(),'".$fordate."','".$_SESSION['tid']."')";

		if($Con->query($insQry))
	{
	?>
    <script>
	alert("insert Succesfully");
	 window.location="Leave.php";
	</script>
    
    <?php	
		
	}
}



	if(isset($_GET['did']))
	{
	$Delqry="delete from tbl_leave where leave_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete");
	window.location="Leave.php";
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
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td>For date</td>
      <td><label for="txt_fordate"></label>
      <input type="date" name="txt_fordate" id="txt_fordate"required="required" /></td>
    </tr>
    <tr>
      <td>Contect</td>
      <td><label for="txt_content"></label>
       <textarea  name="txt_content" id="txt_content"required="required" /></textarea></td>    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
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
	$selQry="select * from tbl_leave e inner join tbl_teacher t on e.teacher_id=t.teacher_id ";
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
   <td><a href="Leave.php.?did=<?php echo $row["leave_id"]?>">
    delete</a>
   </td>
              
  </tr>
    <?php
	}
	?>
  </table>
</form>
</body>
</html>