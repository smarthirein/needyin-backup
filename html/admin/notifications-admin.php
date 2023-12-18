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
 $noti_query="select * from tbl_notifications where notification_to='".$_SESSION['adminSession']."' and mode='admin' and profile_id !='' order by id desc";
$noti_res=mysqli_query($con,$noti_query);
$notif_cnt=mysqli_num_rows($noti_res);
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
   <?php 
include_once("../analyticstracking.php");
	include '../includes-recruiter/admin_header.php'; ?>
       
        <main>
            <section class="jobseekar-profile">              
              
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
                                    <h4 class="flight">Notifications from Jobseeker<span class="fbold"></span></h4> </div>
                              
                                <div class="notifications-list">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>From</th>
                                                    <th>Subject</th>
                                                    <th>Date</th>                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if($notif_cnt>0)
                                            {
                                            while($nt_data=mysqli_fetch_array($noti_res))
                                                 {  
												  $jb_qq="select * from tbl_jobseeker where JUser_Id='".$nt_data['profile_id']."' ";
                                                  $jb_res=mysqli_query($con,$jb_qq);
                                                  $data=mysqli_fetch_array($jb_res);
                                                  ?>
                                                <tr>
                                                    <td>
														<a href="jobseeker-detail-recruiter.php?uid=<?php echo $nt_data['profile_id'] ?>&noti_id=<?php echo $nt_data['id']?>"><?php echo ucfirst($data['JFullName']);?>
												    </td>
                                                    <td>
														<?php echo $nt_data['description'];?>
													</td>
                                                    <td>
														<?php $date=date_create($nt_data['created_on']);
														echo date_format($date,"M d,Y H:i:s");?> 
													</td>    
												</tr>
                                               <?php } } 
                                               else {?>
                                               <tr>
                                                    <td colspan="3"><center>No Notifications</center></td>
                                                </tr>
                                               <?php } ?>
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