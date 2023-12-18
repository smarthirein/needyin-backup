<?php require_once 'class.user.php';
  if(isset($_SESSION['userSession']))
        {   ?>
          

<form method="post" action="job-search-results-postlogin_jobseeker.php">
                                      
                                        <div class="col-md-6 col-sm-5 col-xs-12 searchskills">
                                        
                                           <label class="masterlabel" style="color:	#ffffff;">Select Skills </label>
                                           <div class="form-group">
                                                <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills WHERE skill_Status=1 ORDER BY skill_Name";
												$query3 = mysqli_query($con, $sql3);
												if(!$query3)
												echo mysqli_error($con);
												?>
												 <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"   id="languages" name="languages[]">
												 <option value="0" disabled>Select Skill</option>
													<?php
													while ($row3 = mysqli_fetch_array($query3))
													{ 
													 extract($row3);
													?>
													<option value="<?php echo $row3['skill_Id']; ?>"><?php echo $row3['skill_Name']; ?></option>
													<?php } ?> 
												</select>
                                       </div>
                                        </div>
                                       
                                        <div class="col-md-4 col-sm-5 col-xs-12 sel-city">
                                           <label class="masterlabel" style="color:	#ffffff;">Select Location </label>
                                            <div class="">
                                            <?php $q1 = "SELECT * FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
													$r1 = mysqli_query($con,$q1); 
											?>
												<select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="PLoc" id="PLoc">
													<option value="0" selected></option>
													<?php 
													while($res1 = mysqli_fetch_array($r1)){
													$locName = $res1['Loc_Name'];
													$locId = $res1['Loc_Id'];
													?>
													<option value="<?php echo $locId;?>" <?php if ($loctName==$locName){ echo 'selected';}?> ><?php echo $locName;?></option>;
													<?php }
													?>       
												</select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 col-sm-2 col-xs-12 btn-search">
											 <input type="submit"  name="search" value="SEARCH" class="btn waves-effect waves-light fbold text-center"  onclick="return validate();"/>
                                        </div>
                                       
</form>

<?php   } else {  ?>
<form method="post" action="job-search-results-prelogin.php">
                                        <!-- search by skills or titles -->
                                       
                                        <div class="col-md-6 col-sm-5 col-xs-12 searchskills">
                                           <!-- <input class="form-control" type="text" placeholder="Search by Skills   e.g. HTML Developer" id="default" list="languages" name="languages">-->
                                             <label class="masterlabel">Select Multiple Skills </label>
                                           <div class="form-group">
                                                <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name";
												$query3 = mysqli_query($con, $sql3);
												if(!$query3)
												echo mysqli_error($con);
												?>
												 <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  id="languages" name="languages[]">
												 <option value="0" disabled>Select Skill</option>
													<?php
													while ($row3 = mysqli_fetch_array($query3))
													{ 
													 extract($row3);
													?>
													<option value="<?php echo $row3['skill_Id']; ?>"><?php echo $row3['skill_Name']; ?></option>
													<?php } ?> 
												</select>
                                       </div>
                                        </div>
                                        <!-- / search by skills -->
                                        <!-- select city -->
                                        <div class="col-md-4 col-sm-4 col-xs-12 sel-city">
                                           <label class="masterlabel">Select Location </label>
                                            <div class="">
                                            <?php $q1 = "SELECT * FROM tbl_location where Cntry_Id='101'ORDER BY Loc_Name";
													$r1 = mysqli_query($con,$q1); 
											?>
											
												<select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="PLoc" >
													<option value="0" selected></option>
													<?php 
													while($res1 = mysqli_fetch_array($r1)){
													$locName = $res1['Loc_Name'];
													$locId = $res1['Loc_Id'];
													?>
													<option value="<?php echo $locId;?>" <?php if ($loctName==$locName){ echo 'selected';}?> ><?php echo $locName;?></option>;
													<?php }
													?>       
												</select>
                                            </div>
                                        </div>
                                        <!-- / select city -->
                                        <!-- button -->
                                        <div class="col-md-2 col-sm-3 col-xs-12 btn-search">
											 <input type="submit"  name="search" value="SEARCH" class="btn waves-effect waves-light fbold text-center"  onclick="return validate();"/>
                                        </div>
                                        <!--/ button -->
                                    </form>



 <?php } ?>
<script>
function validate()
{
	var skill=document.getElementById("languages").value;
	if(skill==0)
	{
		alert("Please Select 1 or More Skills");
		document.getElementById("languages").focus();
		return false;
	}
	var PLoc=document.getElementById("PLoc").value;
	if(PLoc==0)
	{
		alert("Please Select Location");
		document.getElementById("PLoc").focus();
		return false;
	}
} 
</script>
<script>
function validate2()
{
	var skill=document.getElementById("languages").value;
	if(skill==0)
	{
		alert("Please Select 1 or More Skills");
		document.getElementById("languages").focus();
		return false;
	}
	
} 
</script>