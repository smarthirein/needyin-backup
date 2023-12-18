<?php
//require_once("queries.php");
$c5="select Indus_Id,Indus_Name from tbl_industry where Indus_Id=".$jrow['Indus_Id'];
$result5 = mysqli_query($con,$c5);
$row5= mysqli_fetch_array($result5);
 $c6="select Func_Id,Func_Name from tbl_functionalarea where Func_Id=".$jrow['Func_Id'];
$result6 = mysqli_query($con,$c6);
$row6= mysqli_fetch_array($result6); 
?>
<div class="display-features">
    <!-- profile over view -->
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">PROFILE <span class="fbold">OVERVIEW</span></h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
        <div id="show-profile-overview">
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Full Name</h4>
                        <p><?php echo $jrow['JFullName']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Birth</h4>
                        <p><?php $date=date_create($jrow['DoB']);
							echo date_format($date,"M d,Y");?>
						</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Gender</h4>
                        <p><?php echo $jrow['Gender']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Contact Number </h4>
                        <p>+91 <?php echo $jrow['JPhone']; ?></p>
                    </div>
                </div>
            </div>
            <!--/row-->
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Personal Email ID</h4>
                        <p><?php echo $jrow['JEmail']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Experience</h4>
                        <p><?php echo $jrow['JTotalEy']; ?> Years - <?php echo $jrow['JTotalEm']; ?> Months</p>
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
                        <h4>Functional Area</h4>
                        <p><?php echo $row6['Func_Name'];?></p>
                    </div>
                </div>
            </div>
            <!--/row-->
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-12 ">
                    <div class="block-show ">
                        <h4>Profile Summary</h4>
                        <p class="text-justify "> <?php echo $jrow['profile_summary'];?> </p>
                    </div>
                </div>
            </div>
            <!--/row-->
        </div>
        <!-- show details -->
        <!--/ display details show-->
    </div>
    <!--/ profile over view -->
    <!-- languages known -->
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">LANGUAGES <span class="fbold">KNOWN</span></h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
        <div id="show-languages-known">
            <div class="row showdetails">
			<?php $user_query1="select lan_id,lang_type from tbl_language";
						 $rrl= mysqli_query($con,$user_query1); 
						 $count=mysqli_num_rows($rrl);
		 
						 while($rrl1=mysqli_fetch_array($rrl)){ 
						// echo "select * from lang_known where JUser_Id='".$jrow['JUser_Id']."' AND lang_id='".$rrl1['lang_type']."'";
					 $user_queryl="select * from lang_known where JUser_Id='".$jrow['JUser_Id']."' AND lang_id='".$rrl1['lang_type']."'";
 $rrlk= mysqli_query($con,$user_queryl); 
	while($rlk=mysqli_fetch_array($rrlk)){	?>
                <div class="col-md-4 col-sm-6">
                    <div class="block-show">
                        <h4><?php echo $rrl1['lang_type'];?></h4>
                        <p class="lang-all">
						<?php if(trim($rlk['read1'])=='on'){ echo "Read";}else { echo " ";}?>
						<?php if(trim($rlk['write1'])=='on'){ echo "Write";}else { echo " ";}?>
						<?php if(trim($rlk['speak1'])=='on'){ echo "Speak";}else { echo " ";}?></p>
                    </div>
                </div>
						 <?php }} ?>
            </div>
            <!--/row-->
        </div>
        <!-- show details -->
        <!--/ display details show-->
    </div>
    <!-- / langugaes known-->
    <!-- social profiles -->
  <!--  <div class="display-details">
        <!-- display details edit and title -->
   <!--      <article class="sub-title">
            <h4 class="pull-left">SOCIAL <span class="fbold">PROFILES</span></h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
  <!--       <div id="show-soc">
            <div class="row showdetails">
                <div class="col-md-3">
                    <div class="block-show">
                        <h4><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</h4>
                        <p class="soc-url"><a href="#!" target="_blank">https://www.facebook.com/praveen.guptha.9</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block-show">
                        <h4><i class="fa fa-linkedin" aria-hidden="true"></i> Linkedin</h4>
                        <p class="soc-url"><a href="#!" target="_blank">https://www.linkedin.com/in/praveenguptha/</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block-show">
                        <h4><i class="fa fa-google-plus" aria-hidden="true"></i> Google Plus</h4>
                        <p class="soc-url"><a href="#!" target="_blank">https://www.linkedin.com/in/praveenguptha/</a></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block-show">
                        <h4><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</h4>
                        <p class="soc-url"><a href="#!" target="_blank">https://www.linkedin.com/in/praveenguptha/</a></p>
                    </div>
                </div>
            </div>
            <!--/row-->
      <!--   </div>
        <!-- show details -->
        <!--/ display details show-->
   <!--  </div>-->
    <!--/ social profiles -->
    <!-- passport details -->
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">PASSPORT <span class="fbold">DETAILS</span></h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
		<?php  
			$c7="select * from tbl_passport where JUser_Id=".$JUser_Id;
			$result7 = mysqli_query($con,$c7);
			$row7= mysqli_fetch_array($result7); 
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
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show txttraup">
                        <h4>Passport Number</h4>
                        <p><?php echo $row7['Number']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date of Issue</h4>
                        <p><?php //echo $row7['DoI']; ?>
						<?php //echo $jrow['DoB']; ?><?php $date1=date_create($row7['DoI']);
						echo date_format($date1,"M d,Y");?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Date of Expiry</h4>
                        <p><?php //echo $row7['DoED']; ?>
						<?php $date2=date_create($row7['DoED']);
						echo date_format($date2,"M d,Y");?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Place of Issue</h4>
                        <p><?php echo $row8['Loc_Name']; ?></p>
                    </div>
                </div>
                 </div>
            <!--/row-->
             <div class="row showdetails ">
				<div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Residency Of Country</h4>
                        <p><?php echo $row10['Cntry_Name']; ?></p>
                    </div>
                </div>
				<div class="col-md-3 col-sm-6">
                    <div class="block-show auth_count">
                        <h4>Authorized to Work</h4>                       
						<?php 
							   $sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$JUser_Id;
							   $result = mysqli_query($con,$sql);
							   $row1 = mysqli_fetch_array($result);
							   $acountry=$row1['JCauthorised'];
							   $acountryid=explode(",",$acountry );
                              // print_r($acountryid);
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
						<span><?php echo $ms_data1['Cntry_Name'];if($count==$q){ break;} ?>,</span>						
                           <?php $q++;  }  
                           }
                           else { ?>
                          
                               <p>None</p>
                               
                           <?php  }
                            ?>   
                    </div>
                </div>
                </div>
           
        </div>
        <!-- show details -->
        <!--/ display details show-->
    </div>
	
    <!--/ passport details -->
</div>