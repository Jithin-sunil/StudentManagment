<?php
 include("../Assets/Connection/Connection.php");
 session_start();
  

 
 
if(isset($_POST["btn_submit"]))
{
	 $SelQry = "SELECT * FROM tbl_class c 
           INNER JOIN tbl_academicyear a ON c.academicyear_id = a.academicyear_id 
           WHERE teacher_id = '".$_SESSION['tid']."' 
           AND a.academicyear_year = '".date('Y')."'";
$res= $Con->query($SelQry);
$data= $res->fetch_assoc();

	
 $name= $_POST["txt_name"];
 $email= $_POST["txt_email"];
 $Contact = $_POST["txt_contact"];
 $address = $_POST["txt_adrs"];
 $gender = $_POST["rd_gender"];
 $password = $_POST["pwd_password"];
 
 
 
 $photo = $_FILES["file_photo"]["name"];
 $path= $_FILES["file_photo"]["tmp_name"];
 move_uploaded_file($path,'../Assets/Files/student/'.$photo);
 
 $insQry="insert into tbl_student(student_name,student_email,student_contact,student_address,student_gender,student_password,student_photo,class_id)value('".$name."','".$email."','".$Contact."','".$address."','".$gender."','".$password."','".$photo."','".$data['class_id']."')";
	if($Con->query($insQry))
	{
		?>
        <script>
		alert("insert Seccesfully");
		window.location="StudentRegistration.php";
		</script>
        <?php
	}
}
if(isset($_GET['did']))
	{
	$Delqry="delete from tbl_student where student_id='".$_GET['did']."'";
	if($Con->query($Delqry))
	{
	?>
	<script>
	alert("delete Succesfully");
	window.location="StudentRegistration.php";
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
<form action="" method="post" enctype="multipart/form-data">
  <table width="200" border="1">
    <tr>
      <td>Name</td>
      <td><label for="txt_name"></label>
      <input type="text" name="txt_name" id="txt_name" required title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" pattern="^[A-Z]+[a-zA-Z ]*$"   /></td>
    </tr>
    
    <tr>
      <td>Email</td>
      <td><label for="txt_email"></label>
      <input type="mail" name="txt_email" id="txt_email"required="required"  /></td>
    </tr>
    <tr>
     <td>Contact</td>
      <td><label for="txt_contact"></label>
      <input type="text" name="txt_contact" id="txt_contact" required pattern="[6-9]{1}[0-9]{9}" 
                title="Phone number with 6-9 and remaing 9 digit with 0-9"  /></td>
    </tr>
      <td>Address</td>
      <td><label for="txt_adrs"></label>
      <input type="text" name="txt_adrs" id="txt_adrs" required /></td>
    </tr>
    
    <tr>
      <td>Gender</td>
      <td><input type="radio" name="rd_gender" id="rd_gender" value="Male"required="required"  />
        Male 
          <input type="radio" name="rd_gender" id="rd_gender2" value="Female" />
          Female</td>
    </tr>
   
  
    <tr>
      <td>Photo</td>
      <td><label for="file_photo"></label>
      <input type="file" name="file_photo" id="file_photo" required  accept="image/*"/></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><label for="pwd_password"></label>
      <input type="password" name="pwd_password" id="pwd_password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required /></td>
    </tr>
    
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" id="btn_submit" value="Submit" /> 
             <input type="reset" name="btn_reset" id="btn_reset" value="reset" /></td>
    </tr>
  </table>
  <table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
       <td>PHOTO</td>
      <td>NAME</td>
      <td>EMAIL</td>
      <td>CONTENT</td>
        <td>ADDRESS;</td>
          <td>GENDER;</td>
      <td>ACTION</td>
    </tr>
    <?php
	$i=0;
	$selQry="select * from tbl_student s inner join tbl_class c on s.class_id = c.class_id where c.teacher_id=".$_SESSION['tid'];
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
    <td> <img src="../Assets/Files/Student/<?php echo $row['student_photo']?>" width="150" height="150" /></td>
       <td><?php echo $row["student_name"];?></td>
    <td><?php echo $row["student_email"];?></td>
     <td><?php echo $row["student_contact"];?></td>
      <td><?php echo $row["student_address"];?></td>
      <td><?php echo $row["student_gender"];?></td>
    <td><a href="StudentRegistration.php?did=<?php echo $row["student_id"]?>?>">
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
 