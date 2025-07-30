<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST["btn_login"]))
{
	
	$email=$_POST["txt_mail"];
	$password=$_POST["txt_password"];
	
	$selstudent="select * from tbl_student where student_email='".$email."' and student_password = '".$password."'";
	$studentrow=$Con->query($selstudent);
	
	echo $selteacher="select * from tbl_teacher where teacher_email='".$email."' and teacher_password = '".$password."'";
	$teacherrow=$Con->query($selteacher);
	
	
	if($studentdata=$studentrow->fetch_assoc())
	{
		$_SESSION['sid']=$studentdata['student_id'];
		$_SESSION['sname']=$studentdata['student_name'];
		header("location:../Student/Homepage.php");
	}
	else if($teacherdata=$teacherrow->fetch_assoc())
	{
		$_SESSION['tid']=$teacherdata['teacher_id'];
		$_SESSION['tname']=$teacherdata['teacher_name'];
		header("location:../Teacher/Homepage.php");
	}
	else
	{
		?>
		<script>
		//alert("invalid login");
		//window.location="Login.php";
		</script>
		<?php		
	}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Portal - Login</title>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #e7f3f8;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      display: flex;
      width: 100%;
      max-width: 1100px;
      height: auto;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
      background: #ffffff;
    }

    .left-box {
      width: 50%;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background-color: #fff;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      color: #222;
    }

    .login-form label {
      font-size: 14px;
      margin: 12px 0 6px;
      font-weight: 600;
    }

    .login-form input[type="text"],
    .login-form input[type="email"],
    .login-form input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 15px;
      border: 1.5px solid #c4e3f2;
      border-radius: 8px;
      font-size: 15px;
      outline: none;
      transition: border-color 0.3s;
    }

    .login-form input:focus {
      border-color: #4cb8dc;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper span {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #777;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      margin-bottom: 20px;
    }

    .options label {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .options a {
      color: #007bff;
      text-decoration: none;
    }

    .options a:hover {
      text-decoration: underline;
    }

    .login-form button {
      background: #4cb8dc;
      color: #fff;
      border: none;
      padding: 14px;
      width: 100%;
      border-radius: 8px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-form button:hover {
      background: #3ca3c7;
    } 

    .right-box {
      width: 50%;
      background: #d2f0fa;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    } 

    lottie-player {
      width: 100%;
      max-width: 500px;
    } 
     @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left-box, .right-box {
        width: 100%;
        padding: 30px;
      }

      .right-box {
      } 
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Section: Login Form -->
    <div class="left-box">
      <h2>Welcome </h2>
      <form class="login-form"  method="post">
        <label for="email">Email ID</label>
        <input type="email" id="email" name="txt_mail" placeholder="Enter your email" required />

        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="txt_password" placeholder="Enter your password" required />
          <span onclick="togglePassword()">👁️</span>
        </div>

        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>

        <button type="submit" name="btn_login"> Login</button>
      </form>
    </div>

    <!-- Right Section: Lottie Animation -->
    <div class="right-box">
      <lottie-player
        src="https://lottie.host/339813ce-1108-4e08-bcb4-6748121807f6/c1QNt0VLgZ.json"
        background="transparent"
        speed="1"
        loop
        autoplay>
      </lottie-player>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      passwordField.type = passwordField.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
