<option>--select--</option>
           <?php
		    include("../Connection/Connection.php");
		   $sel="select * from tbl_subject where course_id='".$_GET['cid']."' AND semester_id='".$_GET['sid']."'";
		   $result=$Con->query($sel);
		   while($row=$result->fetch_assoc())
		   {
				?>
                <option value="<?php echo $row["subject_id"]?>">
                <?php echo $row ["subject_name"]?> </option>
                <?php
			}
			?>