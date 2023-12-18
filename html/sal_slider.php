<?php
session_start();
require_once 'class.user.php';
$reg_user = new USER();
if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}
if(isset($_POST['btn-signup']))
{
     
	 $uname = trim($_POST['txtName']);
	 $email = trim($_POST['txtEmail']);
	 $upass = trim($_POST['txtPwd']);
	 $code = md5(uniqid(rand()));	
	 $mob=trim($_POST['txtMobile']);	 
	 $TEy=trim($_POST['TExpY']);
	 $TEm=trim($_POST['TExpM']);
	 $PLo=trim($_POST['ploc']);
	 $Cship=trim($_POST['citizen']);
	 $skills=implode(",",$_POST['PSkills']);
	 $Cauthor=implode(",",$_POST['CAuthor']);
	 $allowedrr =  array('DOCX','DOC' ,'PDF','JPG','PNG','JPEG','GIF');
	  
	  $_FILES['txtFileReason']['name'];
	
	
	 $CurrentComp=trim($_POST['txtccmpy']);
	 $Np=trim($_POST['selectNp']);	 
	 $Rtype=trim($_POST['jReasonType']);
	 $RSummary=trim($_POST['reasonSummary']);	 
	 $CSL=trim($_POST['CSL']);	
     $ESL=trim($_POST['ESL']);	 
	 $EMSL=trim($_POST['EMSL']);
     $Cloci=trim($_POST['Cloc']);	 
	 $checkbox=trim($_POST['test5']);
	 $dummydes=trim($_POST['desig']);
	 $DESSQL="	SELECT * FROM `tbl_desigination` WHERE `Desig_Id`='$dummydes'";
	 $dessqlres=mysqli_query($con,$DESSQL);
	 $dessqlrow=mysqli_fetch_array($dessqlres);
     $CDes=$dessqlrow['Desig_Name'];				 
	 $_FILES['txtFilePayslip']['name'];		
	 $payslipextension=strtoupper(pathinfo($_FILES['txtFilePayslip']['name'], PATHINFO_EXTENSION));		
	
	 
	 $cvextension=strtoupper(pathinfo($_FILES['txtFileCV']['name'], PATHINFO_EXTENSION)); 
	 $payslip="Upload/Payslip/".$_FILES['txtFilePayslip']['name'];     	 		
	 $_FILES['txtFileCV']['name'];		 		
	 $Cv="Upload/Cv/".$_FILES['txtFileCV']['name'];
	 $mblen=strlen($mob);			
    
     $allowed =  array('DOCX','DOC' ,'PDF');
     $stmt = $reg_user->runQuery("SELECT * FROM tbl_jobseeker WHERE JEmail=:email_id OR JPhone=:phone");	
     $stmt->execute(array(":email_id"=>$email,":phone"=>$mob));
	 $row = $stmt->fetch(PDO::FETCH_ASSOC); 
	 $msgg=array();	
 if(count($_FILES['txtFileReason']['name']) > 0){
        
        for($i=0; $i<count($_FILES['txtFileReason']['name']); $i++) {
			$reasonextension=strtoupper(pathinfo($_FILES['txtFileReason']['name'], PATHINFO_EXTENSION));
		if(!empty($reasonextension))
		{	
		 if(!(in_array($reasonextension,$allowedrr)))
		 {
			 $msgg[]="Reason attachment Wrong file type uploaded";
		 }		
		}
		}
	 }
			 
	 if(empty($TEy)&&empty($TEm))
		 {
			 $msgg[]="Please Fill your experience";
		 }			

		 if(!(in_array($payslipextension,$allowedrr)))
		 {
			 $msgg[]=" Pay slip Wrong file type uploaded";
		 }		
		 if(!(in_array($cvextension,$allowed)))
		 {
			 $msgg[]=" CV Wrong file type uploaded";
		 }
		 if($Cloci==$PLo)
		 {
		 $msgg[]="Preferred Location and present location can't be same";
		 }	
	 if($mblen<10)
			  {
				  $msgg[]="Mobile number must be 10 letters";
			  }
			   if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			  {
				  $msgg[]="Please Enter a valid Email ID.";
			  }
			   if(empty($checkbox))
			  {
				  $msgg[]="please accept to our terms and conditions";
			  }
		 if($stmt->rowCount() > 0)
		{
		$msgg[] = "Sorry !  email OR mobile number  already exists , Please Try another one";
		}
 if(!empty($msgg))
  {
  	echo "<div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>";
	  foreach($msgg as $k)
		  {
			 echo  "
				<strong>".$k."</strong> <br>";			 
		  }
				  echo"</div>";				  
 }			  			  
else
	{
		if($reg_user->register($uname,$email,$upass,$code,$mob,$TEy,$TEm,$PLo,$Cship,$CurrentComp,$Np,$CSL,$ESL,$EMSL,$Cloci,$CDes,$skills,$Cauthor,$Rtype,$RSummary))
	{
	  $idsql = "SELECT * from tbl_jobseeker where JEmail='$email'";
      $idsqlres=mysqli_query($con,$idsql);
      $idresrow=mysqli_fetch_array($idsqlres);
      $id=$idresrow['JUser_Id'];
	  $jid=$id;
      $key = base64_encode($id);
      $id = $key;
	  $siteurl="http://needyin.com/"; 
	 

    if(count($_FILES['txtFileReason']['name']) > 0){
       
        for($i=0; $i<count($_FILES['txtFileReason']['name']); $i++) {
          
            $tmpFilePath = $_FILES['txtFileReason']['tmp_name'][$i];

           
            if($tmpFilePath != ""){
            
               
                $shortname = "Upload/Reason/reason_" . $jid.'-'.$_FILES['txtFileReason']['name'][$i];

               
                $filePath = "Upload/Reason/reason_" . $jid.'-'.$_FILES['txtFileReason']['name'][$i];

                
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
					
                   

                }
              }
        }
    }

    
        $new_name_cv="Upload/Cv/CV_".$jid.".".$cvextension;
		rename($Cv,$new_name_cv);		
		 move_uploaded_file($_FILES['txtFileCV']['tmp_name'],$new_name_cv);								 				 
      $new_name_payslip="Upload/Payslip/payslip_".$jid.".".$payslipextension;
		rename($payslip,$new_name_payslip);
		 move_uploaded_file($_FILES['txtFilePayslip']['tmp_name'],$new_name_payslip);		 		 	  		
		
		$sqlfiles=" UPDATE `tbl_currentexperience` SET `PaySlip`='$new_name_payslip',`UpdateCV`='$new_name_cv' WHERE `JUser_Id`='$jid'";
		$sqlres=mysqli_query($con,$sqlfiles);
		
		$reasonList = implode(',', $files);	
$sqlreason="UPDATE `tbl_jobseeker` SET `JReasonAttach`='$reasonList' WHERE `JUser_Id`='$jid'";
					$sqlreasonres=mysqli_query($con,$sqlreason);
		if($_POST['adr']!="")
        {        	
		  $cadr_sql1="INSERT INTO tbl_address (country,state,location,address,address_type,user_id,user_type ) VALUES('".$_POST['country']."','".$_POST['state']."','".$_POST['loc']."','".$_POST['address1']."','C','".$idresrow['JUser_Id']."','".$_POST['user_type']."')";
              $cadr_res1=mysqli_query($con,$cadr_sql1); 
            
             $cadr_sql1="INSERT INTO tbl_address (country,state,location,address,address_type,user_id,user_type ) VALUES('".$_POST['country']."','".$_POST['state']."','".$_POST['loc']."','".$_POST['address1']."','P','".$idresrow['JUser_Id']."','".$_POST['user_type']."')";
              $cadr_res1=mysqli_query($con,$cadr_sql1); 
         }
         else {
         	 $cadr_sql1="INSERT INTO tbl_address (country,state,location,address,address_type,user_id,user_type ) VALUES('".$_POST['country']."','".$_POST['state']."','".$_POST['loc']."','".$_POST['address1']."','C','".$idresrow['JUser_Id']."','".$_POST['user_type']."')";
              $cadr_res1=mysqli_query($con,$cadr_sql1); 
            
              $cadr_sql1="INSERT INTO tbl_address (country,state,location,address,address_type,user_id,user_type ) VALUES('".$_POST['country2']."','".$_POST['state2']."','".$_POST['loc2']."','".$_POST['address2']."','P','".$idresrow['JUser_Id']."','".$_POST['user_type']."')";
              $cadr_res1=mysqli_query($con,$cadr_sql1);
         }        
			if($cadr_res1)
			{
           $message .= "Hello ".$uname."<br/>";
 
                         $message .= "Welcome to Needyin !<br /><br />";
                         $message .= "To complete your registration  please , just click following link !<br /><br />";
                         $message .= "<a href=".$siteurl."verify.php?id=".$id."&code=".$code.">Click here to Activate </a><br /><br />";
                         $message .= "Thanks,";						
			$subject = "NeedyIn Registration Activation Link";						
			$ok=$reg_user->send_mail($email,$message,$subject);	
     
		             $skill_ids=$_POST['PSkills'];
		             foreach($skill_ids as $skill)
				      {
		                 
	
 
 $qa="select emp_id,Job_Id from tbl_jobposted where Loc_Id='".$PLo."'and  FIND_IN_SET('".$skill."', Job_Skill)";	                  
						  $qa_result = mysqli_query($con,$qa);  
			                  while($qa_data=mysqli_fetch_array($qa_result))
			                  {
				                 
				                   $job_ids[]=$qa_data['Job_Id'];
				                  
			                  }
				      }
				           
				           
				             $jobids=array_filter(array_unique($job_ids));
 
				             $job_count=count($jobids); 
	                        if($job_count!='0')
	                        {
                                foreach($jobids as $job_id)
									{
                                       $cj3="select emp_id from tbl_jobposted where Job_Id='".$job_id."' and Job_Status=1";  
										   $resultcj3 = mysqli_query($con,$cj3);  
										   $result_cj3=mysqli_fetch_array($resultcj3); 

								         $cj4="select emp_email,contact_name from tbll_emplyer where emp_id='".$result_cj3['emp_id']."'";  
										   $resultcj4 = mysqli_query($con,$cj4);  
										   $result_cj4=mysqli_fetch_array($resultcj4); 
                                           $job_email=$result_cj4['emp_email']; 
    

										$description="One new profile is created";
                                       $insert_query = "INSERT into tbl_notifications SET job_id='".$job_id."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$idresrow['JUser_Id']."',notification_to='".$result_cj3['emp_id']."',notification_from='".$idresrow['JUser_Id']."',mode='jobseeker'"; 
										$rr1 = mysqli_query($con,$insert_query); 
                                       
										
                                       

										$subject="New Profile In Needyin";

							             $nt_message .= "Hello ".$result_cj4['contact_name']."<br/>";
						                 $nt_message .= "One New Profile is created match with your Job Summary !<br /><br />";
						                 $nt_message .= "Just click following link !<br /><br />";
						                 $nt_message .= "<a href=".$siteurl.">NeedyIn </a><br /><br />";
						                 $nt_message .= "Thanks,";
							             $mm=$reg_user->send_mail2($job_email,$nt_message,$subject);
									}							
	                        }                 		    
     

			?>
    <script>
        alert("Registered Successfully Please Check Your Email");
        window.location.href = "login.php";
    </script>
    <?php }
		else
		{
		echo "Some Error Occurred Please Ary Again";			
		}
}
		else
		{ ?>
        <script>
            alert("Sorry , Some Error Occurred Please Try Again");
        </script>
        <?php 	}		
	}
}
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>SignUp with Needyin</title>
                <!-- css includes-->
                <?php include"source.php" ?>
                    <script lang="javscript">
                        $(document).on('keypress', '#txtName', function (event) {
                            var regex = new RegExp("^[a-zA-Z ]+$");
                            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                            if (!regex.test(key)) {
                                event.preventDefault();
                                return false;
                            }
                        });
                        $(document).on('keypress', '#txtdesigination', function (event) {
                            var regex = new RegExp("^[a-zA-Z ]+$");
                            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                            if (!regex.test(key)) {
                                event.preventDefault();
                                return false;
                            }
                        });
                    </script>
            </head> 

            <body>
                <?php include"prelogin-header.php"; ?>


                    <!-- main-->
                    <main>
                       
                        <section class="signin">
                            <div class="container">
                                <div class="row sign">
                                    <div class="col-md-12">
                                        <div class="signin-main signup">
                                            <div class="signin-in">
                                                <!-- sign in-->
                                                <div id="signin">
                                                    <h3 class="h3 text-center flight">CREATE AN ACCOUNT <span class="fbold txt-blue">FOR JOB SEEKER </span></h3>
                                                   
                                                    <div class="tab-registration">
                                                       
                                                        <h4 class="h4 txt-blue">Personal details </h4>
                                                        <?php if(isset($msg)) echo $msg;  ?>
                                                            <form method="post" id="form1" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="txtName" name="txtName" type="text" class="validate" pattern=".{5,}" title="Three Characters are Minimum for Name" maxlength="55" required>
                                                                            <label for="Fullname">Enter your Full Name <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="txtEmail" name="txtEmail" type="text" class="validate" maxlength="55" required>
                                                                            <label for="Fullname">Register with your Email ID <span class="mand">*</ span></label>
                                                        </div>
                                                    </div>		
														<div class="col-md-4">
                                                        <div class="input-field">
                                                            <input id="txtMobile" name="txtMobile" type="text" class="validate" pattern = ".{10,}" title="mobile number should be 10 digits" maxlength="10" onkeypress="return isNumber()" required>
                                                            <label for="Fullname">Mobile Number to Contact You <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        $('#txtMobile').bind("cut copy paste", function (e) {
                                                                            e.preventDefault();
                                                                        });
                                                                    </script>
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="txtPwd" name="txtPwd" type="password" class="validate" maxlength="55">
                                                                            <label for="Fullname">Create a Password <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="cpwd" name="cpwd" type="password" class="validate" maxlength="55">
                                                                            <label for="Fullname">Confirm Password <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mt10">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Experience <span class="mand">*</span></label>
                                                                                    <select class="form-control classic" name="TExpY" id="TExpY">
                                                                                        <?php for($i=0;$i<=30;$i++) {  ?>
                                                                                            <option value="<?php echo $i;?>">
                                                                                                <?php echo $i;?> Years</option>
                                                                                            <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>&nbsp;</label>
                                                                                    <select class="form-control classic" name="TExpM" id="TExpM">
                                                                                        <?php for($i=0;$i<=12;$i++) {  ?>
                                                                                            <option value="<?php echo $i;?>">
                                                                                                <?php echo $i;?> Months</option>
                                                                                            <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 custom-btn mt5">
                                                                        <div class="form-group">
                                                                            <label for="PSkills">Skills <span class="mand">*</span></label>
                                                                            <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="PSkills[]" id="PSkills">
                                                                                <option value="0" disabled>Select Multiple Skills </option>
                                                                                <?php 
						                                            $sql = "SELECT skill_Name,skill_Id FROM tbl_masterskills WHERE skill_Status=1 ORDER BY skill_Name ";
						                                            $query = mysqli_query($con, $sql);
						                                            while($row1 = mysqli_fetch_array($query))
						                                               { 
						                                                extract($row1);
						                                                ?>
                                                                                    <option value="<?php echo $row1['skill_Id'];?>">
                                                                                        <?php echo $row1['skill_Name']; ?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Reason Type<span class="mand">*</span></label>
                                                                            <select class="form-control classic" name="jReasonType" id="jReasonType">
                                                                                <option value="0"selected="selected" disabled>Select Reason</option>
                                                                                <option value="Parents in Oldage">Parents in Oldage</option>
                                                                                <option value="Medical Emergency - Parents">Medical Emergency - Parents</option>
                                                                                <option value="Medical Emergency - Self">Medical Emergency - Self</option>
                                                                                <option value="Medical Emergency - Spouse">Medical Emergency - Spouse</option>
                                                                                <option value="Medical Emergency - Children">Medical Emergency - Children</option>
                                                                                <option value="Socio Political Condition">Social Political Condition</option>
                                                                                <option value="Spouse Relocated">Spouse Relocated</option>
                                                                                <option value="Children Education">Children Education</option>
                                                                                <option value="Back to Homeland">Back to Homeland</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt10">
                                                                    <div class="col-md-6">
                                                                        <div class="input-field mt-15">
                                                                            <textarea id="reasonSummary" name="reasonSummary" class="materialize-textarea" maxlength="255"></textarea>
                                                                            <label for="reasonSummary">Reason Description<span class="mand">*</span> <span class="desc-tr"> <small>(Describe Reasons for Transferred to Preferred Location)</small></span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Reason Attachments<span class="desc-tr"> <small>(Attach Documents Reason to Preferred Location Ex:Transfer Certificate, Medical Report | Accept Formats: pdf, jpeg, png, doc)</small></span></label>
                                                                        <div class="file-field input-field mt0">
                                                                            <div class="btn"> <span>Attachment</span>
                                                                                <input type="file" multiple name="txtFileReason[]" id="txtFileReason" onchange="ValidateSingleInput(this)"> </div>
                                                                            <div class="file-path-wrapper">
                                                                                <input class="file-path validate" type="text" placeholder="Upload one or more files at a time"> </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                                <h5 class="txt-blue">Current Address </h5>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="input-field">
                                                                            <input id="add1" name="address1" type="text" maxlength="255" value="<?php echo $rows[" address1 "]?>">
                                                                            <label for="add1">Address Line </label>
                                                                        </div>
                                                                        <input type="hidden" name="address_type1" value="C"> </div>
                                                                </div>
                                                                <div class="row mt10">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <?php
															$sqls = "SELECT Cntry_Name FROM tbl_country where Cntry_Id='".$rows['country_id']."'";
															$querys = mysqli_query($con, $sqls);
															$rows11 = mysqli_fetch_array($querys);
															$countryname = $rows11['Cntry_Name'];
															
															$sql1 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
															$query1 = mysqli_query($con, $sql1);
															?>
                                                                                <label class="pl5" for="Fullname">Country <span class="mand">*</span></label>
                                                                                <select class="form-control classic" name="country" id="country" required>
                                                                                    <option value="0"selected="selected" disabled> Select Country </option>
                                                                                    <?php
																while ($rows1 = mysqli_fetch_array($query1))
																{ 
																	extract($rows1);
																?>
                                                                                        <option value="<?php echo $rows1['Cntry_Id']; ?>" <?php if($rows1[ 'Cntry_Name']==$countryname)echo "selected";?>>
                                                                                            <?php echo $rows1['Cntry_Name']; ?>
                                                                                        </option>
                                                                                        <?php } ?>
                                                                                </select>

                                                                        </div>
                                                                    </div>
                                                                   
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="pl5">State <span class="mand">*</span></label>
                                                                            <select name="state" class="form-control classic" data-live-search="true" data-live-search-style="begins" id="state">
                                                                                <option value="0" selected="selected" disabled>Select State</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                   

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="pl5">District / City <span class="mand">*</span></label>
                                                                            <select name="city" id="city" class="form-control classic">
                                                                                <option value="0"selected="selected" disabled>Select City / District</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <p class="curwornew">
                                                                        <input type="checkbox" id="adr" name="adr" onclick="return check_adr()" />
                                                                        <label for="adr">Permanent Address same as Current Address</label>
                                                                    </p>
                                                                </div>
                                                                <div id="perm_adr">
                                                                    <h5 class="txt-blue">Permanent Address </h5>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="input-field">
                                                                                <input id="add2" name="address2" type="text" maxlength="255" value="<?php echo $rows[" address1 "]?>">
                                                                                <label for="add2">Address Line </label>
                                                                            </div>
                                                                            <input type="hidden" name="address_type2" value="P"> </div>
                                                                    </div>
                                                                    <div class="row mt10">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <?php 											
												$sql2 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
												$query2 = mysqli_query($con, $sql2);
												if(!$query2)
												echo mysqli_error($con);
												?>
                                                                                    <label class="pl5">Country </label>
                                                                                    <select class="form-control classic" name="country2" id="country2" required class="browser-default">
                                                                                        <option value="0"selected="selected" disabled> Select Country </option>
                                                                                        <?php
												while ($row2 = mysqli_fetch_array($query2))
												{ 
												 extract($row2);
												?>
                                                                                            <option value="<?php echo $row2['Cntry_Id']; ?>">
                                                                                                <?php echo $row2['Cntry_Name'];?>
                                                                                            </option>
                                                                                            <?php } ?>
                                                                                    </select>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="pl5">State </label>
                                                                                <select name="state2" id="state2" class="form-control classic">
                                                                                    <option value="0"selected="selected" disabled>Select State</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="pl5">District / City </label>
                                                                                <select name="city2" id="city2" class="form-control classic">
                                                                                    <option value="0"selected="selected" disabled>Select City / District </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <h4 class="h4 txt-blue">Employment Details </h4>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <?php
														
														$sql = "SELECT * FROM tbl_desigination";
														$query = mysqli_query($con, $sql);
														if(!$query)
														echo mysqli_error($con);
														?>
                                                                                
                                                                                <label for="Fullname">Current Designation <span class="mand">*</span></label>
                                                                                <select class="form-control classic" id="desig" name="desig">
                                                                                    <option value="0"selected="selected" disabled>Select Designation</option>
                                                                                    <?php
														while ($row1 = mysqli_fetch_array($query))
														{ 
														extract($row1);
														?>
                                                                                        <option value="<?php echo $row1['Desig_Id']; ?>">
                                                                                            <?php echo $row1['Desig_Name']; ?>
                                                                                        </option>
                                                                                        <?php 
														}
														?>
                                                                                </select>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mt-10">
                                                                        <div class="input-field">
                                                                            <input id="txtccmpy" name="txtccmpy" type="text" class="validate" required>
                                                                            <label for="Current-company">Current Company <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Duration of Notice <span class="mand">*</span></label>
                                                                            <select class="form-control classic" name="selectNp" id="selectNp">
                                                                                <option value="0" selected="selected" disabled>Select</option>
                                                                                <option value="1">Immediate</option>
                                                                                <option value="15">Less than 15 days</option>
                                                                                <option value="30">1 Month</option>
                                                                                <option value="60">2 Month</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="minmax-sliderd cur-sal">
                                                                            <label>Current CTC (Lacs)<span class="mand">*</span></label>
                                                                            <div class="minmax-slider">
                                                                                <div class="noUi-target noUi-ltr noUi-horizontal" id="slider-format">
                                                                                   <div class="noUi-connect" ></div>
                                                                                </div>
                                                                                <div class="values">
                                                                                    <div class="valuein ctcvalue"> <span class="ctc-span">CTC</span>
                                                                                        <input id="input-format" name="CSL" readonly="true"> </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            var sliderFormat = document.getElementById('slider-format');

                                                                            noUiSlider.create(sliderFormat, {
                                                                                start: [1],
                                                                                step: 0.5,
                                                                                behaviour: 'snap',
                                                                                 connect: true,
                                                                                range: {
                                                                                    'min': [1],
                                                                                    'max': [50]
                                                                                }
                                                                            });
                                                                        </script>
                                                                        <script>
                                                                            var inputFormat = document.getElementById('input-format');
                                                                            sliderFormat.noUiSlider.on('update', function (values, handle) {
                                                                                values[handle] = (values[handle]);
                                                                                var cr_val = (values[handle]);
                                                                                inputFormat.value = cr_val;
                                                                            });
                                                                            inputFormat.addEventListener('change', function () {
                                                                                sliderFormat.noUiSlider.set(this.value);
                                                                            });
                                                                        </script>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="minmax-sliderd">
                                                                            <label>Expected CTC (Lacs)<span class="mand">*</span></label>
                                                                            <div class="minmax-slider">
                                                                                <div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-range"></div>
                                                                                <div class="values">
                                                                                    <div class="valuein">
                                                                                        <div class="left-input"><span class="ctc-span">Min</span>
                                                                                            <input class="input-format1" id="slider-range-lower" readonly="true" name="ESL"> </div>
                                                                                        <div class="rt-input"> <span class="ctc-span">Max</span>
                                                                                            <input class="input-format2" id="slider-range-upper" readonly="true" name="EMSL"> </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        var sliderFormat1 = document.getElementById('slider-range');
                                                                        
                                                                        noUiSlider.create(sliderFormat1, {
                                                                            start: [0, 50],
                                                                            step: 0.5,
                                                                            connect: true,
                                                                            range: {
                                                                                'min': [0],
                                                                                'max': [50]
                                                                            }
                                                                        });
                                                                        var values = [document.getElementById('slider-range-lower'), document.getElementById('slider-range-upper')];
                                                                        var inputFormat1 = document.getElementById('slider-range-lower');
                                                                        var inputFormat2 = document.getElementById('slider-range-upper');
                                                                        sliderFormat1.noUiSlider.on('update', function (values, handle) {
                                                                            inputFormat1.value = values[0];
                                                                            inputFormat2.value = values[1];
                                                                        });
                                                                        inputFormat1.addEventListener('change', function () {
                                                                            sliderFormat1.noUiSlider.set(document.getElementById('slider-range-lower').value);
                                                                        });
                                                                        inputFormat2.addEventListener('change', function () {
                                                                            sliderFormat1.noUiSlider.set(inputFormat2.value);
                                                                        });
                                                                    </script>
                                                                    <div class="col-md-4 mt15">
                                                                        <div class="form-group">
                                                                            <?php
															$sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
															$query = mysqli_query($con, $sql);
															if(!$query)
															echo mysqli_error($con);
															?>
                                                                                <label>Current Location <span class="mand">*</span></label>
                                                                                <select class="form-control classic" name="Cloc" id="Cloc" required>
                                                                                    <option value="0"selected="selected" disabled> Select Location </option>
                                                                                    <?php
															while ($row1 = mysqli_fetch_array($query))
															{ 
															extract($row1);
															?>
                                                                                        <option value="<?php echo $Loc_Id; ?>">
                                                                                            <?php echo $Loc_Name; ?>
                                                                                        </option>
                                                                                        <?php } ?>
                                                                                </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <?php
                                                                                $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
                                                                                $query = mysqli_query($con, $sql);
                                                                                if(!$query)
                                                                                echo mysqli_error($con);
                                                                                ?>
                                                                                <label>Preferred Location <span class="mand">*</span></label>
                                                                                <select class="form-control classic" id="ploc" name="ploc">
                                                                                    <option value="0"selected="selected" disabled> Select Preferred Location </option>
                                                                                    <?php
                                                        while ($row1 = mysqli_fetch_array($query))
                                                        { 
                                                         extract($row1);
                                                        ?>
                                                                                        <option value="<?php echo $Loc_Id; ?>">
                                                                                            <?php echo $Loc_Name; ?>
                                                                                        </option>
                                                                                        <?php } ?>
                                                                                </select>

                                                                        </div>
                                                                    </div>
																	<div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <?php
                                                                                $sqlc = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
                                                                                $queryc = mysqli_query($con, $sqlc);                                                                            
                                                                                ?>
                                                                                <label>Citizen Country<span class="mand"></span></label>
                                                                                <select class="form-control classic" id="citizen" name="citizen">
                                                                                   <option value="0" selected="selected" disabled> Select Country</option>
																								<?php
																					while ($rowc = mysqli_fetch_array($queryc))
																					{ 
																						extract($rowc);
																					?>
																						<option value="<?php echo $Cntry_Id; ?>"><?php echo $Cntry_Name; ?></option>
																					<?php } ?>
                                                                                </select>
                                                                        </div>
                                                                    </div>
																		<div class="col-md-4 custom-btn mt5">
																			<div class="form-group auth-country">
																				<label for="CAuthor">Authorised Country <span class="mand"></span></label>
																				<select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="CAuthor[]" id="CAuthor">
																					<option value="0" disabled>Select 3 Country Authorization </option>
																					<?php 
																					$sqla = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name ";
																					$querya = mysqli_query($con, $sqla);
																					while($rowa = mysqli_fetch_array($querya))
																				   { 
																					extract($rowa);
																					?>
																					<option value="<?php echo $rowa['Cntry_Id'];?>"><?php echo $rowa['Cntry_Name']; ?></option>
																					<?php } ?>
																				</select>
																			</div>
																		</div>																																	
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6 atbtn">
                                                                       <label>Payslip <span class="mand">*</span> <span class="desc-tr"> <small>(Attach Recent Payslip | Accept Formats: pdf, jpeg, png, doc)</small></span></label>
                                                                        <div class="file-field input-field">
                                                                            <div class="btn"> <span>Attachment </span>
                                                                                <input type="file" name="txtFilePayslip" id="txtFilePayslip" onchange="ValidateSingleInput(this)" required> </div>
                                                                            <div class="file-path-wrapper">
                                                                                <input class="file-path validate" type="text" required> </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 atbtn">
                                                                       <label>Resume <span class="mand">*</span> <span class="desc-tr"> <small>(Attach Update CV | Accept Formats: pdf, doc)</small></span></label>
                                                                        <div class="file-field input-field">
                                                                            <div class="btn"> <span>Attachment</span>
                                                                                <input type="file" name="txtFileCV" id="txtFileCV" onchange="Validateresume(this)" required> </div>
                                                                            <div class="file-path-wrapper">
                                                                                <input class="file-path validate" type="text"> </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--/button -->
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <p class="agree">
                                                                            <input type="checkbox" id="test5" name="test5" value="checked">
                                                                            <label for="test5"><a href="#terms-pop">I Agree to the Terms and Conditions</a></label>
                                                                        </p>
                                                                        <input type="hidden" name="user_type" value="job_seekar">
                                                                        <button class="btn-register btn btn-block waves-effect waves-light" type="submit" name="btn-signup" onclick="return validate();">Register with us <i class="fa fa-user-plus" aria-hidden="true"></i> </button>
                                                                        <p style="margin-top:10px;">Are you Member? <a href="login.php">Sign in</a></p>
                                                                    </div>
                                                                </div>
                                                                <p><span class="mand">*</span> All are Mandatory Fields</p>
                                                            </form>
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

                            function ValidateSingleInput(oInput) {
                                var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".doc", ".docx", ".pdf"];
                                
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

                            function ValidateSingleInput(oInput) {
                                var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".doc", ".docx", ".pdf"];
                                
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

                            function Validateresume(oInput) {
                                var _validFileExtensions = [".doc", ".docx", ".pdf"];
                               
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

                            function isNumber(evt) {
                                evt = (evt) ? evt : window.event;
                                var charCode = (evt.which) ? evt.which : evt.keyCode;
                                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                            $(document).ready(function () {
                                var ckbox = $('#test5');
                                $('input').on('click', function () {
                                    if (ckbox.is(':checked')) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                });
                            });
                        </script>
                       
                        <script>
                         var last_valid_selection = null;
                            $('#CAuthor').change(function(event) {
                                if ($(this).val().length >3) {
                                alert('You can only choose 3 Country !');
                                $(this).val(last_valid_selection);
                                } else {
                                last_valid_selection = $(this).val();
                                }
                            });                             
                        </script>
                        
                        <script>
                            function validate() {
                                var name = document.getElementById('txtName').value;
                                if (name == "") {
                                    alert("Please Enter Full Name");
                                    document.getElementById('txtName').focus();
                                    return false;
                                }
                                var email = document.getElementById('txtEmail').value;
                                if (email == "") {
                                    alert("Please Enter Email ID ");
                                    document.getElementById('txtEmail').focus();
                                    return false;
                                }
                                if (!emailverify(email)) {
                                    document.getElementById('txtEmail').focus();
                                    return false;
                                }
                                var mobnum = document.getElementById('txtMobile').value;
                                if (mobnum == "") {
                                    alert("Please Enter Mobile Number.");
                                    document.getElementById('txtMobile').focus();
                                    return false;
                                }
                                var mobnum1 = document.getElementById('txtMobile').value;
                                if (mobnum1.length != 10) {
                                    alert("Please Enter Valid Mobile Number");
                                    document.getElementById('txtMobile').focus();
                                    return false;
                                }
                                var arr = document.getElementById('txtPwd').value;
                                if (!passwordverify(arr)) {
                                    document.getElementById('txtPwd').focus();
                                    return false;
                                }
                                var c_pwd = document.getElementById('cpwd').value;
                                if (!passwordverify(arr)) {
                                    document.getElementById('cpwd').focus();
                                    return false;
                                }
                                var pwd = document.getElementById('txtPwd').value;
                                var cpwd = document.getElementById('cpwd').value;
                                if (pwd != cpwd) {
                                    alert("Password and Confirm Password should match");
                                    document.getElementById('cpwd').focus();
                                    return false;
                                }
                               
                                var exp = document.getElementById('TExpY').value;
                                var expmon = document.getElementById('TExpM').value;
                                if (exp == "0" && expmon == "0") {
                                    alert("Please Select Experience");
                                    document.getElementById('TExpY').focus();
                                    return false;
                                }
                                
                                var skillselect = document.getElementById('PSkills').value;
                                if (skillselect == 0) {
                                    alert("Please Select Skills");
                                    document.getElementById('PSkills').focus();
                                    return false;
                                }
                                
                                var options = document.getElementById('PSkills').options,
                                    count = 0;
                                for (var i = 0; i < options.length; i++) {
                                    if (options[i].selected) count++;
                                }
                                if (count < 3) {
                                    alert("Please Select at least 3-Skills");
                                    document.getElementById('PSkills').focus();
                                    return false;
                                }
                                var reasonoption = document.getElementById('jReasonType').value;
                                if (reasonoption == "0") {
                                    alert("Please Select Reason to Relocate");
                                    document.getElementById('jReasonType').focus();
                                    return false;
                                }
                                var reasonoption = document.getElementById('reasonSummary').value;
                                if (reasonoption.length < 1) {
                                    alert("Please Enter Reason Description");
                                    document.getElementById('reasonSummary').focus();
                                    return false;
                                }
                                
                                var reason = document.getElementById('txtFileReason').value;
                                if (reason != "") {
                                    var reasonsize = document.getElementById('txtFileReason').files[0].size;
                                    if (reasonsize > 250000) {
                                        alert("Reason file size is more than 250KB ,please check");
                                        document.getElementById('txtFileReason').focus();
                                        return false;
                                    }
                                }
                                var adr = document.getElementById('add1').value;
                                if (adr == "") {
                                    alert("Please Enter Current Address");
                                    document.getElementById('add1').focus();
                                    return false;
                                }
                                var country = document.getElementById('country').value;
                                if (country == "0") {
                                    alert("Please Select Country");
                                    document.getElementById('country').focus();
                                    return false;
                                }
                                var state = document.getElementById('state').value;
                                if (state == "") {
                                    alert("Please Select State");
                                    document.getElementById('state').focus();
                                    return false;
                                }
                                var city = document.getElementById('city').value;
                                if (city == "") {
                                    alert("Please Select City");
                                    document.getElementById('city').focus();
                                    return false;
                                }
                                var desig = document.getElementById('desig').value;
                                if (desig == "0") {
                                    alert("Please Select Designation");
                                    document.getElementById('desig').focus();
                                    return false;
                                }
                                var curcmny = document.getElementById('txtccmpy').value;
                                if (curcmny == "") {
                                    alert("Please Enter Current Company");
                                    document.getElementById('txtccmpy').focus();
                                    return false;
                                }
                                var selectNp = document.getElementById('selectNp').value;
                                if (selectNp == '0') {
                                    alert("Please Select Notice Period");
                                    document.getElementById('selectNp').focus();
                                    return false;
                                }
                                var clocemp = document.getElementById('Cloc').value;
                                if (clocemp == '') {
                                    alert("Please Select Current Location");
                                    document.getElementById('Cloc').focus();
                                    return false;
                                }
                                var plocemp = document.getElementById('ploc').value;
                                if (plocemp == '0') {
                                    alert("Please Select Preferred Location");
                                    document.getElementById('ploc').focus();
                                    return false;
                                }
                                var cloc = document.getElementById('Cloc').value;
                                var ploc = document.getElementById('ploc').value;
                                if (cloc == ploc) {
                                    alert("Current Location and preferred location can't be same");
                                    document.getElementById('ploc').focus();
                                    return false;
                                }
                                var txtFilePayslip = document.getElementById('txtFilePayslip').value;
                                if (txtFilePayslip == "") {
                                    alert("Please Upload Latest payslip");
                                    document.getElementById('txtFilePayslip').focus();
                                    return false;
                                }
                                var payslipsize = document.getElementById('txtFilePayslip').files[0].size;
                                if (payslipsize > 250000) {
                                    alert("Please check Payslip file size is more than 250KB");
                                    document.getElementById('txtFilePayslip').focus();
                                    return false;
                                }
                                var txtFileCV = document.getElementById('txtFileCV').value;
                                if (txtFileCV == "") {
                                    alert("Please Upload Latest CV");
                                    document.getElementById('txtFileCV').focus();
                                    return false;
                                }
                                var cvsize = document.getElementById('txtFileCV').files[0].size;
                                if (cvsize > 250000) {
                                    alert("Please check Resume file size is more than 250KB");
                                    document.getElementById('txtFileCV').focus();
                                    return false;
                                }
                                if (!(document.getElementById("test5").checked)) {
                                    alert("Please Agree to our Terms and Conditions");
                                    document.getElementById('test5').focus();
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        </script>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#country').on('change', function () {
                                    var countryID = $(this).val();
                                    if (countryID) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'country_id=' + countryID,
                                            success: function (data) {
                                                $("#state").html(data);
                                                $("#city").html('<option value="">Select State First</option>');
                                            }
                                        });
                                    } else {
                                        $('#statelist').html('<option value="">Select Country First</option>');
                                        $('#city').html('<option value="">Select state first</option>');
                                    }
                                });
                                $('#state').on('change', function () {
                                    var stateID = $(this).val();
                                   
                                    if (stateID) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'state_id=' + stateID,
                                            success: function (htmls) {
                                                $('#city').html(htmls);
                                            }
                                        });
                                    } else {
                                        $('#city').html('<option value="">Select State First</option>');
                                    }
                                });
                            });
                            $(document).ready(function () {
                                $('#country2').on('change', function () {
                                    var countryID2 = $(this).val();
                                    if (countryID2) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'country_id=' + countryID2,
                                            success: function (data) {
                                                $("#state2").html(data);
                                                $("#city2").html('<option value="">Select State First</option>');
                                            }
                                        });
                                    } else {
                                        $('#statelist').html('<option value="">Select Country First</option>');
                                        $('#city').html('<option value="">Select state first</option>');
                                    }
                                });
                                $('#state2').on('change', function () {
                                    var stateID2 = $(this).val();
                                    
                                    if (stateID2) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxData.php',
                                            data: 'state_id=' + stateID2,
                                            success: function (htmls) {
                                                $('#city2').html(htmls);
                                            }
                                        });
                                    } else {
                                        $('#city').html('<option value="">Select State First</option>');
                                    }
                                });
                            });
                        </script>
                        <script>
                            function check_adr() {
                                if (document.getElementById("adr").checked == true) {
                                    document.getElementById("perm_adr").style.display = "none";
                                } else {
                                    document.getElementById("perm_adr").style.display = "block";
                                }
                            }
                        </script>
                    </main>
                   
                    <?php include"footer.php"; ?>
                       
                        <div id="terms-pop" class="modal">
                            <div class="modal-content">
                                <h4 class="h4">Terms &amp; Conditions for Register With Needyin</h4>
                                <p class="text-justify">
								By registering your profile or uploading your resume to www.needyin.com you agree to the following terms.
								</p> <p class="text-justify">
•	The resume/profileinformation/data fed by the user can be updated by the user alone, free of cost.</p> 
<p class="text-justify">
•	CTPL offers no guarantee nor warranties that there would be a satisfactory response or any response at all once the resume/profile information/data is fed by the user.</p><p class="text-justify">
•	CTPL neither guarantees nor offers any warranty about the credentials bonafides, status or otherwise of the prospective employer/organization which downloads the resume/profile information/data and uses it to contact the user.</p>
<p class="text-justify">
•	CTPL would not be held liable for loss of any data technical or otherwise, or of the resume/profile information/data or particulars supplied by user due to acts of god as well as reasons beyond its control like corruption of data or delay or failure to perform as a result of any cause(s) or conditions that are beyond CTPL’s reasonable control including but not limited to strikes, riots, civil unrest, Govt. policies, tampering of data by unauthorized persons like hackers, distributed denial of service attacks, virus attacks, war and natural calamities.</p><p class="text-justify">
•	It shall be sole prerogative and responsibility of the user to check the authenticity of all or any response received pursuant to the resume/profile information/data being fed into the network system of CTPL by the user, for going out of station or in station for any job or interview. CTPL assumes no responsibility in respect thereof and expressly disclaims any liability for any act, deed or thing which the user may so do, pursuant to the receipt of the response, if any, to the resume/profile information/data being fed into the network system of CTPL.</p><p class="text-justify">
•	Uploading of multiple resume/profiles beyond a reasonable limit by the same individual, using the same or different accounts shall entitle CTPL to remove the Resume/profiles without notice to the subscriber. This service is only meant for candidates looking for suitable jobs. Any usage with commercial intent is prohibited.</p><p class="text-justify">
•	CTPL reserves its right to reject and delete any resume/profile information/data fed in by the user without assigning any reason.</p><p class="text-justify">
•	This free service entitles the user alone ie.the same person, to add modify or change the data/information fed in by him but does not entitle him to use the free service to feed fresh insertion or information/data/resume/profile of another person in place of the insertion or information/data already fed in by such user.</p><p class="text-justify">
•	CTPL has the right to make all such modifications/editing of resume/profile in order to fit resume/profile in its database.</p><p class="text-justify">
•	It shall be the sole responsibility of the user to ensure that it uses the privacy setting options as it deems fit to debar/refuse access of the data fed by it, to such corporate entities individuals or consultants. CTPL shall not be responsible for such insertions/data being accessed by its subscribers or users whose access has not been specifically blocked/debarred by the user while using the privacy settings.</p>
<p class="text-justify">
•	Although CTPL will make all possible efforts to adhere to these privacy settings, it will not be responsible for a resume/profile being seen by a blocked user for any reason. For best privacy settings it is recommended that you do not allow your resume/profile to be searched at all.</p><p class="text-justify">
•	The user represents that he/she is not a minor and is not under any legal or other disability which limits his/her ability to comply with these Terms or to install and use the services subscribed and purchased with minimal risk of harm to you or others. You further represent that you are not purchasing the products/services for resale to others and will not do so without CTPL’s prior written consent.</p><p class="text-justify">
•	All changes/modifications made by the user to the data/information shall be effected and will come into operation only after 24-48 hours of such changes/modifications being made.
On registration you agree to: a) CAREATOR TECHNOLOGIES PRIVATE LIMITED contacting you via email and/or telephone to verify the information available on your profile. b) Making your profile/resume searchable to the clients of CAREATOR TECHNOLOGIES PRIVATE LIMITED. c) You may be contacted by recruiters via email, telephone and/or post. If you wish to not be contacted you need to deactivate your account. We recommend that you read the privacy settings carefully and CAREATOR TECHNOLOGIES PRIVATE LIMITED will not be held responsible for contacts/mails received by you. d) Receive job alerts (mails detailing jobs that match your profile as entered on Needyin) via email. You may remove yourself from the job alert email database by resetting this option in the Setting section of your resume/profile e) Receive promotional mailers/special offers. You may remove yourself from the promotional mailer email database by resetting this option on the Setting section of your resume/profile.</p><p class="text-justify">
CTPL uses an automated algorithm to match jobs against the keywords/attributes present in the profile submitted by the user, and hence offers no guarantee nor warranties that the jobs sent in the job mail will be relevant to the profile.
CTPL neither guarantees nor offers any warranty about the credentials of the prospective employer/organization whose details are sent in the job mail.</p>
<p class="text-justify">
Although all attempts will be made by CTPL to send all jobs on the specified days, however it does not take any responsibility for job mail not been sent (which may be on account of non-availability of jobs as per the user's specified criteria).
CTPL will not be responsible in any way for failure of any backend technology of mail exchange server and resultant inability of a user to receive job mail.</p><p class="text-justify">
CTPL reserves the right to regulate number of jobs sent out in the Job mail to a particular user in a single day.
The user agreement between a user/subscriber and CAREATOR TECHNOLOGIES PRIVATE LIMITED will be treated as having been terminated in the following events: (i) On completion of the term for which the user/subscriber engages the services of the website; or (ii) In case the user/subscriber violates any of the conditions of this agreement or any other agreement entered into by him with CAREATOR TECHNOLOGIES PRIVATE LIMITED, however, such termination will be at the option and discretion of CAREATOR TECHNOLOGIES PRIVATE LIMITED ; or (iii)On writing and on such terms as agreed to by the parties mutually.</p>
<p class="text-justify">
CTPL would not be held liable for loss of any data technical or otherwise and particulars supplied by subscribers due to reasons beyond its control like corruption of data or delay or failure to perform as a result of any causes or conditions that are beyond Careator Technology reasonable control including but not limited to strikes, riots, civil unrest, Govt. policies, tampering of data by unauthorized persons like hackers, war and natural calamities.</p>
<p class="text-justify">
The User of these services does not claim any copyright or other Intellectual Property Right over the data uploaded by him/her on the website.</p>
<p class="text-justify">
Jurisdiction for any disputes arising from and related to this contest shall be Bengaluru, India to the exclusion of all other courts.
Disputes shall be resolved in accordance with the laws of India as applicable
</p>
                            </div>
                            <div class="modal-footer"> <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a> </div>
                        </div>
                       
            </body>

            </html>