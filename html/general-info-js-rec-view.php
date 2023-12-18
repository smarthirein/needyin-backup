
<?php

$c5="select Indus_Id,Indus_Name from tbl_industry where Indus_Id=".$row2['Indus_Id'];
$result5 = mysqli_query($con,$c5);
$row5= mysqli_fetch_array($result5);

 $c6="select Func_Id,Func_Name from tbl_functionalarea where Func_Id=".$row2['Func_Id'];
$result6 = mysqli_query($con,$c6);
$row6= mysqli_fetch_array($result6); 
?>
<div class="display-features">
   
    <div class="display-details">
 
        <article class="sub-title">
            <h4 class="pull-left">PROFILE <span class="fbold">OVERVIEW</span></h4> </article>
        
        <div id="show-profile-overview">
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Full Name</h4>
                        <p><?php echo $row['JFullName']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Birth</h4>
                        <p>
						<!--<?php echo $row['DoB']; ?> -->
						<?php $date=date_create($row['DoB']);
						echo date_format($date,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Gender</h4>
                        <p><?php echo $row['Gender']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Contact Number </h4>
                        <p>+91 <?php echo $row['JPhone']; ?></p>
                    </div>
                </div>
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Personal Email ID</h4>
                        <p><?php echo $row['JEmail']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Experience</h4>
                        <p><?php echo $row['JTotalEy']; ?> Years <?php echo $row['JTotalEm']; ?> months</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Industry Information</h4>
                        <p><?php echo $row5['Indus_Name']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Function Area</h4>
                        <p><?php echo $row6['Func_Name'];?></p>
                    </div>
                </div>
            </div>
           
            <div class="row showdetails ">
                <div class="col-md-12 ">
                    <div class="block-show ">
                        <h4>Profile Summary</h4>
                        <p class="text-justify "> <?php echo $row['profile_summary'];?> </p>
                    </div>
                </div>
            </div>
            
        </div>
   
    </div>
   
    <div class="display-details">
        
        <article class="sub-title">
            <h4 class="pull-left">LANGUAGES <span class="fbold">KNOWN</span></h4> </article>
      
        <div id="show-languages-known">
            <div class="row showdetails">
			<?php 
                        
                     $user_queryl="select * from lang_known where JUser_Id='".$row['JUser_Id']."' ";
                         $rrlk= mysqli_query($con,$user_queryl); 
                         $rr_cnt=mysqli_num_rows($rrlk);
                            while($rlk=mysqli_fetch_array($rrlk)){  
                                $user_query1="select lan_id,lang_type from tbl_language where lan_id='".$rlk['lang_id']."'";
                                $rrl= mysqli_query($con,$user_query1); 
                                $rrl1=mysqli_fetch_array($rrl);?>
                        <div class="col-md-3 col-sm-6">
                            <div class="block-show">
                                <h4>
                                <?php 
                                echo $rrl1['lang_type'];
                           ?>
                                </h4>
                                <p class="lang-all">
                               <?php if(trim($rlk['lang_speak'])=='on'){?> <span> <?php echo "Speak";?></span><?php } ?>
                            <?php if(trim($rlk['lang_write'])=='on'){?> <span><?php  echo "Write"; ?></span><?php }?>
                             <?php if(trim($rlk['lang_read'])=='on'){?> <span><?php  echo "Read"; ?></span><?php }?>
                                </p>
                    </div>
                </div>
                
						 <?php } ?>
            </div>
          
        </div>
      
    </div>
   
    <div class="display-details">
     
        <article class="sub-title">
            <h4 class="pull-left">PASSPORT <span class="fbold">DETAILS</span></h4> </article>
       
		<?php 
				$c7="select * from tbl_passport where JUser_Id=".$row['JUser_Id'];
				$result7 = mysqli_query($con,$c7);
				$row7= mysqli_fetch_array($result7); 
				$p_cnt=mysqli_num_rows($result7);
				$c8="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row7['Loc_Id'];
				$result8 = mysqli_query($con,$c8);
				$row8= mysqli_fetch_array($result8);
				$c9="select * from tbl_jobseeker where JUser_Id=".$JUser_Id;
				$result9 = mysqli_query($con,$c9);
				$row9= mysqli_fetch_array($result9); 
				$c10="select Cntry_Id,Cntry_Name from tbl_country where Cntry_Id=".$row9['Jcitizen'];
				$result10 = mysqli_query($con,$c10);
				$row10= mysqli_fetch_array($result10);
		?>
        <div id="showpp">
         <?php if($p_cnt!='0'){ ?>
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show txttraup ">
                        <h4>Passport Number</h4>
                        <p><?php echo $row7['Number']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Issue</h4>
                        <p>
						<!--<?php echo $row7['DoI']; ?>-->
							<?php if($row7['DoI']!=""){ $date1=date_create($row7['DoI']);
							echo date_format($date1,"M d,Y"); } ?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Expiry</h4>
                        <p>
						<!--<?php echo $row7['DoED']; ?>-->
							<?php if($row7['DoED']!=""){ $date2=date_create($row7['DoED']);
							echo date_format($date2,"M d,Y"); } ?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Place Of Issue</h4>
                        <p><?php echo $row8['Loc_Name']; ?></p>
                    </div>
                </div>
		        <div class="col-md-3 col-sm-6">
							  <div class="block-show ">
								<h4>Resident Of Country</h4>                                  
								<?php $acountry="Select Cntry_Name from tbl_country where Cntry_Id='".$row['Jcitizen']."'";
								 $ac1= mysqli_query($con,$acountry); $acc1=mysqli_fetch_array($ac1); ?>									
								 <p><?php echo $acc1['Cntry_Name']; ?></p>
							  </div>
				</div>
					<div class="col-md-6 col-sm-6">
						<div class="block-show auth_count">
                        <h4>Authorized to Work</h4>                       
							<?php 
							   $sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$_SESSION['userSession']."'";
							   $result = mysqli_query($con,$sql);
							   $row1 = mysqli_fetch_array($result);
							   $acountry=$row1['JCauthorised'];
							   $acountryid=explode(",",$acountry );
                             
                               $count=count(array_filter($acountryid));						
							if($count!=0)
                             {
                                $q=1;
                               foreach($acountryid as $acountryids)  { ?>         
						<?php 
                                $ms_sql1="select Cntry_Id,Cntry_Name from tbl_country where Cntry_Id=".$acountryids;
                                $ms_result1 = mysqli_query($con,$ms_sql1);
                                $ms_data1 = mysqli_fetch_array($ms_result1);								
                        ?> 
						<span><?php echo $ms_data1['Cntry_Name']; if($count==$q){ break;} ?>,</span>
                           <?php $q++;  }  
                           }
                           else { ?>                          
                               <p>None</p>                               
                           <?php  }
                            ?>  
						</div>
					</div>
            </div>
            
             <?php } else {?>
                         No Details
                   <?php } ?>
        </div>
       
    </div>
   
</div>