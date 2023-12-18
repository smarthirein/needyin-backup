<?php 
session_start();
require_once '../class.user.php';
$user_home = new USER();
$siteurl="http://needyin.com/dev/";
if($user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 if(isset($_POST['statusc']) && $_POST['juserids']!=""){				
			$juserids=$_POST['juserids'];				
			 $status=$_POST['activeinactive'];
			if($status=='A'){
				$ac_jexp ="Update tbl_user_admin_curationdts SET A_updt='NOW()' where JUser_Id='".$juserids."'";
					$ajexp= mysqli_query($con,$ac_jexp);
				$approve_jobs_status="UPDATE tbl_applied SET user_status='A' WHERE JUser_Id='".$juserids."'";
				$approve_jobs_status_res= mysqli_query($con,$approve_jobs_status);
			}else if($status=='SQ'){
				$ac_jexp ="Update tbl_user_admin_curationdts SET SQ_updt='NOW()' where JUser_Id='".$juserids."'";
					$ajexp= mysqli_query($con,$ac_jexp);
			}elseif($status=='R'){
				$ac_jexp ="Update tbl_user_admin_curationdts SET R_updt='NOW()' where JUser_Id='".$juserids."'";
					$ajexp= mysqli_query($con,$ac_jexp);
			}else{}
				 $insert_jexp ="Update tbl_jobseeker SET JuserStatus='".$status."' where JUser_Id='".$juserids."'";
					$jexp= mysqli_query($con,$insert_jexp);
					if($jexp )
					{ 
						if($status=='SQ'){
					 $jc1= "SELECT adm_status,JFullName,JEmail FROM tbl_jobseeker where JUser_Id='".$juserids."'";
						$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
						 $cnamea=explode("#",$jrow['adm_status']);
							$email=$jrow['JEmail'];
					 // SPLITING DATA INTO ARRAY
					$output[] = preg_split( "/(^|@|#)/", $cnamea[0]);//uname
					$output[] = preg_split( "/(^|@|#)/", $cnamea[1]);//uphone
					$output[] = preg_split( "/(^|@|#)/", $cnamea[2]);//uexp
					$output[] = preg_split( "/(^|@|#)/", $cnamea[3]);//udob
					$output[] = preg_split( "/(^|@|#)/", $cnamea[4]);//ugen
					$output[] = preg_split( "/(^|@|#)/", $cnamea[5]);//ucsal
					$output[] = preg_split( "/(^|@|#)/", $cnamea[6]);//udoj
					$output[] = preg_split( "/(^|@|#)/", $cnamea[7]);//upayslip
					$output[] = preg_split( "/(^|@|#)/", $cnamea[8]);//updatedcv
					$output[] = preg_split( "/(^|@|#)/", $cnamea[9]);//uemail
					$output[] = preg_split( "/(^|@|#)/", $cnamea[10]);//reattach
					$output[] = preg_split( "/(^|@|#)/", $cnamea[11]);//ploc
					$output[] = preg_split( "/(^|@|#)/", $cnamea[12]);//cauth
					$output[] = preg_split( "/(^|@|#)/", $cnamea[13]);//fname
					$output[] = preg_split( "/(^|@|#)/", $cnamea[14]);//psum
					$output[] = preg_split( "/(^|@|#)/", $cnamea[15]);//rtype
					$output[] = preg_split("/(^|@|#)/", $cnamea[16]);//comname
					$output[] = preg_split( "/(^|@|#)/", $cnamea[17]);//comname
						
					
					for($i=0;$i<count($output);$i++){
						
						$data=explode('^',$output[$i][1]);
						
						if($data[1]=='no')
						{
							$list[]=$data[0];
							$reason[]=$output[$i][2];
						}
					
					}
								
				for($j=0;$j<count($list);$j++){
						if($list[$j]=='uname'){
							$no[]="Name not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='uphone'){
							$no[]="Phone Number not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='ugen'){
							$no[]="Gender not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='uexp'){
							$no[]="Experience not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='udob'){
							$no[]="Date of Birth not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='ucsal'){
							$no[]="Current Salary not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='udoj'){
							$no[]="Date of Join not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='upayslip'){
							$no[]="Payslip not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='updatedcv'){
							$no[]="Your CV not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='uemail'){
							$no[]="Your Email not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='reattach'){
							$no[]="Reason Attachement not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='ploc'){
							$no[]="Prefered Location not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='cauth'){
							$no[]="Country Authorised not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='fname'){
							$no[]="Functional Name not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='psum'){
							$no[]="Profile Summary not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='rtype'){
							$no[]="Reason Type not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='rsum'){
							$no[]="Reason Summary not Approved Reason:".$reason[$j].",";					
						}
						if($list[$j]=='comname'){
							$no[]="Company not Approved Reason:".$reason[$j].",";					
						}						
					} 
					
					
					$usname=$jrow['JFullName'];
					if ($list!='') {
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
								                   Dear ".ucfirst($usname).",<br><br>";
												   foreach ($no as $value) {
													   $message.=" '$value' ";
													}
								             $message.="  
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>To complete your registration process, please Recheck above fields validate your account.</p>
					               
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
									
					$subject = "Your Profile Status Rejected";
				
					$ok=$user_home->send_mail2($email,$message,$subject);	
						}
					}
						?><script>alert("status changed");
						window.location.href = "profiles-latest.php?uid=<?php echo $juserids  ?>";</script><?php
					}
					else
					{
						?><script>alert("status not changed");
						window.location.href = "profiles-latest.php?uid=<?php echo $juserids  ?>";</script><?php
					}
 } 
 if(isset($_POST['statusemp']) && $_POST['empid']!=""){				
			$empid=$_POST['empid'];				
			$status=$_POST['activeinactive'];
				$insert_jexp ="Update tbll_emplyer SET status='".$status."' where emp_id='".$empid."'";
					$jexp= mysqli_query($con,$insert_jexp);
					if($status=='4'){
				// to add the status date to the table tbl_emp_admin_updts
					$updt_edu = "INSERT INTO tbl_emp_admin_updts SET 4_updts='NOW()',emp_id='$empid'";				
					$updu= mysqli_query($con,$updt_edu);
			}else if($status=='5'){
				// to add the status date to the table tbl_emp_admin_updts
					$updt_edu = "INSERT INTO tbl_emp_admin_updts SET 5_updts='NOW()',emp_id='$empid'";				
					$updu= mysqli_query($con,$updt_edu);
			}else if($status=='7'){
				$updt_edu = "INSERT INTO tbl_emp_admin_updts SET 7_updts='NOW()',emp_id='$empid'";				
					$updu= mysqli_query($con,$updt_edu);
			}else{
			}
					if($jexp)
					{ 
						if($status==7){
					$jc1= "SELECT adminstatus,contact_name,emp_email FROM tbll_emplyer where emp_id='".$empid."'";
						$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
							$cnamea=explode("#",$jrow['adminstatus']);
							$email=$jrow['emp_email'];
						// SPLITING DATA INTO ARRAY
						$output[] = preg_split( "/(^|@|#)/", $cnamea[0]);//cname
						$output[] = preg_split( "/(^|@|#)/", $cnamea[1]);//curl
						$output[] = preg_split( "/(^|@|#)/", $cnamea[2]);//croc
						$output[] = preg_split( "/(^|@|#)/", $cnamea[3]);//ctype
						$output[] = preg_split( "/(^|@|#)/", $cnamea[4]);//indtype
						$output[] = preg_split( "/(^|@|#)/", $cnamea[5]);//cyor
						$output[] = preg_split( "/(^|@|#)/", $cnamea[6]);//desig
						for($i=0;$i<count($output);$i++){							
							$data=explode('^',$output[$i][1]);							
							if($data[1]=='no')
							{
								$list[]=$data[0];
								$reason[]=$output[$i][2];
							}						
						}
							
					for($j=0;$j<count($list);$j++){
					if($list[$j]=='cname'){
						$no[]="Company Name not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='curl'){
						$no[]="Company URL not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='croc'){
						$no[]="Registration of Company not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='ctype'){
						$no[]="Company Type not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='udob'){
						$no[]="Date of Birth not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='indtype'){
						$no[]="Industry Type not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='cyor'){
						$no[]="Year of Registration not Approved Reason:".$reason[$j].",";					
					}
					if($list[$j]=='desig'){
						$no[]="Designation not Approved Reason:".$reason[$j].",";					
					}					
					
					}					
				 $usname=$jrow['contact_name'];
			if ($list!='') {
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
												
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(".$siteurl."/img/thankyou_img.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear ".ucfirst($usname).",<br><br>";
												   foreach ($no as $value) {
													   $message.=" '$value' ";
													}
													$message.="  
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>To complete your registration process, please Recheck above fields validate your account.</p>
					               
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
					$subject = "Your Profile Status Rejected";
					$ok=$user_home->send_mail2($email,$message,$subject);	
					if($ok){echo "mail sent";}
					}
						}
						?><script>alert("status changed");
						window.location.href = "employers-latest.php?uid=<?php echo $empid  ?>";</script><?php
					}
					else
					{
						?><script>alert("status not changed");
						window.location.href = "employers-latest.php?uid=<?php echo $empid  ?>";</script><?php
					}
					
 } 
 if(isset($_POST['statusjob']) && $_POST['jobid']!="")
 {		
			$jobid=$_POST['jobid'];				
			$status=$_POST['activeinactive'];
			$empid=$_POST['empid'];
			$reason=$_POST['reason'];
			
			if($status=='A'){
				$ac_jobexp ="Update tbl_Job_details_updts SET a_updts='NOW()' where Job_Id='".$jobid."',emp_Id='".$empid."'";
					$ajexp= mysqli_query($con,$ac_jobexp);
			}else if($status=='R'){
				$ac_jobexp ="Update tbl_Job_details_updts SET r_updts='NOW()' where Job_Id='".$jobid."',emp_Id='".$empid."'";
					$ajexp= mysqli_query($con,$ac_jobexp);
			}else{
			}
			 $insert_jexp ="Update tbl_jobposted SET adm_status='".$status."',adm_reason='".$reason."' where Job_Id='".$jobid."' and emp_id='".$empid."'";
					$jexp= mysqli_query($con,$insert_jexp);
					
					if($jexp){
					
					  $jc1="SELECT tj.adm_reason,te.contact_name,te.emp_email  from tbl_jobposted tj INNER JOIN tbll_emplyer te on te.emp_id=tj.emp_id where tj.Job_Id='".$jobid."'and tj.emp_id='".$empid."'";
						
					$jresult1 = mysqli_query($con,$jc1);
						$jrow = mysqli_fetch_array($jresult1);
						 
					 $usname=$jrow['contact_name'];
						 $email=$jrow['emp_email'];
							if($status=='SQ') {
							
							
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
												
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(".$siteurl."/img/thankyou_img.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear ".ucfirst($usname).",<br><br>Reason:".$jrow['adm_reason'].";
												  
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>Your Job posting is rejected because of above reason.</p>
					               
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
									
					$subject = "Your Profile Status Rejected";
				
					$ok=$user_home->send_mail2($email,$message,$subject);	
					}	
						?><script>alert("status changed");
						window.location.href = "all_jobs.php?jobId=<?php echo $jobid  ?>";</script><?php	

						
					}
					
					else
					{
						?><script>alert("status not changed");
						window.location.href = "all_jobs.php?jobId=<?php echo $jobid  ?>";</script><?php
					}
					
					 }
	
?>