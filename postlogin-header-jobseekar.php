<?php require_once 'dbconfig.php'; 

 $from_name_query="SELECT JFullName from tbl_jobseeker WHERE JUser_Id=".$_SESSION['userSession'];
$from_name_res=mysqli_query($con,$from_name_query);
$from_name=mysqli_fetch_array($from_name_res);


$jb_query="select * from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
$jb_res=mysqli_query($con,$jb_query);
$jb_data=mysqli_fetch_array($jb_res);

  $notif_query="select * from tbl_notifications where notification_to='".$_SESSION['userSession']."' and mode='employer' and notification_read=0";
$notif_res=mysqli_query($con,$notif_query);
  $notif_count=mysqli_num_rows($notif_res);

$short_query="select * from tbl_shortlisted where JUser_Id=".$_SESSION['userSession']." and notification_read=0 ";
$short_res=mysqli_query($con,$short_query);
 $short_count=mysqli_num_rows($short_res);

 $inter_query="select * from interviewscheduled where juser_id=".$_SESSION['userSession']." and notification_read=0 ";
$inter_res=mysqli_query($con,$inter_query);
 $inter_count=mysqli_num_rows($inter_res);
 

 $total_notif=$notif_count+$short_count+$inter_count;
 
 


?>

    <header>
	<style>
	@media only screen and (max-width: 768px) {
    .invite img{
		display:none;
	}
	
	.invite1  {
		display:block !important;
	}
	.modal{
position: absolute;
  
    z-index: 999999 !important;
    
  

	}
}



	</style>
         <div class="container nopadmob">
        <nav class="navbar navbar-default navbar-static nav-postlogin-js">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarpost" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="index.php" alt="needyin"><img src="img/logo.png" alt="needyin"></a>
            </div>
             <div id="navbarpost" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="notif"> <a href="notifications.php"> Notifications <i class="fa fa-bell" aria-hidden="true"></i><span><?php echo $total_notif;?></span></a> </li>
					  <li> </li>
                   <li class="dropdown">
                           <a class="profile-pic" style="float:left;" href="jobseeker-profile.php"> <?php if($jb_data['JPhoto']!="") { ?><img src="<?php echo $jb_data['JPhoto']; ?>" alt="" class="circle img-cover" data-object-fit="cover" data-object-fit="cover"><?php } else { ?><img src="img/profile-ic.png" alt="" class="circle img-cover" data-object-fit="cover"><?php } ?> </a>
                              <a class="dropdown-toggle profile-pic" style="float:left;" href="javascript:void(0)" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $jb_data['JFullName']; ?> <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
								<li>
                                        <a href="#invitefriend"><i class="fa fa-plus" aria-hidden="true"></i>Invite Friend</a>
                                        </li>
			
                                     <li>
                                        <a href="jobseeker-profile.php"> <i class="fa fa-user-o" aria-hidden="true"></i> My Profile</a>
                                        </li>
                                        <li>
                                            <a href="jobseeker-profile-recent-activities.php"> <i class="fa fa-list-alt" aria-hidden="true"></i> My Activities</a>
                                        </li>
                                        <li>
                                            <a href="jobseeker-profile-update-password.php"> <i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                                        </li>
                                        <li>
                                        <a href="savejob.php"> <i class="fa fa-user-o" aria-hidden="true"></i> Save a Job</a>
                                        </li>
                                        <li>
                                            <a href="jobseekar_logout.php"> <i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                        </li>
                 <li><a class="invite" href="#invitefriend" ><img src="img/invite_friend3.png" style="height: 50px;width: 70px;margin-top: -15px"></a>
				 <a class="invite1" style="display:none" href="#invitefriend" ><span>Refer a Friend</span></a></li>
                 
                </ul>
            </div>
			
			
          
        </nav>
    </div>
	            
    <div id="invitefriend" class="modal" >
               <form method="post" action="visit.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Invite Friend</h3>
                   
                    <div class="importjobs-in">
                        
                        
						<div class="input-field">
                           <input id="email" type="email" name="email"> 
                           <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                           <input id="name" type="text" name="name"> 
                           <label for="name">Name</label>
                        </div>
						 <div class="input-field">
                           <input id="number" type="text" name="number"> 
                           <label for="number">Mobile Number</label>
                        </div>
						<div class="input-field">
                            <input  type="hidden" name="fromname" value="<?php echo $from_name['JFullName']?>">
                             <label for="fromname"></label>
                        </div>
						<div>
						<a href="#" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
                    <a  class=" modal-action waves-effect waves-green btn-flat"><input type="submit" name="inviteFriend" value="Send"></a>
						</div>
                        
                    </div>
                </div>
                
                    
                    
                    
        
             </form>
			</div>
			
    </header>
  