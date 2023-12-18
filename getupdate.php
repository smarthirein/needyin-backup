<?php  require_once 'class.user.php'; ?>
<?php 
if (rand(0,1))
{
$result_feed=mysqli_query($con,"SELECT description from tbl_notifications WHERE description != 'Skills Changed' ORDER BY RAND() ");
			
				$row_feed=mysqli_fetch_array($result_feed);
				{ ?>
				<p>
				<div class="talk-bubble tri-right round btm-left">
				<div class="talktext">
					 <?php echo $row_feed['description']; ?>
				</div>
				</div>
			 </p>

			 
<?php }
}

	else
	{
		$result_feed=mysqli_query($con,"SELECT * from tbl_visits ORDER BY RAND()");
		$row_feed=mysqli_fetch_array($result_feed);
		if($row_feed['city'])
		{ ?>
			<p>
			<div class="talk-bubble tri-right round btm-left">
				<div class="talktext">
					 <?php echo "A user from ".$row_feed['city']." visted."; ?>
				</div>
				</div>
			 </p>
		<?php
		}
		else
		{ ?>
			<p>
			<div class="talk-bubble tri-right round btm-left">
				<div class="talktext">
					 <?php echo "A user from ".$row_feed['country']." visted."; ?>
				</div>
				</div>
			 </p>
	<?php }
	}




?>	