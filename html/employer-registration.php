<?php

require_once("config.php");
require_once 'class.user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include "source.php"; ?>

	
</head>

<body>
    <?php include "includes-recruiter/prelogin-header-recruiter.php"; ?>
        
        <main>
         
            <section class="new-employer-registration">
               
                <div class="registration-banner">
                    <div class="container">
                        <article>
                            <h3 class="txt-white h3 flight">New Employer <span class="fbold txt-blue">Registration</span></h3>
                           
                        </article>
                    </div>
                </div>
               
                <div class="container">
                    <div class="row">
                   
                        <div class="col-md-8 col-sm-12">
                            <div class="registration-form">
                               <div class="registration-title">
                                   <h4 class="h4 flight">Create your <span class="fbold">Account Details</span></h4>
                               </div>
								<form method="post" action="employer-info.php" name="employer-info" class="form-employer-reg"  enctype="multipart/form-data">
                                    <div class="row">
									
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="email" class="validate" name="email" id="email" maxlength="55" required title="Enter your official Email ID" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                                                <label>Official Email ID <span class="mand">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="text" class="validate" name="comname" id="comname" maxlength="55" required title="Enter your Company Name">
                                                <label>Company Name<span class="mand">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="password" class="validate" name="password" id="password" maxlength="55" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%#^*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character" required>
                                                <label>Password <span class="mand">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="password" class="validate" name="cpassword" id="cpassword" maxlength="55" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%#^*?&])[A-Za-z\d$@$!#^%*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character" required>
                                                <label>Confirm Password<span class="mand">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 mt15">
                                            <div class="form-group">
                                               <label>Organisation Type <span class="mand">*</span> </label>
                                                <select class="form-control classic" name="ctype" id="org_type" required>
                                             
													
                                                    <option value="Company">Company</option>
                                                    <option value="Consultant">Consultant</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 mt15">
                                            <div class="form-group">
                                            <label>Industry Type <span class="mand">*</span> </label>
											<?php
												$sql2 = "SELECT Indus_Id,Indus_Name FROM tbl_industry ORDER BY Indus_Name";
												$query2 = mysqli_query($con, $sql2);
												if(!$query2)
												echo mysqli_error($con);
												?>
												<select class="form-control classic"  name="industry_type" id="industry_type" required >
												
												<?php
												while ($row2 = mysqli_fetch_array($query2))
												{ 
												 extract($row2);
												?>
												<option value="<?php echo $row2['Indus_Id']; ?>" <?php if(trim($row2['Indus_Id'])== "36"){ echo "selected";}else { echo "";}?>><?php echo $row2['Indus_Name']; ?></option>
												<?php } ?>
												</select>											
												
                                            </div>
                                        </div>
                                                                             
									
										 <div class="col-md-6 col-xs-6 col-sm-6 ">
                                                       <label class="cus-lab">Attach ROC <span class="mand">* </span> <span class="desc-tr" style="font-size:8px !important;"> <small>( Accepted formats: pdf, jpeg, png | Size &lt; 256KB)</small></span></label>
                                                        <div class="file-field input-field mt5">
                                                          
                                                            <div class="btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="Attach your ROC Document " data-tooltip-id="9733f4f1-111c-0653-27df-7ad9782209a7"> <span> Attachment </span>
                                                                <input type="file" name="roc" id="roc" onchange="Validateresume(this)"> <i class="fa fa-info-circle" aria-hidden="true"></i></div>
                                                            <div class="file-path-wrapper">
                                                                <input class="file-path validate" type="text" placeholder="Upload ROC File"> </div>
                                                        </div>
                                                         
                                                    </div>
													<div class="col-md-6 col-xs-6 col-sm-6 ">
													  <div class="form-group">
                                            <label>Company Identification Number <span class="mand">*</span> </label>
													<input type="text" class="validate" name="cin" id="cin" maxlength="50"  title="Enter company identification number" placeholder="Enter company identification number">
                                               </div>
													</div>
										
													<div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="input-field ">
                                                <input type="text" class="validate" name="address1"id="address1" maxlength="100" required title="Enter company's address">
                                                <label>Address <span class="mand">*</span></label>
                                            </div>
                                        </div> 
                                        <div class="col-md-6 col-xs-12 col-sm-6 mt15">
                                            <div class="form-group">
                                            <label>Country <span class="mand">*</span> </label>
												<?php 											
												$sql2 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country where Cntry_Id=101 ORDER BY Cntry_Name ASC";
												$query2 = mysqli_query($con, $sql2);
												if(!$query2)
												echo mysqli_error($con);
												?>
												<select class="form-control classic" name="country" id="country" required >
												<option value="0"></option>
												<?php
												while ($row2 = mysqli_fetch_array($query2))
												{ 
												 extract($row2);
												?>
												<option value="<?php echo $row2['Cntry_Id']; ?>"><?php echo $row2['Cntry_Name']; ?></option>
												<?php } ?>
												</select>
												                                              
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 mt15">
                                            <div class="form-group">
                                            <label> State <span class="mand">*</span> </label>
												<select class="form-control classic" name="state" id="state">
													<option value=""></option>
												</select>
											</div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                             <label>City <span class="mand">*</span> </label>
												<select class="form-control classic" name="city" id="city">
													<option value=""></option>
												</select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 mt-10">
                                            <div class="input-field ">
                                                <input type="text" class="validate" name="pincode" pattern=".{6,}"  id="pincode" maxlength="6" onkeypress="return isNumber()" required title="Enter pincode">
                                                <label>Pin-code<span class="mand">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                       <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="text" class="validate" name="cnumber" id="cnumber" maxlength="10" onkeypress="return isNumber()" pattern = ".{10,}" required title="mobile number should be 10 digits">

                                                
                                                <label>Contact Number<span class="mand">*</span></label>
                                            </div>
                                        </div>
										<script>
											 $('#cnumber').bind("cut copy paste",function(e) {
												 e.preventDefault();
												});
											</script> 
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="input-field ">
                                                <input type="text" class="validate" name="cname" id="cname" maxlength="55" required title="Enter your name">
                                                <label>Contact Name<span class="mand">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="input-field nomrgtop">
                                                <p>
                                                   <!-- <input type="checkbox" id="t22" name="terms" value="checked" onclick="return false;" onkeydown="return false;"/>-->
													<input type="checkbox" id="t22" name="terms" value="checked"/>
                                                    <label for="t22">I Agree to the <a href="#terms-pop-rec">Terms & Conditions</a></label>
                                                </p>
												<script>
												function termschecked(){
													var terms=document.getElementById('t22').checked=true;
												}
												</script>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="input-field nomrgtop">
											 <input type="submit"  name="Empinfo" value="Register" class="btn btn-blue-sm waves-effect waves-light" onclick="return validate()"/>
                                               
                                                <a href="index-recruiter.php" class="btn btn-blue-sm waves-effect waves-light">CANCEL</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-xs-12 col-sm-12">
                            <!-- registration contact details -->
                            <div class="reg-contact-details">
                                <h4 class="txt-blue h4 flight">For Sales Enquiries</h4> <address>
                                  
                                   		<p>Hyderabad: <span class="fbold">040-69990030</span></p>
                                        <p>Bangalore: <span class="fbold">080-65693030</span></p>
                                        <p>Email: <span class="fbold">sales@needyin.com</span></p>
                                </address> 
                                <h4 class="txt-blue h4 flight">For Support</h4> <address>
                                    
                                  
                                     <p>Email:  <span class="fbold">support@needyin.com</span></p>
                                </address>
								<h4 class="txt-blue h4 flight">For Enquiries</h4> <address>
                                    
                                 
                                     <p>Email:  <span class="fbold">info@needyin.com</span></p>
                                </address>
							</div>
                            
                        </div>
                       
                    </div>
                </div>
              
            </section>
          
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
			<script lang="javascript">
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
function Validateresume(oInput) {
	var _validFileExtensions = [".jpg",".jpeg",".pdf",".gif",".png"];    
	
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
function validate()
            { 
	
			var email=document.getElementById('email').value;
            	if(email=="")
            	{
            		alert("Please Enter Your email");				
            		document.getElementById('email').focus();
            		return false;
            	}
				if(!emailverify(email))
				{
					document.getElementById('email').focus();
            		return false;					
				}
				var rejectList = [ "gmail.com" , "yahoo.com","outlook.com","hotmail.com" ];
				var emailValue = document.getElementById('email').value; 
				var splitArray = emailValue.split('@'); 
				if(rejectList.indexOf(splitArray[1]) >= 0)
				{
					alert("Can't use public domain emails");
					return false;
				}				
				var cname=document.getElementById('comname').value;
            	if(cname== "" )
            	{
            		alert("Please Enter your Company name");
            		document.getElementById('comname').focus();
            		return false;
            	}
				var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})");
				var pwd=document.getElementById('password').value;
				var cpwd=document.getElementById('cpassword').value;
            	if(!strongRegex.test(pwd))
            	{
            		alert("Password must contain a Upper case character, a Lower case character ,\nOne number and a Special characters !@#\$%\^&\* with minumum length of 8 characters");
            		document.getElementById('password').focus();
            		return false;
            	}
				if(pwd!=cpwd)
            	{

            		alert("Password and Confirm Password are not same,Please check again");
            		document.getElementById('password').focus();
            		return false;
            	}				
				var ctypes=document.getElementById('org_type').value;
            	if(ctypes == "0")
            	{
            		alert("Please Select Your Organisation Type");
            		document.getElementById('org_type').focus();
            		return false;
            	}				
				var indtype=document.getElementById('industry_type').value;
            	if(indtype=="0")
            	{
            		alert("Please Select Your Industry type");
            		document.getElementById('industry_type').focus();
            		return false;
            	}
				var cin=document.getElementById('cin').value;
				if(document.getElementById("roc").files.length <= 0 && cin =="")
				{
				alert("Attach ROC (or) Enter CIN");				
				return false;
				}
				var address=document.getElementById('address1').value;
				if(address=="")
            	{
            		alert("Please Enter Your Address");
            		document.getElementById('address1').focus();
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
				if(state=="")
            	{
            		alert("Please Enter Your Current State");
            		document.getElementById('state').focus();
            		return false;
            	}
				
				var clocemp=document.getElementById('city').value;
            	if(clocemp=="")
            	{
            		alert("Please Select  Location");
            		document.getElementById('city').focus();
            		return false;
            	}
				var plocemp=document.getElementById('pincode').value;
            	if(plocemp =="")
            	{
					
            		alert("Please Enter Pincode ");
            		document.getElementById('pincode').focus();
            		return false;
            	}
				 var mobnum1 = document.getElementById('pincode').value;
                                if (mobnum1.length != 6) {
                                    alert("Please Enter Valid Pincode");
                                    document.getElementById('pincode').focus();
                                    return false;
                                }
				if(plocemp.length>6)
            	{
            		alert("PIN Code can have max of six digits");
            		document.getElementById('pincode').focus();
            		return false;
            	}				
            	var contnumber=document.getElementById('cnumber').value;            	
            	if(contnumber =="")
            	{
            		alert("please give ur contact number");
            		document.getElementById('cnumber').focus();
            		return false;
            	}
				 var mobnum = document.getElementById('cnumber').value;
                                if (mobnum.length != 10) {
                                    alert("Please Enter Valid Contact Number");
                                    document.getElementById('cnumber').focus();
                                    return false;
                                }
				
					var cname=document.getElementById('cname').value;
            	if(cname =="")
            	{
            		alert("Please Give your contact name");
				
					
            		document.getElementById('cname').focus();
            		return false;
            	}
			
            	if(document.getElementById('t22').checked==false)
            	{
            		alert("Please agree to our Terms and Conditions");
            		document.getElementById('t22').focus();
            		return false;
            	}
			           	else 
            	{
            		return true;
            	}
				
            }





</script>       
        </main>
       
       
        
        
     
  <div id="terms-pop-rec" class="modal">
    <div class="modal-content">
      <h4 class="h4">Terms &amp; Conditions for Registration for Recruiter With Needyin</h4>
      <p class="text-justify">Needyin Pvt. Ltd. shall place the information relating to vacancies on Needyin jobs board or such other classified sections on the website www.needyin.comor such other mirror or parallel site(s) or in allied publications as NI may deem fit and proper but such additional web hosting shall be without any extra cost to the subscriber/user.</p> <p class="text-justify">
The insertion so displayed in the classified section of Needyin shall be for a fixed period, which period is subject to change without notice. Every instance of refreshing and existing listing entitles you to and additional fixed period starting from the date on which the listing is refreshed and shall be counted as fresh posting.</p> <p class="text-justify">
Needyin Pvt. Ltd. offers no guarantee nor warranties that there would be a satisfactory response or any response at all subscriber for applications.</p> <p class="text-justify">
Needyin Pvt. Ltd. shall in no way be held liable for any information received by the subscriber and it shall be the sole responsibility of the subscriber to check, authenticate and verify the information/response received at its own cost and expense.</p> <p class="text-justify">
Any actions taken by an employer/recruiter on the basis of the background check report or otherwise, is the employer's/recruiter's responsibility alone and NI will not be liable in any manner for the consequences of such action taken by the user.</p> <p class="text-justify">
Needyin Pvt. Ltd. reserves its right to suspend/terminate the services contracted for by the subscriber either prior to or during the contracted period without assigning any reason. In such an eventuality, any amount so paid for by the subscriber for this service, may be refunded by NI at a prorata basis to the subscriber at its discretion.</p> <p class="text-justify">
Needyin Pvt. Ltd. reserves its right to reject any insertion or information/data provided by the subscriber without assigning any reason either before uploading or after uploading the vacancy details, but in such an eventuality, any amount so paid for, may be refunded to the subscriber on a pro-rata basis at the sole discretion of NI.</p> <p class="text-justify">
By posting/uploading a job posting on the website you confirm that you have obtained all licenses/permits as are necessary for recruitment and to indemnify Needyin Pvt. Ltd. against all claims, damages arising out of actions/claims that may be made in relation to the same.</p> <p class="text-justify">
Needyin Pvt. Ltd. has the right to make all such modifications/editing of the vacancy details in order to fit its database.
All information intimated by the subscriber/recruiter and displayed by NI on Needyin becomes public knowledge and NI may at its sole discretion include the vacancy intimated by a subscriber for display on Needyin in any other media including the print media at no extra costs to the subscriber and NI shall not be held liable for usage/publicity of such information.</p> <p class="text-justify">
NI offers no guarantee nor warranties that there would be a satisfactory response or any at all response once the job is put on display.
NI shall in no way be held liable for any information received by the subscriber and it shall be the sole responsibility of the subscriber to check, authenticate and verify the information/response received at its own cost and expense.</p> <p class="text-justify">
NI would not be held liable for any loss of data, technical or otherwise, information, particulars supplied by the subscriber, due the reasons beyond its control like corruption of data or delay or failure to perform as a result of any causes or conditions that are beyond NI’s reasonable control including but not Ltd. to strike, riots, civil unrest, Govt. policies, tampering of data by unauthorized persons like hackers, war and natural calamities.</p> <p class="text-justify">
Needyin Pvt. Ltd. will commence providing services only upon receipt of amount/charges upfront either from the subscriber or from a third party on behalf of the subscriber.</p> <p class="text-justify">
The Subscriber/Recruiter shall be deemed to give an undertaking to NI that the jobs sought to be advertised on the classified section of Needyin are in existence, are genuine and that the subscriber/recruiter has the authority to advertise for such jobs.
Needyin Pvt. Ltd. will commence providing services only upon receipt of amount/charges upfront either from the subscriber or from a third party on behalf of the subscriber.</p> <p class="text-justify">
The Subscriber/Recruiter must give an undertaking to NI that there will be no fee charged from any person who responds to jobs advertised on the classified section of Needyin for processing of applications/responses from such person.
NI reserves its right to change the look, feel, design, prominence, depiction and classification of the classified section of Needyin at any time without assigning any reason and without giving any notice.</p> <p class="text-justify">
The subscriber can select password’s to post vacancies on the site in agreed upon section(s), but the sole responsibility of the safe custody of the password shall be that of the subscriber and NI shall not be responsible for data loss/theft of data/corruption of data or the wrong usage/misuse of the password and any damage or leak of information and its consequential usage by a third party. NI undertakes to take all reasonable precautions at its end to ensure that there is no leakage/misuse of the password granted to the subscriber.</p> <p class="text-justify">
The information on NI is for use by its subscribers alone and does not authorize the subscriber to download and use the data for commercial purposes. In case of violation NI at its discretion may suspend its service/subscription and also may take such action as it may be advised.</p> <p class="text-justify">
The subscriber shall not use/circulate/forward a person's resume/profile hosted on the NI Network to his/her current employer as mentioned by the person in his / her resume /profile.</p> <p class="text-justify">
The User of these services does not claim any copyright or other Intellectual Property Right over the data uploaded by him/her on the website
All disputes arising out of the transactions between a user and NI will be resolved in accordance with the laws of India as applicable.
All Disputes arising out of the transactions between a user and NI will be subject to the jurisdiction of Courts situate in Hyderabad alone.</p> <p class="text-justify">
Charges
This Site reserves the right to charge subscription and/or membership fees in respect of any part, aspect of this Site upon reasonable prior notice. NI reserves its right to terminate your account without any prior notice for any violation of the Terms of Use. All content posted by you becomes the property of NI and you agree to grant/assign the royalty free, perpetual right to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, perform and display such content (in whole or part) worldwide and/or to incorporate it in other works in any form, media or technology now known or later developed.</p> <p class="text-justify">
Disclaimer of Warranties and Liability
All the contents of this Site are only for general information or use. They do not constitute advice and should not be relied upon in making (or refraining from making) any decision. Any specific advice or replies to queries in any part of the site is/are the personal opinion of such experts/consultants/persons and are not subscribed to by this Site. The information from or through this site is provided on "AS IS" basis, and all warranties, expressed or implied of any kind, regarding any matter pertaining to any goods, service or channel, including without limitation, the implied warranties of merchantability, fitness for a particular purpose, and non-infringement are disclaimed and excluded. Certain links on the Site lead to resources located on servers maintained by third parties over whom NI has no control or connection, business or otherwise as these sites are external to NI you agree and understand that by visiting such sites you are beyond the Needyin website. NI therefore neither endorses nor offers any judgment or warranty and accepts no responsibility or liability for the authenticity/availability of any of the goods/services/or for any damage, loss or harm, direct or consequential or any violation of local or international laws that may be incurred by your visit and/or transaction/s on these sites.</p> <p class="text-justify">
Advertising Material
Part of the Site might contain advertising/other material submitted to NI by third parties. Responsibility for ensuring that material submitted for inclusion on the site complies with applicable International and National law is exclusively on the advertisers and NI will not be responsible for any claim, error, omission or inaccuracy in advertising material. NI reserves the right to omit, suspend or change the position of any advertising material submitted for insertion. Acceptance of advertisements on the Site will be subject to NI terms and conditions which are available on request.</p> <p class="text-justify">
Force Majeure
NI shall have no liability to you for any interruption or delay in access to the Site irrespective of the cause.</p> <p class="text-justify">
Indian Law
The Agreement shall be governed by the Laws of India. The Courts of law at Hyderabad shall have exclusive jurisdiction over any disputes arising under this agreement.</p> <p class="text-justify">
ANTI SPAM POLICY
The use and access to jobseeker data is subject to this policy. The services provided to you are aimed at providing recruitment solutions and should be restricted to contacting suitable candidates for genuine jobs in existence.
Mailing practices such as transmitting marketing and promotional mailers/ Offensive messages/ messages with misleading subject lines in order to intentionally obfuscate the original message, are strictly prohibited.
We reserve the right to terminate services, without prior notice, to the originator of Spam. No refund shall be admissible under such circumstances.</p> <p class="text-justify">
Following is an illustrative (not exhaustive) list of the kinds of messages which can be classified as spam:</p> <p class="text-justify">
•	Unsolicited Bulk Messages/Unsolicited Commercial Communications.</p> <p class="text-justify">
•	Voice Calls/SMS to telephone numbers registered on the National Consumer Preference Register.</p> <p class="text-justify">
•	Non Job related mails.</p> <p class="text-justify">
•	Messages with misleading subject lines.</p> <p class="text-justify">
•	Blank Messages.</p> <p class="text-justify">
•	Extra ordinary High Number of mails.</p> <p class="text-justify">
•	Mails soliciting payments.</p> <p class="text-justify">
Users agree to indemnify and hold harmless NI from any damages or claims arising out of usage for transmitting spam.</p> <p class="text-justify">
Users are advised to change their passwords frequently in order to reduce the possibility of misuse of their accounts.</p> <p class="text-justify">
To seek more information and to report Spam. Please mail us at:info@needyin.com.</p> <p class="text-justify"> 
Note: The terms in this agreement may be changed by Needyin Pvt. Ltd. at any time. NI is free to offer its services to any client/prospective client without restriction
</p>
    </div>
    <div class="modal-footer">
      <a href="#!" onclick="termschecked();" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
  </div>

</body>

</html>