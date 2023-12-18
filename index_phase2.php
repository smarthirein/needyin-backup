<!DOCTYPE html>
<?php 
require_once 'class.user.php';
$user_login = new USER();



$curl='job-detail-postlogin.php'.'?loc='.$_GET['loc'].'&skills='.$_GET['sids'].'&jid='.$_GET['job_id'].'&uid='.$_GET['emp_id'];

if(isset($_POST['login']))
{
	$email = trim($_POST['username']);
	$upass = trim($_POST['password']);
	$loginsql="SELECT * FROM `tbl_jobseeker` WHERE `JEmail`='$email'";
	$loginres=mysqli_query($con,$loginsql);
	$numrows=mysqli_num_rows($loginres);

	$login_data=mysqli_fetch_array($loginres);
	$dnd=$login_data['jdndstatus'];
if($numrows>0)
{
	if($user_login->login($email,$upass))
	{

		if($dnd=='2')
	    {
	    	$user_login->redirect('jobseeker-profile-update-password.php?dmsg=dmsg');
	    }
		else if($_GET['sids']=="")
		{
         
		 $user_login->redirect('jobseeker-profile.php');
	    } 
	    else 
	    {   
	    	$user_login->redirect($curl);
	    }
	}
	if(!$user_login->login($email,$upass))
	{
		echo "<script lang='javascript'>alert('Email ID or password is wrong')</script>";
	}
}
	else
	{
	echo '<script lang="javascript">alert("Your email Id isn\'t registered with us or Please check your email id '.$user_login->login($email,$upass).'")</script>';
	}
}
?>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Needyin</title>
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">
      <link rel="stylesheet" type="text/css" href="css_phase2/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="css_phase2/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css_phase2/style.css">
      <link rel="stylesheet" type="text/css" href="css_phase2/reset.css">
      <link rel="stylesheet" type="text/css" href="css_phase2/global.css">
      <!-- Link Swiper's CSS -->
      <link rel="stylesheet" href="css_phase2/swiper.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="js_phase2/jquery.min.js"></script>
      <script src="js/jquery.easing.min.js"></script>
      <script src="js_phase2/bootstrap.min.js"></script>
      <!--  comparision-slider-scripts -->
      <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> 
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
      <!--  //comparision-slider-scripts -->
      <!-- Swiper JS -->
      <script src="js_phase2/swiper.min.js"></script>
      <script src="js_phase2/custom.js"></script>
      <script src="js_phase2/fadeInOutGallery.js"></script>
   </head>
   <body class="bg-color-blue">
      <!-- Login-Popup -->
      <div class="modal fade top20" id="loginPopup"  role="dialog">
         <div class="modal-dialog ">
            <div class="modal-content text-center">
               <!-- login-block -->
               <div class="login-pop-container">
                  <div class="login-block">
                     <button type="button" class="close pull-left marginLeft10px" data-dismiss="modal">×</button>
                     <div class="login-block-text" id="login">
                        <h1 class="text-center color-blue">LOGIN</h1>
                        <form action="" method="post">
                           <ul class="form-group">
                              <li>
                                 <input type="text" id="email" name="username" placeholder="User name" class="form-control">
                                 <div class="error">Please enter correct value</div>
                              </li>
                              <li>  <input type="password" id="password" name="password" placeholder="password" class="form-control"></li>
                              <a onclick="forgot()" class="pull-right" href="#">  Forgot Password ?</a>
                           </ul>
                            <button class="btn start-btn" type="submit" onclick="return validate()" name="login">lets get started</button>
                        </form>
                        <!--  <ul class="login-pop-links-sec">
                           <li><a href="">business email id</a></li>
                           <li><a href="">password</a></li>
                           <li><a href="">forgot password</a></li>
                           </ul> -->
                       
                        <a href="signup-jobseekar.php" class="login-but-text">not a member ? SIGNUP</a>
                     </div>
					 
					 <div class="forgot-block" id="forgot">
                        <h1 class="text-center color-blue">FORGOT PASSWORD</h1>
                        <form action="#" method="post">
                           <ul class="form-group">
                              <li>
                                 <input type="text" id="femail" name="email" placeholder="Email" class="form-control">
                                 <div class="error">Please enter correct value</div>
                              </li>
                           </ul>
                            <button class="btn start-btn" type="submit" name="forgot-password" onclick="return fvalidate()">submit</button>
							 <a class="btn start-btn"  name="cancel" onclick="forgot()">cancel</a>
                        </form>
                        <a href="signup-jobseekar.php" class="login-but-text">not a member ? SIGNUP</a>
                     </div>
                     <div class="login-block-image">
                        <img src="http://www.gdgoenka-gurgaon.com/images/login_icon.jpg">
                     </div>
                  </div>
               </div>
               <!-- //login-block -->
               <div class="login-hire-block text-right">
                  <div class="login-hire-block-text">
                     <h1 class="color-white">HIRE</h1>
                     <p>Finding the right candidate for your desired location is just a matter of seconds. Register yourself with Needyin and get benefitted with the innumerable features making your candidate search even easier. 
                     </p>
                  </div>
                  <div class="login-hire-block-image">
                     <img src="https://www.abservetech.com/wp-content/uploads/2017/09/hire-dedicated-devloper.png">
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- //Login-Popup -->
      <!--**** Landing-Screen**** -->
      <div class="landing-screen" id="landingScreen">
         <span class="global-letter global-letter-N bottom45">N</span>
		 <?php if(!isset($_SESSION['userSession'])) { ?>
         <div class="login-sec" data-toggle="modal" data-target="#loginPopup">
            <img src="images_phase2/7.png" alt="login_img">
            <p>LOGIN</p>
         </div>
		 <?php } ?>
         <div id="compare-img-container" class="compare-slider">
            <span class="cmp-border-top"></span>
            <div id="cmp-img-bt" class="cmp-img">
               <div class="cmp-img-text cmp-img-text-right">keeping you away from your family</div>
               <img src="images_phase2/2.jpg" class="img-responsive">
            </div>
            <div id="cmp-img-top" class="cmp-img">
               <div id="cmp-mask">
                  <div class="cmp-img-text cmp-img-text-right">
                     <span>Needyin helps you reconcile with your family!</span>
                  </div>
                  <div class="cmp-img-text cmp-img-text-left">
                     <span>Nothing is worth, if you aren’t happy!<br>
                     Life seems to be better when you focus on what truly matters!
                     </span>
                  </div>
                  <img src="images_phase2/1.jpg" alt="">
                  <span class="logo-circle">
                  <img src="images_phase2/LOGO_home.png" class="img-responsive">
                  <a href="#verticalSwiper">
                  <button class="btn start-btn" type="button">lets get started</button>
                  </a>
                  </span>
               </div>
               <div id="cmp-drag">
                  <div id="cmp-drag-btn"> 
                     <i class="fa fa-caret-left" aria-hidden="true"></i>
                     <i class="fa fa-caret-right" aria-hidden="true"></i> 
                  </div>
               </div>
            </div>
         </div>
         <!--Banner-->
         <section id="verticalSwiper" class="vertical-swiper-container">
            <div class="banner">
               <div class="wrraper">
                  <span class="global-letter global-letter-N">N</span>
                  <!-- Swiper -->
                  <div class="swiper-container custom-vertical-swiper">
                     <div class="swiper-wrapper">
                        <div class="swiper-slide">
                           <img src="images_phase2/3.jpg" class="img-responsive">
                           <div class="cmp-img-text">
                              <span class="">SEEKING A BALANCED LIFE? <br>
                              YOU’VE JUST REACHED THE RIGHT PLACE!
                              </span>
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <img src="images_phase2/3a.jpg" alt="" class="img-responsive">
                           <div class="cmp-img-text">
                              <span>
                              IS YOUR JOB NOT ALLOWING YOU TO BE WITH YOUR FAMILY& FRIENDS?<br> 
                              FIND A JOB THAT BRINGS YOUR LIFE BACK!
                              </span>
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <img src="images_phase2/3b.jpg" alt="" class="img-responsive">
                           <div class="cmp-img-text">
                              <span class="">
                              WAITING FOR A LONG WEEKEND TO MEET FAMILY?<br>
                              NOT ANYMORE! FIND A JOB WHERE YOU FAMILY IS
                              </span>
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <img src="images_phase2/3c.jpg" alt="" class="img-responsive">
                           <div class="cmp-img-text">
                              <span>
                              FIND JUST THE RIGHT CANDIDATE, FOR THE RIGHT JOBS, FOR THE RIGHT LOCATION IN A SIMPLE CLICK.
                              </span>
                           </div>
                        </div>
                     </div>
                     <!-- Add Pagination -->
                     <div class="swiper-pagination"></div>
                  </div>
               </div>
               <!-- login -->
			    <?php if(!isset($_SESSION['userSession'])) { ?>
               <div class="login-sec right5px" data-toggle="modal" data-target="#loginPopup">
                  <img src="images_phase2/7.png" alt="login_img" class="img-responsive">
                  <p>LOGIN</p>
               </div>
				<? } ?>
               <!-- social links -->
               <ul class="social-links-sec">
               	<li><a href="https://www.facebook.com/needyin/"><img src="images_phase2/8.png"></a></li>
               	<li><a href="https://www.linkedin.com/company/needyintechnologies"><img src="images_phase2/9.png"></a></li>
               	<li><a href="https://twitter.com/Needyin"><img src="images_phase2/10.png"></a></li>
               </ul>
               <a href="#sucessSotries" class="mouse-hover">
                  <div class="mouse">
                  </div>
               </a>
            </div>
            <!--/ Banner-->
         </section>
         <!--Navigation bar-->
         <nav class="navbar navbar-default needyin-navbar">
            <div class="container">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.html">
                 <img src="images_phase2/LOGO_main_home.png" class="navbar-needy-logo img-responsive">
                  </a>
               </div>
               <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav navbar-right">
                     <li><a href="#verticalSwiper" class="nav-home effect-underline">Home</a></li>
                     <li><a href="#sucessSotries" class="effect-underline">Sucess stories</a></li>
                     <li><a href="#whyNeedyin" class="effect-underline">Why we</a></li>
                     <li><a href="#howItworks" class="effect-underline">How it works</a></li>
                     <li><a href="#getHired" class="effect-underline">Get hired</a></li>
                  </ul>
               </div>
            </div>
         </nav>
         <!--/ Navigation bar-->
      </div>
      <!--****//Landing-Screen**** -->
      <div class="home-page-container" id="homePage">
         <!--Sucess Stories-->
         <section id="sucessSotries" class="section-wrraper sucess-stories-section">
            <span class="global-letter global-letter-S">S</span>
            <div class="container-fluid">
               <div class="sucess-info row">
                  <div class="col-lg-6 col-md-6 col-sm-6 m-0 p-0 sucess-left-block">
                     <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 m-0 p-0 h-100">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0 h-50">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0 h-50">
                           <div class="slideshow1 slideshow">
                              <img src="images_phase2/20.jpg" class="img-responsive">
                              <img src="images_phase2/23.jpg" class="img-responsive">
                              <img src="images_phase2/19.jpg" class="img-responsive">
                              <img src="images_phase2/22.jpg" class="img-responsive">
                           </div>
                           <img src="images_phase2/20.jpg" class="img-responsive">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0 h-50">
                           <div class="slideshow2 slideshow">
                              <img src="images_phase2/22.jpg" class="img-responsive">
                              <img src="images_phase2/23.jpg" class="img-responsive">
                              <img src="images_phase2/19.jpg" class="img-responsive">
                              <img src="images_phase2/22.jpg" class="img-responsive">
                           </div>
                           <img src="images_phase2/22.jpg" class="img-responsive">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 p-0 h-50 bg-color-dark-blue">
                           <span class="quotation quot-md quot-up"><img src="images_phase2/6.png"></span>
                           <div class="text-slideshow1 slideshow">
                              <p>
                                 “Registering onNeedyin was the best decision I’veever made. I found a good job in Delhi and am happy with my family too.”<br>- Prashant Desai
                              </p>
                              <p>
                                 “My mother was not well and I had to be there for her. Thanks to Needyin for giving the kind of job I wanted in my city.” <br>- ManishaGoyal
                              </p>
                              <p>
                                 “I am the only child and if Needyin was not there, I wouldn’t have been able to treat my ailing father. Thank You Needyin” <br>- PrithviJayaram
                              </p>
                              <p>
                                 “I felt guilty each time I missed my daughter’s birthday due to work. Needyin helped me settle down in my own city and last month we celebrated my daughter’s 5th Birthday.”<br>–Kartik Bhatia
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 m-0 p-0 h-80">
                        <div class="slideshow3 slideshow">
                           <img src="images_phase2/23.jpg" class="img-responsive">
                           <img src="images_phase2/22.jpg" class="img-responsive">
                           <img src="images_phase2/19.jpg" class="img-responsive">
                           <img src="images_phase2/22.jpg" class="img-responsive">
                        </div>
                        <img src="images_phase2/23.jpg" class="img-responsive">
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 m-0 p-0 sucess-right-block">
                     <div class="slideshow5 slideshow">
                        <img src="images_phase2/19.jpg" class="img-responsive">
                        <img src="http://www.mynewdealok.com/images/profile-img.jpg" class="img-responsive">
                        <img src="images_phase2/23.jpg" class="img-responsive">
                        <img src="images_phase2/19.jpg" class="img-responsive">
                        <img src="images_phase2/22.jpg" class="img-responsive">
                     </div>
                     <img src="images_phase2/19.jpg" class="img-responsive">
                     <div class="right-top">
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block bg-transparent-blue">
                           <span class="quotation quot-md quot-down"><img src="images_phase2/6.png"></span>
                           <div class="text-slideshow2 slideshow">
                              <p>
                                 “My mother was not well and I had to be there for her. Thanks to Needyin for giving the kind of job I wanted in my city.” <br>- ManishaGoyal
                              </p>
                              <p>
                                 “Registering onNeedyin was the best decision I’veever made. I found a good job in Delhi and am happy with my family too.”<br>- Prashant Desai
                              </p>
                              <p>
                                 “I am the only child and if Needyin was not there, I wouldn’t have been able to treat my ailing father. Thank You Needyin” <br>- PrithviJayaram
                              </p>
                              <p>
                                 “I felt guilty each time I missed my daughter’s birthday due to work. Needyin helped me settle down in my own city and last month we celebrated my daughter’s 5th Birthday.”<br>–Kartik Bhatia
                              </p>
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block bg-color-dark-blue">
                        </div>
                     </div>
                     <div class="right-bottom">
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block">
                           <div class="bg-color-blue h-60">
                              <h2 class="p-0 m-0 text-center">SUCESS<br>
                                 STORIES
                              </h2>
                              <span class="quotation quot-sm quot-up"><img src="images_phase2/6.png"></span>
                           </div>
                           <div class="text-slideshow3 slideshow">
                              <p>
                                 “I am the only child and if Needyin was not there, I wouldn’t have been able to treat my ailing father. Thank You Needyin” <br>- PrithviJayaram
                              </p>
                              <p>
                                 “My mother was not well and I had to be there for her. Thanks to Needyin for giving the kind of job I wanted in my city.” <br>- ManishaGoyal
                              </p>
                              <p>
                                 “Registering onNeedyin was the best decision I’veever made. I found a good job in Delhi and am happy with my family too.”<br>- Prashant Desai
                              </p>
                              <p>
                                 “I felt guilty each time I missed my daughter’s birthday due to work. Needyin helped me settle down in my own city and last month we celebrated my daughter’s 5th Birthday.”<br>–Kartik Bhatia
                              </p>
                           </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block">
                           <div class="slideshow4 slideshow">
                              <img src="http://www.mynewdealok.com/images/profile-img.jpg" class="img-responsive">
                              <img src="images_phase2/23.jpg" class="img-responsive">
                              <img src="images_phase2/19.jpg" class="img-responsive">
                              <img src="images_phase2/22.jpg" class="img-responsive">
                           </div>
                           <img src="http://www.mynewdealok.com/images/profile-img.jpg" class="img-responsive">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 md-block bg-transparent-blue">
                           <span class="quotation quot-sm quot-down"><img src="images_phase2/6.png"></span>
                           <div class="text-slideshow4 slideshow">
                              <p>
                                 “I felt guilty each time I missed my daughter’s birthday due to work. Needyin helped me settle down in my own city and last month we celebrated my daughter’s 5th Birthday.”<br>–Kartik Bhatia
                              </p>
                              <p>
                                 “I am the only child and if Needyin was not there, I wouldn’t have been able to treat my ailing father. Thank You Needyin” <br>- PrithviJayaram
                              </p>
                              <p>
                                 “My mother was not well and I had to be there for her. Thanks to Needyin for giving the kind of job I wanted in my city.” <br>- ManishaGoyal
                              </p>
                              <p>
                                 “Registering onNeedyin was the best decision I’veever made. I found a good job in Delhi and am happy with my family too.”<br>- Prashant Desai
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!--/ Sucess Stories-->
         <!-- Why Needyin-->
         <section id="whyNeedyin" class="section-wrraper why-needin-section">
            <div class="container ">
               <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				  <?php if(!isset($_SESSION['userSession'])) { ?>
                     <a class="btn start-btn" data-toggle="modal" data-target="#loginPopup">lets get started</a>
				  <? } ?>
                     <p>
                        How often do jobs offer you the leisure to be with your family? How often has the idea of quitting the current job crossed your mind? Are you able to find the kind of job you need?<br>
                        How many times have you struggled to find just the right candidate for your firm? How cumbersome it is to verify the genuineness of a profile? Want to know the analytics driving the employment market?
                     </p>
                     <p>Find all the answers here!</p>
                     <button class="btn start-btn" type="button">Learn More >></button>
                     <h2 class="color-blue">WHY NEEDYIN</h2>
                  </div>
                  <span class="global-letter global-letter-w">W</span>
                  <div class="why-needin-right-block">
                     <img src="images_phase2/5.jpg">
                  </div>
               </div>
            </div>
         </section>
         <!-- //  Why Needyin-->
         <!--How It Works-->
         <section id="howItworks" class="section-wrraper how-it-works-section">
            <span class="global-letter global-letter-h">H</span>
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hw-left-block">
                     <img src="images_phase2/4.jpg" alt="hw_img"/>
                     <div class="cmp-img-text">
                        <span>
                        HOW IT WORKS
                        </span>
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hw-right-block">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hw-rw">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-right">
                           <strong>Registration</strong>
                           <p>
                              - Fill-in essential details and register on Needyin in simple steps.
                           </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <img src="images_phase2/13.png">
                        </div>
                     </div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hw-rw">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-right">
                           <strong>Verification</strong>
                           <p>
                              Our experts will get in-touch with the candidate to verify the profile genuineness.
                           </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <img src="images_phase2/15.png">
                        </div>
                     </div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hw-rw">
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 text-right">
                           <strong>Profile Visibility/Job posting</strong>
                           <p>
                              Your profile gets automatically mapped to the right employer once registered.  Employers can post their requirements.
                           </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <img src="images_phase2/14.png">
                        </div>
                     </div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hw-rw">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-right">
                           <strong>Employment Opportunity</strong>
                           <p>
                              Once visible, suitable employers connect with the job-seekers regarding the opportunity.  
                           </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <img src="images_phase2/12.png">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!--/ How It Works-->
         <!--Get Hired-->
         <section id="getHired" class="section-wrraper  get-hired-section">
            <span class="global-letter global-letter-G">G</span>
            <div class="container">
               <div class="row">
                  <div class="get-hired-wrraper">
                     <div class="get-hired-sec gh-block">
                        <h1>GET HIRED</h1>
                        <p>
                           Your work-life balance is just a click away. Fill-in few essential details and leave the rest on us. We map your profile to the right employers who are looking for the candidates just like you.Upload/update your resume and increase the chances of your hiring today!signup-jobseekar.php
                        </p>
						<?php if(!isset($_SESSION['userSession'])) { ?>
                        <a href="signup-jobseekar.php" class="btn start-btn" >lets get started</a><br>
                        <div  data-toggle="modal" data-target="#loginPopup" class="login-but-text text-uppercase">already registered ? login</div>
						<? } ?>
                     </div>
                     <div class="find-profe-sec gh-block">
						<?php if(!isset($_SESSION['userSession'])) { ?>
                        <a href="employer-registration.php" class="btn start-btn">lets get started</a><br>
                        <a href="recruiter.php" class="login-but-text text-uppercase">already registered ? login</a>
						<? } ?>
                        <p>Finding the right candidate for your desired location is just a matter of seconds. Register yourself with Needyin and get benefitted with the innumerable features making your candidate search even easier. 
                        <h1>HIRE</h1>
                     </div>
                     <ul class="social-links-sec">
                        <li><a href="https://www.facebook.com/needyin/"><img src="images_phase2/8.png"></a></li>
                        <li><a href="https://www.linkedin.com/company/needyintechnologies"><img src="images_phase2/9.png"></a></li>
                        <li><a href="https://twitter.com/Needyin"><img src="images_phase2/10.png"></a></li>
                     </ul>
                  </div>
               </div>
               <ul class="links-list">
                  <li><a href="about_us.php">About Us</a></li>
                  <li><a href="faq.php">FAQs</a></li>
                  <li><a href="terms-conditions.php">Terms & Conditions</a></li>
                  <li><a href="privacy.php">Privacy Policy</a></li>
                  <li><a href="contact.php">Contact Us</a></li>
               </ul>
            </div>
      </div>
      <div clear="all"></div>
      <!-- Footer -->
      <div class="needy-footer">
      <div class="container text-center">
      <span>Copyright 2017 Needyin. All Rights Reserved</span>
      <span class="pull-right">info@needyin.com</span>
      </div>
      </div>
      <!--// Footer -->
      </section>
      <!--/ Get Hired-->
      </div>
   </body>
<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if(isset($_POST['forgot-password']))
{
	$email = $_POST['email'];
	$pwdresetquery=("SELECT * FROM `tbl_jobseeker` WHERE JEmail='$email'");
	$pwdresetqueryres=mysqli_query($con,$pwdresetquery);
	$pwdresetqueryrow = mysqli_fetch_array($pwdresetqueryres);	
	$jsname=ucfirst($pwdresetqueryrow['JFullName']);
	$sname=base64_encode($jsname);
	if(mysqli_num_rows($pwdresetqueryres) == 1)
	{
		$id = base64_encode($pwdresetqueryrow['JEmail']);
		$code = md5(uniqid(rand()));
	
		$stmt = $user->runQuery("UPDATE tbl_jobseeker SET JtokenCode=:token WHERE JEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
                $siteurl="http://needyin.com"; 		
		$message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
            <td align='left' width='400px;' >
                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
               
            </td>
            <td align='right' width='300px;'>
                <table>
                    <tr height='70'>
                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |</td>
                       <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/js_forgot.php?sn=".$sname."&jsi=".$id."&jsc=".$code."' target='_blank'>View in web</a> 
		                </td>
                       
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
                <td colspan='2' >
                              <div style='background:url(https://www.needyin.com/img/for-passw.png) no-repeat center 0; background-size: 597px 396px; height:245px; ' >
                              
                                      <div style='text-align: justify;font-size: 15px;padding: 20px; margin-left: 350px;   width: 210px;  color: white; padding-top: 45px; line-height: 18px;'> 
                                                Dear ".$jsname.",<br><br>
                                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            To change your password, we request you to click on the below link which will redirect you to set new password.<br><br><br>

                                            Thanks<br>
                                            Team Needyin. 
                                    </div>
                              </div>
                </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#90bd14;' align='center'>
                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'><a href=".$siteurl."/reset-pw.php?id=".$id."&code=".$code.">Click here to set new password</a></p>
                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'></p>
            </td> 
        </tr>
        <tr>
            <td height='5' colspan='2' align='center'>
            </td>
        </tr>
        <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:14px; line-height:18px; color:#fff; padding:0 27px;'>In case of any support required, please contact  <a style='color:#fff; text-decoration:underline;' href='mailto:support@needyin.com '>support@needyin.com  </a> to set your password.</p>
            </td>
        </tr>
        
        </tr>
    </table>";
		$subject = "Needyin- Forgot Password";				
		$user->send_mail($email,$message,$subject);		
		echo "<script lang='javascript' >alert('A link has been sent your email to set a new password. Please check your mail'); document.location.replace('https://needyin.com/dev/index_phase2.php');</script>";		 
		 
	}
	else
	{
		echo "<script lang='javascript' >alert('Entered Email does not exist'); document.location.replace('https://needyin.com/dev/index_phase2.php');</script>";
	}
}
?>
</html>