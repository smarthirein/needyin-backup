<?php  $c11= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$JUser_Id;
$result11 = mysqli_query($con,$c11);
$row11 = mysqli_fetch_array($result11);


$jc11= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$JUser_Id;
$jresult11 = mysqli_query($con,$jc11);
$jrow11 = mysqli_fetch_array($jresult11);?>
<div class="display-features">
    
    <div class="display-details">
	
      
        <article class="sub-title">
            <h4 class="pull-left"><?php echo $row11['Company_Name'];?></h4> </article>
    
        <div>
          
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Designation</h4>
                        <p><?php echo $row11['Des']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Joining </h4>
                        <p>
							<?php $date1=date_create($row11['doJ']);
							echo date_format($date1,"M d,Y");?>
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
						<?php
						$c8="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row11['Loc_Id'];
						$result8 = mysqli_query($con,$c8);
						$row8= mysqli_fetch_array($result8)
						?>
						 
                        <p><?php echo $row8['Loc_Name']; ?></p>
                    </div>
                </div>
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Roles & Responsibilities</h4>
						<?php $user_query="select Func_Name from tbl_functionalarea where Func_Id='".$jrow['Func_Id']."'";
						 $rr= mysqli_query($con,$user_query);
						 $rrs=mysqli_fetch_array($rr);
						 ?>
                        <p><?php echo $rrs['Func_Name']; ?></p>
                    </div>
                </div>
               
            </div>
           
            <div class="row showdetails ">
                <div class="col-md-12 col-sm-12 ">
                    <div class="block-show ">
                        <h4>Job Description</h4>
                        <p class="text-justify "><?php echo $row11['JDesc']; ?></p>
                    </div>
                </div>
            </div>
            
        </div>
       
    </div>
   
    <div class="display-details">
      
		<?php $sql1 = "SELECT * FROM tbl_experience where JUser_Id='".$JUser_Id."'";
			$query1 = mysqli_query($con, $sql1);
			while($row1 = mysqli_fetch_array($query1)){
					$Exp_Id=$row1['Exp_Id'];
				?>	
        <article class="sub-title">
            <h4 class="pull-left"><?php echo $row1['Cmpy_Name'];?> <span class="fbold"></span></h4> </article>
       
        <div id="">
           
            <div class="row showdetails ">
                <div class="col-md-3  col-sm-6">
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
						
						<?php $date1=date_create($row1['doJ']);
							echo date_format($date1,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Relieved</h4>
                        <p>
						<!--<?php echo $row1['dor'];?> -->
						<?php $datelt=date_create($row1['dor']);
						echo date_format($datelt,"M d,Y");?>
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
                <div class="col-md-12 col-sm-12 ">
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