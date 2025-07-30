<?php
session_start();
include("../Assets/Connection/Connection.php");

if(isset($_POST["btn_submit"]))
{
$reply=$_POST['txt_reply'];
	$upQry="update tbl_complaint set complaint_reply='".$reply."',complaint_status=1 where complaint_id='".$_GET['cid']."'";
	if($Con->query($upQry))
	{
		?>
        <script>
		alert("Updated");
		window.location="ViewComplaint.php";
		</script>
        <?php
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPLY</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<h2 align="center">REPLY</h2>
  <table align="center" width="200" border="1">
    <tr>
      <td>REPLY</td>
      <td><label for="txt_reply"></label>
      <input type="text" name="txt_reply" id="txt_reply" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>