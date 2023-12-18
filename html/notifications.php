<?php session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
} 


if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];

$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";

		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
		
		
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";
		
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);
		
		if(mysqli_num_rows($sqljsres3)<1)
		{
			$valres[]="Please Give at least one Education(Degree) Details";
		}
		
		
		$sqlressow=mysqli_fetch_array($sqljsres);
		$sqlressow2=mysqli_fetch_array($sqljsres2);
		for($i=0;$i<11;$i++)
		{
			if($i==3||$i==4)
			{
				if(empty($sqlressow[3])&&empty($sqlressow[4]))
				{
				
				$valres[]="Please fill General Information ";
				
				}
			}
			else if(empty($sqlressow[$i]))
			{
				
				
				$valres[]="Please fill General Information ".$i;
				
				break;
			}
				
	
		}
		
		for($j=0;$j<11;$j++)
		{
			if($j==3||$j==4||$j==5||$j==6)
			{
				if(empty($sqlressow2[3])&&empty($sqlressow2[4]))
				{
				
				$valres[]="Please fill General Information Information ";
				break;
				
				}
				else if(empty($sqlressow2[5])&&empty($sqlressow2[6]))
				{
				
				$valres[]="Please fill General Information Information ";
				break;
				
				}
			}
			else if(empty($sqlressow2[$j]))
			{
				
				
				$valres[]="Please fill Professional Experince";
				
				break;
			}
				
	
		}
		
	//	echo $valres;
		if(!empty($valres))
		{?>
	
	
			<script language="javascript">alert("<?php  foreach($valres as $k) {echo $k.'\\n'; }?>");
		window.location='jobseeker-profile.php';
		</script>
			
			
			
	<?php		
		}else
    {
     
			$qq="update  tbl_jobseeker set JuserStatus='Y' where JuserStatus='V' and JUser_Id=$userid";
      $res=mysqli_query($con,$qq);
			  //for adding updated date in 'tbl_user_admin_curationdts' for 100% completed date start date
	  $ac="update  tbl_user_admin_curationdts set Y_updt='NOW()' where JUser_Id=$userid";
      $resac=mysqli_query($con,$ac);
			$sqljs="SELECT  `JFullName`, `JEmail`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";	
			$sqljsres=mysqli_query($con,$sqljs);
			$result_cj4=mysqli_fetch_array($resultcj4); 
	  $sjss="SELECT  count(profile_id)  as idcs FROM `tbl_notifications` WHERE `profile_id`='$userid' and `description`='Profile 100% completed'";	
		$ssjsres=mysqli_query($con,$sjss);
		$re_cj4=mysqli_fetch_array($ssjsres); 
	//	echo $re_cj4['idcs'];
	  if(($result_cj4['JuserStatus']=='Y')&&($re_cj4['idcs']==''))
	  {
	  /*$qq="update  tbl_jobseeker set JuserStatus='AW' where JUser_Id=".$_SESSION['userSession'];
		  $res=mysqli_query($con,$qq);*/
		  
		  
		  
		  
		  $description="Profile 100% completed";
           $insert_query = "INSERT into tbl_notifications SET description='".$description."',profile_id='".$_SESSION['userSession']."',notification_to='1',notification_from='".$_SESSION['userSession']."',mode='admin'"; 
			$rr1 = mysqli_query($con,$insert_query);
			
				$subject="Profile Completed 100%";
				
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
                           
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Admin ,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified with name called ".$result_cj4['JFullName']." and Email id is ".$result_cj4['JEmail'].". </p>
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
  
        
        </tr>
    </table>";
	$admin_email="prashant@needyin.com";

							             $mm=$user_home->send_mail2($admin_email,$nt_message,$subject);
	  }
    
    }
		
		
		
}


$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u                         
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 $noti_query="select * from tbl_notifications where notification_to='".$_SESSION['userSession']."' and mode='employer'";
$noti_res=mysqli_query($con,$noti_query);
 $noti_cnt=mysqli_num_rows($noti_res);

$nt_query1="select * from tbl_shortlisted where JUser_Id=".$_SESSION['userSession'];
$nt_res1=mysqli_query($con,$nt_query1); 
$nt_count1=mysqli_num_rows($nt_res1);

$nt_query2="select * from interviewscheduled where juser_id=".$_SESSION['userSession'];
$nt_res2=mysqli_query($con,$nt_query2);
$nt_count2=mysqli_num_rows($nt_res2);

  $total_cnt=$noti_cnt+$nt_count1+$nt_count2;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    
    <?php include"source.php"; ?>
</head>

<body>
    <?php 
include_once("analyticstracking.php");
include"postlogin-header-jobseekar.php"; ?>
       
        <main>
            <section class="jobseekar-profile">
                <?php include "inner-menu.php"; ?>
               
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="jobseeker-profile.php"><?php echo $row['JFullName'] ?></a> </li>
                        <li> <a href="#">Notifications</a> </li>
                    </ul>
                </div>
                
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        
                        <div class="container">
                           
                            <div class="notifications-block">
                                <div class="title-block-tab">
                                    <h4 class="flight"><span class="fbold">Notifications</span></h4> </div>
                              
                                <div class="notifications-list">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Job Title</th>
                                                    <th>Subject</th>
                                                    <th>Date</th>                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                        
                                            if($noti_cnt>0)
                                            {
                                            	 
                                            while($noti_data=mysqli_fetch_array($noti_res))
                                                 {  
                                            
                                                  $jb_qq="select * from tbl_jobposted where Job_Status='1' and Job_Id=".$noti_data['job_id'];
                                                $jb_res=mysqli_query($con,$jb_qq);
                                                  $data=mysqli_fetch_array($jb_res);
                                                  ?>
                                                <tr>
                                                    <td> 
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $noti_data['job_owner_id']?>&jid=<?php echo $noti_data['job_id']?>&cd=<?php echo $noti_data['created_on']?>&act=noti"><?php echo $data['Comp_Name'];?></a>
                                                    </td>
                                                    <td> 
													<?php $sql1 = "SELECT * FROM tbl_desigination where Desig_Id ='".$data['Job_Name']."'";
							                	$query1 = mysqli_query($con, $sql1);
							                	$row1 = mysqli_fetch_array($query1);?>
								  
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $noti_data['job_owner_id']?>&jid=<?php echo $noti_data['job_id']?>&cd=<?php echo $noti_data['created_on']?>&act=noti"><?php echo $row1['Desig_Name'];?></a>
                                                    </td>
                                                    <td><?php echo $noti_data['description'];?></td>
                                                    <td><?php 
                                                            $date=date_create($noti_data['created_on']);
                                                            echo date_format($date,"M d, Y"); 
                                                      ?>
                                                        

                                                    </td>                                                  
                                                </tr>
                                               <?php  } }
                                            if($nt_count1>0)
                                            {
                                            while($nt_data1=mysqli_fetch_array($nt_res1))
                                                 {  
                                                  $jb_qq1="select * from tbl_jobposted where Job_Status='1' and Job_Id=".$nt_data1['JobId'];
                                                  $jb_res1=mysqli_query($con,$jb_qq1);
                                                  $data1=mysqli_fetch_array($jb_res1);

                                                  $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$data1['Job_Name']."'";
                                                   $query2 = mysqli_query($con, $sql2);
                                                   $row2 = mysqli_fetch_array($query2);
                                                  ?>
                                                <tr>
                                                    <td> 
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $nt_data1['emp_id']?>&jid=<?php echo $nt_data1['JobId']?>&cd=<?php echo $nt_data1['created']?>&act=sh"><?php echo $data1['Comp_Name'];?></a>
                                                    </td>
                                                    <td> 
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $nt_data1['emp_id']?>&jid=<?php echo $nt_data1['JobId']?>&cd=<?php echo $nt_data1['created']?>&act=sh"><?php echo $row2['Desig_Name'];?></a>
                                                    </td>
                                                    <td><?php echo "Shortlisted";?></td>
                                                    <td><?php 
                                                             $dateb=date_create($nt_data1['created']); 
                                                             echo $dob= date_format($dateb,"M d, Y");
                                                            ?>
                                                        

                                                    </td>                                                  
                                                </tr>
                                               <?php }}
                                               if($nt_count2>0)
                                               {
												   
                                                while($nt_data2=mysqli_fetch_array($nt_res2))
                                                 {  
                                                  $jb_qq2="select * from tbl_jobposted where Job_Status='1' and Job_Id=".$nt_data2['job_id'];
                                                  $jb_res2=mysqli_query($con,$jb_qq2);
                                                  $data2=mysqli_fetch_array($jb_res2);

                                                  $sql3 = "SELECT * FROM tbl_desigination where Desig_Id ='".$data2['Job_Name']."'";
                                                   $query3 = mysqli_query($con, $sql3);
                                                   $row3 = mysqli_fetch_array($query3);
                                                  ?>
                                                <tr>
                                                    <td> 
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $nt_data2['emp_id']?>&jid=<?php echo $nt_data2['job_id']?>&cd=<?php echo $nt_data2['created']?>&act=ins"><?php echo $data2['Comp_Name'];?></a>
                                                    </td>
                                                    <td> 
                                                     <a href="job-detail-postlogin.php?uid=<?php echo $nt_data2['emp_id']?>&jid=<?php echo $nt_data2['job_id']?>&cd=<?php echo $nt_data2['created']?>&act=ins"><?php echo $row3['Desig_Name'];?></a>
                                                    </td>
													<?php $date=date_create($nt_data2['scheduled_on']); ?>
                                                    <td><?php echo "Interview Scheduled on ".date_format($date,"M d, Y");?></td>
                                                    <td><?php $date=date_create($nt_data2['created']);
                                                            echo date_format($date,"M d, Y"); ?>
                                                        

                                                    </td>                                                  
                                                </tr>
                                               <?php } }
                                               if($total_cnt==0)
                                               {   ?>
                                                      <tr>
                                                    <td colspan='4'><center>No Notifications</center></td></tr>
                                               <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              
                            </div>
                           
                        </div>
                    </div>
                   
                </section>
             
            </section>
        </main>
     
        <script>
            $(document).ready(function () {
                Materialize.updateTextFields();
            });
        </script>
      
      
           
</body>

</html>