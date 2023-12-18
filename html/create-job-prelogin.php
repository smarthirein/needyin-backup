<?php
session_start();
require_once 'class.user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('.tooltipped').tooltip({
                    delay: 50
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#describe-job-prelogin").Editor();
            });
        </script>
		        <script>
            $(document).ready(function () {
             
                    $('#notshow').change(function(){
                    if(this.checked)
                        $('#chck').hide();
                    else
                        $('#chck').show();
                    });
            });
        </script>
</head>
<body>
    <?php include "includes-recruiter/prelogin-header-recruiter.php"; ?>
      
        <main>
           
            <section class="jobpost-prelogin">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-12">
                            <div class="signin-main signup">
                                <div class="signin-in">
                                    <!-- sign in-->
                                    <div id="signin">
                                        <h3 class="h3 text-center flight">CREATE YOUR <span class="fbold txt-blue">FREE JOB </span></h3>
                                        <!-- responsive tab -->
                                        <div class="newjob-form">
                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button class="btn waves-effect waves-light">Continue Job Post</button>
                                                </div>
                                            </div>
											 <form action="create-job-prelogin-info.php" method="POST" name="RecruiterJobC">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
                                   <input name="PJobName" type="text" id="PJobName" maxlength="20" required	>
                                    <label for="Job Name">Enter Job name<span class="mand">*</span></label>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="input-field">
                                    <select  name="PSkills[]" id="PSkills" multiple>
                                        <option value="" disabled >Select Multiple Skills<span class="mand">*</span></option>
                                        <?php 
                                            $sql = "SELECT skill_Name,skill_Id FROM tbl_masterskills WHERE skill_Status=1";
                                            $query = mysqli_query($con, $sql);
                                            if(!$query)
                                            echo mysqli_error($con);
                                            while ($row1 = mysqli_fetch_array($query))
                                            { 
                                                extract($row1);
                                                ?>
                                                <option value="<?php echo $row1['skill_Id'];?>"><?php echo $row1['skill_Name']; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                <?php

									$sql = "SELECT Loc_Id,Loc_Name FROM tbl_location ORDER BY Loc_Name";
									$query = mysqli_query($con, $sql);
									if(!$query)
									echo mysqli_error($con);
									?>
									
									<select name="PLoc" id="PLoc" required>
									<option value="0"> Select Preferred Location <span class="mand">*</span></option>
									<?php
									while ($row1 = mysqli_fetch_array($query))
									{ 
									 extract($row1);
									?>
									<option value="<?php echo $Loc_Id; ?>"><?php echo $Loc_Name; ?></option>
									<?php } ?>
									</select>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-md-2">
                                <div class="input-field">
                                    <select name="PMinE"    id="PMinE" required>
                                        <option value="" disabled selected>Min Exp<span class="mand">*</span></option>
                                         
										<?php for($i=0;$i<=30;$i=$i+1){  ?>
                                        <option value="0<?php echo $i ?>"><?php echo $i ?> Year</option>
                                       
										<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-field">
                                <select name="PMaxE"   id= "PMaxE"required>
                                        <option value="" disabled selected>Max Exp<span class="mand">*</span></option>
                                        <?php for($i=0;$i<=30;$i=$i+1){  ?>
                                        <option value="0<?php echo $i ?>"><?php echo $i ?> Year</option>
                                       
										<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                <select name="PSal" id="PSal" required>
                                        <option value="" disabled selected>Salary Range Yearly<span class="mand">*</span></option>                                        										
										<?php for($i=0;$i<=30;$i=$i+1){  ?>
                                       <option value="<?php echo $i+1 ?>"><?php echo $i ?> - <?php echo $i+1 ?> Lakhs</option>
                                       
										<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                   <input name="PCompname" id="PCompname" type="text" required>
                                    <label for="Company Name">Company Name<span class="mand">*</span></label>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
                                 <input name="PCompurl" type="text" id="PCompurl">
                                    <label for="Company Name">Company Website URL</label>
                                </div>
                            </div>
                        </div>
                     
                        <div class="row jobdescribe">
                            <div class="col-md-12">
                                <label>Job Description<span class="mand">*</span></label>
                                <textarea id="describe-job" name="PJobdesc"  required></textarea>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
                            <?php
$sql1 = "SELECT Qual_Id,Qual_Name FROM tbl_qualification";
$query1 = mysqli_query($con, $sql1);
if(!$query1)
echo mysqli_error($con);
?>
<select name="PEduc" id= "PEduc" required>
								<option value="0"> Select Education <span class="mand">*</span>
<?php
while ($row1 = mysqli_fetch_array($query1))
{ 
 extract($row1);
?>
<option value="<?php echo $Qual_Id; ?>"><?php echo $Qual_Name; ?></option>
<?php } ?>
</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                     <?php
$sql2 = "SELECT Speca_Id,Speca_Name FROM tbl_specialization";
$query2 = mysqli_query($con, $sql2);
if(!$query2)
echo mysqli_error($con);
?>
									<select name="PSpeca" id="PSpeca" required>
										<option value="0"> Select Specialization <span class="mand">*</span></option>
<?php
while ($row1 = mysqli_fetch_array($query2))
{ 
 extract($row1);
?>
<option value="<?php echo $Speca_Id; ?>"><?php echo $Speca_Name; ?></option>
<?php } ?>
</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                                                       <?php

$sql3 = "SELECT University_Id,University_Name FROM tbl_university";
$query3 = mysqli_query($con, $sql3);
if(!$query3)
echo mysqli_error($con);
?>
<select name="PUniver" id="PUniver" required>
									<option value="0"> Select University <span class="mand">*</span></option>
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
                            <div class="col-md-4">
                                <div class="input-field">
                                <?php
$sql4 = "SELECT Indus_Id,Indus_Name FROM tbl_industry";
$query4 = mysqli_query($con, $sql4);
if(!$query4)
echo mysqli_error($con);
?>
<select name="PIndus" id="PIndus" required>
									<option value="0"> Select Industry <span class="mand">*</span></option>
<?php
while ($row1 = mysqli_fetch_array($query4))
{ 
 extract($row1);
?>
<option value="<?php echo $Indus_Id; ?>"><?php echo $Indus_Name; ?></option>
<?php } ?>
</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
<?php
$sql5 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea";
$query5 = mysqli_query($con, $sql5);
if(!$query5)
echo mysqli_error($con);
?>
									<select name="PFunct"  id="PFunct" required>
									<option value="0"> Select Function<span class="mand">*</span> </option>
<?php
while ($row1 = mysqli_fetch_array($query5))
{ 
 extract($row1);
?>
<option value="<?php echo $Func_Id; ?>"><?php echo $Func_Name; ?></option>
<?php } ?>
</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                 <input name="PAchive" type="text">
                                    <label for="achivements">Achivements</label>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
                               <select multiple name="PAward" id="PAward" required>
                                        <option value="" disabled >Awards / Rewards <span class="mand">*</span></option>
                                        <option value="1">Awards </option>
                                        <option value="2">Patenets</option>
                                        <option value="3">Publications </option>
                                        <option value="4">Certifications</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                 <select multiple name="PLang" id="PLang" required>
                                        <option value="" disabled >Select Languages <span class="mand">*</span></option>
                                        <option value="1">Hindi </option>
                                        <option value="2">English</option>
                                        <option value="3">Telugu </option>
                                        <option value="4">Bengali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                   <select multiple name="PCitizen" id="PCitizen" required>
                                        <option value="" disabled >citizenship <span class="mand">*</span></option>
                                        <option value="1">Indian </option>
                                        <option value="2">American</option>
                                        <option value="3">Canadian </option>
                                        <option value="4">Algeria</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                       <div class="row">
                            <div class="col-md-4 seldiv"> <span>Job Type</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" value="Perment"  id="perm"  name="Pperm" />
                                            <label for="perm">Permanent</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" value="Cont" id="cont" name="Pperm" />
                                            <label for="cont">Contractor</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 seldiv"> <span>Employment Type</span>
                                <div class="row" >
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
                            <div class="col-md-4 seldiv"> <span>Gender</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="male" name="Gender" value="Male" />
                                            <label for="male">Male</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="female" name="Gender" value="Female" />
                                            <label for="female">Female</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-field">
                        <?php
							$sql6 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country";
							$query6 = mysqli_query($con, $sql6);
							if(!$query6)
							echo mysqli_error($con);
							?>
							<select name="PVisa" multiple>
							<option value="0" disabled> Visa for Countries </option>
							<?php
							while ($row1 = mysqli_fetch_array($query6))
							{ 
							 extract($row1);
							?>
							<option value="<?php echo $Cntry_Id; ?>"><?php echo $Cntry_Name; ?></option>
							<?php } ?>
							</select>
                                </div>
                            </div>
                                 <div class="col-md-4 seldiv"> <span>Willing to Travel</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="Yes" name="wtt" value="Yes" />
                                            <label for="Yes">Yes</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="no" name="wtt" value="No" />
                                            <label for="no">No</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 seldiv"> <span>Passport</span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio"  id="pYes" name="Passport" value="Yes" />
                                            <label for="pYes">Yes</label>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            <input type="radio" id="pno" name="Passport" value="No" />
                                            <label for="pno">No</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                   <div class="row">
                            <div class="col-md-12">
                                <h4 class="txt-blue h4">Employment Details</h4>
                                <p>
                                    <input type="checkbox" id="notshow" />
                                    <label for="notshow">Do not show to Jobseekar</label>
                                </p>
                            </div>
                        <div id="chck">
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input name="recName" id="recName" type="text">
                                    <label for="rec">Recruiter Name:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="add" type="text" name="address" required>
                                    <label for="add">Address</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input id="connumb" maxlength="10" type="text" name="cnumber" onkeypress="return isNumber()" required>
                                    <label for="connumb">Contact Number</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-field">
                                    <input name="emailName" id="emailName" type="email"  required>
                                    <label for="email">Email ID</label>
                                </div>
                            </div>
                        </div>
                        </div>
                      
                        <div class="row btndiv">
                            <div class="col-md-12">
								<input type="submit" value="Create Job" class="btn waves-effect waves-light" name="btn-CreateJob"  onclick="return validate();"  />
								<a class="btn waves-effect waves-light" href="index.php"> Cancel </a>
                              
                            </div>
                        </div>
                            </form>  <div class="row btndiv">
                                                <div class="col-md-12">
												<a class="btn waves-effect waves-light" href="create-job-prelogin.php"> Continue Job Post </a>                                                   
                                                </div>
                                            </div>
                                           
                                        </div>
                                       
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
            <script>
                $('.responsive-tabs').responsiveTabs({
                    accordionOn: ['xs', 'sm']
                });
				function isNumber(evt) 
{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
	{
        return false;
    }
   else
   {
		return true;
   }
}
				function validate()
            { 
			
			


				var name=document.getElementById('PJobName').value;
            	if(name== "" )
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
				
				
				var exp=document.getElementById('PMinE').value;
				var expmon=document.getElementById('PMaxE').value;
            	if(exp==0&&expmon==0)
            	{
            		alert("Please Give Experience");
            		document.getElementById('PMinE').focus();
            		return false;
            	}
				if(exp > expmon)
				{
					alert("Minimum experience can't be more than maximum experience"+exp+"  "+ expmon);
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
				
				
				var PCompname=document.getElementById('PCompname').value;
            	if(PCompname=="")
            	{
            		alert("Please give your company name");
            		document.getElementById('PCompname').focus();
            		return false;
            	}
				
				
				var PJobdesc=document.getElementById('describe-job').value;
            	if(PJobdesc.length<250)
            	{ var df=250-PJobdesc.length;
            		alert("Description must be atleast 250  characters ,You have to enter  "+ df+ "  more Characters");
            		document.getElementById('describe-job').focus();
            		return false;
            	}
				
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
				
	
				var PAward=document.getElementById('PAward').value;
            	if(PAward==0)
            	{
            		alert("Please give your Awards");
            		document.getElementById(PAward).focus();
            		return false;
            	}
				
				
				var PLang=document.getElementById('PLang').value;
            	if(PLang==0)
            	{
            		alert("Please give your Languages");
            		document.getElementById('PLang').focus();
            		return false;
            	}
				
				
				
				var PCitizen=document.getElementById('PCitizen').value;
            	if(PCitizen==0)
            	{
            		alert("Please give your Citizen ship");
            		document.getElementById('PCitizen').focus();
            		return false;
            	}
		
				
				var permanent = document.getElementsByName("Pperm");
			var Pperm = false;

			var i = 0;
			while (!Pperm && i < permanent.length) {
        if (permanent[i].checked) Pperm = true;
        i++;        
				}

			if (!Pperm) 
			{alert("Please check Job Type!");
				return Pperm;
				}
				var emptype = document.getElementsByName("PFull");
			var PFull = false;

			var i = 0;
			while (!PFull && i < emptype.length) {
        if (emptype[i].checked) PFull = true;
        i++;        
				}

			if (!PFull) 
			{alert("Please check Employement type!");
				return PFull;
				}
				
				var radiosgender = document.getElementsByName("Gender");
			var Gender = false;

			var i = 0;
			while (!Gender && i < radiosgender.length) {
        if (radiosgender[i].checked) Gender = true;
        i++;        
				}

			if (!Gender) 
			{alert("Please check gender!");
				return Gender;
				}
				
				var recName=document.getElementById('recName').value;
            	if(recName=="")
            	{
            		alert("Please give recruiters name");
            		document.getElementById('recName').focus();
            		return false;
            	}
				var add=document.getElementById('add').value;
            	if(add=="")
            	{
            		alert("Please give your Address");
            		document.getElementById('add').focus();
            		return false;
            	}
				var connumb=document.getElementById('connumb').value;
            	if(connumb=="")
            	{
            		alert("Please give your contact number");
            		document.getElementById('connumb').focus();
            		return false;
            	}
				var PFunct=document.getElementById('emailName').value;
            	if(emailName=="")
            	{
            		alert("Please give your Email");
            		document.getElementById('emailName').focus();
            		return false;
            	}
				
			}
            </script>
        </main>
       
        <?php include"footer.php"?>
</body>

</html>