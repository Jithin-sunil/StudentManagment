 <option>--select--</option>
 <?php
 include("../Connection/Connection.php");
 session_start();
		   $sel="select * from tbl_assignsubject a INNER JOIN tbl_subject s on a.subject_id = s.subject_id where s.semester_id='".$_GET['sid']."' and a.teacher_id = '".$_SESSION['tid']."' ";
		   $result=$Con->query($sel);
		   while($row=$result->fetch_assoc())
		   {
				?>
                <option value="<?php echo $row["subject_id"]?>">
                <?php echo $row ["subject_name"]?> </option>
                <?php
			}
			?>