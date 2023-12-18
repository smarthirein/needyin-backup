	<?php if($count ==0){ ?>
	
	<div class="noprofiles-available text-center">
<h3 class="h3">Sorry we couldn't find any matches </h3>

<figure><img src="img/nofound.svg"></figure>
</div>
	
	<?php } else	{ 	while ($row2 = mysqli_fetch_assoc($resultv1)) { ?>
    <div class="mb15">
        <div class="brdbg-white list-block-db row">
            
            <div class="">
            <div class="col-md-5 col-sm-12">
                <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <figure class="js-list-pic">
                   <img class="img-cover" data-object-fit="cover" src="<?php if($row2['JPhoto']){  echo  $row2['JPhoto']; }else {?>img/nav-login-recruiter-img.jpg <?php } ?>">
                    </figure>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 mobcenter">
                    <a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=4" class="name">
                        <h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
                        <h5><?php echo $row2['Des']; ?></h5>
                        <p><?php echo $row2['Company_Name']; ?></p>
                    </a> <span class="notice-list"><?php  ?><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']." days"; }?> Notice</span> </div>
            </div>
            </div>
            <div class="col-md-7 col-sm-12">
                 
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                        <tr>
                            <td><i class="fa fa-black-tie" aria-hidden="true"></i></td>
                            <td class="grtxt"> Prof. Experience </td>
                            <td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months </td>
                            <td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="grtxt"> Preferred Location </td>
                            <td><?php echo $row2['Loc_Name']; ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt"> Current CTC (Lacs)</td>
                            <td><?php echo $row2['CurrentSalL']; ?></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt"> Exp CTC (Lacs)</td>
                            <td>Min: <?php echo $row2['ExpSalL']; ?> - Max: <?php echo $row2['ExpMaxSalL']; ?> </td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                            <td class="grtxt"> Education </td>
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
                      $skill_ids=explode(",",$row2['Job_Skills']); 
                       foreach ($skill_ids as $skill_id) {

                             $s_query="select skill_Name from tbl_masterskills where skill_Id=".$skill_id;
                             $s_res=mysqli_query($con,$s_query);
                             $skill_name=mysqli_fetch_array($s_res);
                             ?> <span><?php echo $skill_name['skill_Name']; ?> </span><?php
                                                     
                        } ?>

                 
					 </p>
                </div>
            </div>
             
                </div>
            </div>
            </div>
            </div>
        
        </div>
    </div>
	<?php } } ?>
	<?php if($count >=10){ ?>
	<form method="post" action="recently-viewed.php">
	<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
	</form>
	<?php } ?>

