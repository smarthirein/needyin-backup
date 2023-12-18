<?php
session_start();
if(isset($_GET['jobId'])){
require_once 'class.user.php';
$user_home = new USER();

if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');   
} 				  
	$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
	$stmt->execute(array(":rid"=>$_SESSION['empSession']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$q = "SELECT * FROM tbl_jobposted WHERE Job_Id ='".$_GET['jobId']."'";
	$r = mysqli_query($con,$q);
	$res = mysqli_fetch_array($r);//echo $res['Job_Name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/modernAlert.min.js"></script>
    <!-- css includes-->
<script type="text/javascript">
$(document).ready(function()
{
	$("#loding1").hide();
	$(".education").change(function()
	{
		$("#loding1").show();
		var id=$(this).val();
		var dataString = 'id='+ id;
		$("#PSpeca").find('option').remove();
		$.ajax
		({
			type: "POST",
			url: "get_specialization.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$("#loding1").hide();
				$("#PSpeca").html(html);
			} 
		});
	});		
});
</script>
        <script>
            $(document).ready(function () {
               // $("#describe-job").Editor();
					$('#notshow').change(function(){
					if(this.checked)
						$('#chck').hide();
					else
						$('#chck').show();
					});
            });
        </script>
				<style>
						.t{
						width: 1050px;
						height: 330px;
						resize:none;
						}
				</style>
				    <?php include"source.php" ?>
</head>

<body>
    <?php include'includes-recruiter/db-recruiter-header.php' ?>
        <!-- main-->
        <main>
            <!--dashboard of profiles section -->
		<form name="editJobForm" method="POST" action="editjob-info.php?jobId=<?php echo $_GET['jobId'];?>">
            <section class="db-recruiter">
                <div class="container">
                    <!-- title row-->
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Edit Job</h4> </article>
                        </div>
                    </div>
                    <!--/ title row-->
                </div>
                <!-- create new job form -->
                <div class="container">
                    <div class="newjob-form">
                        <!-- row -->
                        
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>Job name </label>
								<?php 
									$q2 = "SELECT Desig_Name FROM  tbl_desigination WHERE Desig_Id ='".$res['Job_Name']."'";
									$r2 = mysqli_query($con,$q2);
									$res2 = mysqli_fetch_array($r2);
									$loctName = $res2['Desig_Name'];
									$loctId = $res2['Desig_Id'];
								?>
								<input type="text" name="PJobName"  value="<?php echo $loctName ?>" readonly>
								<!--<select name="PJobName" id="PJobName" >
									<option value="0" disabled >Select Job Location</option>
									<?php 
										/*$q1 = "SELECT * FROM tbl_desigination";
										$r1 = mysqli_query($con,$q1);
										while($res1 = mysqli_fetch_array($r1)){
											$locName = $res1['Desig_Name'];
											$locId = $res1['Desig_Id'];*/
											?>
											<option value="<?php //echo $locId;?>" <?php //if ($loctName==$locName){ echo 'selected';}?> ><?php //echo $locName;?></option>;
									<?php //}
									?>       
								</select>-->
                                </div>
                            </div>
                            <div class="col-md-4 custom-btn mt10">
                                <div class="form-group">
                                <label>Multiple Skills <span class="mand">*</span> </label>
									<?php	
											$skills = explode(',',$res['Job_Skill']);
											foreach($skills as $i){
												$q2 = "SELECT * FROM tbl_masterskills WHERE skill_Id ='".$i."'";
												$r2 = mysqli_query($con,$q2);
												$res2 = mysqli_fetch_array($r2);
												$skillsArr[] = $res2['skill_Name'];
											}
									?>
                                    <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" name="PSkills[]" id="PSkills">
										<option value="0" disabled>Select Multiple Skills</option>
										<?php 
											$q1 = "SELECT * FROM tbl_masterskills";
											$r1 = mysqli_query($con,$q1);
											while($res1 = mysqli_fetch_array($r1)){
												$skillName = $res1['skill_Name'];
												$skillId = $res1['skill_Id'];
												?>
												<option value="<?php echo $skillId;?>" <?php if (in_array($skillName,$skillsArr)){ echo 'selected disabled';}?>><?php echo $skillName;?></option>;
										<?php	}
										?>                                    
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt5">
                                <div class="form-group">
                                <label>Job Location </label>
								<?php 
									$q2 = "SELECT Loc_Name FROM  tbl_location WHERE Loc_Id ='".$res['Loc_Id']."'";
									$r2 = mysqli_query($con,$q2);
									$res2 = mysqli_fetch_array($r2);
									$loctName = $res2['Loc_Name'];
									$loctId = $res2['Loc_Id'];
								?>
                                    <select class="form-control classic" name="PLoc" id="PLoc" disabled>
                                        <option value="0" disabled >Select Job Location</option>
										<?php 
											echo $q1 = "SELECT * FROM tbl_location WHERE Cntry_Id='101' ORDER BY Loc_Name";
											$r1 = mysqli_query($con,$q1);
											while($res1 = mysqli_fetch_array($r1)){
											echo	$locName = $res1['Loc_Name'];
												$locId = $res1['Loc_Id'];
												?>
												<option value="<?php echo $locId;?>" <?php if ($res['Loc_Id']==$locId){ echo 'selected';}?> ><?php echo $locName;?></option>;
										<?php }
										?>       
									</select>
                                </div>
                            </div>
                        </div>
                        <!--/ row -->
                        <!-- row -->
                       <!-- <div class="row">
                            <div class="col-md-2">
                                <div class="input-field">
									<?php 
										$minExp = $res['Min_Exp'];
										$maxExp = $res['Max_Exp'];
										$salRange = $res['Sal_Range'];
										$msalRange = $res['MSal_Range'];
									?>
                                    <select name="PMinE" id="PMinE">
                                        <option value="-1" disabled >Min Exp</option>
                                        <?php for($i=1;$i<=30;$i++){?>
											<option value="0<?php echo $i;?>" <?php if($i == $minExp) echo "selected";?> ><?php echo $i." Years";?></option>
										<?php }?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-field">
                                    <select name="PMaxE" id="PMaxE">
                                        <option value="-1" disabled >Max Exp</option>
										<?php for($i=1;$i<=30;$i++){?>
											<option value="0<?php echo $i;?>" <?php if($i == $maxExp) echo "selected";?> ><?php echo $i." Years";?></option>
										<?php }?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                    <select name="PSal" id="PSal">
                                        <option value="0" disabled>Salary Range Yearly</option>
                                        <?php for($i=1;$i<=30;$i++){$next = $i+1;?>
											<option value="<?php echo $i;?>" <?php if($i == $salRange) echo "selected";?> ><?php echo $i."-".$next." Lakhs";?></option>
										<?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                    <input name="PCompname" id="PCompname"  type="text" value="<?php echo $res['Comp_Name']; ?>">
                                    <label for="Company Name">Company Name</label>
                                </div>
                            </div>
                        </div> -->
						  <div class="row">
								<div class="col-md-4">
											<div class="minmax-sliderd">
											   <label> Experience (Years)<span class="mand">*</span></label>
														 <div class="minmax-slider">
																<div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-range"></div>
																<div class="values">
																	<div class="valuein">												
																			<div class="left-input">
																				<span class="ctc-span">Min</span>
																				<input class="input-format1 slider-job" id="PMinE" readonly="true" name="PMinE">
																			</div>														
																			<div class="rt-input">
																				<span class="ctc-span">Max</span>
																				<input class="input-format2" id="PMaxE"readonly="true" name="PMaxE">
																			</div>
																	</div>
																</div>
														 </div>
											</div>
								</div>
								 <script>
											var sliderFormat1 = document.getElementById('slider-range');
											noUiSlider.create(sliderFormat1,{
											start: [<?php echo $minExp; ?>,<?php echo $maxExp; ?>],
											step: 1,
											connect: true,
											range: {
											'min': [3],
											'max': [50]
												}
											});
											var values = [document.getElementById('PMinE'), document.getElementById('PMaxE')];														
											var inputFormat1 = document.getElementById('PMinE');
											var inputFormat2 = document.getElementById('PMaxE');
											sliderFormat1.noUiSlider.on('update', function( values, handle ) 
												{							
												inputFormat1.value = values[0];
												inputFormat2.value = values[1];													
												});
											inputFormat1.addEventListener('change', function()
											{
												sliderFormat1.noUiSlider.set(document.getElementById('PMinE').value);
											});
											inputFormat2.addEventListener('change', function()
											{
												sliderFormat1.noUiSlider.set(inputFormat2.value);
											}); 
								
								</script> 
                                       <!-- <div class="col-md-2">
                                            <div class="input-field">
                                                <select name="PMinE" id="PMinE">
                                                    <option value="" disabled selected>Min Exp<span class="mand">*</span></option>
                                                    <?php for($i=0;$i<=30;$i=$i+1){  ?>
                                                        <option value="0<?php echo $i ?>"><?php echo $i ?> Year</option>

                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-field">
                                                <select name="PMaxE" id="PMaxE">
                                                    <option value="" disabled selected>Max Exp<span class="mand">*</span></option>
                                                    <?php for($i=0;$i<=30;$i=$i+1){  ?>
                                                        <option value="0<?php echo $i ?>"><?php echo $i ?> Year</option>

                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>-->
                                        <div class="col-md-4">                                           
											<div class="minmax-sliderd">
                                                       <label>Expected Salary (Lacs)<span class="mand">*</span></label>
                                                        <div class="minmax-slider">
														<div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-range1" disabled></div>
														<div class="values">
														<div class="valuein">												
														<div class="left-input"><span class="ctc-span">Min</span><input class="sinput-format1 slider-job" id="PSal" readonly="true" name="PSal" >
                                                          </div>
														
                                                            <div class="rt-input"> <span class="ctc-span">Max</span>
														<input class="sinput-format2" id="MPSal" readonly="true" name="MPSal">
														</div>
														</div>
                                                        </div>														
														</div>
														 <script>
															var sliderFormat1 = document.getElementById('slider-range1');
															noUiSlider.create(sliderFormat1,{
															start: [<?php echo $salRange;?>,<?php echo $msalRange; ?>],
															step: 1,
															connect: true,
															range: {
															'min': [1],
															'max': [50]
																}
															});
														    var values = [document.getElementById('PSal'), document.getElementById('MPSal')];
                                                            var sinputFormat1 = document.getElementById('PSal');
															var sinputFormat2 = document.getElementById('MPSal');
                                                            sliderFormat1.noUiSlider.on('update', function( values, handle ) 
																{							
                                                                sinputFormat1.value = values[0];
																sinputFormat2.value = values[1];													
																});
														    sinputFormat1.addEventListener('change', function()
															{
                                                                sliderFormat1.noUiSlider.set(document.getElementById('PSal').value);
                                                            });
															sinputFormat2.addEventListener('change', function()
															{
                                                                sliderFormat1.noUiSlider.set(sinputFormat2.value);
                                                            }); 
													
                                                        </script> 
                                                <!--<select name="PSal" id="PSal" required>
                                                    <option value="" disabled selected>Salary Range Yearly<span class="mand">*</span></option>

                                                    <?php for($i=0;$i<=30;$i=$i+1){  ?>
                                                        <option value="<?php echo $i+1 ?>"><?php echo $i ?> - <?php echo $i+1 ?> Lakhs</option>

                                                        <?php } ?>
                                                </select>-->
                                            </div>
                                        </div>
										<div class="col-md-4">
											<div class="input-field pt10">
												<input name="PCompurl" id="PCompurl" type="text"  value="<?php echo $row["CompanyUrl"];?>" readonly>
												<label for="Company Name">Company Website URL <span class="mand">*</span></label>
											</div>
										</div>
                                       <!-- <div class="col-md-4">
											<div class="input-field pt10">
												<input name="PCompname" id="PCompname"  type="text" value="<?php echo $res['Comp_Name']; ?>">
												<label for="Company Name">Company Name</label>
											</div>
                                        </div>-->
                                    </div>
                        <!--/ row -->
                        <!-- row -->
                       <!--  <div class="row">
                           <div class="col-md-4">
                                <div class="input-field">
                                    <input name="PCompurl" id="PCompurl" type="text" value="<?php //echo $res['Comp_Url']; ?>">
                                    <label for="Company Name">Company Website URL</label>
                                </div>
                            </div>
							<div class="col-md-4 seldiv mt10"> <span>Job Type</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Pperm" type="radio" id="ft" value="Permanent" checked="<?php //if($res['PJobtype']=="Permanent") echo "checked";?>" />
                                            <label for="ft">Permanent</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Pperm" type="radio" id="cont1" value="Contract" checked="<?php //if($res['PJobtype']=="Contract") echo "checked";?>" />
                                            <label for="cont1">Contractor</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
						  <div class="col-md-4 seldiv mt10"> <span>Employment Type</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input name="PFull" type="radio" id="perm"  value="Full Time" checked="<?php if($res['PEmploytype']=="Full Time") echo "checked";?>" />
                                            <label for="perm">Full Time</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input name="PFull" type="radio" id="cont"  value="Part Time" checked="<?php if($res['PEmploytype']=="Part Time") echo "checked";?>" />
                                            <label for="cont">Part Time</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!--/ row -->
                        <!-- row text editor -->
                        <div class="row jobdescribe">
                            <div class="col-md-12">
                                <label>Job Description</label>
								<!--id="describe-job" id of text area field to get editor--> 
                                <textarea name="PJobdesc" id="PJobdesc" class="t" required="true" maxlength="2000"><?php echo htmlspecialchars_decode($res['Job_Desc']); ?></textarea>
                            </div>
                        </div>
						 <script>
							
										CKEDITOR.replace( 'PJobdesc' );
									</script>
                        <!-- / row text editor -->
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-4 mt10">
								<div class="form-group">
								<label>Education</label>
								<?php
									$sql = "SELECT Qual_Name FROM tbl_qualification WHERE Qual_Id='".$res['PEduc_Id']."'";
									$queryq = mysqli_query($con, $sql);
									$rowq = mysqli_fetch_array($queryq);
									$qualName = $rowq['Qual_Name'];
																
									$sql1 = "SELECT Qual_Id,Qual_Name FROM tbl_qualification";
									$query1 = mysqli_query($con, $sql1);
									?>
									<select name="PEduc" id="PEduc" class="education form-control classic" required="true">
										<option value="0" > Select Education </option>
										<?php
										while ($rowq1 = mysqli_fetch_array($query1))
										{ 
											extract($rowq1);	
										?>
										<option value="<?php echo $rowq1['Qual_Id']; ?>" <?php if(trim($rowq1['Qual_Name'])== $qualName) echo "selected";?> ><?php echo $rowq1['Qual_Name']; ?></option>
									<?php } ?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-4 mt10">
								<div class="form-group">
                               <label>Specialization</label>
                                <?php
									$sqlsp = "SELECT Speca_Name FROM tbl_specialization WHERE Speca_Id='".$res['PSpeci_Id']."'";
									$querysp = mysqli_query($con, $sqlsp);
									$rowsp = mysqli_fetch_array($querysp);
									$specaName = $rowsp['Speca_Name'];
									
									$sql1 = "SELECT Speca_Id,Speca_Name FROM tbl_specialization";
									$query1 = mysqli_query($con, $sql1);
								?>
									<select class="form-control classic" name="PSpeca" id="PSpeca">
										<option value="0"> Select Specialization </option>
										<?php
										while ($rowsp1 = mysqli_fetch_array($query1))
										{ 
											extract($row1);
										?>
										<option value="<?php echo $rowsp1['Speca_Id']; ?>" <?php if(trim($rowsp1['Speca_Name']) == $specaName)echo "selected";?> ><?php echo $rowsp1['Speca_Name'];  ?></option>
									<?php } ?>
									</select>
                                </div>            
                                <!-- praveen's code 
								<div class="input-field">
                                    <input name="PSpeca" id="spe" type="text" value="">
                                    <label for="spe">Speciazalation</label>
                                </div>-->
                            </div>
                            <div class="col-md-4 mt10">
                                <div class="form-group">
                                <label>University / College</label>
                                <?php
									$sqlu = "SELECT University_Name FROM tbl_university WHERE University_Id='".$res['PUniver_Id']."'";
									$queryu = mysqli_query($con, $sqlu);
									$rowu = mysqli_fetch_array($queryu);
									$univName = $rowu['University_Name'];

									$sql1 = "SELECT University_Id,University_Name FROM tbl_university";
									$query1 = mysqli_query($con, $sql1);
									?>
									<select class="form-control classic" name="PUniver" id="PUniver" >
										<option value="0"> Select University </option>
										<?php
										while ($rowu1 = mysqli_fetch_array($query1))
										{ 
											extract($rowu1);
										?>
										<option value="<?php echo $rowu1['University_Id']; ?>" <?php if($rowu1['University_Name']==$univName)echo "selected"; ?> ><?php echo $rowu1['University_Name']; ?></option>
									<?php } ?>
									</select>
                                </div>
								<!-- praveeen's code
								<div class="input-field">
                                    <input name="PUniver" id="University" type="text" value="">
                                    <label for="University">University</label>
                                </div>-->
                            </div>
                        </div>
                        <!--/ row -->
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
								<?php
									$sqls = "SELECT Indus_Name FROM tbl_industry WHERE Indus_Id='".$res['PIndus_Id']."'";
									$querys = mysqli_query($con, $sqls);
									$rows = mysqli_fetch_array($querys);
									$indsName = $rows['Indus_Name'];
									
									$sql1 = "SELECT Indus_Id,Indus_Name FROM tbl_industry";
									$query1 = mysqli_query($con, $sql1);
									?>
									<select name="PIndus" id="PIndus">
										<option value="0" disabled> Select Industry *</option>
										<?php
										while ($row1 = mysqli_fetch_array($query1))
										{ 
											extract($row1);
										?>
										<option value="<?php echo $row1['Indus_Id']; ?>" <?php if($row1['Indus_Name']==$indsName)echo "selected";?>><?php echo $row1['Indus_Name']; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
									<?php
									$sqlf = "SELECT Func_Name FROM tbl_functionalarea WHERE Func_Id='".$res['PFunc_Id']."'";
									$queryf = mysqli_query($con, $sqlf);
									$rowf = mysqli_fetch_array($queryf);
									$funcName = $rowf['Func_Name'];
									
									$sqlf1 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea";
									$queryf1 = mysqli_query($con, $sqlf1);
									
									?>
									<select name="PFunct" id="PFunct">
										<option value="0"> Select Function </option>
										<?php
										while ($rowf1 = mysqli_fetch_array($queryf1))
										{ 
											extract($row1);
											?>
											<option value="<?php echo $rowf1['Func_Id']; ?>" <?php if(trim($rowf1['Func_Name'])== $funcName) echo "selected";?> ><?php echo $rowf1['Func_Name']; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                           <!-- <div class="col-md-4">				
                                <div class="input-field">
                                    <input name="PAchive" id="achivements" type="text" value="<?php echo $res['PAchive'];?>">
                                    <label for="achivements">Achivements</label>
                                </div>
                            </div>-->
                        </div>
                        <!--/ row -->
                         <!-- row for job duration -->
                                    <div class="row">
                                     <div class="col-md-12">
                                        <h4 class="txt-blue h4">Job Duration</h4>
                                        <p><small>Job Duration / Job Expired Details mention here</small></p>
                                      </div>
                                      <div class="col-md-4">
                                           <div class="input-field">
                                           <label>Date of Job Creation<span class="mand">*</span></label>
                                            <input value="<?php echo $res['jobcreation'];  ?>" name="jobcreation" id="jobcreation" type="text" class="datepicker" placeholder="Date of Created">
                                        </div>
                                           <script>
                                          $('.datepicker').pickadate({
                                            selectMonths: true, // Creates a dropdown to control month
                                            selectYears: 15,
min:new Date()											// Creates a dropdown of 15 years to control year
                                          });
                                           </script>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="input-field">
                                            <label>Date of Job Expire<span class="mand">*</span></label>
                                            <input value="<?php echo $res['jobclosed'];?>"  name="jobclosed" id="jobclosed" type="text" class="datepicker1" placeholder="Date of Job Closed">
                                        </div>
                                        <script>
                                          $('.datepicker1').pickadate({
                                            selectMonths: true, // Creates a dropdown to control month
                                            selectYears: 15,
											min:new Date()// Creates a dropdown of 15 years to control year
                                          });
                                        </script>
                                      </div>
									   <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Job Posting Category <span class="mand">*</span></label>
                                                    <?php
                                                    $jb_cat = "SELECT * FROM tbl_jb_post_categories where status='active' ";
                                                    $jbcat_res = mysqli_query($con, $jb_cat);
                                                    if(!$query5)
                                                        echo mysqli_error($con);
                                                    ?>
                                                    <select class="form-control classic" name="job_category" id="job_category" required>
                                                       <!-- <option value="0"> Select Category </option>-->
                                                        <?php
                                                        while ($cat_data = mysqli_fetch_array($jbcat_res ))
                                                        { 
                                                        extract($cat_data);
                                                        ?>
                                                        <option value="<?php echo $category_id; ?>" <?php if(trim($category_id)== $res['category_id']) echo "selected";?> ><?php echo $category_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / row for job duratino -->
                        <div class="row empdetblock">
                            <div class="col-md-12">
                                <h4 class="txt-blue h4">Employment Details</h4>
                                <div class="empdet">
                                    <input type="checkbox" id="notshow" value="<?php echo $res['notshow_jobseeker'];?>" name="notshow" <?php if($res['notshow_jobseeker']==1){echo "checked";} else{ echo "unchecked";}?>/>
                                    <label for="notshow">Do not show to Jobseekar </label> 
                                    <p class="pt15"><span><small>Your Personal Details should not shown to Prelogin Job Seekers </small></span></p>
                                </div>
                            </div>
							<div id="chck">
								<div class="col-md-4">
									<div class="input-field">
										<input id="rec" type="text" value="<?php echo $row['contact_name'];?>">
										<label for="rec">Recruiter Name:</label>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="input-field">
										<input id="connumb" type="text" value="<?php echo $row['contact_num'];?>">
										<label for="connumb">Contact Number</label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="input-field">
										<input id="email" type="text" value="<?php echo $row['emp_email'];?>">
										<label for="email">Email ID</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="input-field">
										<input id="add" type="text" value="<?php echo $row['address1'].",".$row['address2'];?>">
										<label for="add">Address</label>
									</div>
								</div>
							</div>
						
                            <!--<div class="col-md-12 text-right">
                                <button type="submit" class="btn waves-effect waves-light" name="updateJobBtn">Update</button>
                              <a href="rec-jobs.php" class="btn waves-effect waves-light" data-position="top" data-delay="50" data-tooltip="Cancel Edit" data-tooltip-id="42ecda16-47a1-cc2f-d51d-2c8c4af48bc8"> Cancel </a>
                            </div>-->
                        </div>
                        <!--/ row -->
                        <div class="row">
                            
                        </div>
                        <!-- row -->
                        <div class="row">
                           <!-- <div class="col-md-4">
                                <div class="input-field">
										<?php	
											$awards = explode(',',$res['PAward']);
											foreach($awards as $key=>$value){
												$awardsArr[] = $value;
											}
											//print_r($awards);
										?>
                                    <select multiple>
                                        <option value="0" disabled >Awards / Rewards </option>
										<?php $awards = array('Awards','Patenets','Publications','Certifications');
                                        foreach($awards as $key => $value){?>
											<option value="<?php echo $value; ?>" <?php if(in_array($value,$awardsArr)) echo "selected";?>><?php echo $value;?> </option>
										<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
									<?php
										$langs = explode(',',$res['PLang']);
										foreach($langs as $key=>$value){
											$langs[] = $value;
										}
									?>
                                    <select multiple name="PLang[]">
										<option value="0" disabled> Select Languages  </option>
										<?php
										$sql = "SELECT lan_id,lang_type FROM tbl_language";
										$query = mysqli_query($con, $sql);
										while ($row = mysqli_fetch_array($query))
										{ 
											extract($row);
											?>
											<option value="<?php echo $lan_id; ?>" <?php if(in_array($lan_id,$langs))echo "selected";?>><?php echo $lang_type; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                    <select name="PCitizen">
                                        <option value="0" disabled >Citizenship </option>
                                        <?php
										$sql = "SELECT * FROM tbl_country";
										$query = mysqli_query($con, $sql);
										while ($row = mysqli_fetch_array($query))
										{ 
											extract($row);
											?>
											<option value="<?php echo $Cntry_Id; ?>" <?php if($Cntry_Id==$res['Pcitizenship']) echo "selected";?>><?php echo $Cntry_Name; ?></option>
										<?php } ?>
									</select>
                                </div>
                            </div> -->
                        </div>
                        <!--/ row -->
                        <!-- row -->
                       <!-- <div class="row">
                            <div class="col-md-4 seldiv"> <span>Job Type</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Pperm" type="radio" id="perm" value="Permanent" checked="<?php if($res['PJobtype']=="Permanent") echo "checked";?>" />
                                            <label for="perm">Permanent</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Pperm" type="radio" id="cont" value="Contract" checked="<?php if($res['PJobtype']=="Contract") echo "checked";?>" />
                                            <label for="cont">Contractor</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 seldiv"> <span>Employment Type</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input name="PFull" type="radio" id="perm"  value="Full Time" checked="<?php if($res['PEmploytype']=="Full Time") echo "checked";?>" />
                                            <label for="perm">Full Time</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input name="PFull" type="radio" id="cont"  value="Part Time" checked="<?php if($res['PEmploytype']=="Part Time") echo "checked";?>" />
                                            <label for="cont">Part Time</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                           <!-- <div class="col-md-4 seldiv"> <span>Gender</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Gender" type="radio" id="male" value="Male" checked="<?php if($res['PGender']=="Male") echo "checked";?>"  />
                                            <label for="male">Male</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input name="Gender" type="radio" id="female" value="Female"checked="<?php if($res['PGender']=="Female") echo "checked";?>" />
                                            <label for="female">Female</label>
                                        </p>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <!-- / row -->
                        <!-- row -->
                        <!--<div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
								<?php
									$countries = explode(',',$res['PVisaCtry']);
									foreach($countries as $key => $value){
										$cntrs[] = $value;
									}
									//print_r($cntrs);
								
									$sql6 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country";
									$query6 = mysqli_query($con, $sql6);

									?>
									<select name="PVisa[]" multiple>
										<option value="0" disabled> Visa for Countries </option>
										<?php
										while ($row1 = mysqli_fetch_array($query6))
										{ 
											extract($row1);
										?>
											<option value="<?php echo $Cntry_Id; ?>" <?php if(in_array($Cntry_Id,$cntrs)) echo "selected";?>><?php echo $Cntry_Name; ?></option>
									<?php } ?>
									</select>
                                </div>
                            </div>
                            <div class="col-md-4 seldiv"> <span>Willing to Travel</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="Yes" name="wtt" value="Yes"  checked="<?php if($res['PWillingtotravel']=="Yes") echo "checked";?>" />
                                            <label for="Yes">Yes</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="no" name="wtt" value="No" checked="<?php if($res['PWillingtotravel']=="No") echo "checked";?>" />
                                            <label for="no">No</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 seldiv"> <span>Passport</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio"  id="pYes" name="Passport" value="Yes" checked="<?php if($res['PPassport']=="Yes") echo "checked";?>"   />
                                            <label for="pYes">Yes</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="pno" name="Passport" value="No" checked="<?php if($res['PPassport']=="No") echo "checked";?>" />
                                            <label for="pno">No</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!--/ row -->
                        <!-- row -->
						<!---
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="txt-blue h4">Employment Details</h4>
                                <p>
                                    <input type="checkbox" id="notshow" />
                                    <label for="notshow">Do not show to Jobseekar</label>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="rec" type="text">
                                    <label for="rec">Recruiter Name:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="add" type="text">
                                    <label for="add">Address</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="connumb" type="text">
                                    <label for="connumb">Contact Number</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="email" type="text">
                                    <label for="email">Email ID</label>
                                </div>
                            </div>
                        </div>-->
                        <!-- / row -->
                        <!-- row -->
                        <div class="row btndiv">
                            <div class="col-md-12">
                                <button type="submit" class="btn waves-effect waves-light" name="updateJobBtn" onclick="return validate()">Update</button>                               
								<a href="rec-jobs.php" class="btn waves-effect waves-light" data-position="top" data-delay="50" data-tooltip="Cancel Edit" data-tooltip-id="42ecda16-47a1-cc2f-d51d-2c8c4af48bc8"> Cancel </a>
                            </div>
                        </div>
                        <!--/ row -->
                    </div>
                    
                
                <!--/ create a new job form -->
                
            </section>
            
		</form>
            <!--/ dtashboard of profiles section -->
        </main>
		<script lang="javascript">
			function validate()
            { 
				var name=document.getElementById('PJobName').value;
            	if(name==0)
            	{
            		alert("Please Enter Job name");
            		document.getElementById('PJobName').focus();
            		return false;
            	}
			var PSkills=document.getElementById('PSkills').value;
            	if(PSkills==0)
            	{
            		alert("Please Select skills");
            		document.getElementById('PSkills').focus();
            		return false;
            	}
				var mobnum=document.getElementById('PLoc').value;
				if(mobnum=="0")
            	{
            		alert("Please Select Preferred Location");
            		document.getElementById('PLoc').focus();
            		return false;
            	}
				
				/*var exp=document.getElementById('PMinE').value;
				var expmon=document.getElementById('PMaxE').value;
            	if(exp==0&&expmon==0)
            	{
            		alert("Please Give Experience");
            		document.getElementById('PMinE').focus();
            		return false;
            	}
				if(exp>expmon)
				{
					alert("Minimum experience can't be more than maximum experience");
            		document.getElementById('PMinE').focus();
            		return false;
				} */
				var exp=document.getElementById('PMinE').value;
				var expmon=document.getElementById('PMaxE').value;
            	if(exp==0&&expmon==0)
            	{
            		alert("Please Give Experience");
            		document.getElementById('PMinE').focus();
            		return false;
            	}
				if((Number(exp)>Number(expmon))||(Number(exp)==Number(expmon)))
				{
					alert("Minimum experience can't be more than maximum experience");
            		document.getElementById('PMinE').focus();
            		return false;
				}
				
				var PSal=document.getElementById('PSal').value;
            	if(PSal=="")
            	{
            		alert("Please give your salary range");
            		document.getElementById('PSal').focus();
            		return false;
            	}
				/*var PCompname=document.getElementById('PCompname').value;
            	if(PCompname=="")
            	{
            		alert("Please give your company name");
            		document.getElementById('PCompname').focus();
            		return false;
            	}
				var permanent = document.getElementsByName("Pperm");
				var Pperm = false;

			var i = 0;
			while (!Pperm && i < permanent.length) 
			{
			if (permanent[i].checked)
			Pperm = true;
			i++;        
			}

			if (!Pperm) 
				{
				alert("Please check Job Type!");
				return Pperm;
				}				
				var emptype = document.getElementsByName("PFull");
			var PFull = false;

			var i = 0;
			while (!PFull && i < emptype.length) 
			{
			if (emptype[i].checked) PFull = true;
			i++;        
			}

			if (!PFull) 
				{
				alert("Please check Employement type!");
				return PFull;
				}
				var PJobdesc=document.getElementById('PJobdesc').value;
            	if(PJobdesc.length<50)
            	{ var df=50-PJobdesc.length;
            		alert("Description must be atleast 50  characters ,You have to enter  "+ df+ "  more Characters");
            		document.getElementById('PJobdesc').focus();
            		return false;
            	}*/
				var PEduc=document.getElementById('PEduc').value;
            	if(PEduc=="0")
            	{
            		alert("Please give your Education");
            		document.getElementById('PEduc').focus();
            		return false;
            	}
				
				var PSpeca=document.getElementById('PSpeca').value;
            	if(PSpeca=="0")
            	{
            		alert("Please give your Specialization");
            		document.getElementById('PSpeca').focus();
            		return false;
            	}				
				var PUniver=document.getElementById('PUniver').value;
            	if(PUniver=="0")
            	{
            		alert("Please give your University");
            		document.getElementById('PUniver').focus();
            		return false;
            	}				
				var PIndus=document.getElementById('PIndus').value;
            	if(PIndus=="0")
            	{
            		alert("Please Select your industry");
            		document.getElementById('PIndus').focus();
            		return false;
            	}
				var PFunct=document.getElementById('PFunct').value;
            	if(PFunct=="0")
            	{
            		alert("Please give your functional area");
            		document.getElementById('PFunct').focus();
            		return false;
            	}
			}
		</script>
        <!--/main-->
        
</body>

</html>

<?php
} // first if condition
?>