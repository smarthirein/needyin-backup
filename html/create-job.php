<?php
	session_start();
	require_once("dbconfig.php");
	require_once 'class.user.php';
	$user_home = new USER();
	if(!isset($_SESSION['empSession']))
	{
			 $user_home->redirect('index-recruiter.php');
	   
	} 
	$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
	$stmt->execute(array(":eid"=>$_SESSION['empSession']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(empty($row['EmployerStrength']) || empty($row['CompanyUrl']) || empty($row['YoR']) || empty($row['NoOfBranch']) || empty($row['ToR']) || empty($row['designation']) )
	{
		echo "<script>alert('Complete your profile first to post jobs');</script>";
		header('location:edit-profile-recruiter.php');
	}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Needyin</title>
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#loding1").hide();
                $(".education").change(function () {
                    $("#loding1").show();
                    var id = $(this).val();
                    var dataString = 'id=' + id;
                    $("#PSpeca").find('option').remove();
                    $.ajax({
                        type: "POST",
                        url: "get_specialization.php",
                        data: dataString,
                        cache: false,
                        success: function (html) {
                            $("#loding1").hide();
                            $("#PSpeca").html(html);
                        }
                    });
                });
            });
        </script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
    function multiSelect(){
    var d = document.getElementById("PLoc");
    var dispalytext = d.option[d.selectedIndex].text;
    document.getElementById("describe-job").value = dispalytext;
    }
    </script> -->
        <?php include"source.php" ?>
    </head>
    <body>
        <?php
		include_once("analyticstracking.php");
		include 'includes-recruiter/db-recruiter-header.php'; ?>
            
            <main>
               
                <section class="db-recruiter">
                    <div class="container">
                       
                        <div class="row">
                            <div class="col-md-12">
                                <article class="dbpage-title">
                                    <h4 class="h4"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Create a New Job</h4>
                                </article>
                            </div>
                        </div>
                       
                    </div>
                    
                    <div class="container">
                        <div class="newjob-form">
                           
                            <div class="row">
                                <form action="createjob-info.php" method="POST" name="RecruiterJobC" id="createjob">
                                    <div class="row">
									 <div class="col-md-12">
                                        <h4 class="txt-blue h4">Job Details</h4>                                       
                                      </div>
                                        <div class="col-md-4">										 
                                            <div class="form-group">
                                               <label>Job Name <span class="mand">*</span> </label>
                                                
																<?php
													$sql = "SELECT id,Job_Role FROM tbl_jobdesc ORDER BY Job_Role";
													$query = mysqli_query($con, $sql);
													if(!$query)
													echo mysqli_error($con);
													?>
                                                    <select class="form-control classic" name="PJobName" id="PJobName" data-live-search="true" data-show-subtext="true" onChange="job_check(this); showArea(this.value);">
														<option value=""> </option> 
														<option value="Otherjob">Others</option>														
														<?php
														while ($row1 = mysqli_fetch_array($query))
														{ 
														 extract($row1);
														?>
														<option value="<?php echo $row1['id']; ?>" <?php if(trim($row1['id'])== "1"){ echo "selected";}else { echo "";}?>><?php echo $row1['Job_Role']; ?></option>

														<?php } ?>
                                                    </select>
													<div id="other-job" style="display:none;">
																<label><input id="other-jobs" name="newjob" onfocusout="myjob()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Job"></input>
																</label>
																</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 custom-btn mt5">
                                            <div class="form-group">
                                                <label>Skills <span class="mand">*</span> </label>
                                                <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="PSkills[]" id="PSkills" onChange="skill_check(this); ">
												<option value="" disabled></option>
												<option value="Others">Others</option>
													<?php 
													$sql = "SELECT skill_Name,skill_Id FROM tbl_masterskills WHERE skill_Status=1 order by skill_Name";
													$query = mysqli_query($con, $sql);
													if(!$query)
													echo mysqli_error($con);
													while ($skillrow = mysqli_fetch_array($query))
													{ 
														extract($skillrow);
														?>
														<option  value="<?php echo $skillrow['skill_Id'];?>"><?php echo $skillrow['skill_Name'];?></option>
													<?php } ?>
                                                </select>
												<div id="other-skill" style="display:none;">
																<label><input id="other-skills" name="newskill" onfocusout="myskill()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Skill"></input>
																</label>
																</div>
                                            </div>
                                        </div>
										<script>
															function skill_check(elem)
															{	
																if (elem.value =='Others') 
																{
																	document.getElementById("other-skill").style.display = 'block';
																}
																else
																{
																	document.getElementById("other-skill").style.display = 'none';
																}
															}	
															function myskill()
															{								
																document.getElementById("other-skill").style.font="italic bold 0.5rem arial,serif";
															}
															function job_check(elem)
															{	
																if (elem.value =='Otherjob') 
																{
																	document.getElementById("other-job").style.display = 'block';
																}
																else
																{
																	document.getElementById("other-job").style.display = 'none';
																}
															}	
															function myjob()
															{								
																document.getElementById("other-job").style.font="italic bold 0.5rem arial,serif";
															}
						</script>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Preferred Location <span class="mand">*</span> </label>
                                                <?php
													$sql = "SELECT Loc_Id,Loc_Name FROM tbl_location WHERE Cntry_Id='101' ORDER BY Loc_Name";
													$query = mysqli_query($con, $sql);
													if(!$query)
													echo mysqli_error($con);
													?>
                                                    <select class="form-control classic" name="PLoc" id="PLoc" required data-live-search="true" data-show-subtext="true">
														<option value="0"></option>
                                                        <?php
															while ($row1 = mysqli_fetch_array($query))
															{ 
															 extract($row1);
															?>
														<option value="<?php echo $row1['Loc_Id']; ?>" <?php if(trim($row1['Loc_Id'])== "4460"){ echo "selected";}else { echo "";}?>><?php echo $row1['Loc_Name']; ?></option>
				
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                              
                                    <div class="row">
									<div class="col-md-4">
                                                      <div class="minmax-sliderd">
                                                       <label>Expected Experience (Years)<span class="mand">*</span></label>
                                                        <div class="minmax-slider">
														<div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-range"></div>
														<div class="values">
														<div class="valuein">												
														<div class="left-input"><span class="ctc-span">Min</span><input class="input-format1 slider-job" id="PMinE" readonly="true" name="PMinE">
                                                          </div>
														
                                                            <div class="rt-input"> <span class="ctc-span">Max</span>
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
															start: [3,50],
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
                              
                                        <div class="col-md-4">
                                           
											<div class="minmax-sliderd">
                                                       <label>Expected Salary (Lacs)<span class="mand">*</span></label>
                                                        <div class="minmax-slider">
														<div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-range1"></div>
														<div class="values">
														<div class="valuein">												
														<div class="left-input"><span class="ctc-span">Min</span><input class="sinput-format1 slider-job" id="PSal" readonly="true" name="PSal">
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
															start: [1,50],
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
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-field pt10">
                                                <input name="PCompname" id="PCompname" type="text" value="<?php echo ucfirst($row["companyname"]);?>" maxlength="45" readonly>
                                                <label for="Company Name">Company Name<span class="mand">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-field">
                                                <input name="PCompurl" type="text" id="PCompurl"  value="<?php echo $row["CompanyUrl"];?>" placeholder="http://www.google.com" maxlength="45" value="http://" readonly>
                                                <label for="Company Name">Company Website URL<span class="mand"> *</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 seldiv"><label for='job type'>Job Type<span class="mand"> *</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>
                                                        <input type="radio" value="Permanent" id="perm" name="Pperm" required/>
                                                        <label for="perm">Permanent</label>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                        <input type="radio" value="Contractor" id="cont" name="Pperm" />
                                                        <label for="cont">Contractor</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 seldiv"> Employment Type <span class="mand"> *</span>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>
                                                        <input type="radio" value="Full Time" id="full" name="PFull" />
                                                        <label for="full">Full Time</label>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                        <input type="radio" value="Part Time" id="part" name="PFull" />
                                                        <label for="part">Part Time</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- code for special instructions -->
                                    <div class="row splinstrtns">
                                    <style type="text/css" scoped>
                                    .GeneratedTexts {
                                    font-family:'Comic Sans MS';font-size:1em;letter-spacing:0.2em;line-height:1.3em;color:#330099;background-color:#FFFF;padding:1.5em;
                                    }
                                    #spl_instrtns {
                                    height:80px;
                                    transition: all 2s;
                                    -webkit-transition: all 2s; /* Safari */
                                    }
                                    #spl_instrtns:focus {
                                    height:300px;
                                    }
                                    </style>
                                        <div class="col-md-12">
                                        <div class = "GeneratedTexts">
                                            <label><h4 class="txt-blue h4">Special Instructions<span class="mand">*</h4></span></label>
                                            <textarea id="spl_instrtns" name="spl_instrtns" class="t" required onchange="return txtarea('100','1000',this,'Profile Summary')">
                                            </textarea>
                                        </div>
                                    </div>
                              			<script>
										CKEDITOR.replace( 'spl_instrtns' );
									</script>
                                    <!--End code for special instructions -->
                                    <div class="row jobdescribe">
                                    <style type="text/css" scoped>
                                    .GeneratedText {
                                    font-family:'Comic Sans MS';font-size:1em;letter-spacing:0.2em;line-height:1.3em;color:#330099;background-color:#FFFF;padding:1.5em;
                                    }
                                    #describe-job {
                                    height:80px;
                                    transition: all 2s;
                                    -webkit-transition: all 2s; /* Safari */
                                    }
                                    #describe-job:focus {
                                    height:300px;
                                    }
                                    </style>
                                        <div class="col-md-12">
                                        <div class = "GeneratedText">
                                            <label><h4 class="txt-blue h4">Job Description<span class="mand">*</h4></span></label>
                                            <textarea id="describe-job" name="PJobdesc" class="t" required spellcheck = "true" onchange="return txtarea('100','1000',this,'Profile Summary')">
                                            </textarea>
                                        </div>
                                    </div>
                              			<script>
										CKEDITOR.replace( 'describe-job' );
									</script>
<!-- code for Auto_Job_description -->
<script>

function showArea(str)
{
if (str == "")
{
document.getElementById("describe-job").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
	//alert(xmlhttp.responseText);
document.getElementById("describe-job").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("GET","get_jobdesc.php?q="+str,true);
xmlhttp.send();
}
</script>
<!-- code for Auto_Job_description -->
                                    <div class="row mt10">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Highest Qualification </label>
                                                <?php
													$sql1 = "SELECT Qual_Id,Qual_Name FROM tbl_qualification ORDER BY Qual_Name";
													$query1 = mysqli_query($con, $sql1);
													if(!$query1)
													echo mysqli_error($con);
													?>
                                                    <select class="education form-control classic" name="PEduc" id="PEduc" required="true">
                                                       
                                                        <option value="0" selected="selected"></option>
                                                        <?php
																while ($row1 = mysqli_fetch_array($query1))
																{ 
																 extract($row1);
																?>
                                                            <option value="<?php echo $Qual_Id; ?>"><?php echo $Qual_Name; ?> </option>
                                                            <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                 <label>Specialization </label>
                                                <select class="form-control classic" name="PSpeca" id="PSpeca">
                                                    <option value="0" selected="selected"></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>University</label>
                                                <?php
									$sql3 = "SELECT University_Id,University_Name FROM tbl_university ORDER BY University_Name ";
									$query3 = mysqli_query($con, $sql3);
									if(!$query3)
									echo mysqli_error($con);
									?>
                                                    <select class="form-control classic" name="PUniver" id="PUniver">
													<option value="0">Others</option>
                                                        <?php
									while ($row1 = mysqli_fetch_array($query3))
									{ 
									 extract($row1);
									?>
                                     <option value="<?php echo $University_Id; ?>"><?php echo $University_Name; ?></option>
                                                            <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                
<div class="row">
                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="form-group">
                               <label>Industry Information </label>
                                <?php 											
									$sql1 = "SELECT Indus_Id,Indus_Name FROM tbl_industry ORDER By Indus_Name";
									$query1 = mysqli_query($con, $sql1);
									if(!$query1)
									echo mysqli_error($con);
								?>
											<select class="form-control classic" name="industry" id="industry" onChange="check1(this);">
											<option value="0">Select Industry</option>
											<option value="Others">Others</option>
											<?php
											while ($row1 = mysqli_fetch_array($query1))
											{ 
											extract($row1);
											?>
                                            <!--<option value="<?php echo $row1['Indus_Id']; ?>"<?php if(trim($row['Indus_Id'])==$row1['Indus_Id']){ echo "selected";}else { echo "";}?>>
                                                <?php echo $row1['Indus_Name']; ?>
                                            </option>-->
											<option value="<?php echo $row1['Indus_Id']; ?>" <?php if($row1['Indus_Id']==$row['Indus_Id'])echo "selected";?>><?php echo $row1['Indus_Name']; ?></option>
                                            <?php } ?>
										</select>					
                            </div>
								<div id="other-indus" style="display:none;">
																<label><input id="other-inputs" name="newindus" onfocusout="myindus()" style="height:15px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Industry"></input>
																</label>
																</div>
																<script>
																function check1(elem) {																			
																	 if (elem.value == "Others") {
																		document.getElementById("other-indus").style.display = 'block';
																	} else {
																		document.getElementById("other-indus").style.display = 'none';
																	}
																}
																function myindus(){															
																	document.getElementById("other-indus").style.color="blue";
																	  document.getElementById("other-indus").style.font="italic bold 0.5rem arial,serif";

																}</script>
							
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="form-group">
                               <label>Functional Area</label>
                                <?php 											
					$sql2 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea ORDER By Func_Name";
					$query2 = mysqli_query($con, $sql2);
					if(!$query2)
					echo mysqli_error($con);
					?>
                                    <select class="form-control classic" name="functional_area" id="functional_area" onChange="func_check(this);">
                                        <option value="0"  selected> Select Functional Area </option>
										<option value="Others" >Others</option>
                                        <?php
											while ($row2 = mysqli_fetch_array($query2))
											{ 
											 extract($row2);
											?>
									  <!-- <option value="<?php echo $row2['Func_Id']; ?>" <?php if(trim($row[ 'Func_Id'])==$row2[ 'Func_Id']){ echo "selected";}else { echo "";}?>> <?php echo $row2['Func_Name']; ?>  </option>-->
									  <option value="<?php echo $row2['Func_Id']; ?>" <?php if($row2['Func_Id']==$row['Func_Id'])echo "selected"; else "";?>><?php echo $row2['Func_Name']; ?></option>
									 <?php } ?>
                                    </select>

                                   
                            </div>
                           
							<div id="other-func" style="display:none;">
																<label>	<input id="other-funcs" name="newfunc" onfocusout="myfunc()" style="height:15px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Functional Area"></input>
																</label>
																</div>
																<script>
																			function func_check(elem) {	
																		if (elem.value == "Others") {
																		document.getElementById("other-func").style.display = 'block';
																	} else {
																		document.getElementById("other-func").style.display = 'none';
																	}
																}
																function myfunc(){															
																	
																	 document.getElementById("other-func").style.font="italic bold 0.5rem arial,serif";

																}</script>
                        </div>

                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="input-field">
                                <label>Hiring Manager</label>
                                    <input  name="hiringManager" id="hiringManager" type="text"  value="<?php echo $Hiring_Manager;?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="input-field">
                                <label>Department</label>
                                    <input  name="department" id="department" type="text"  value="<?php echo $Department;?>">
                            </div>
                        </div>
                                    </div>
                                    <!-- row for job duration -->
                                    <div class="row">
                                     <div class="col-md-12">
                                        <h4 class="txt-blue h4">Job Duration</h4>                                       
                                      </div>
                                      <?php $cur_date=date("d M,Y");
                                          $expiry_date=date("d M,Y", strtotime("+2 week"));
                                          $expd=date("Y M d", strtotime("+2 week"));?>
                                      <div class="col-md-4">
                                           <div class="input-field">
                                           <label>Date of Job Creation</label>
                                            <input  name="jobcreation" id="jobcreation" type="text"  value="<?php echo $cur_date;?>" placeholder="Date of Created" readonly>
                                        </div>
                                           <script>
                                          $('.datepicker').pickadate({
                                            selectMonths: true, 
                                            selectYears: 15,
											min:new Date()											
                                          });
                                           </script>
                                      </div>
                                      <div class="col-md-4">
                                           <div class="input-field">
                                           <label>Date of Job Expire</label>
                                            <input  name="jobclosed" id="jobclosed" type="text" class="datepicker" value="<?php echo $expiry_date;?>" placeholder="Date of Job Closed">
                                        </div>
                                          <script>
                                          $('.datepicker').pickadate({
                                            selectMonths: true, 
                                            selectYears: 15,
											min:new Date('<?php echo $expiry_date;?>')
										 
											
                                          });
                                           </script>
                                      </div>
                                       <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Job Posting Category</label>
                                                    <?php
                                                    $jb_cat = "SELECT * FROM tbl_jb_post_categories where status='active' ";
                                                    $jbcat_res = mysqli_query($con, $jb_cat);
                                                    if(!$query5)
                                                        echo mysqli_error($con);
                                                    ?>
                                                    <select class="form-control classic" name="job_category" id="job_category" required>
                                                       
                                                        <?php
                                                        while ($cat_data = mysqli_fetch_array($jbcat_res ))
                                                        { 
                                                        extract($cat_data);
                                                        ?>
                                                        <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="row empdetblock">
                                        <div class="col-md-12">
                                            <h4 class="txt-blue h4">Employer Details</h4>
                                            <p>
                                                <input type="checkbox" id="notshow" value="1" name="notshow" />
                                                <label for="notshow">Do not show to Jobseeker</label>
                                            </p>
                                        </div>
                                        <div id="chck">
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="rec" type="text" value="<?php echo $row['contact_name'];?>" readonly>
                                                    <label for="rec">Recruiter Name:<span class="mand">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="connumb" type="text" value="<?php echo $row['contact_num'];?>" readonly>
                                                    <label for="connumb">Contact Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="email" name="emails" type="text" value="<?php echo $row['emp_email'];?>" readonly>
                                                    <label for="email">Email ID</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-field">
                                                <input id="add" type="text" value="<?php echo $row['address1']." , ".$row['address2'];?>" readonly>
                                                <label for="add">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <div class="row btndiv">
                                        <div class="col-md-12">
                                            <input type="submit" value="Create Job" id="info" class="btn waves-effect waves-light" name="btn-CreateJob" onclick="return validate();"  />
											
                                            <button class="btn waves-effect waves-light" onclick="Javascript:window.location.href='rec-jobs.php';">Cancel</button>
                                        </div>
										<script>
  
</script>
                                    </div>
                                </form>
                               
                            </div>
                        </div>
                    </div>
                
                </section>
               
            </main>
         
            <?php// include "footer.php " ?>
        
                <div id="savejob" class="modal bottom-sheet text-center alertbx">
                    <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
                    <div class="modal-content">
                        <h4 class="h4 txt-blue">Saved Job</h4>
                        <p>Your Job Post Successfully placed in to Posted Jobs list</p> <a href="rec-jobs.php" class="btn btn-flat">Goto Posted Jobs</a> </div>
                </div>
              
		
                <script lang="javascript">			
					
                    function isNumber(evt) {
                        evt = (evt) ? evt : window.event;
                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                    function validate() 
					{
                        var name = document.getElementById('PJobName').value;
                        if (name==0) {
                            alert("Please Select Job Name");
                            document.getElementById('PJobName').focus();
							
                            return false;
                        }
						
                        var PSkills = document.getElementById('PSkills').value;
                        if (PSkills == 0) {
                            alert("Please Select Skills");
                            document.getElementById('PSkills').focus();
							
                            return false;
                        }
                        var mobnum = document.getElementById('PLoc').value;
                        if (mobnum == "0") {
                            alert("Please Select Preferred Location");
                            document.getElementById('PLoc').focus();
							
                            return false;
                        }
                        var exp = document.getElementById('PMinE').value;
                        var expmon = document.getElementById('PMaxE').value;
                        if (exp == 0 && expmon == 0) {
                            alert("Please Select Experience");
                            document.getElementById('PMinE').focus();
							
                            return false;
                        }
                        if ((Number(exp) > Number(expmon)) || (Number(exp) == Number(expmon))) {
                            alert("Minimum Experience can't be more than maximum experience");
                            document.getElementById('PMinE').focus();
							
                            return false;
                        }
                        var PSal = document.getElementById('PSal').value;
                        if (PSal == "") {
                            alert("Please Select Salary range");
                            document.getElementById('PSal').focus();
						
                            return false;
                        }
                        var PCompname = document.getElementById('PCompname').value;
                        if (PCompname == "") {
                            alert("Please Enter Company Name");
                            document.getElementById('PCompname').focus();
							
                            return false;
                        }
						 var PCompname = document.getElementById('PCompurl').value;
                        if ((PCompname == "http://") || PCompname == "") {
                            alert("Please Enter Company URL");
                            document.getElementById('PCompurl').focus();
                            return false;
                        }
                        var permanent = document.getElementsByName("Pperm");
                        var Pperm = false;
                        var i = 0;
                        while (!Pperm && i < permanent.length) {
                            if (permanent[i].checked)
                                Pperm = true;
                            i++;
                        }
                        if (!Pperm) {
                            alert("Please Select Job Type!");
                            return Pperm;
                        }
                        var emptype = document.getElementsByName("PFull");
                        var PFull = false;

                        var i = 0;
                        while (!PFull && i < emptype.length) {
                            if (emptype[i].checked) PFull = true;
                            i++;
                        }

                        if (!PFull) {
                            alert("Please Select Employement type!");
							
                            return PFull;
                        }
						
                       var PJobdesc = document.getElementById('cke_describe-job').value;
                        if (PJobdesc.length == 0) {
                            
                            alert("Please Enter Job Description");
                            document.getElementById('describe-job').focus();
							
                            return false;
                        }
							
						if (PJobdesc.length < 50) {
                            
                            alert("Job Description should have minimum 50 characters");
                            document.getElementById('describe-job').focus();
							
                            return false;
                        }
// JavaScript code for spl_instructions
                        var spl_instrtns = document.getElementById('cke_spl_instrtns').value;
                        if (spl_instrtns.length == 0) {
                            
                            alert("Please Enter Special instructions");
                            document.getElementById('spl_instrtns').focus();
							
                            return false;
                        }
							
						if (PJobdesc.length < 50) {
                            
                            alert("Special Instructions should have minimum 50 characters");
                            document.getElementById('spl_instrtns').focus();
							
                            return false;
                        }
// JavaScript code for spl_instructions
						
					}

        
                </script>
    </body>
    </html>