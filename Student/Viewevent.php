<?php  
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_GET['eid']))
{
	$upQry="insert into  tbl_eventregistration(student_id,event_id,eventregistration_date) values('".$_SESSION['sid']."','".$_GET['eid']."',curdate()) ";
		if($Con->query($upQry))
		{
			
		?>
		<script>
		alert("registered");
		window.location="Viewevent.php";
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
<table width="200" border="1">
    <table width="200" border="1">
    <tr>
      <td>SINO</td>
      <td>date</td>
      <td>Event details</td>
        <td>FOE DATE</td>
        <td>CONTENT</td>
      <td>REGISTER HERE</td>
     
    </tr>
    <?php
	$i=0;
	   $selQry="select * from tbl_event";
	$result=$Con->query($selQry);
	while($row=$result->fetch_assoc())
	{
	$i++;
	?>
  <tr>
    <td><?php echo $i ?></td>
      <td><?php echo $row["event_date"];?></td>
       <td><?php echo $row["event_content"];?></td>
     <td><?php echo $row["event_fordate"];?></td>
       <td><?php echo $row["event_file"];?>
       
   
                <?php
				 if ($row['event_file'] == "") {
                
           		 }
				 else
				 {
					 ?>
                      <a href="../Assets/Files/Event/<?php echo $row['event_file']?>">Document</a>
                     <?php
				 }
				
				?>
                    
       
      
      <td>
      <?php
	  if($row['event_fordate'] > date('Y-m-d'))
	  {
		  ?>
           <a href="Viewevent.php?eid=<?php echo $row['event_id']?>">registration</a> 
          <?php
	  }
	  else
	  {
		  echo "Registration Ended.";
	  }
	  ?>
      
     
       </td>
      
  </tr>
      
	 <?php
	}
	?>
	
  </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>
