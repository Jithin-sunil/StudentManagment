<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST['btn_submit']))
{
	$InsQry="insert into tbl_classsem(semester_id,class_id)values('".$_POST['sel_semester']."','".$_GET['cid']."') ";
	if($Con->query($InsQry))
	
	{
		?>
        <script>
		alert("Data Inserted");
		window.location="ClassSem.php?cid=<?php echo $_GET['cid']?>";
		</script>
        <?php
	}
}

if(isset($_GET['did']))
	{
	$Delqry="delete from tbl_classsem where classsem_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete");
	window.location="ClassSem.php?cid=<?php echo $_GET['cid']?>";
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
      <td>Semester</td>
      <td><label for="sel_semester"></label>
        <select name="sel_semester" id="sel_semester">
          <option>--Select--</option>
           <?php
		   $sel="select * from tbl_semester";
		   $result=$Con->query($sel);
		   while($row=$result->fetch_assoc())
		   {
				?>
                <option value="<?php echo $row["semester_id"]?>">
                <?php echo $row ["semester_name"]?> </option>
                <?php
			}
			?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="200" border="1">
    <tr>
      <td>SlNo</td>
      <td>Semester</td>
      <td>Action</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_classsem c inner join tbl_semester s on c.semester_id = s.semester_id where class_id=".$_GET['cid'];
	
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row["semester_name"];?></td>
      <td><a href="ClassSem.php?did=<?php echo $row["classsem_id"]?>&cid=<?php echo $row['class_id'] ?>"> delete</a></td>
    </tr>
    <?php
	}
	?>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>