<?php 
$cj21="SELECT Job_Skill,Loc_Id FROM tbl_jobposted WHERE emp_id = '".$row[emp_id]."' and Job_Status=1 "; 
			$resultcj12 = mysqli_query($con,$cj21);  			
			while($result_cj12=mysqli_fetch_array($resultcj12))
			{  
			$jobskills[]=$result_cj12['Job_Skill'];
			$loc[]=$result_cj12['Loc_Id'];
			}
			$jobskills1=array_filter(array_unique($jobskills));
			$loc1=array_filter(array_unique($loc));
			 $ids = join(",",$jobskills1);				
			$ids2 =array_unique(explode(",",$ids));
			$loc_id = join(",",$loc1); 
			$locids =explode(",",$loc_id);				
			foreach($ids2 as $idss)
			{		
				$query11s="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and jdndstatus='0' and FIND_IN_SET('$idss',Job_Skills)";
				$qu_ress=mysqli_query($con,$query11s);
						while ($qu_data = mysqli_fetch_array($qu_ress)) 
						{
							$juser_ids[]=$qu_data['JUser_Id'];
							
						}
			}	
			$suids=array_filter(array_unique($juser_ids));
			foreach($locids as $loc)	
			{	
 $query22="select JUser_Id FROM tbl_jobseeker where JuserStatus='A' and  (JPLoc_Id='".$loc."' || nri_status='Y' )";
			$qu_res21=mysqli_query($con,$query22);
			   while($qu_data2 = mysqli_fetch_array($qu_res21))
			   {
				  $luser_ids[]=$qu_data2['JUser_Id'];
			   }
			}
			$luserids=array_filter(array_unique($luser_ids));
			$c_ids=array_intersect($suids,$luserids);
	
			?>
    
	<?php if($count ==0){ ?>
	
	<div class="noprofiles-available text-center">
<h3 class="h3">Sorry we couldn't find any matches </h3>

<figure><img src="img/nofound.svg"></figure>
</div>
	
	<?php } else	{ 	while ($row2 = mysqli_fetch_array($result1)) { ?>
    <div class="mb15">
        <div class="brdbg-white list-block-db row">
          
            <div class="col-md-5 col-sm-12">
                <div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<figure class="js-list-pic">
							
						   <img class="img-cover" data-object-fit="cover" src="<?php if($row2['JPhoto']){  echo $row2['JPhoto']; }else if($row2['Gender']=="Male") {?>img/js-profile-list-pic.jpg <?php } else {?>img/female.png <?php }?>" >
						</figure>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12 mobcenter">
						<a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=1" class="name">
							<h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
							<h5><?php echo $row2['Des']; ?></h5>
							<p><?php echo $row2['Company_Name']; ?></p>
							</a> <span class="notice-list"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days"; }?>  Notice</span> 
<span style="font-size:10px;" class="notice-list tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $row2['jReasonType'];?> ">Reason:<?php  $reason = substr($row2['jReasonType'], 0, 20);if(strlen($reason)<20){echo $reason ;}else{echo $reason."...";}?> </span> 																		
							<p class="profile-action"><?php 		
							 if (in_array($row2['JUser_Id'], $c_ids)) {?>
							 <span> <a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=1"><i class="fa fa-exchange" aria-hidden="true"></i> </a> </span>
							<?php }
							 $query11s="select count(JUser_Id) as ids FROM tbl_employerview where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
											$qu_ress=mysqli_query($con,$query11s);
											$ress = mysqli_fetch_array($qu_ress);if($ress['ids'] !=0){?>
							 <span><a  href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=6"><i class="fa fa-eye" aria-hidden="true"></i></a> </span>
							<?php }
							 $short_id="select count(JUser_Id) as sid FROM tbl_shortlisted where JUser_Id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
											$s_id=mysqli_query($con,$short_id);
											$short_res = mysqli_fetch_array($s_id);if($short_res['sid'] !=0){?>
							 <span><a  href="dbrecruiter-profles-shortlist.php"><i class="fa fa-heart" aria-hidden="true"></i> </a> </span>
							<?php }
							 $sche_id="select count(juser_id) as scheid FROM interviewscheduled where juser_id='".$row2['JUser_Id']."' and  emp_id='".$row[emp_id]."'";
											$sc_id=mysqli_query($con,$sche_id);
											$sche_res = mysqli_fetch_array($sc_id);if($sche_res['scheid'] !=0){?>
							<span><a  href="dbrecruiter-sche-int.php"><i class="fa fa-calendar" aria-hidden="true"></i> </a></span>
							<?php }
							?></p>				
					</div>					
				</div>
            </div>
            <div class="col-md-7 col-sm-12">
               
				<div class="row">
					<div class="col-md-12">
						<table width="100%" cellpadding="0" cellspacing="0" class="list-table">
							<tr>
								<td><i class="fa fa-black-tie" aria-hidden="true"></i></td>
								<td class="grtxt">Prof. Experience</td>
								<td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months</td>   
								<td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
								<td class="grtxt"> Preferred Location </td>
								<td><?php echo $row2['Loc_Name']; ?></td>
							</tr> 
							<tr>
								<td><i class="fa fa-inr" aria-hidden="true"></i></td>
								<td class="grtxt">Current CTC (Lacs)</td>
								<td><?php echo $row2['CurrentSalL']; ?></td>
								<td><i class="fa fa-inr" aria-hidden="true"></i></td>
								<td class="grtxt">Exp CTC (Lacs)</td>
								<td>Min: <?php echo $row2['ExpSalL']; ?> - Max: <?php echo $row2['ExpMaxSalL']; ?> </td>
							</tr>
							<tr>
								<td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
								<td class="grtxt">Education</td>
								<td><?php echo $row2['Qual_Name']; ?></td>
								<td><i class="fa fa-calendar" aria-hidden="true"></i></td>
								<td class="grtxt"> Last Active:</td>
								<td>
									<?php 
									 $nt_querys="select `Date&time` from tbl_recent_views where userid='".$row2['JUser_Id']."' order by `Date&time` DESC";
									$nt_ress=mysqli_query($con,$nt_querys);
									$datas_sws=mysqli_fetch_array($nt_ress);
									
									$date=date_create($datas_sws['Date&time']);
									echo date_format($date,"M d,Y");
									?>
								</td>
							</tr>
						</table>
					
					<div class="skills-tab">
						<div class="col-md-12">
							<h6 class="h6">Skills</h6><p class="skills-js-list">
							<?php
							$sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row2['JUser_Id'];
							$result = mysqli_query($con,$sql);
							$row1 = mysqli_fetch_array($result);
							$skills=$row1['Job_Skills'];
							$skill_ids=explode(",",$skills);?>
							<p class="skills-js-list">
							<?php foreach($skill_ids as $skillid)  { 
								$ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
								$ms_result1 = mysqli_query($con,$ms_sql1);
								$ms_data1 = mysqli_fetch_array($ms_result1);?>      
							<span>
								<?php echo $ms_data1['skill_Name']; ?>
							</span> <?php } ?>
							</p>
						</div>
					</div>
				               
					</div>
						              
				</div>           
            </div>            
        </div>
    </div>
	<?php  } }?>
	<?php if($count >=10){ ?>
	<form method="post" action="dbrecruiter-latest.php">
	
	<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
	</form>
	<?php  } ?>
   
