<?php
session_start();
require_once 'class.user.php';	
$user_home = new USER();
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
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Admin,<br>one new job is posted by ".$result_cj4['contact_name'].",&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; more details:. </p>
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
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>One New job is posted match with your Profile. </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'> 
                            Job Name : ".$result_cj3['Desig_Name']."</br>
                            Company Name : ".$PCompname."</br>
                            </p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; ;width:120px;text-decoration:none;margin-left: 50px;'>To view job details please click on the link below</br><a href=".$siteurl.">NeedyIn </a></p></td>
                           
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
										//  echo $nt_message; exit;
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
}		  
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);	
           	if(isset($_POST['btn-CreateJob']))
           	{	
			
				  $newindus=$_POST['newindus'];
				 $newfunc=$_POST['newfunc'];
				if($newindus!="" && $_POST['industry']=="Others")
				{
					 $jindus="select * from tbl_industry where Indus_Name='".$newindus."'";
					$indus_res=mysqli_query($con,$jindus);
					$indus_data=mysqli_fetch_array($indus_res);
					if(mysqli_num_rows($indus_res)==1){		
					$PIndus=$indus_data['Indus_Id'];				
					}
					else{				
					$indus_query = "INSERT into tbl_industry SET  Indus_Name='".$newindus."'"; 
					$iq1 = mysqli_query($con,$indus_query);				
					$jindus1="select * from tbl_industry where Indus_Name='".$newindus."'";
					$indus_res1=mysqli_query($con,$jindus1);
					$indus_data1=mysqli_fetch_array($indus_res1);
					$PIndus=$indus_data1['Indus_Id'];
				
			}
			}
			else{
			 $PIndus=$_POST['industry'];
				}
				 $newjob=$_POST['newjob'];
				if($newjob!="" && $_POST['PJobName']=="Otherjob")
				{
					 $jjob="select * from tbl_Desigination where Desig_Name='".$newjob."'";
					$job_res=mysqli_query($con,$jjob);
					$job_data=mysqli_fetch_array($job_res);
					if(mysqli_num_rows($job_res)==1){		
					$JobName=$job_data['Desig_Id'];				
					}
					else{				
					$job_query = "INSERT into tbl_Desigination SET  Desig_Name='".$newjob."'"; 
					$ij1 = mysqli_query($con,$job_query);				
					$jjob1="select * from tbl_Desigination where Desig_Name='".$newjob."'";
					$job_res1=mysqli_query($con,$jjob1);
					$job_data1=mysqli_fetch_array($job_res1);
					$JobName=$job_data1['Desig_Id'];
				
			}
			}
			else{
			 $JobName=$_POST['PJobName'];
				}
			if($_POST['newfunc']!="" && $_POST['functional_area']=="Others"){
				$jfunc="select * from tbl_functionalarea where Func_Name='".$newfunc."'";
				$func_res=mysqli_query($con,$jfunc);
				$func_data=mysqli_fetch_array($func_res);
				if(mysqli_num_rows($func_res)==1){		
					$PFunct=$func_data['Func_Id'];
				}
				else{
				
					$func_query = "INSERT into tbl_functionalarea SET  Func_Name='".$newfunc."'";
					$fq1 = mysqli_query($con,$func_query);
				
					$jfunc1="select * from tbl_functionalarea where Func_Name='".$newfunc."'"; 
					$func_res1=mysqli_query($con,$jfunc1);
					$func_data1=mysqli_fetch_array($func_res1);
					$PFunct=$func_data1['Func_Id'];
				
				}
			}
			else{
				$PFunct=$_POST['functional_area']; 
				}
			
			    //$JobName=$_POST['PJobName'];				
				 $Skills = implode(",",$_POST['PSkills']);								
				foreach ($Skills as $key => $value) {
				if (empty($value)) {
				unset($playerlist[$key]);
				}
				}				
				//$PAward=$_POST['PAward'];
				$PAward = implode(",",$_POST['PAward']);
				foreach ($PAward as $key => $value) {
				if (empty($value)) {
				unset($playerlist[$key]);
				}
				}
				//$PLang=$_POST['PLang'];
				$PLang = implode(",",$_POST['PLang']);
				foreach ($PLang as $key => $value) {
				if (empty($value)) {
				unset($playerlist[$key]);
				}
				}
				//$PVisa=$_POST['PVisa'];
				$PVisa = implode(",",$_POST['PVisa']);
				foreach ($PVisa as $key => $value) {
				if (empty($value)) {
				unset($playerlist[$key]);
				}
				}
                $PLoc=$_POST['PLoc'];	
				$PMinE=$_POST['PMinE'];
				$PMaxE=$_POST['PMaxE'];
				$PSal=$_POST['PSal']; 
				$MSal=$_POST['MPSal']; 
				$PCompname=$_POST['PCompname'];
				$PCompurl=$_POST['PCompurl'];
				$spl_instrtns = $_POST['spl_instrtns'];
				$PJobdesc = htmlspecialchars($_POST['PJobdesc'], ENT_QUOTES);
				//$PJobdesc=$_POST['PJobdesc'];
				$PEduc=$_POST['PEduc'];
				$PSpeca=$_POST['PSpeca'];
				$PUniver=$_POST['PUniver'];			
				$PAchive=$_POST['PAchive'];								
				$PCitizen=$_POST['PCitizen'];				
	            $Pperm=$_POST['Pperm'];				
				$PFull=$_POST['PFull'];
				$JobCreated=$_POST['jobcreation'];	
				$JobClosed=$_POST['jobclosed'];				
				$Gender=$_POST['Gender'];
				$notshow=$_POST['notshow'];
				$wtt=$_POST['wtt'];
				$Passport=$_POST['Passport'];	
				$cat_id=$_POST['job_category'];			
				$msgg=array();
				
				$desclen=strlen($PJobdesc);			
				$filurl=filter_var($_POST['PCompurl'], FILTER_SANITIZE_URL);	
				 $newskills=$_POST['newskill'];
		 if($newskills!='')
	{
		 $skill_sql="select skill_Id from tbl_masterskills where skill_Name='".$newskills."' ";
		$skill_res=mysqli_query($con,$skill_sql);
		if(mysqli_num_rows($skill_res) == 1)
		{
			$newskills_add=mysqli_fetch_array($skill_res);
			 $Skills=$Skills.",".$newskills_add['skill_Id'];
			 $Skills=trim($Skills,'Others,');
		}
		else
		{
			$master_query = "INSERT into tbl_masterskills SET  skill_Name='".$newskills."',skill_Status=1"; 
			$mq1 = mysqli_query($con,$master_query);
			 $skill_res="select skill_Id from tbl_masterskills where skill_Name='".$newskills."' ";
			$skill_res_ar=mysqli_query($con,$skill_res);
			 $newskills_add=mysqli_fetch_array($skill_res_ar);
		 $Skills=$Skills.",".$newskills_add['skill_Id'];
			
			
			 
			 $Skills=trim($Skills,'Others,');
		}
		
					
	}
	else
	{
			
	}
				if(empty($JobName))
		 {
			$msgg[]="Please fill Job Name";				
		 }
		 else if(empty($PMinE))
		{
			$msgg[]="Please Select Min Exp";
			 
		 }
		 else if(empty($PMaxE))
			  {
			 
			 $msgg[]="Please Select Max Exp";
			 
		 } else if(empty($PSal))
			  {
			 
			 $msgg[]="Please Select Salary";
			 
		 }
		 else if(empty($spl_instrtns))
			  {
			 
			 $msgg[]="Please Select Special Instructions";
			 
		 }
		else if(empty($PJobdesc))
			  {
			 
			 $msgg[]="Please fill Job Description ";
			 
		 }
		/* else if(empty($PEduc))
			  {
			 
			 $msgg[]="Please Select Education";
			 
		 }
	*/
		 else if(empty($Pperm))
			  {
			 
			 $msgg[]="Please Select Job type";
			 
		 }
		  /*if (!is_numeric($cnumber)) {
				   
				   $msgg[]="Phone Number can be Numerics only";
			   }
			    if (!is_numeric($pincode)) {
				   
				   $msgg[]="Pin code can be  Numerics only";
			   }*/
			   
			   if($desclen>1000&&$desclen<50)
			   {
				   
				   $msgg[]="Job description must be have atleast 50 and atmost 250 characters";
			   }
			   $is_alpha_space = ctype_alpha(str_replace(' ', '', $JobName));
	/*if (!($is_alpha_space))
	{
        $msgg[]="Job Name can be  Alphabets only";
    }*/
	if(empty($Skills))
	{
		$msgg[]="Please Select at least one skill required";
	}
	
	//$PCompname_space = ctype_alpha(str_replace(' ', '', $PCompname));
      //  if (!($PCompname_space))
       //  {
			
     //  $msgg[]="company name can be  Alphabets only";
     //   }
	if($PMinE>$PMaxE)
	{
		
		$msgg[]="Minmum Experience can't be more than Max Experience , please check";
	}
	/*if(!empty($_POST['PCompurl']))
	{
		if (!filter_var($PCompurl, FILTER_VALIDATE_URL) === false) {
			echo(" ");
		} else {
			$msgg[]="Please Enter Valid URL";
		}
		
	}*/
				if(!empty($msgg))
  {?><script language="javascript">alert("<?php  foreach($msgg as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
			/*foreach ($_POST as $key => $value)
			if(empty($value))
 echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";	*/
				  
		 }
				
			else
			{				
				 if($notshow=='')
					 $notshow=0;
				 if($PVisa=='')
					 $PVisa=0;
				
				//"INSERT INTO tbll_emplyer SET emp_email='".$email."',emp_password='".$password."',company_type='".$ctype."',industry_type='".$industry_type."',address1='".$address1."',address2='".$address2."',country_id='".$country."',state_id='".$state."',loc_id='".$location."',pincode='".$pincode."',contact_num='".$cnumber."',contact_name='".$cname."',terms='".$terms."',JUser_Id='".mysql_real_escape_string($row['JUser_Id'])."' ";
				$create_job = "INSERT INTO tbl_jobposted SET 
				Job_Name='".$JobName."',
				Job_Skill='".$Skills."',
				Loc_Id='".$PLoc."',
				Min_Exp='".$PMinE."',
				Max_Exp='".$PMaxE."',
				Sal_Range='".$PSal."',
				MSal_Range='".$MSal."',
				Comp_Name='".$PCompname."',
				Comp_Url='".$PCompurl."',
				spl_instructions='".$spl_instrtns."',
				Job_Desc='".$PJobdesc."',
				PEduc_Id='".$PEduc."',
				PSpeci_Id='".$PSpeca."',
				PUniver_Id='".$PUniver."',
				PIndus_Id='".$PIndus."',	 
				PFunc_Id='".$PFunct."',
				PAchive='".$PAchive."',
				PAward='".$PAward."',
				PLang='".$PLang."',
				Pcitizenship='".$PCitizen."',				 
			    PJobtype='".$Pperm."',
				PEmploytype='".$PFull."',
				jobcreation='".$JobCreated."',	
				jobclosed='".$JobClosed."',					
				PGender='".$Gender."',
				PVisaCtry='".$PVisa."',				 
			    PWillingtotravel='".$wtt."',	
				notshow_jobseeker='".$notshow."',
				PPassport='".$Passport."',
				category_id='".$cat_id."',
				emp_id='".$row['emp_id']."',
				adm_status='SA'";	
								$jb_create_date=date_create($JobCreated);
				$jb_close_date=date_create($JobClosed);
				$jb_created=date_format($jb_create_date,'Y-m-d');
				$jb_closed=date_format($jb_close_date,'Y-m-d');
				$createJob= mysqli_query($con,$create_job); 
				 $job_id = mysqli_insert_id($con);
				
				  $refJobResPhas2= mysqli_query($con_phase2,"set FOREIGN_KEY_CHECKS=0;");
			   $create_job_mobile="INSERT INTO `tbl_jobsposted`(Emp_Id, Job_Loc_Id, Job_Pref_Edu_Id, Job_Pref_Uni_Id, Job_Pref_Spez_Id, Job_Pref_Indus_Id, Job_Pref_Func_Id, Job_Name_Id, Job_Cat_Id, Job_Min_Exp, Job_Max_Exp, Job_Min_Sal_Range, Job_Max_Sal_Range, Job_Desc, Job_Type, Job_Employment_Type, Job_Creationdate, Job_Closeddate, Job_Status, Job_Confidential, Ph1_Ref_Job_Id) VALUES (".$_SESSION['empPhase2'].",$PLoc,$PEduc,$PUniver,$PSpeca,$PIndus,$PFunct,$JobName,$cat_id,$PMinE,$PMaxE,$PSal,$MSal,'$PJobdesc','$Pperm','$PFull','$jb_created','$jb_closed',1,'$notshow', $job_id);"; 

			$create_job_phase2=mysqli_query($con_phase2,$create_job_mobile); 


		//	echo $job_id_phase2 = mysqli_insert_id($con_phase2);


			 $ref_retrive_query="SELECT * FROM tbl_jobsposted WHERE Ph1_Ref_Job_Id=$job_id;";
			 $refJobResPhas2= mysqli_query($con_phase2,$ref_retrive_query);
			 $job_id_phase2 = mysqli_fetch_array($refJobResPhas2);
			

		//	print_r($refJobResPhas2);
			$ref_job_query="UPDATE tbl_jobposted SET Ph2_Ref_Job_Id='".$job_id_phase2['Job_Id']."'  WHERE Job_Id=$job_id";
		
			$refJobRes= mysqli_query($con,$ref_job_query);
//			echo mysqli_error($con);
				$change_aw = "INSERT INTO tbl_Job_details_updts SET emp_Id='".$row['emp_id']."',Job_Id='".$job_id."',ac_updts='NOW()',sa_updts='NOW()'";
				$eduz= mysqli_query($con,$change_aw);
				 $skill_ids=$_POST['PSkills'];	
					foreach($skill_ids as $skill){	
  "INSERT INTO tbl_cand_skills (Csk_User_Id,Csk_Job_Id,Csk_Skill_Id) VALUES ('".$_SESSION['empPhase2']."','".$job_id_phase2['Job_Id']."',$skill);";					
						mysqli_query($con_phase2,"INSERT INTO tbl_cand_skills (Csk_User_Id,Csk_Job_Id,Csk_Skill_Id) VALUES ('".$_SESSION['empPhase2']."','".$job_id_phase2['Job_Id']."',$skill);");
					}
								$refJobResPhas2= mysqli_query($con_phase2,"set FOREIGN_KEY_CHECKS=1;");
								
				
				$description="One new Job is posted";
			 $insert_query = "INSERT into tbl_notifications SET  job_id='".$job_id."',description='".$description."',job_owner_id='".$row['emp_id']."',notification_to='3',notification_from='".$row['emp_id']."', mode='admin'"; 
												$rr1 = mysqli_query($con,$insert_query);
				if($job_id!="")
				{				   
							foreach($skill_ids as $skill)
		                    {
							
								$cj2="select JUser_Id,Job_Skills from tbl_jobseeker where JPLoc_Id='".$PLoc."' and  FIND_IN_SET('".$skill."', Job_Skills) "; 
				                  $resultcj2 = mysqli_query($con,$cj2);  
					                  while($result_cj2=mysqli_fetch_array($resultcj2))
					                  {
						                  $user_ids[]=$result_cj2['JUser_Id'];
						                  $skillids[]=$result_cj2['Job_Skills'];
					                  }
		            		 } 
                             $userids=array_filter(array_unique($user_ids));     
                             $u_cnt=count($userids);
							 $cj42="select Desig_Name from  tbl_desigination where Desig_Id='".$JobName."' ";  
										   $resultcj42 = mysqli_query($con,$cj42);  
										   $result_cj42=mysqli_fetch_array($resultcj42);
										   //echo "INSERT INTO `tbl_emp_job_details`(`job_id`,`emp_id`,`job_nm`,`job_sts`)VALUES('".$job_id_phase2['Job_Id']."','".$_SESSION['empPhase2']."','".$result_cj42['Desig_Name']."','Active')";
							 mysqli_query($digital_ocean,"INSERT INTO `tbl_emp_job_details`(`job_id`,`emp_id`,`job_nm`,`job_sts`)VALUES('".$job_id_phase2['Job_Id']."','".$_SESSION['empPhase2']."','".$result_cj42['Desig_Name']."','1')");
						
                               //  print_r($userids); exit;
                                if($u_cnt!='0')
                                {  
 									
									foreach($userids as $user)
									{
                                   //  $sal_qq="select ExpSalL,JUser_Id from tbl_currentexperience where JUser_Id='".$user."' and  ExpSalL<=".$PSal;  
									//	$sal_res=mysqli_query($con,$sal_qq);
									//	$sal_data=mysqli_fetch_array($sal_res);
									//	$sdata_cnt=mysqli_num_rows($sal_res); 
									//	if($sdata_cnt!='0')
                                       //  {
										   $cj3="select emp_id from tbl_jobposted where Job_Id='".$job_id."'"; 
										   $resultcj3 = mysqli_query($con,$cj3);  
										   $result_cj3=mysqli_fetch_array($resultcj3); 
										$description="One new Job is posted";
									 $insert_query = "INSERT into tbl_notifications SET  job_id='".$job_id."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$user."',notification_to='".$user."',notification_from='".$result_cj3['emp_id']."', mode='admin'"; 
												//$rr1 = mysqli_query($con,$insert_query);
						 $jb_seeker="select JEmail,JFullName from tbl_jobseeker where JUser_Id='".$user."' and jdndstatus='0'";
							                   $jb_res=mysqli_query($con,$jb_seeker);
							                  $jb_data=mysqli_fetch_array($jb_res);
												 $jb_email=$jb_data['JEmail']; 

										  $cj4="select Desig_Name from  tbl_desigination where Desig_Id='".$JobName."' ";  
										   $resultcj4 = mysqli_query($con,$cj4);  
										   $result_cj4=mysqli_fetch_array($resultcj4);

										   $jsname=base64_encode($jb_data['JFullName']);
										   $jobname=base64_encode($result_cj4['Job_Role']);
										   $cmpname=base64_encode($PCompname);
							                    $subject="New Job In Needyin";
							                    //$message = "Hello ".$jb_data['JFullName']."\n One New job is posted match with your Profile \n Just click following link !\n <a href=".$siteurl.">NeedyIn </a> \n Thanks,";

												/* $message = "Hello ".$jb_data['JFullName']."";
						                         $message .= " One New job is posted match with your Profile !<br /><br />";
						                         $message .= "Just click following link !<br /><br />";
						                         $message .= "<a href=".$siteurl.">NeedyIn </a><br /><br />";
						                         $message .= "Thanks,";    */

						                                                            
										  // echo $message; exit;
										   
											   
                                       //  }
									    }
                                 }
						
									}
									 $nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/crjb_notif.php?jsname=".$jsname."&jobname=".$jobname."&cmpname=".$cmpname."' target='_blank'>View in web</a> </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Admin <br>, ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;one new job is posted.Please check. </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."/img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>One New job is posted . </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'>                            
                            Company Name : ".$PCompname."
                            </p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; ;width:120px;text-decoration:none;margin-left: 50px;'>To view job details please click on the link below</br><a href=".$siteurl.">NeedyIn </a></p></td>
                           
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
									//  $admin_email="arjuna.k@needyin.com";
				// $admin_email1="arjuna.k@needyin.com";
				// $user_home->send_mail2($admin_email1,$nt_message,$subject);
				// 			                  $user_home->send_mail2($admin_email,$nt_message,$subject);
				// 			                   $nt_message=null;
	?>
					<script type="text/javascript">
						alert("successfully Posted Job");
						window.location.href = "screened-profles.php";
					</script>
				<?php 
			}
			}else{?>
				<script type="text/javascript">
						alert("Please Try again once");
						window.location.href = "screened-profles.php";
				</script>
			<?php }
			
		?>
			
      