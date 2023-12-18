<?php 
session_start();
//require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
//$msg=array();
//print_r($_POST); exit;
if(isset($_SESSION['userSession']))
{
	$userid=$_SESSION['userSession'];

$sqljs="SELECT  `JFullName`, `JEmail`, `JPhone`,`JTotalEy`, `JTotalEm`, `DoB`, `Gender`,  `JPLoc_Id`, `Job_Skills`, `Indus_Id`, `Func_Id`, `JuserStatus` FROM `tbl_jobseeker` WHERE `JUser_Id`='$userid'";
//echo $sqljs;
		$sqljs2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
		//echo $sqljs2;
		
		$sqljs3="SELECT * FROM `tbl_education` WHERE `JUser_Id`='$userid'";
		//echo $sqljs3;
		$sqljsres=mysqli_query($con,$sqljs);
		$sqljsres2=mysqli_query($con,$sqljs2);
		$sqljsres3=mysqli_query($con,$sqljs3);
		//echo mysqli_num_rows($sqljsres3);
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
			{// echo $i;
				
				
				$valres[]="Please fill General Information ";
				
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
				//echo $j;
				
				$valres[]="Please fill Professional Experince";
				
				break;
			}
				
	
		}
		
		
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
		//echo "HII";
		
		
		
		
		
		
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include "postlogin-header-jobseekar.php" ?>
        <!-- main-->
        <main>
            <section class="jobseekar-profile">
                <?php include "inner-menu.php" ;?>
                
                <!-- job seekar header -->
                <!-- job seekar body -->
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        <!-- job seekear profile navigation -->
                        <div class="container">
                            <!-- update resume block -->
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">My Recent  <span class="fbold">Activites</span></h4> </div>
                                <!--change password -->
                                <div class="my-activities">
                                    <ul class="list-activities row">
									<?php 
									$jc1= "SELECT tv.*,tj.Job_Name FROM tbl_recent_views tv LEFT JOIN tbl_jobposted tj on tv.Reference=tj.Job_Id where userid='".$row['JUser_Id']."' ORDER BY id DESC limit 0,20 " ;
									$jresult1 = mysqli_query($con,$jc1);
									while ($jrow = mysqli_fetch_array($jresult1)){
									?>
                                        <li class="col-md-6">
                                           <div class="activities-div">
                                            <h5 class="h5"><?php echo $jrow['Activity'] ?>
											<span> <!--<?php echo $jrow['Date&time'] ?>-->
											<?php $date=date_create($jrow['Date&time']);
											echo date_format($date,"M d, Y H:i:s");?>
											</span></h5>
                                            <article class="activities-table">
                                                <p><span class="fbold"> <?php echo ucfirst($row['JFullName']); ?></span>
                                                 <?php echo $jrow['Activity'] ?>
                                                
												<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);

                                   ?>
                                                 <?php if($row2['Desig_Name']!="") { ?>
                                                 <b> for 
                                                 <?php echo $row2['Desig_Name']; 
                                                 } ?></b></p>                                                
                                            </article>
                                            </div>
                                        </li>
                                     <?php } ?>  
                                    </ul>
                                </div>
                                <!--/ change password -->
                            </div>
                            <!--/ update resume block -->
                        </div>
                    </div>
                    <!-- job seekar profile navigation -->
                </section>
                <!-- / job seekar body -->
            </section>
        </main>
        <!--/main-->
        <!-- footer-->
        <?php //include 'footer.php'; ?>
            <!--/footer-->
</body>

</html>