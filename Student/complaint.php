<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST["btn_submit"]))

{
$Content=$_POST["txt_content"];
$date=$_POST["txt_date"];


$insQry="insert into tbl_complaint(complaint_content,complaint_date,student_id,complaint_status,complaint_reply)value('".$Content."',curdate(),'".$_SESSION['sid']."','".$status."','".$reply."')";
if($Con->query($insQry))
{
	?>
    <script>
	alert("insert Successfully");
		window.location="Complaint.php";
	</script>
    <?php
}
}
if(isset($_GET['cid']))
{
	echo $Delqry="delete from tbl_complaint where complaint_id='".$_GET['cid']."'";
	if($Con->query($Delqry))
{
	?>
    <script>
	alert("deleted Successfully");
		window.location="Complaint.php";
	</script>
    <?php
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
   
    <tr>
      <td>For date</td>
      <td><label for="txt_date"></label>
      <input type="date" name="txt_date" id="txt_date"required="required" /></td>
    </tr>
     
    </tr>
     <tr>
      <td>content</td>
      <td><label for="txt_content"></label>
       <textarea name="txt_content" id="txt_content" cols="45" rows="5"required="required"></textarea></td>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
  </form>
  <br />
  <table width="360" border="1">
  <tr><td width="49"><table width="360" border="1">
    <tr>
      <td >SlNo</td>
      <td >Contemt</td>
      <td >Date</td>
      <td >Reply</td>
      <td >Action</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_complaint where student_id='".$_SESSION['sid']."'";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row["complaint_content"];?></td>
      <td><?php echo $row["complaint_date"];?></td>
      <td><?php 
	  			if($row['complaint_status']==0)
	  			{
					echo "Not Replied Yet";
				}
				else
				{
					echo $row["complaint_reply"];
				}
				?>
                </td>
      <td><a href="Complaint.php?cid=<?php echo $row['complaint_id']?>">Delete</a></td>
    </tr>
    <?php
    }
	?>
  </table>
  </tr>
  </table>
</form>
</body>
</html>