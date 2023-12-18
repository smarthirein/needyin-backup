<?php

require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
$user_home->redirect('index.php');
}
$sql_add="SELECT country from tbl_address WHERE user_id='".$_SESSION['userSession']."'";
$res_add=mysqli_query($con,$sql_add);
$row_add=mysqli_fetch_array($res_add);
if($row_add['country']=="101")
$address_sql="SELECT ad.address_type,ad.address,lo.Loc_Name,st.states,con.Cntry_Name from tbl_address as ad INNER JOIN tbl_location as lo ON ad.location = lo.Loc_Id INNER JOIN tbl_states as st ON ad.state = st.id INNER JOIN tbl_country as con ON ad.country= con.Cntry_Id WHERE ad.user_id='".$_SESSION['userSession']."'";
else
$address_sql="SELECT ad.address_type,ad.address,con.Cntry_Name from tbl_address as ad INNER JOIN tbl_country as con ON ad.country= con.Cntry_Id WHERE ad.user_id='".$_SESSION['userSession']."'";
$stmt = mysqli_query($con,$address_sql);                          
$row = mysqli_fetch_array($stmt);
if(isset($_SESSION['userSession']))
{
$userid=$_SESSION['userSession'];
$sqljspf2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
$sqljsrespf2=mysqli_query($con,$sqljspf2);
$sqlressowpf2=mysqli_fetch_array($sqljsrespf2);
$countres=0;            
if(empty($sqlressowpf2[2])||empty($sqlressowpf2[7])||empty($sqlressowpf2[8])||empty($sqlressowpf2[9]))
{   
$countres++;  
  
}
}                           
?>
<div class="title-block-tab">
<h4 class="flight">Address<span class="fbold"> Information</span>  </h4>
  
</div>

<div class="display-features">
    
    <div class="display-details">
      
         <form method="post" action="general-info.php" name="Cexper">
         
        <article class="sub-title">
               <h4 class="pull-left">Address</h4> <span class="fbold"></span></h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="editaddress()" id="edit-curr-add"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
       
        <div id="editadd" style="display:none;">           
               
                <div class="row col-md-12" >
                <div class="col-md-4 col-xs-12 col-sm-6 mt15">
                       
						 <div class="form-group">
							 <label class="pl5">Address Type </label>
						<select class="form-control classic" name="address_type" id="address_type" >
							<option value="C" >Current</option>
							<option value="P" >Permanent</option>
							</select>
							</div>
						
                </div>
            
                   
                    <div class="col-md-4 col-xs-12 col-sm-6 mt15">
                        <div class="form-group">
                           
                                         <?php                                           
                    $sql2 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
                    $query2 = mysqli_query($con, $sql2);
                    if(!$query2)
                    echo mysqli_error($con);
                    ?>
					<label class="pl5">Country </label>
                    <select class="form-control classic" name="country_name" id="country" >
                    <option value="0"> Select country </option>
                    <?php
                    while ($row2 = mysqli_fetch_array($query2))
                    { 
                     extract($row2);
                    ?>
                    <option value="<?php echo $row2['Cntry_Id']; ?>" <?php if(trim($row['Cntry_Id'])==$row2['Cntry_Id']){ echo "selected";}else { echo "";}?>><?php echo $row2['Cntry_Name']; ?></option>
                    <?php } ?>
                    </select>
                
                        </div>
                    </div>
 </div> <div class="row col-md-12" >
          
                    <div class="col-md-4">
                        <div class="form-group">
						<label class="pl5">State </label>
                        <select name="state2" id="state2" class="form-control classic">
                     <option value="0"selected="selected" disabled></option>
                      </select>
					</div>
					</div>
                    <div class="col-md-4">
                      <div class="form-group">
                    <label class="pl5">District / City </label>
                     <select name="city2" id="city2" class="form-control classic">
                      <option value="0"selected="selected" disabled></option>
                    </select>
                    </div>
                </div>
			        <div class="col-md-4 col-xs-12 col-sm-6 ">
                        <div class="form-group">
						 <label>Address </label>
						<input value="<?php echo $row['address'];?>" type="text" class="validate" name="address" id="address1">
                          
       
                        </div>
                    </div>
               
       </div>
          
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <button class="btn waves-effect waves-light btn-blue-sm " type="submit" name="editadd" value="editadd" onclick="return validateadd()">Save</button>
                  <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a>
                  
                </div>
            </div>
           </form>
        </div>
       
       <div id="showadd">
           
            <div class="row showdetails ">
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Address Type</h4>
                        <p><?php  if($row['address_type']=='C') echo "Current"; else echo "Permanent"; ?></p>
                    </div>
                </div>
				 <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Country</h4>
                        
                        <p><?php echo $row['Cntry_Name']; ?></p>
                    </div>
                </div>
				     <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>State </h4>
                        <p><?php echo $row['states']; ?></p>
                    </div>
                </div>
				</div>
				 <div class="row showdetails ">
				  <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Location</h4>
						  <?php echo $row['Loc_Name']; ?> 
                    </div>
                </div>
           
				
                <div class="col-md-4 col-xs-12 col-sm-6">
				
                    <div class="block-show ">
                        <h4>Address </h4>
                        <p>
                       
                        <?php echo $row['address']; ?> 
                        </p>
                    </div>
                </div>
            </div>
           
            
               
          
          
        
          
        </div>



            <?php $sql1 = "SELECT * FROM tbl_experience where JUser_Id='".$row['JUser_Id']."'";
            $query1 = mysqli_query($con, $sql1);
            $dorval=0;
            $dojval=0;
            $datesofjoining=array();
            $datesofrelieving=array();
            $expidarray=array();
            $companynames=array();
            while($row1 = mysqli_fetch_array($query1)){
                    $Exp_Id=$row1['Exp_Id'];
                    $expidarray[]=$Exp_Id;
                    
                    $user_queryD1="select Desig_Name from tbl_desigination  where Desig_Id='".$row1['Desig_Id']."'";
                         $rrD1= mysqli_query($con,$user_queryD1); $rrsD1=mysqli_fetch_array($rrD1); 
                ?>      
        <?php  }?>
        
</div>
<div class="display-features reasonatt">
  
       <div class="row"> 
   
    <div class="display-details">
       
        <article class="sub-title">
            <h4 class="pull-left">Reasons to Relocate</h4><a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="showreasonoverview()" id="edit-rea-profileov"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
       
        <div id="show-reason-overview">
         
			<?php 
				$jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$_SESSION['userSession'];
				$jresult1 = mysqli_query($con,$jc1);
				$jrow = mysqli_fetch_array($jresult1);
				?>
            <div class="row showdetails ">
                <div class="col-md-6 col-sm-6">
                    <div class="block-show ">
                        <h4>Reason Type</h4>
                        <p><?php echo $jrow['jReasonType']; ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="block-show ">					
                        <h4>Reason Document</h4>
						<?php $jr1=explode(",",$jrow['JReasonAttach']);
                              $jr1_cnt=count(array_filter(($jr1)));?>
                        <p class="attachments">
					<?php	
                    if($jr1_cnt!="0")
                    {
                    foreach ($jr1 as $value) {?>
					   <a href="<?php echo $value; ?>" download><i class="fa fa-download" aria-hidden="true"></i> Download Reason</a>
					<?php } 
					} else { ?>
					No Attached Documents
					<?php } ?>
						</p>
                    </div>
                </div>
           
                <div class="col-md-6 ">
                    <div class="block-show ">
                        <h4>Reason Description</h4>
                        <p class="text-justify "> <?php echo $jrow['jReasonSummary']; ?></p>
                    </div>
                </div>
            </div>
            
           
          
        </div>
        
    </div>
	</div>
   
    
  <div id="edit-rea-overview" class="hide-details">
                <form method="post" action="reason.php" name="general-info" novalidate enctype="multipart/form-data">
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Reason Type<span class="mand">*</span></label>
								<select class="form-control classic" name="jReasonType" id="jReasonType">
									<option value="<?php echo $jrow['jReasonType']; ?>"selected="selected" disabled><?php echo $jrow['jReasonType']; ?></option>
				 
								</select> 
							</div>  
						</div>
         
						
							<div class="col-md-6">
								<div class="input-field mt-15" >
									<textarea id="reasonSummary" name="reasonSummary" class="materialize-textarea" style="padding:.8rem 0 0.6rem 0 !important;" maxlength="255" required><?php echo $jrow['jReasonSummary']; ?> </textarea>
									<label for="reasonSummary">Reason Description<span class="mand">*</span> <span class="desc-tr"> <small>(Describe Reasons for Transferred to Preferred Location)</small></span></label>
								</div>
							</div>
				
					
							<div class="col-md-6">
								<label>Reason Attachments<span class="desc-tr"> <small>(Attach Documents Reason| Accept Formats: pdf, jpeg, png, doc)</small></span></label>
								<div class="file-field input-field mt0">
									<div class="btn"> <span>Attachment</span>
										<input type="file" multiple name="txtFileReason[]" id="txtFileReason" onchange="ValidateSingleInput(this)" required> </div>
										
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Upload one or more files at a time"> </div>
								</div>
							</div>
					
		
						
                    </div>
					 <div class="row">
                        <div class="col-md-12">
                            <input type="submit" name="SavedReason" value="Save" class="btn waves-effect waves-light btn-blue-sm " onclick="return validatereason()"/>
                           <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a> </div>
						<input type="hidden" name="user_id" value="<?php echo $_SESSION['userSession'] ?>">
				   </div>
					</div>
			</form>
			</div>
<script>
	function validatereason()
	{
		var summary= document.getElementById('reasonSummary').value;
		if(summary=='')
		{
			alert("Please Enter Reason Description");
            document.getElementById('reasonSummary').focus();
            return false;
		}
		else
			return true;
	}
  function showreasonoverview()
  {
    var p3 = document.getElementById("show-reason-overview");
    p3.style.display = "none";
    var p4 = document.getElementById("edit-rea-profileov");
    p4.style.display = "none";
    var p6 = document.getElementById("edit-rea-overview");
    p6.style.display = "block";
}
</script>
<script>
 function editaddress()
  {
    var p3 = document.getElementById("edit-curr-add");
    p3.style.display = "none";
    var p4 = document.getElementById("editadd");
    p4.style.display = "block";
    var p6 = document.getElementById("showadd");
    p6.style.display = "none";
}
</script>
 <script>
 function ValidateSingleInput(oInput) 
	{
		var reason = document.getElementById('txtFileReason').value;
		if (reason != "")
		{
			var reasonsize = document.getElementById('txtFileReason').files[0].size;
			if (reasonsize > 250000)
			{
			alert("Reason file size is more than 250KB ,please check");
			document.getElementById('txtFileReason').focus();
			return false;
			}
		}
		var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".doc", ".docx", ".pdf"];
//alert("DDDD");
		if (oInput.type == "file")
		{
		var sFileName = oInput.value;
		if (sFileName.length > 0)
		{
			var blnValid = false;
			for (var j = 0; j < _validFileExtensions.length; j++) 
			{
				var sCurExtension = _validFileExtensions[j];
				if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) 
				{
					blnValid = true;
					break;
				}
			}
			if (!blnValid) 
			{
				alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
				oInput.value = "";
				return false;
			}
		}
		}
	}
 </script>    
</div>	


        <script lang="javascript">   
 $(document).ready(function () {
                                $('#country').on('change', function () {
                                    var countryID = $(this).val();
                                    if (countryID) {
                                    	/*if(countryID !='101')
                                    	{
                                    		 $("#Cloc  option").attr("disabled", "disabled");
                                    		 $("#ploc  option").attr("disabled", "disabled");
                                    		 $("#cl").hide();
                                    		 $("#pl").hide();
                                    		 $("#c_st").hide();
                                    		 $("#c_ct").hide();
                                    	}
                                    	if(countryID =='101') {
                                    		$("#Cloc  option").attr("disabled", false);
                                    		$("#ploc  option").attr("disabled", false);
                                    		$("#cl").show();
                                    		$("#pl").show();
                                    		$("#c_st").show();
                                    		 $("#c_ct").show();
                                    	}*/
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'country_id=' + countryID,
                                            success: function (data) {
                                                $("#state2").html(data);
                                                if(countryID !='101')
                                            	{
                                            		 ("#city").html('<option value="">City Not Applicable</option>');
                                            	} else 
                                            	{
                                               		 $("#city").html('<option value="">Select State First</option>');
                                                }
                                            }
                                        });
                                    } else {
                                        $('#statelist').html('<option value="">Select Country First</option>');
                                        $('#city2').html('<option value="">Select State First</option>');
                                    }
                                });
                                $('#state2').on('change', function () {
                                    var stateID = $(this).val();
                                    
                                    if (stateID) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'state_id=' + stateID,
                                            success: function (htmls) {
                                                $('#city2').html(htmls);
                                            }
                                        });
                                    } else {
                                        $('#city2').html('<option value="">Select State First</option>');
                                    }
                                });
                            });
                           		
            
                function validateadd()
            {
				
             var adr = document.getElementById('address1').value;
                                if (adr == "") {
                                    alert("Please Enter Address");
                                    document.getElementById('address1').focus();
                                    return false;
                                }
                                var country = document.getElementById('country').value;
                                if (country == "0") {
                                    alert("Please Select Country");
                                    document.getElementById('country').focus();
                                    return false;
                                }
                                if(country=='101')
                                {
	                                var state = document.getElementById('state2').value;
	                                if (state == "") {
	                                    alert("Please Select State");
	                                    document.getElementById('state2').focus();
	                                    return false;
	                                }
	                                var city = document.getElementById('city2').value;
	                                if (city == "") {
	                                    alert("Please Select City");
	                                    document.getElementById('city2').focus();
	                                    return false;
	                                }
                            	}   
            
  }
			function currexpedit() {
    var ee1 = document.getElementById("editexp");
    ee1.style.display = "block";
    ee1.style.display = "none";
    var ee2 = document.getElementById("showexp");
    ee2.style.display = "none";
    var ee5 = document.getElementById("edit-ic-exp");
    ee5.style.display = "none";
}

</script>
      
      
