<?php
$Server="localhost";
$User="root";
$Password="";
$DB="db_studentmanagment";
$Con=mysqli_connect($Server,$User,$Password,$DB);
if(!$Con)
{
	echo "failed";
}
?>