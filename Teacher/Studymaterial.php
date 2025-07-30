<?php
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit']))
{
    $teacherId = $_SESSION['tid'];
	$question= $_POST['txt_question'];
	$subject= $_POST['sel_subject'];
	if(isset( $_FILES["file_qn"]) )
	{
    $questionfile = $_FILES["file_qn"]["name"];
    $tmpName = $_FILES["file_qn"]["tmp_name"];
   
    move_uploaded_file($tmpName, '../Assets/Files/Studymaterial/' . $questionfile);
	}else
	{
		$questionfile = "";
	}
    
   

        $insQry = "INSERT INTO tbl_studymaterial (studymaterial_content,studymaterial_file, subject_id) 
                   VALUES ('$question','$questionfile', '$subject')";

        if($Con->query($insQry)) {
            echo "<script>alert('studymaterial added successfully'); window.location='studymaterial.php'; </script>";
        } else {
            echo "<script>alert('Insertion failed');</script>";
        }
    
}
	

if(isset($_GET['did'])) {
    $delqry = "DELETE FROM tbl_studymaterial WHERE studymaterial_id='".$_GET['did']."'";
    if($Con->query($delqry)) {
        echo "<script>alert('Deleted Successfully'); window.location='studymaterial.php';</script>";
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
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
  <table width="200" border="1">
  <tr>
    <td>Semester</td>
    <td><label for="sel_semester"></label>
      <select name="sel_semester" id="sel_semester" onchange="getSubject(this.value)">
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
    <td>Subject</td>
    <td><label for="sel_subject"></label>
      <select name="sel_subject" id="sel_subject">
      <option>--Select--</option>
      
      </select></td>
  </tr>
  <tr>
    <td>Notes </td>
    <td><textarea name="txt_question" id="txt_question" rows="5" cols="30"></textarea></td>
  </tr>
  <tr>
    <td>Notes File (optional)</td>
    <td><input type="file" name="file_qn" id="file_qn" /></td>
  </tr>
 
  <tr>
    <td colspan="2" align="center">
      <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
    </td>
  </tr>
</table>

  <table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>Notes </td>
       <td>Notes File</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_studymaterial ";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row["studymaterial_content"];?></td>
     <td><a href="../Assets/Files/Studymaterial/<?php echo $row["studymaterial_file"];?>" >View File</td>
   <td><a href="Studymaterial.php?did=<?php echo $row["studymaterial_id"]?>">
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
<script src="../Assets/JQ/jQuery.js"></script>
<script>
function getSubject(sid){
	$.ajax({
		url:"../Assets/AjaxPages/AjaxSubject.php?sid="+sid,
		success:function(result){
			$("#sel_subject").html(result);
		}
	});
}
</script>