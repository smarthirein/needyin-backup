<?php
session_start();
require_once("../config.php");
require_once '../class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['adminSession']))
{
		 $user_home->redirect('index-recruiter.php');
   
} 
	
$stmt = $user_home->runQuery("SELECT * FROM tbl_admin WHERE id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$noti_query="select * from tbl_notifications where notification_to='".$_SESSION['adminSession']."' and mode='admin' and job_owner_id !='' order by id desc";
$noti_res=mysqli_query($con,$noti_query);
 $noti_cnt=mysqli_num_rows($noti_res);
 

 //$noti_cnt=mysqli_num_rows($noti_res1);
  $total_cnt=$noti_cnt;

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
include_once("../analyticstracking.php");
	include '../includes-recruiter/admin_header.php'; ?>
       
        <main>
            <section class="jobseekar-profile">
                <?php include "inner-menu.php"; ?>
               
                <div class="container">
                    <ul class="bcrumb-listjobs">
                        <li> <a href="index.php">Home</a> </li>                        
                        <li> <a href="#">Notifications</a> </li>
                    </ul>
                </div>
                
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        
                        <div class="container">
                           
                            <div class="notifications-block">
                                <div class="title-block-tab">
									<h4 class="flight"><span class="fbold">Notifications from Employer</span></h4>
								</div>                              
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
$noti_query1="select * from tbll_emplyer where emp_id='".$noti_data['job_owner_id']."' order by emp_id desc";
$noti_res1=mysqli_query($con,$noti_query1);	
												$datas=mysqli_fetch_array($noti_res1);
                                                  $jb_qq="select * from tbl_jobposted where Job_Status='1' and Job_Id=".$noti_data['job_id'];
												  $jb_res=mysqli_query($con,$jb_qq);
                                                  $data=mysqli_fetch_array($jb_res);
                                                  ?>
                                                <tr>
                                                    <td> 	
<?php if($data['Comp_Name']!=''){?>
													
                                                     <a href="view-job-admin.php?jid=<?php echo $noti_data['job_owner_id']?>&jobId=<?php echo $noti_data['job_id']?>&cd=<?php echo $noti_data['created_on'];?>&act=noti">
														<?php echo $data['Comp_Name']; ?>
													 </a>
<?php } else {?> <a href="employer-detail-recruiter.php?uid=<?php echo $noti_data['job_owner_id'];?>&cd=<?php echo $noti_data['created_on'];?>&act=notis">
														<?php  echo $datas['companyname'];?>
													 </a><?php } ?>
                                                    </td>
                                                    <td> 
													<?php 
														$sql1 = "SELECT * FROM tbl_desigination where Desig_Id ='".$data['Job_Name']."'";
														$query1 = mysqli_query($con, $sql1);
														$row1 = mysqli_fetch_array($query1);
													?>
								  
                                                     <?php echo $row1['Desig_Name'];?>
                                                    </td>
                                                   <td><?php echo $noti_data['description'];?></td>
                                                    <td><?php 
                                                            $date=date_create($noti_data['created_on']);
                                                            echo date_format($date,"M d, Y"); 
                                                      ?>
                                                        

                                                    </td>                                                  
                                                </tr>
                                               <?php  } }
                                          
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
      
        <?php include 'footer.php'; ?>
           
</body>

</html>