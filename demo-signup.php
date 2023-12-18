<?php

require_once 'class.user.php';
$reg_user = new USER();
 
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
	 $pskills=$_POST['PSkills'];
	 $sskills=$_POST['SSkills'];
	 $newskills=$_POST['newskill'];
	  $area=$_POST['area'];
	  $skills=implode(",",$_POST['PSkills']);
	$sec_skills=implode(",",$_POST['SSkills']);
	$askills=$skills.",".$sec_skills;
	 if($newskills!='')
	{
		 $skill_sql="select skill_Id from tbl_masterskills where skill_Name='".$newskills."' ";
		$skill_res=mysqli_query($con,$skill_sql);
		if(mysqli_num_rows($skill_res) == 1)
		{
			$newskills_add=mysqli_fetch_array($skill_res);
			 $askills=$askills.",".$newskills_add['skill_Id'];
			
			 $skills=$skills.",".$newskills_add['skill_Id'];
			
			 $askills=trim($askills,'Others,');
			
			 $skills=trim($skills,'Others,');
		}
		else
		{
			$master_query = "INSERT into tbl_masterskills SET  skill_Name='".$newskills."',skill_Status=1"; 
			$mq1 = mysqli_query($con,$master_query);
			 $skill_res="select skill_Id from tbl_masterskills where skill_Name='".$newskills."' ";
			$skill_res_ar=mysqli_query($con,$skill_res);
			 $newskills_add=mysqli_fetch_array($skill_res_ar);
		 $askills=$askills.",".$newskills_add['skill_Id'];
			
			 $skills=$skills.",".$newskills_add['skill_Id'];
		
			 $askills=trim($askills,'Others,');
			 
			 $skills=trim($skills,'Others,');
		}
					
	}
	else
	{
			
	}
	$msgg=array();	
	if(array_intersect($pskills,$sskills))
	{
			$msgg[]="Primary and Secondary skills can't be same";					  
	}
	 $allowedrr =  array('DOCX','DOC' ,'PDF','JPG','PNG','JPEG','GIF');
	 $Np=trim($_POST['selectNp']);	 
	 $Rtype=trim($_POST['jReasonType']);
	 
	 $CSL=trim($_POST['CSL']);	
     $ESL=trim($_POST['ESL']);	 
	 $EMSL=trim($_POST['EMSL']);
     $Cloci=trim($_POST['Cloc']);	
	 $nri=trim($_POST['country']);
	 $checkbox=trim($_POST['test5']);	
	$gender=trim($_POST['gender']);	
	
	 
	 $cvextension=strtoupper(pathinfo($_FILES['txtFileCV']['name'], PATHINFO_EXTENSION)); 		
	 $_FILES['txtFileCV']['name'];		 		
	 $Cv="Upload/Cv/".$_FILES['txtFileCV']['name'];
	 $mblen=strlen($mob);			
    
     $allowed =  array('DOCX','DOC' ,'PDF');
     $stmt = $reg_user->runQuery("SELECT * FROM tbl_jobseeker WHERE JEmail=:email_id OR JPhone=:phone");	
     $stmt->execute(array(":email_id"=>$email,":phone"=>$mob));
	 $row = $stmt->fetch(PDO::FETCH_ASSOC); 
	 $stmt_emp = $reg_user->runQuery("SELECT * FROM tbll_emplyer WHERE emp_email=:email_id OR contact_num=:phone");	
     $stmt_emp->execute(array(":email_id"=>$email,":phone"=>$mob));
	 $row_emp = $stmt_emp->fetch(PDO::FETCH_ASSOC); 
	 if($stmt_emp->rowCount() > 0)
	 {
		$msgg[] = "Sorry !  email OR mobile number  already registered as Employer, Please Try another one";
	 }		 
			 
	 if(empty($TEy)&&empty($TEm))
		 {
			 $msgg[]="Please Fill your experience";
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
		if($reg_user->register($uname,$email,$upass,$code,$mob,$TEy,$TEm,$PLo,$Np,$CSL,$ESL,$EMSL,$Cloci,$skills,$Rtype,$nri,$sec_skills,$askills,$gender,$area))
	     {
				  $idsql = "SELECT * from tbl_jobseeker where JEmail='$email'";
			      $idsqlres=mysqli_query($con,$idsql);
			      $idresrow=mysqli_fetch_array($idsqlres);
			      $id=$idresrow['JUser_Id'];
				  $jid=$id;
			      $key = base64_encode($id);
				 $js_name=base64_encode($uname);
				  $js_id=base64_encode($id);
				  $js_code=base64_encode($code);
			      $id = $key;
                  $siteurl="https://production.needyin.com"; 
                   session_start();     
                 $_SESSION['link'] = $siteurl;
                 $_SESSION['id'] = $id;
                 $_SESSION['code'] = $code;
                 
    //show success message
        $new_name_cv="Upload/Cv/CV_".$jid.".".$cvextension;
		rename($Cv,$new_name_cv);		
		 move_uploaded_file($_FILES['txtFileCV']['tmp_name'],$new_name_cv);								 				 
       		 	  		
		
		$sqlfiles=" UPDATE `tbl_currentexperience` SET `UpdateCV`='$new_name_cv' WHERE `JUser_Id`='$jid'";
		$sqlres=mysqli_query($con,$sqlfiles);
		
	
				 
			if($sqlres)
			{
		               $message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43px'>
						            <td align='left' width='400px;' >
						                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='300px;'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |
						                        </td>
												<td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/js_register.php?jsn=".$js_name."&jsi=".$js_id."&jsc=".$js_code."' target='_blank'>View in web</a> 
						                        </td>
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(".$siteurl."/img/thankyou_img.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear ".ucfirst($uname).",<br><br>
								              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have successfully registered your account with us. To complete your registration process, please click on the below link to validate your account for your account security. 
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>To complete your registration process, please click on the below link to validate your account.</p>
					                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'><a href=".$siteurl."/verify.php?id=".$id."&code=".$code.">Click here to validate </a></p>
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>
					        <tr>
					            <td colspan='2' style='background:#0274bb;' align='center'>
					                <p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
					            </td>
					        </tr>
    
    </table>";
									
					$subject = "NeedyIn Registration Activation Link";						
                    //
                    //
                    //
                    $ok=$reg_user->send_mail($email,$message,$subject);	
				/* 	$description="One new profile is created";
                    $insert_query = "INSERT into tbl_notifications SET description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$idresrow['JUser_Id']."',notification_to='2',notification_from='".$idresrow['JUser_Id']."',mode='admin'"; 
					$rr1 = mysqli_query($con,$insert_query); */
          
		           		  $skill_ids=$_POST['PSkills'];
			             foreach($skill_ids as $skill)
					      {
			                 
		
	if($nri=="101")
	 $qa="select emp_id,Job_Id from tbl_jobposted where Loc_Id='".$PLo."'and  FIND_IN_SET('".$skill."', Job_Skill)";
	else
		 $qa="select emp_id,Job_Id from tbl_jobposted where FIND_IN_SET('".$skill."', Job_Skill)";
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

								         $cj4="select emp_email,contact_name ,subscription_type from tbll_emplyer where emp_id='".$result_cj3['emp_id']."'";  
										   $resultcj4 = mysqli_query($con,$cj4);  
										   $result_cj4=mysqli_fetch_array($resultcj4); 
                                           $job_email=$result_cj4['emp_email']; 
    
												if($result_cj4['subscription_type']== 'FULL' || $result_cj4['subscription_type']== 'DEMO') {
													$description="One new profile is created";
                                       $insert_query = "INSERT into tbl_notifications SET job_id='".$job_id."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$idresrow['JUser_Id']."',notification_to='".$result_cj3['emp_id']."',notification_from='".$idresrow['JUser_Id']."',mode='jobseeker'"; 
										$rr1 = mysqli_query($con,$insert_query);  
										}
								
										/* $description="One new profile is created";
                                       $insert_query = "INSERT into tbl_notifications SET job_id='".$job_id."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$idresrow['JUser_Id']."',notification_to='".$result_cj3['emp_id']."',notification_from='".$idresrow['JUser_Id']."',mode='jobseeker'"; 
										$rr1 = mysqli_query($con,$insert_query);  */
									
										
                                       $emp_name=base64_encode($result_cj4['contact_name']);

										$subject="New Profile In Needyin";

							      

										$nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."about-us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."contact.php.php' target='_blank'>Contact</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."notif.php?name=".$emp_name."' target='_blank'>View in web</a> </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear ".$result_cj4['contact_name'].",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified matching with your job details which are close to your skills,location and / or other criteria. </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>I heard about needyin from my friend and registered in the portal two weeks back. </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'> I joined the portal a few days back and I could reach the recruiters as per by preferred location anad skills.</p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; ;width:120px;text-decoration:none;margin-left: 50px;'>I joined this portal recently. To get my details please click on the link below</br><a href=".$siteurl.">NeedyIn </a></p></td>
                           
                        </tr>
                    </table>
</div>						
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:30px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please dont reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
   // echo $nt_message; exit;
  //$mm=$reg_user->send_mail2($job_email,$nt_message,$subject);
	$nt_message=null;
		}							
	    }                		    
       	?>
    <script> 
    // alert("Registered Successfully Please Check Your Email"); /*Commented due to requirements and Added below location code*/
 window.location.href="index(otp).php";
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
                <?php ///include"source.php" ?>
				<!-- styles sheets -->
<!-- styles sheets -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-select.css">
<!--<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">-->
<!--<link rel="stylesheet" href="css/font-awesome.min.css">-->
<link rel="stylesheet" href="css/materialize.css">
<!--<link rel="stylesheet" href="css/reset-styles.css">-->
<link rel="stylesheet" href="css/style.css">
<!--<link rel="stylesheet" href="css/recruiter.css">-->
<link rel="stylesheet" href="css/responsive.css">

<!--<link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">-->
<link rel="stylesheet" href="css/nouislider.css">

<!-- <script src="js-webshim/minified/polyfiller.js"></script>-->
 <script type="text/javascript" src="js/modernAlert.min.js"></script>
<!--/ modern alert -->
<!-- js includes -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!--<script type="text/javascript" src="js/image-scale.js"></script>-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-select.js"></script>
<script type="text/javascript" src="js/customone.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/objectFitPolyfill.min.js"></script>
<!--<script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>-->
<script type="text/javascript" src="js/html5shiv.min.js"></script>
<!--<script type="text/javascript" src="js/jquery.easyResponsiveTabs.js"></script>-->

<script type="text/javascript" src="js/nouislider.js"></script>



<!-- data tables for bootstrap -->

<!--<script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>-->
<script type="text/javascript">
    modernAlert();
    function modernAlertCallback(input) {
        if (typeof input === 'boolean') {
            if (input === true) {
                alert('You clicked ok!');
            } else {
                alert('You clicked cancel!');
            }
        } else {
            alert('Your name is ' + input + '!');
        }
    }
	
</script>    
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>

<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
	(function($){
		$(window).on("load",function(){

			//$("body").mCustomScrollbar({
				theme:"minimal"
			});

		});
	})(jQuery);
</script>
<!--Start of Zendesk Chat Script-->
<!--<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?4zAjUjU13yamEqxKtiwNnrmjmAyIF164";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>-->
<!--End of Zendesk Chat Script-->
<!--<script>
    webshim.activeLang('en');
    webshims.polyfill('forms');
    webshims.cfg.no$Switch = true;

</script>-->


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

                    <!--New code for Already Existed Email Id-->
                    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#txtEmail').keyup(function()
    {
    $.post("avail_email.php",
    {
        txtEmail : $('#txtEmail').val()
        },
        function(response)
        {
            $('#txtEmailResult').fadeOut()
            setTimeout("txtEmailResult('txtEmailResult','"+escape(response)+"')",350);
        });
        return false;
    });
    });
function txtEmailResult(id,response)
{
    $('#txtEmailLoading').hide();
    $('#'+id).html(unescape(response));
    $('#'+id).fadeIn();
}
</script>
<!--End AJAX & JS code for Email validation -->

 <!--New code for Already Existed MobileNumber Id-->

 <!-- <script>
    $(document).ready(function(){
           $("#txtMobile").blur(function(){
               $("#Status_Cell").show();
                $("#Status_Cell").html("checking...");
           var cell = $("#txtMobile").val();
             $.ajax({
                   type:"post",
                   url:"avail_mobile.php",
                   data:"cell="+cell,
                       success:function(data){
                       if(data==0){
                           $("#Status_Cell").html("Cell Number available");
                       }
                       else{
                           $("#Status_Cell").html("<font color='red'>mobile number is already used use another number</font>");
                       }
                   }
                });
   
           });
   
        });
   </script> -->


   <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#txtMobile').keyup(function()
    {
    $.post("avail_mobile.php",
    {
        txtMobile : $('#txtMobile').val()
        },
        function(response)
        {
            $('#txtMobileResult').fadeOut()
            setTimeout("txtMobileResult('txtMobileLoading','"+escape(response)+"')",350);
        });
        return false;
    });
    });
function txtMobileResult(id,response)
{
    $('#txtMobileLoading').hide();
    $('#'+id).html(unescape(response));
    $('#'+id).fadeIn();
}
</script>


            </head>

            <body>
                <?php 
	include_once("analyticstracking.php");
	include"prelogin-header.php"; ?>


                    <!-- main-->
                    <main>
                        <!-- login, register, forgot password -->
                        <section class="signin">
                            <div class="container">
                                <div class="row sign">
                                    <div class="col-md-12">
                                        <div class="signin-main signup">
                                            <div class="signin-in">
                                                <!-- sign in-->
                                                <div id="signin">
                                                    <h3 class="h3 text-center flight">CREATE AN ACCOUNT <span class="fbold txt-blue">FOR JOB SEEKER </span></h3>
                                                    <!-- responsive tab -->
                                                    <div class="tab-registration">
                                                        <!-- personal details -->
                                                        <h4 class="h4 txt-blue">Personal Details </h4>
                                                        <?php if(isset($msg)) echo $msg;  ?>
                                                            <form method="post" id="form1" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="txtName" name="txtName" type="text" class="validate" pattern=".{5,}" title="Three Characters are Minimum for Name" maxlength="55" required>
                                                                            <label for="Fullname">Full Name <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">

                                                                        <div class="input-field">
                                                                            <input id="txtEmail" name="txtEmail" type="text" class="validate" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="55" onfocusout="insert_visitor()" required>
                                                                            <label for="Fullname">Email ID <span class="mand">*</ span></label>
                                                                            <span id = "txtEmailLoading"></span>
                                                                            <span id = "txtEmailResult"></span> 

                                                        </div>
                                                    </div> 		
														<div class="col-md-4">
                                                        <div class="input-field">
                                                            <input id="txtMobile" name="txtMobile" type="text" class="validate" pattern = "^[6789]\d{9}$" title="mobile number should be 10 digits" maxlength="10" onkeypress="return isNumber()" onfocusout="insert_visitor()" placeholder="Enter Only Non-DND Numbers" required>
                                                            <label for="Fullname">Mobile Number <span class="mand">*</span></label>
                                                            <span id = "txtMobileLoading"></span>
                                                                <span id = "txtMobileResult"></span>
                                                                                                                   
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        $('#txtMobile').bind("cut copy paste", function (e) {
                                                                            e.preventDefault();
                                                                        });
                                                                    </script>
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                            <input id="txtPwd" name="txtPwd" type="password" class="validate" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)" maxlength="55" >
                                                                            <label for="Fullname">Password <span class="mand">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="input-field">
                                                                             <input id="cpwd" name="cpwd" type="password" class="validate" maxlength="55" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                                            <label for="Fullname">Confirm Password <span class="mand">*</span></label>
                                                                         </div>
                                                                     </div>
                                                                    
                                                                     <div class="col-md-4">
                                                                         <div class="row">
                                                                             <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Experience <span class="mand">*</span></label>
                                                                                    <select class="form-control classic" name="TExpY" id="TExpY">
                                                                                        <?php for($i=1;$i<=30;$i++) {  ?>
                                                                                            <option value="<?php echo $i;?>">
                                                                                                <?php echo $i; if($i==1) echo " Year"; else echo " Years"; ?> </option>
                                                                                            <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>&nbsp;</label>
                                                                                    <select class="form-control classic" name="TExpM" id="TExpM">
                                                                                        <?php for($i=0;$i<=11;$i++) {  ?>
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
                                                                            <label for="PSkills">Primary Skills <span class="mand">*</span></label>
                                                                            <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="PSkills[]" id="PSkills" onChange="skill_check(this)";>
                                                                                <option value="0" disabled>Select Multiple Skills </option>
																				<option value="Others">Others</option>
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
																<div id="other-skill" style="display:none;">
																<label><input id="other-skills" name="newskill" onfocusout="myskill()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;"</input>
																</label>
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
						</script>
                        
                                                                    </div>
																	 <div class="col-md-4 custom-btn mt5">
                                                                        <div class="form-group">
                                                                            <label for="PSkills">Seconday Skills </label>
                                                                            <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="SSkills[]" id="SSkills" >
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
                                                                                
																				<!--<option value="0"selected="selected" disabled></option>-->
																				<option value="Others">Others</option>
                                                                                <option value="Parents in Old age">Parents in Old age</option>
                                                                                <option value="Medical Emergency - Parents">Medical Emergency - Parents</option>
                                                                                <option value="Medical Emergency - Self">Medical Emergency - Self</option>
                                                                                <option value="Medical Emergency - Spouse">Medical Emergency - Spouse</option>
                                                                                <option value="Medical Emergency - Children">Medical Emergency - Children</option>
                                                                                <option value="Socio-Political Condition">Social-Political Condition</option>
                                                                                <option value="Spouse Relocated">Spouse Relocated</option>
                                                                                <option value="Children Education">Children Education</option>
                                                                                <option value="Back to Homeland">Back to Homeland</option>
                                                                                
                                                                            </select>

                                                                        </div>
                                                                    </div>
																	</div>
																	 <div class="row">
																	           <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <?php
															$sqls = "SELECT Cntry_Name FROM tbl_country where Cntry_Id='".$rows['country_id']."'";
															$querys = mysqli_query($con, $sqls);
															$rows11 = mysqli_fetch_array($querys);
															$countryname = $rows11['Cntry_Name'];
															
															//$sql1 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country where Cntry_Id=101 ORDER BY Cntry_Name";
															$sql1 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
															$query1 = mysqli_query($con, $sql1);
															?>
                                                                                <label class="pl5" for="Fullname">Country <span class="mand">*</span></label>
                                                                                <select class="form-control classic" name="country" id="country" required onchange="return get_cntryid(this.value);  return get_prefid(this.value)">
                                                                                    <option value="0"selected="selected" disabled>  </option>
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
																		<label class="pl5" for="Fullname">Gender <span class="mand">*</span></label>
																		<select class="form-control classic" name="gender" id="gender" required >
                                                                            <option value="0" selected="selected" disabled>  </option>
																			<option value="Male"> Male </option>
																			<option value="Female"> Female </option>																					
																		</select>
																		</div>
																		</div>
																		<div class="col-md-4 atbtn">
                                                                       <label>Resume <span class="mand">*</span> <span class="desc-tr"> <small>(Attach resume | Accepted formats: pdf, doc, Resume file size should not be more than 250KB)</small></span></label>
                                                                        <div class="file-field input-field">
                                                                            <div class="btn" style="height=25px"> <span>Attachment</span>
                                                                                <input type="file" name="txtFileCV" id="txtFileCV" onchange="Validateresume(this)" style="height=25px" required> </div>
                                                                            <div class="file-path-wrapper">
                                                                                <input class="file-path validate" type="text"> </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                               
                                                                <h4 class="h4 txt-blue">Employment Details </h4>
                                                                <div class="row">
                                                                    <!--ctc-->
													<div class="col-md-4">
													
                                                        <div class="input-field" style="margin-top: 1.25rem;">   
                                                                                                          
                                                <input value="<?php echo $csal_data['CurrentSalL'];?>" name="CSL" id="CSL" maxlength="4" type="text"  class="validate"  onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                <label>Current CTC (Lacs) <span class="mand">*</span> </label>
												</div>
								                    </div>
                                                                      <!--  <div class="minmax-sliderd cur-sal">
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
																			var sliderFormat1 = document.getElementById('slider-range');
                                                                            var inputFormat = document.getElementById('input-format');
                                                                            sliderFormat.noUiSlider.on('update', function (values, handle) {
																				var sliderFormat1 = document.getElementById('slider-range');
                                                                                values[handle] = (values[handle]);
                                                                                var cr_val = (values[handle]);
																				var inputFormat1 = document.getElementById('slider-range-lower');
                                                                                inputFormat.value = cr_val;
																				//inputFormat1.value = cr_val;
																				minval=cr_val;
																				//alert(minval);
																				//updateSliderRange(parseFloat(inputFormat.value), 50);
																				var sliderFormat1 = document.getElementById('slider-range');
																				var	origins = sliderFormat1.getElementsByClassName('noUi-origin');
																				toggle.call(this, origins[0]);
																				                                                                        
																			});
																		
                                                                           function toggle ( element ){

																			
																			}

																			function updateSliderRange ( min, max ) {
																				sliderFormat1.noUiSlider.updateOptions({
																				start: [min,max],
																				range: {
																					'min': 1,
																					'max': max
																					}
																				
																					});
																			}
                                                                   
                                                                        </script>-->
                                                                   
																	<!-- ectc-->
							 <div class="col-md-4 ">   
							
							 <label>Expected CTC (Lacs)<span class="mand">*</span></label> <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                   <div style="margin-top:-2px;">
                                                   <input value="<?php echo $csal_data['ExpSalL']; ?>" name="ESL" id="ESL" class="validate"   placeholder="MinSalary"  type="text" maxlength="4"    title="Must Mention MinSalary"  onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                  </div>
                                                    </div>    
                                                 
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group"> 	
                                                   <div style="margin-top:-2px;">
                                                   <input value="<?php echo $csal_data['ExpMaxSalL'];  ?>" name="EMSL" id="EMSL" class="validate" placeholder="Max Salary"    maxlength="4" type="text"  title="Must Mention Max Salary" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                                   </div>
                                                </div>
                                            </div>
											
                                        </div>
                                                                            <!--<div class="minmax-sliderd">
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
                                                                        </div>-->
                                                                    
																	
																	
									
                                                                   <!-- <script>
                                                                        var sliderFormat1 = document.getElementById('slider-range');
                                                                        var minval = inputFormat.value ;
                                                                  
                                                                        noUiSlider.create(sliderFormat1, {
                                                                            start: [1, 50],
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
																		
                                                                    </script>-->
                                                                    
																	
																	
																	
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Notice Period <span class="mand">*</span></label>
                                                                            <select class="form-control classic" name="selectNp" id="selectNp">
                                                                                
                                                                                <option value="1">Immediate</option>
                                                                                <option value="15">Less than 15 days</option>
                                                                                <option value="30">1 Month</option>
                                                                                <option value="60">2 Month</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    
                                                                    <div class="col-md-4 mt15" id="curr_cntry">
                                                                        <div class="form-group" id="current_loc">
                                                                            <?php
																				$sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
																				$query = mysqli_query($con, $sql);
																				if(!$query)
																				echo mysqli_error($con);
																				?>
		                                                                                <label>Current Location <span class="mand" id="cl">*</span></label>
		                                                                                <select class="form-control classic" name="Cloc" id="Cloc" style="height=40px" required>
		                                                                                    <!--<option value="0" selected="selected" disabled> </option>-->
		                                                                                    <?php
																				while ($row1 = mysqli_fetch_array($query))
																				{ 
																				extract($row1);
																				?>
																							<option value="<?php echo $row1['Loc_Id']; ?>" <?php if(trim($row1['Loc_Id'])== "4460"){ echo "selected";}else { echo "";}?>><?php echo $row1['Loc_Name']; ?></option>
	                                                                                        <!--<option value="<?php echo $Loc_Id; ?>">
	                                                                                            <?php echo $Loc_Name; ?>
	                                                                                        </option>-->
	                                                                                        <?php } ?>
	                                                                                </select>

                                                                        </div>

                                                                    </div>
																	<!--plocation>-->
																	<br>
																	<div class="col-md-4" id="pref_loc">
                                                                        <div class="form-group" >
                                                                            <?php
                                                                                $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
                                                                                $query = mysqli_query($con, $sql);
                                                                                if(!$query)
                                                                                echo mysqli_error($con);
                                                                                ?>
                                                                                <label>Preferred Location <span class="mand" id="pl">*</span></label>
                                                                                <select class="form-control classic" id="ploc" name="ploc" style="height=40px" onChange="showArea(this.value)">
                                                                                    <option value="0"selected="selected" disabled>  </option>
                                                                                    <?php
									                                                        while ($row1 = mysqli_fetch_array($query))
									                                                        { 
									                                                         extract($row1);
									                                                        ?>
																					<option value="<?php echo $row1['Loc_Id']; ?>" <?php if(trim($row1['Loc_Id'])== "4460"){ echo "";}else { echo "";}?>><?php echo $row1['Loc_Name']; ?></option>
                                                                                       <!-- <option value="<?php echo $Loc_Id; ?>">
                                                                                            <?php echo $Loc_Name; ?>
                                                                                        </option>-->
                                                                                        <?php } ?>
                                                                                </select>

                                                                        </div>
                                                                    </div>
<div class="col-md-4" id="area_loc">
<div class=" form-group">
<div class="form-group" >
<label>Select Area <span class="mand" id="pl">*</span></label>                                                                         
<div id="txtHint">
<select class="form-control classic" placeholder="Area Location" ></select>
</div>
</div>
</div>
<script>

function showArea(str)
{
if (str=="")
{
	//alert("shashi");
document.getElementById("txtHint").innerHTML="";
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
document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("GET","get_area.php?q="+str,true);
xmlhttp.send();
}
</script>
                                                                        </div>
                                                                    </div>																	
																	<!--resume-->
																	
                                                                </div>
                                                               
                                                                <!--/button -->
                                                                <div class="row">
																
                                                                    <div class="col-md-4">
                                                                        <p class="agree">
                                                                            <input type="checkbox" id="test5" name="test5" value="checked" title="Please read the T&C">
																			
                                                                            <label for="test5" >I Agree to the<a href="#terms-pop"> Terms &  Conditions</a></label>
																			 
                                                                        </p>
                                                                        <input type="hidden" name="user_type" value="job_seekar">
																	</div>
																		
																		<div class="col-md-3"></div>
																		<div class="col-md-3">
																		<br>
																		
                                                                        <button class="btn-register btn btn-block waves-effect waves-light" align = "right" type="submit" name="btn-signup" onclick = "return validate();"/>Register with us <i class="fa fa-user-plus" aria-hidden="true"></i> </button></div>
                                                                        <div class="col-md-2" style="width:112px;">
																		<br/>
																		<a class="btn-register btn btn-block waves-effect waves-light" href="index.php" >CANCEL</a>
                                                                       </div>																		
																		<script>
																		function termschecked(){										
																			var terms=document.getElementById('test5').checked=true;
																		}
																		</script>
                                                                </div>
																<div class="row">
																	<div class="col-md-4"></div>
																		<div class="col-md-4"></div>
																<div class="col-md-4">
                                                               <p><span class="mand">*</span> <font size="1px">All are mandatory fields</font></p>
																 </div></div>
                                                            </form>
                                                   
                                                    <!--/ responsive tab-->
                                                    <!-- bootbox code -->
                                                </div>
                                                <!-- /sing in-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--/login, register, forgot password -->
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
                        <!-- Authorised Validation Start-->
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
                         <!-- Authorised Validation End-->
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
                                var acceptList = [ "","gmail.com","yahoo.com","outlook.com","hotmail.com","rediffmail.com","yahoo.co.in","yahoo.co.uk","allscripts.com"];
								var emailValue = document.getElementById('txtEmail').value; 
								var splitArray = emailValue.split('@'); 
								if(acceptList.indexOf(splitArray[1]) >= 0)
								{
									
								}
								else
								{
									alert("Only public domains are allowed");
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
								var mobileRegex = new RegExp("^[1-9][0-9]{9}");
								if(!mobileRegex.test(mobnum1))
								{
									alert("Please Enter Valid Mobile Number ");
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
                                if (exp == "0" ) {
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
                    
								var new_skills=document.getElementById('other-skills').value;
                                var options = document.getElementById('PSkills').options,
                                    count = 0;
								if(options[1].selected && new_skills == '')
								{
									 alert("Please Enter New Skill");
                                    document.getElementById('other-skills').focus();
                                    return false;
								}
                                for (var i = 0; i < options.length; i++) {
                                    if (options[i].selected) count++;
                                }
                                if (count < 1) {
                                    alert("Please Select at least 1-Skills");
                                    document.getElementById('PSkills').focus();
                                    return false;
                                }
								var priskills = document.getElementById('PSkills').options;
								var secskills = document.getElementById('SSkills').options;
								
								for (var i = 1; i < priskills.length; i++) {
									
                                    if (priskills[i].selected && secskills[i-1].selected){
										 alert("Primary skills and Secondary skills can't be same");
                                    document.getElementById('PSkills').focus();
                                    return false;
									
									}
									}
								
                                var reasonoption = document.getElementById('jReasonType').value;
                                if (reasonoption == "0") {
                                    alert("Please Select Reason to Relocate");
                                    document.getElementById('jReasonType').focus();
                                    return false;
                                }
								
                            
                                var selectNp = document.getElementById('selectNp').value;
                                if (selectNp == '0') {
                                    alert("Please Select Notice Period");
                                    document.getElementById('selectNp').focus();
                                    return false;
                                }
                                var country = document.getElementById('country').value;
								 if (country == "0") {
                                    alert("Please Select Country");
                                    document.getElementById('country').focus();
                                    return false;
                                }
								  var gen = document.getElementById('gender').value;
                                if (gen == '0') {
                                    alert("Please Select Gender");
                                    document.getElementById('gender').focus();
                                    return false;
									}

                                var current = document.getElementById('CSL').value;
                                if (current == "") {
                                    alert("Please Enter Current CTC");
                                    document.getElementById('CSL').focus();
                                    return false;
                                }
							 
							  var ExpectedMin = document.getElementById('ESL').value;
                                if (ExpectedMin == "") {
                                    alert("Please Enter Min Salary in ExpectedCTC");
                                    document.getElementById('ESL').focus();
                                    return false;


                                }
							    var ExpectedMax = document.getElementById('EMSL').value;
                                if (ExpectedMax == "") {
                                    alert("Please Enter Max Salary in Expected CTC");
                                    document.getElementById('EMSL').focus();
                                    return false;
                                }
                           /*  var ExpectedMin = document.getElementById('ESL').value;
                                var ExpectedMax = document.getElementById('EMSL').value;
                                if(ExpectedMin==0&&ExpectedMax==0)
                                {
            		alert("Please Give Expectedsalary");
            		document.getElementById('ESL').focus();
            		return false;
            	} */
                            
                if((Number(ExpectedMin)>Number(ExpectedMax)))
				{
					alert("Minimum Salary can't be more than maximum Salary");
            		document.getElementById('ESL').focus();
            		return false;
				}
                     
                               



								var cloc = document.getElementById('Cloc').value;
	                                var ploc = document.getElementById('ploc').value;
	                                if ((cloc == ploc) && (cloc != '0' && ploc !='0' )) {
	                                    alert("Current Location and preferred location can't be same");
	                                    document.getElementById('ploc').focus();
	                                    return false;
	                                }
                                if(country=='101')
                                {
	                                var clocemp = document.getElementById('Cloc').value;
	                                if (clocemp == '0') {
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
	                                if (cloc == '0' && ploc=='0') {
	                                    alert("Current Location and preferred location can't be empty");
	                                    document.getElementById('ploc').focus();
	                                    return false;
	                                }
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
						function insert_visitor()
						{
							var email = document.getElementById('txtEmail').value;
							var mobnum = document.getElementById('txtMobile').value;
							var name = document.getElementById('txtName').value;
							if (email == "" || !email_verify(email) || mobnum == "" || mobnum.length != 10 || name=="") 
							{
								
							}
							else
							{
								var xmlhttp = new XMLHttpRequest();
								xmlhttp.open("GET", "insert_visitor.php?email="+email+"&mobile="+mobnum+"&name="+name, true);
								xmlhttp.send();
							}
						}
						function email_verify(email)
						{
							var x = email;
							var atpos = x.indexOf("@");
							var dotpos = x.lastIndexOf(".");
							if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			
							return false;
		
							}
							else 
							{return true;}	
						}
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
                                                $("#state").html(data);
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
                                        $('#city').html('<option value="">Select State First</option>');
                                    }
                                });
                                $('#state').on('change', function () {
                                    var stateID = $(this).val();
                                    //alert(stateID);
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
                                    //alert(stateID);
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
                           function get_cntryid(cntry_id)
							{
							   // alert(cntry_id);
							    var xmlhttp;
							    if (window.XMLHttpRequest)
							      {
							      xmlhttp=new XMLHttpRequest();
							      }
							    else
							      {
							      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							      }
							    xmlhttp.onreadystatechange=function()
							      {
							      if (xmlhttp.readyState==4 && xmlhttp.status==200)
							        {
							        	//alert(xmlhttp.responseText);
							            document.getElementById("curr_cntry").innerHTML=xmlhttp.responseText;
							            if(cntry_id!='101')
							            {
							            document.getElementById("ploc").innerHTML='<option value="5743">India</option>';
							            }else{
							            	get_prefid(cntry_id);
							            }
							        }
							      }
							    xmlhttp.open("GET","get_cntrydata.php?cntry_id="+cntry_id,true);
							    xmlhttp.send();
							}
							function get_prefid(cntryid)
							{
							   //alert(cntryid);
							    var xmlhttp;
							    if (window.XMLHttpRequest)
							      {
							      xmlhttp=new XMLHttpRequest();
							      }
							    else
							      {
							      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							      }
							    xmlhttp.onreadystatechange=function()
							      {
							      if (xmlhttp.readyState==4 && xmlhttp.status==200)
							        {
							        	//alert(xmlhttp.responseText);
							            document.getElementById("pref_loc").innerHTML=xmlhttp.responseText;
							            
							        }
							      }
							    xmlhttp.open("GET","get_prefloc_data.php?cntryid="+cntryid,true);
							    xmlhttp.send();
							}
							
                        </script>
                    </main>
                    <!--/main-->
                    <?php// include"footer.php"; ?>
                        <!-- popup terms & conditins -->
                        <!-- Modal Structure -->
                        <div id="terms-pop" class="modal">
                            <div class="modal-content">
                                <h4 class="h4">Terms &amp; Conditions for Register With Needyin</h4>
                                <p class="text-justify">
								By registering your profile or uploading your resume to www.needyin.com you agree to the following terms.
								</p> <p class="text-justify">
•	The resume/profileinformation/data fed by the user can be updated by the user alone, free of cost.</p> 
<p class="text-justify">
•	NI offers no guarantee nor warranties that there would be a satisfactory response or any response at all once the resume/profile information/data is fed by the user.</p><p class="text-justify">
•	NI neither guarantees nor offers any warranty about the credentials bonafides, status or otherwise of the prospective employer/organization which downloads the resume/profile information/data and uses it to contact the user.</p>
<p class="text-justify">
•	NI would not be held liable for loss of any data technical or otherwise, or of the resume/profile information/data or particulars supplied by user due to acts of god as well as reasons beyond its control like corruption of data or delay or failure to perform as a result of any cause(s) or conditions that are beyond NI’s reasonable control including but not Ltd. to strikes, riots, civil unrest, Govt. policies, tampering of data by unauthorized persons like hackers, distributed denial of service attacks, virus attacks, war and natural calamities.</p><p class="text-justify">
•	It shall be sole prerogative and responsibility of the user to check the authenticity of all or any response received pursuant to the resume/profile information/data being fed into the network system of NI by the user, for going out of station or in station for any job or interview. NI assumes no responsibility in respect thereof and expressly disclaims any liability for any act, deed or thing which the user may so do, pursuant to the receipt of the response, if any, to the resume/profile information/data being fed into the network system of NI.</p><p class="text-justify">
•	Uploading of multiple resume/profiles beyond a reasonable limit by the same individual, using the same or different accounts shall entitle NI to remove the Resume/profiles without notice to the subscriber. This service is only meant for candidates looking for suitable jobs. Any usage with commercial intent is prohibited.</p><p class="text-justify">
•	NI reserves its right to reject and delete any resume/profile information/data fed in by the user without assigning any reason.</p><p class="text-justify">
•	This free service entitles the user alone ie.the same person, to add modify or change the data/information fed in by him but does not entitle him to use the free service to feed fresh insertion or information/data/resume/profile of another person in place of the insertion or information/data already fed in by such user.</p><p class="text-justify">
•	NI has the right to make all such modifications/editing of resume/profile in order to fit resume/profile in its database.</p><p class="text-justify">
•	It shall be the sole responsibility of the user to ensure that it uses the privacy setting options as it deems fit to debar/refuse access of the data fed by it, to such corporate entities individuals or consultants. NI shall not be responsible for such insertions/data being accessed by its subscribers or users whose access has not been specifically blocked/debarred by the user while using the privacy settings.</p>
<p class="text-justify">
•	Although NI will make all possible efforts to adhere to these privacy settings, it will not be responsible for a resume/profile being seen by a blocked user for any reason. For best privacy settings it is recommended that you do not allow your resume/profile to be searched at all.</p><p class="text-justify">
•	The user represents that he/she is not a minor and is not under any legal or other disability which limits his/her ability to comply with these Terms or to install and use the services subscribed and purchased with minimal risk of harm to you or others. You further represent that you are not purchasing the products/services for resale to others and will not do so without NI’s prior written consent.</p><p class="text-justify">
•	All changes/modifications made by the user to the data/information shall be effected and will come into operation only after 24-48 hours of such changes/modifications being made.
On registration you agree to: a) Needyin Pvt. Ltd. contacting you via email and/or telephonic services to verify the information available on your profile. b) Making your profile/resume searchable to the clients of Needyin Pvt. Ltd.. c) You may be contacted by recruiters via email, telephonic services and/or post. If you wish to not be contacted you need to deactivate your account. We recommend that you read the privacy settings carefully and Needyin Pvt. Ltd. will not be held responsible for contacts/mails received by you. d) Receive job alerts (mails detailing jobs that match your profile as entered on Needyin) via email. You may remove yourself from the job alert email database by resetting this option in the Setting section of your resume/profile e) Receive promotional mailers/special offers. You may remove yourself from the promotional mailer email database by resetting this option on the Setting section of your resume/profile.</p><p class="text-justify">
NI uses an automated algorithm to match jobs against the keywords/attributes present in the profile submitted by the user, and hence offers no guarantee nor warranties that the jobs sent in the job mail will be relevant to the profile.
NI neither guarantees nor offers any warranty about the credentials of the prospective employer/organization whose details are sent in the job mail.</p>
<p class="text-justify">
Although all attempts will be made by NI to send all jobs on the specified days, however it does not take any responsibility for job mail not been sent (which may be on account of non-availability of jobs as per the user's specified criteria).
NI will not be responsible in any way for failure of any backend technology of mail exchange server and resultant inability of a user to receive job mail.</p><p class="text-justify">
NI reserves the right to regulate number of jobs sent out in the Job mail to a particular user in a single day.
The user agreement between a user/subscriber and Needyin Pvt. Ltd. will be treated as having been terminated in the following events: (i) On completion of the term for which the user/subscriber engages the services of the website; or (ii) In case the user/subscriber violates any of the conditions of this agreement or any other agreement entered into by him with Needyin Pvt. Ltd., however, such termination will be at the option and discretion of Needyin Pvt. Ltd. ; or (iii)On writing and on such terms as agreed to by the parties mutually.</p>
<p class="text-justify">
NI would not be held liable for loss of any data technical or otherwise and particulars supplied by subscribers due to reasons beyond its control like corruption of data or delay or failure to perform as a result of any causes or conditions that are beyond NeedyinTechnology reasonable control including but not Ltd. to strikes, riots, civil unrest, Govt. policies, tampering of data by unauthorized persons like hackers, war and natural calamities.</p>
<p class="text-justify">
The User of these services does not claim any copyright or other Intellectual Property Right over the data uploaded by him/her on the website.</p>
<p class="text-justify">
Jurisdiction for any disputes arising from and related to this contest shall be Bengaluru, India to the exclusion of all other courts.
Disputes shall be resolved in accordance with the laws of India as applicable
</p>
                            </div>
                            <div class="modal-footer"> <a href="#!" onclick="termschecked();" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a> </div>
                        </div>
                         <!--/ popup terms & conditions -->                        
            </body>           
            </html>
            <?php
            // session_start();
            // $uid = $_SESSION['id'];
            // $code = $_SESSION['code'];
            // echo $uid;
             
            // $url = "http://test.needyin.com/controller.php?message=" .$id.$code; 
              
            ?>
         