
<?php require_once 'dbconfig.php'; 
 $jb_query="select * from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
$jb_res=mysqli_query($con,$jb_query);
$jb_data=mysqli_fetch_array($jb_res);

$nt_query="select * from tbl_notifications where notification_to='".$_SESSION['empSession']."' and mode='employer'";
$nt_res=mysqli_query($con,$nt_query);
$nt_count=mysqli_num_rows($nt_res);

$nt_query1="select * from tbl_shortlisted where JUser_Id=".$_SESSION['userSession'];
$nt_res1=mysqli_query($con,$nt_query1);
$nt_count1=mysqli_num_rows($nt_res1);

$nt_query2="select * from interviewscheduled where juser_id=".$_SESSION['userSession'];
$nt_res2=mysqli_query($con,$nt_query2);
$nt_count2=mysqli_num_rows($nt_res2);

$total_cnt=$nt_count+$nt_count1+$nt_count2;
?>
    <header>
         <div class="container nopadmob">
        <nav class="navbar navbar-default navbar-static nav-postlogin-js">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarpost" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png"></a>
            </div>
             <div id="navbarpost" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    
                   <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" href="javascript:void(0)" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if($jb_data['JPhoto']!="") { ?><img src="<?php echo $jb_data['JPhoto']; ?>" alt="" class="circle img-cover" data-object-fit="cover" data-object-fit="cover"><?php } else { ?><img src="img/profile-ic.png" alt="" class="circle img-cover" data-object-fit="cover"><?php } ?>
                                <?php echo $jb_data['JFullName']; ?> <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    
                                        <li>
                                            <a href="jobseeker-profile-update-password.php"> <i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                                        </li>
                                         <li>
                                            <a href="jobseekar_logout.php"> <i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                        </li>
                  
                </ul>
            </div>
          
        </nav>
    </div>
   
    </header>
