<?php 
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u Join tbl_currentexperience exp on u.JUser_Id=exp.JUser_Id
							  JOIN  tbl_location loc on exp.Loc_Id=loc.Loc_Id
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="display-features">
   
    <div class="display-details">
	
        <article class="sub-title">
            <h4 class="pull-left"><?php echo $row['Company_Name'];?>  -<span>Current Organization</span></h4> </article>
       
        <div>
            
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Designation</h4>
                        <p><?php echo $row['Des']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Joining </h4>
                        <p>
						
							<?php $date=date_create($row['doJ']);
							echo date_format($date,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Relieved</h4>
                        <p class="txt-blue">Currently working</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Location </h4>
						 
                        <p><?php echo $row['Loc_Name']; ?></p>
                    </div>
                </div>
            </div>
           
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Roles & Responsibilities</h4>
						<?php $user_query="select Func_Name from tbl_functionalarea where Func_Id='".$row['Func_Id']."'";
						 $rr= mysqli_query($con,$user_query); $rrs=mysqli_fetch_array($rr); ?>
                        <p><?php echo $rrs['Func_Name']; ?></p>
                    </div>
                </div>
               
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-12 col-sm-12">
                    <div class="block-show ">
                        <h4>Job Description</h4>
                        <p class="text-justify "><?php echo $row['JDesc']; ?></p>
                    </div>
                </div>
            </div>
           
        </div>
       
    </div>
   
   <div class="display-details">
        
		<?php $sql1 = "SELECT * FROM tbl_experience where JUser_Id='".$row['JUser_Id']."'";
			$query1 = mysqli_query($con, $sql1);
			while($row1 = mysqli_fetch_array($query1)){
					$Exp_Id=$row1['Exp_Id'];
				?>	
        <article class="sub-title">
            <h4 class="pull-left"><?php echo $row1['Cmpy_Name'];?> <span class="fbold"></span></h4> </article>
       
        <div id="">
           
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Designation</h4>
                        <p> <?php $user_queryD="select Desig_Name from tbl_desigination  where Desig_Id='".$row1['Desig_Id']."'";
						$rrD= mysqli_query($con,$user_queryD); $rrsD=mysqli_fetch_array($rrD); ?>						
                        <p><?php echo $rrsD['Desig_Name'];?></p></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Joining </h4>
                        <p>
					
							<?php $date=date_create($row1['doJ']);
							echo date_format($date,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Relieved</h4>
                        <p>
						<!--<?php echo $row1['dor'];?> -->
						<?php $date=date_create($row1['dor']);
						echo date_format($date,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Location </h4>
                       <?php $user_queryL="select Loc_Name from tbl_location  where Loc_Id='".$row1['Loc_Id']."'";
						 $rrL= mysqli_query($con,$user_queryL); $rrsL=mysqli_fetch_array($rrL); ?>
                        <p><?php echo $rrsL['Loc_Name'];?></p>
                    </div>
                </div>
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Roles & Responsibilities</h4>
                       <?php $user_queryR="select Func_Name from tbl_functionalarea  where Func_Id='".$row1['Roles_Resp']."'";
						 $rrR= mysqli_query($con,$user_queryR); $rrsR=mysqli_fetch_array($rrR); ?>						
                        <p><?php echo $rrsR['Func_Name'];?></p>
                    </div>
                </div>
               
            </div>
            
            <div class="row showdetails ">
                <div class="col-md-12 col-sm-12">
                    <div class="block-show ">
                        <h4>Job Description</h4>
                        <p class="text-justify "><?php echo $row1['JDescri'];?></p>
                    </div>
                </div>
            </div>
          
        </div>
		<?php  }?>
        
    </div>
   
</div>