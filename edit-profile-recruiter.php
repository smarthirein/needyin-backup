<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');  
}		  
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include"source.php" ?>
		<script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
			
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'country_id='+countryID,
                success:function(data){
					
					$("#state").html(data);
                    $("#city").html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#statelist').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
	
        if(stateID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'state_id='+stateID,
                success:function(htmls){
                    $('#city').html(htmls);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});
</script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include 'includes-recruiter/db-recruiter-header.php' ?>
      
        <main>
         
            <section class="db-recruiter">
                <div class="container">
                  
                   <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</h4> </article>
                        </div>
                    </div>
                 
                </div>
               
                <div class="profile-rec">
					<form name="remopic" action="edit-profile.php" method="post" enctype="multipart/form-data">
												
													<input type="submit" name="removepic" class="Waves-effect waves-light btn-blue-sm " value="&#128465;" style="float: left;position: absolute;left: 371px;margin-top: 17px;z-index: 1;">													
												</form>	
<form name="removelogo" action="edit-profile.php" method="post" enctype="multipart/form-data">
												
													<input type="submit" name="removelogo" class="Waves-effect waves-light btn-blue-sm " value="&#128465;" style="float: left;position: absolute;left: 375px;top: 528px;z-index: 1;">													
												</form>		
				<form name="" method="post" action="edit-profile.php" >
                    <div class="container">
                        <div class="row">
                          
                            <div class="col-md-4 col-sm-5 text-center">
                                <div class="profile-left profile-leftedit">
                                    <div class="profile-pic-rec">
                                        <figure class="rec-pic">									
										<?php 																
											$sql = "SELECT ePhoto FROM tbll_emplyer WHERE emp_id='".$rows['emp_id']."'";
											$result = mysqli_query($con,$sql);
											$rows1 = mysqli_fetch_array($result);
											$profileLogo=$rows1['ePhoto']; if($profileLogo){?>
											<img class="img-cover" data-object-fit="cover" src="<?php echo $profileLogo; ?>"><?php } else {?>
															<img class="img-cover" data-object-fit="cover" src="img/js-profile-list-pic.jpg"> 
											<?php } ?>
										<a class="edit-pic" href="#modaledit-picrecruiter"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                           
                                        </figure>
                                         <figcaption class="figcapt"><?php echo ucfirst($rows["contact_name"])?> <span> <?php echo ucfirst($rows["designation"])?>, <?php echo ucfirst($rows["companyname"])?></span></figcaption>
                                        <figure class="logo-company"> 										
											<?php 																			
									$sql = "SELECT eLogo FROM tbll_emplyer WHERE emp_id='".$rows['emp_id']."'";
									$result = mysqli_query($con,$sql);
									$rows1 = mysqli_fetch_array($result);
									$profileLogos=$rows1['eLogo']; if($profileLogos){?>
									<img class="img-contain" data-object-fit="contain" src="<?php echo $profileLogos; ?>"><?php } else {?>
													<img class="img-contain" data-object-fit="contain" src="img/logo.svg">
									<?php } ?>									
										<a class="edit-logo" href="#modal-editlogo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            
                                        </figure>
                                        <p class="pt15 text-center"><?php echo $rows["address1"]?> <?php echo $rows["address2"]?>  </p>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-8 col-sm-7">
                                <div class="profile-right">
                                   
                                    <div class="main-profile-rec eidtmainprofile">
                                        
                                        <div class="row pb15">
                                            <div class="col-md-12">
                                                <h4 class="h4 txt-blue">Personal Details </h4> </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input name="ContactName" id="ContactName" type="text" value="<?php echo ucfirst($rows["contact_name"]);?>" maxlength="45" readonly="true">
                                                    <label for="comp_name">Full Name <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input  type="text" name="designation" id="designation"  maxlength="55" value="<?php echo ucfirst($rows["designation"]);?>" required class="validate">
                                                    <label for="desi">Designation <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="OMobileNo" name="mobile" type="text" maxlength="10" value="<?php echo $rows["contact_num"]?>" readonly="true" >
                                                    <label for="mob1">Mobile Number <span class="mand">*</span></label>
                                                </div>
                                            </div>
											<script>
											 $('#OMobileNo').bind("cut copy paste",function(e) {
												 e.preventDefault();
												});
											</script> 
                                      </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="h4 txt-blue pb15">Company Details </h4> </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input name="CompName" type="text" maxlength="55" value="<?php echo ucfirst($rows["companyname"]);?>" readonly>
                                                    <label for="compname">Company Name</label>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="email" type="text" name="email" maxlength="55" value="<?php echo $rows["emp_email"]?>" readonly>
                                                    <label for="official-email">Official Email ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt10">
                                                <div class="form-group">
                                                   <label>Company Type</label>
                                                    <select class="form-control classic" disabled>
                                                        <option disabled selected>Company type</option>
                                                        <option value="Consultant" <?php if(trim(Consultant)==$rows["company_type"])echo "selected";?>>Consulting</option>
                                                        <option value="Company" <?php if(trim(Company)==$rows["company_type"])echo "selected";?>>Company</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>Industry <span class="mand">*</span></label>
                                                   <?php
													$sql = "SELECT Indus_Name FROM tbl_industry WHERE Indus_Id='".$rows['industry_type']."'";
													$query = mysqli_query($con, $sql);
													$rows1 = mysqli_fetch_array($query);
													$indsName = $rows1['Indus_Name'];
													
													$sql1 = "SELECT Indus_Id,Indus_Name FROM tbl_industry ORDER BY Indus_Name";
													$query1 = mysqli_query($con, $sql1);
													?>
													<select class="form-control classic" name="PIndus" id="PIndus" >
														<option value="0"> Select Industry </option>
														<?php
														while ($rows1 = mysqli_fetch_array($query1))
														{ 
															extract($rows1);
														?>
														<option value="<?php echo $rows1['Indus_Id']; ?>" <?php if($rows1['Indus_Name']==$indsName) echo "selected";?>><?php echo $rows1['Indus_Name']; ?></option>
														<?php } ?>
													</select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="emp-strength">Company Head Count <span class="mand">*</span></label>
												<select class="form-control classic" name="emp-strength" id="emp-strength">
												<option value="">Select Company Head Count</option>
												<option value="1-25" <?php if($rows['EmployerStrength']=="1-25") echo "selected";?>>1-25</option>
												<option value="26-50" <?php if($rows['EmployerStrength']=="26-50") echo "selected";?>>26-50</option>
												<option value="51-100" <?php if($rows['EmployerStrength']=="51-100") echo "selected";?>>51-100</option>
												<option value="101-250" <?php if($rows['EmployerStrength']=="101-250") echo "selected";?>>101-250</option>
												<option value="251-500" <?php if($rows['EmployerStrength']=="251-500") echo "selected";?>>251-500</option>
												<option value="501-1000" <?php if($rows['EmployerStrength']=="501-1000") echo "selected";?>>501-1000</option>
												<option value="1001-2000" <?php if($rows['EmployerStrength']=="1001-2000") echo "selected";?>>1001-2000</option>
												<option value="2001-5000" <?php if($rows['EmployerStrength']=="2001-5000") echo "selected";?>>2001-5000</option>
												<option value="5001-10000" <?php if($rows['EmployerStrength']=="5001-10000") echo "selected";?>>5001-10000</option>
												<option value="10000+" <?php if($rows['EmployerStrength']=="10000+") echo "selected";?>>10000+</option>
												</select>
                                               
                                                    
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-field">
                                                    <input id="add1" name="address1" type="text" maxlength="255" value="<?php echo $rows["address1"]?>">
                                                    <label for="add1">Address Line 1 <span class="mand">*</span></label>
                                                </div>
                                        </div>
                                        </div>
                                        
                                        <div class="row mt10">
										 <div class="col-md-4">
                                                <div class="form-group">
                                                   <label>Select Country <span class="mand">*</span></label>
                                                    <?php
													$sqls = "SELECT Cntry_Name FROM tbl_country where Cntry_Id='".$rows['country_id']."' ";
													$querys = mysqli_query($con, $sqls);
													$rows11 = mysqli_fetch_array($querys);
													$countryname = $rows11['Cntry_Name'];
													
													$sql1 = "SELECT Cntry_Id,Cntry_Name  FROM tbl_country";
													$query1 = mysqli_query($con, $sql1);
													?>
													<select class="form-control classic" name="country" id="country" required>
														<option value="0"> Select Country </option>
														<?php
														while ($rows1 = mysqli_fetch_array($query1))
														{ 
															extract($rows1);
														?>
														<option value="<?php echo $rows1['Cntry_Id']; ?>" <?php if($rows1['Cntry_Name']==$countryname)echo "selected";?>><?php echo $rows1['Cntry_Name']; ?></option>
														<?php } ?>
													</select>
													
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                   <label>Select State <span class="mand">*</span></label>
                                                    <?php
													 $sql = "SELECT states FROM tbl_states where id='".$rows['state_id']."' ";
													$query = mysqli_query($con, $sql);
													$rowss1 = mysqli_fetch_array($query);
													$statename = $rowss1['states'];
													
													$sql1 = "SELECT id,states  FROM tbl_states ORDER By states";
													$query1 = mysqli_query($con, $sql1);
													?>
													
													<select class="form-control classic" name="state" id="state">
														<option value="0"> Select State </option>
														<?php
														while ($rows1 = mysqli_fetch_array($query1))
														{ 
															extract($rows1);
														?>
														<option value="<?php echo $rows1['id']; ?>" <?php if($rows1['states']==$statename)echo "selected";?>><?php echo $rows1['states']; ?></option>
														<?php } ?>
													</select>
													
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                				 <?php  $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location ORDER BY Loc_Name";
													$query = mysqli_query($con, $sql);
													if(!$query)
													echo mysqli_error($con);
													?>
													<label>City <span class="mand">*</span></label>
													<select class="form-control classic" name="loc" id="city" required>	
													<?php
													while ($rows1 = mysqli_fetch_array($query))
													{ 
													 extract($rows1);
													?>
													<option value="<?php echo $Loc_Id; ?>" <?php if(trim($Loc_Id)==$rows["loc_id"])echo "selected";?>><?php echo $Loc_Name; ?></option>
													<?php } ?>
													</select>
													
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="pcode" type="text" name="pincode" maxlength="6" value="<?php echo $rows['pincode']; ?>">
                                                    <label for="pcode">Pincode <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input  type="text"  name="csite" id="PCompurl"  maxlength="100" value="<?php echo $rows['CompanyUrl']; ?>" >
                                                    <label for="pcode">Company Website <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="yrsofreg" type="text"  name="yearreg" maxlength="4" value="<?php echo $rows['YoR']; ?>" onblur="yearValidation(this.value,event)">
                                                    <label for="yrsofreg">Year of Registration <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mt10">
                                                <div class="form-group">
                                                   <label> Type of Registration <span class="mand">*</span></label>
                                                    <select class="form-control classic" name="registype" id="registype">
                                                        <option value="0">Type of Registration</option>
                                                        <option value="Private Limited" <?php if($rows['ToR']=="Private Limited")echo "selected";?>>Private Limited</option>
                                                        <option value="Limited" <?php if($rows['ToR']=="Limited")echo "selected";?>>Limited</option>
                                                        <option value="Multinational Company" <?php if($rows['ToR']=="Multinational Company")echo "selected";?>>Multinational Company</option>
                                                        <option value="Medium level" <?php if($rows['ToR']=="Medium level")echo "selected";?>>Medium level</option>
                                                        <option value="Others" <?php if($rows['ToR']=="Others")echo "selected";?>>Others</option>
                                                    </select>                                                 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <input id="noofbranches" type="text" maxlength="4" value="<?php echo $rows['NoOfBranch']; ?>" name="noofbranches">
                                                    <label for="pcode">Number of Branches <span class="mand">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="btns-editprofile pt15">
										 <input type="submit"  name="editprofile" value="SUBMIT" class="btn waves-effect waves-light" onclick="return validateedit()"/>
											<a href="view-profile-recruiter.php" class="btn btn-flat waves-effect waves-light" data-position="top" data-delay="50"> Cancel </a> 
										</div>
                                       
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
					</form>
                </div>
               
            </section>
           
        </main>
           
            <div id="modaledit-picrecruiter" class="modal editpic-modal">	
			<form name="logos" action="edit-profile.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <h4 class="text-center">Change Profile Picture</h4>
                   
                    <div class="profile-pic-edit text-center">
					 <?php 
																
					$sql = "SELECT ePhoto FROM tbll_emplyer WHERE emp_id='".$_SESSION['empSession']."'";
						$result = mysqli_query($con,$sql);
						$rows1 = mysqli_fetch_array($result);
						$profileLogo=$rows1['ePhoto']; if($profileLogo){?>
							<figure><img class="img-cover" data-object-fit="cover" src="<?php echo $profileLogo; ?>"></figure>
							<?php } else { ?><figure> <img class="img-cover" data-object-fit="cover" src="img/js-profile-list-pic.jpg"> </figure><?php } ?>
                             		
                    </div>
                  
                </div>
                <div class="modal-footer text-center"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> 
				<a class="btn-flat file-field input-field"><span>Upload Picture</span><input type="file" id="logo" name="logo" onchange="return ValidateSingleInput(this)" required></a>
				<a class=" waves-effect waves-green btn-flat"><input type="submit"  name="Savelogo" value="Save" onclick="return logofile()"></a> </div>
            </form>
			</div>
          
            <div id="modal-editlogo" class="modal editpic-modal">
			<form name="logos" action="edit-profile.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <h4 class="text-center">Change Company Logo</h4>
                   
                    <div class="profile-pic-edit logoedit text-center">
					<?php 
																
					$sql = "SELECT eLogo FROM tbll_emplyer WHERE emp_id='".$_SESSION['empSession']."'";
						$result = mysqli_query($con,$sql);
						$rows1 = mysqli_fetch_array($result);
						$profileLogo=$rows1['eLogo']; if($profileLogo){?>
						<figure><img class="img-contain" data-object-fit="contain" src="<?php echo $profileLogo; ?>"></figure>
						<?php } else { ?>
                        <figure><img class="img-contain" data-object-fit="contain" src="img/logo.svg"></figure>
						<?php } ?>
                    </div>
                 
                </div>
                <div class="modal-footer text-center">
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> 
				<a href="#!" class="btn-flat file-field input-field"><span>Upload Logo</span> <input type="file" id="clogo" name="clogo" class="btn-flat file-field input-field" onchange="return ValidateSingleInput(this)" required></a> 
				<a class="waves-effect waves-green btn-flat"><input type="submit"  name="Saveclogo" value="Save" onclick="return clogofile()"> </a> <!--<a href="#!" class=" waves-effect waves-green btn-flat">Delete</a>--> </div>
                </form>
            </div>
			<script type="text/javascript" src="js/objectFitPolyfill.min.js"></script>
<script lang="javascript">
function yearValidation(year,ev) {


var year=document.getElementById('yrsofreg').value;

  var text = /^[0-9]+$/;
  if(ev.type=="blur" || year.length==4 && ev.keyCode!=8 && ev.keyCode!=46) {
    if (year != 0) {
        if ((year != "") && (!text.test(year))) {

            alert("Please Enter Numeric Values Only");
            return false;
        }

        if (year.length != 4) {
            alert("Year is not proper. Please check");
            return false;
        }
        var current_year=new Date().getFullYear();
        if((year < 1920))
            { 
				          alert(year);  alert("Year should be in range 1920 to current year");
            return false;
            }
			else if((year > current_year)){
				alert(year);  alert("Year should be greater than current year");
			}else {
				return true;
			}
        
    } }
}
function ValidateSingleInput(oInput) {
	var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
	
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
}



function logofile()
{
	
	var logo=document.getElementById('logo').files[0].size;
	
	if(logo ==="") {
  alert("Please Upload a file");
		document.getElementById('logo').focus();
		return false;
}
	if(logo>60000)
	{
		
		alert("Profile Picture size is more than 60KB ,please check");
		document.getElementById('logo').focus();
		return false;
	}
	
}

function clogofile()
{
	
	var logo=document.getElementById('clogo').files[0].size;
	
	if(logo ==="") {
  alert("Please Upload a file");
		document.getElementById('clogo').focus();
		return false;
}
	if(logo>60000)
	{
		
		alert("Profile Picture size is more than 60KB ,please check");
		document.getElementById('clogo').focus();
		return false;
		
	}
	
}


function validateedit()
{
				var designation=document.getElementById('designation').value;
            	if(designation=="")
            	{
            		alert("Please Enter Your Designation");
            		document.getElementById('designation').focus();
            		return false;
            	}
				var indtype=document.getElementById('PIndus').value;
            	if(indtype=="0")
            	{
            		alert("Please Select Your Industry type");
            		document.getElementById('PIndus').focus();
            		return false;
            	}
				
				var empstrength=document.getElementById('emp-strength').value;
            	if(empstrength=="")
            	{
            		alert("Please Give Your Head count");
            		document.getElementById('emp-strength').focus();
            		return false;
            	}
				
				
				var address=document.getElementById('add1').value;
				if(address==" ")
            	{
            		alert("Please Enter Your Address");
            		document.getElementById('add1').focus();
            		return false;
            	}
				
				var country=document.getElementById('country').value;
				if(country=="0")
            	{
            		alert("Please Select Your Country");
            		document.getElementById('country').focus();
            		return false;
            	}
				var state=document.getElementById('state').value;
				if(state=="0")
            	{
            		alert("Please Select Your State");
            		document.getElementById('state').focus();
            		return false;
            	}
				
				var city=document.getElementById('city').value;
				if(city=="0")
            	{
            		alert("Please Select Your City");
            		document.getElementById('city').focus();
            		return false;
            	}
				
			
				
				var address=document.getElementById('pcode').value;
				if(address=="")
            	{
            		alert("Please Enter Your Pincode");
            		document.getElementById('pcode').focus();
            		return false;
            	}
				
				 var PCompname = document.getElementById('PCompurl').value;
				
                        if ((PCompname == 0) || (PCompname == "")) {
                            alert("Please Enter Company URL");
                            document.getElementById('PCompurl').focus();
                            return false;
                        }
				var yrsofreg=document.getElementById('yrsofreg').value;
				if(yrsofreg=="")
            	{
            		alert("Please Enter Your Year of Registration");
            		document.getElementById('yrsofreg').focus();
            		return false;
            	}

var registype=document.getElementById('registype').value;
				if(registype=="0")
            	{
            		alert("Please Enter Your  Registration type");
            		document.getElementById('registype').focus();
            		return false;
            	}
				

var noofbranches=document.getElementById('noofbranches').value;
				if(noofbranches=="")
            	{
            		alert("Please Enter Your No. of Branches");
            		document.getElementById('noofbranches').focus();
            		return false;
            	}
				
}


</script>
          
</body>

</html>