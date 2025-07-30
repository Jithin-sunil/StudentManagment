<?php
 include("../Assets/Connection/Connection.php");
 if(isset($_POST['btn_submit']))
 {
	$mark = $_POST['txt_mark']; 
	$insQry="update tbl_assignmentbody set assignmentbody_mark='".$mark."',assignmentbody_status=1 where assignmentbody_id='".$_GET['asid']."'";
	if($Con->query($insQry))
	{
		
			?>
    <script>
	alert("Mark Added Succesfully");
	 window.location="Viewassignmentfile.php?aid=<?php echo $_GET['aid']?>";
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
      <td>Enter assignment mark </td>
      <td><label for="txt_mark"></label>
      <input type="text" name="txt_mark" id="txt_mark" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>