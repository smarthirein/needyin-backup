<?php  require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="NeedyIn is a free online platform for job seekers who are immediate joiners and employers to meet their job requirements.">
    <title>Free Job Portals and Placement Consultants | Job Posting Sites in India - Needyin</title>
	 
	<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
		
		<link rel="stylesheet" type="text/css" href="needyinLanding/needyinLanding/assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/responsive.css" />
		<link rel="stylesheet" type="text/css" href="css/recruiter.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="needyinLanding/needyinLanding/assets/js/jquery.min.js"></script> 
      
    <?php // include "source1.php" ?>
        <script>
            $(document).ready(function () {
               
                $('.searchskills, .sel-city').focusin(function () {
                    $('.pagebanner-in').addClass('darkbg');
                })
              
                $('.searchskills, .sel-city').focusout(function () {
                    $('.pagebanner-in').removeClass('darkbg');
                });
            });
        </script>
		 <style type="text/css">    
header .navbar-brand {
    height: auto!important;
    padding: 0!important;
}
		 
header .navbar-brand img {
    width: 198px;
}
header .navbar-default .navbar-nav li a {
    line-height: 27px;
    padding-top: 0;
    padding-bottom: 0;
    font-size: 13px;
    color: #333;
    text-transform: uppercase;
}
.pheader {
    background: #fff !important;
    position: relative;
    z-index: 9999 !important;
}
     .bslider {
    background: #fff;
    opacity: 1.6;
    color: #000;
}
.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
header .navbar-default {
    background: none;
    border: none;
    box-shadow: none;
    margin-bottom: 0;
    padding: 10px 0;
}

.navbar-static {
    position: relative;
}
header .nav {
    margin-top: 10px;
}
.footer-in {
    background: url(../img/footer-trans.png) repeat 0 0;
    padding-top: 2px;
    z-index: 999999;
    left: 0;
    right: 0;
    bottom: -10px;
    position: fixed;
}
.txt-white {
    color: #fff!important;
}
    </style>
	
	<style>
		.quotes {
			display: none;
		}
	</style>
</head>
        <!-- main-->
       <body class="landing">
<!--dev <video id="Video1" controls autoplay >
            <source src="./videos/independence.mp4" type="video/mp4" />                  
       </video> -->
	   <script>
      var vid = document.getElementById("Video1"); 
      vid.onended = function() {
            window.open("welcome.php", "_self");
      };
</script>
    <!--<ul class="cb-slideshow">
  <li><span></span><div><h3>Want to be there for your old age parents ? <strong style="color:#005eb8 !important;">Needyin</strong> is here..</h3></div></li>
          <li><span></span><div><h3> When in need of Job think <strong style="color:#005eb8 !important;">Needyin </strong></h3></div></li>
         <li><span></span><div><h3><strong style="color:#005eb8 !important;">Needyin</strong> supports in moving you closer to your loved ones </h3></div></li>
         <li><span></span><div><h3><strong style="color:#005eb8 !important;">Needyin</strong> supports... </h3></div></li>
           <!--dev <li><span></span><div><h3>Difficult to Balance Work and Life</h3></div></li>  -->
		    <!--  <li><span></span><div><h3> Fulfill your need to support your family with <strong style="color:#005eb8 !important;">Needyin</strong>  </h3></div></li>-->
        </ul>
<?php 
	include_once("analyticstracking.php");
 $query="select jdndstatus from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
                                  $query_res=mysqli_query($con,$query);
                                  $dnd=mysqli_fetch_array($query_res);
                                $dnd_status=$dnd['jdndstatus'];
?>
    <?php 
      /* if($dnd_status=='2')
        {
            include "postlogin-header-inactive.php"; 
        }
        else 
        {
              if(isset($_SESSION['userSession']))
                    {
                         include "postlogin-header-jobseekar.php"; 
                    } 
                 
            	else if(isset($_SESSION['empSession']))
                    {
                         include "includes-recruiter/db-recruiter-header.php"; 
                    } 
                    
            		else
            	{
                include "prelogin-header1.php"; 
              } 
       } */
	?> 


	<div id="page-wrapper">

		<!-- Header -->
		<!--<header id="header" style="font-family:Oswald;">
			<h1 id="logo">
				<a href="index.html">
					<img style="width:170px; margin-top:15px;" src="needyinLanding/needyinLanding/images/logo.png" alt="">
				</a>
			</h1>
		
		</header> -->
<header class="pheader bslider">
    <div class="container nopadmob ">
     <nav class="navbar navbar-default navbar-static">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbarpre"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png"></a>
            </div>
            <div id="navbarpre" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                 
                    <li> <a href="job-seeker-login.php"> Job Seekers  </a> </li>
                    <li> <a href="recruiter.php">Employer Zone  </a> </li>
                    
                </ul>
            </div>
           
        </nav>
		 
</div>
	
</header>


		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
			
					<div style="background-image: url(needyinLanding/needyinLanding/images/59kb.jpg);position:relative;min-width:100%;min-height:100vh;z-index:0;">
</div>
		
				<div >
					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:28%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 20%;
					left: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#ddd3;">I have a job that pays me good…</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:20%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 25%;
					right:4%;
					z-index: 1;
					border-radius:20px;
					background-color:#ddd3;">But am i happy ???</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:18%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 30%;
					left: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#ddd3;">NO…. I am NOT!!!</h2>



					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:23%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 35%;
					right: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#33333369;">I am away from family….</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:28%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 40%;
					left: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#33333369;">Missing all the family time</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:34%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 45%;
					right: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#33333369;">Unable to take care of ageing parents</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:28%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 50%;
					left: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#33333369;">Traveling hours to work…….!</h2>

					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:47%;
					height:48px;
					color: #e8e8b3;
					font-weight:700;
					font-size:30px;
					top: 55%;
					right: 4%;
					z-index: 1;
					border-radius:20px;
					background-color:#33333369;">Can’t I find a job that could save me from these hassles?</h2>


					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:40%;
					height:145px;
					color: white;
					font-weight:700;
					font-size:30px;
					top: 50%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					border-radius:20px;
					line-height: 1.6;
					background-color:#3cb37170;">YES!! You can!<br>Look for a job that suits your needs! <br> Register in <b> <font color="#003366">Needy</font>In</b> !!</h2>


				
					<!-- <h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:100%;
					height:150px;
					color: #e8e8b3;
					font-weight:700;
					font-size:75px;
					top: 64%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					background-color:rgb(8, 8, 61);">Looking for the same profile like yours..</h2>
					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:100%;
					height:150px;
					color: #e8e8b3;
					font-weight:700;
					font-size:75px;
					top: 64%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					background-color:rgb(8, 8, 61);">What if the right candidate just crossed your path</h2>
					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:100%;
					height:150px;
					color: #e8e8b3;
					font-weight:700;
					font-size:75px;
					top: 64%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					background-color:rgb(8, 8, 61);"> and you don’t know it ?</h2>
					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:100%;
					height:150px;
					color: #e8e8b3;
					font-weight:700;
					font-size:75px;
					top: 64%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					background-color:rgb(8, 8, 61);">Look around you for opportunities and skills</h2>
				
					<h2 class="quotes" style="position: absolute;
					font-family:Oswald;
					text-align:center;
					width:100%;
					height:150px;
					color: #e8e8b3;
					font-weight:700;
					font-size:75px;
					top: 64%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%);
					z-index: 1;
					background-color:rgb(8, 8, 61);">Download and Register on
						<b>Milonow</b>, NOW!</h2> -->

				</div>
			</div>

		</div>
	</div>
	<script>
		(function () {

			var quotes = $(".quotes");
			var quoteIndex = -1;

			function showNextQuote() {
				++quoteIndex;
				quotes.eq(quoteIndex % quotes.length)
					.fadeIn(1000)
					.delay(2000)
					.fadeOut(1000, showNextQuote);
			}

			showNextQuote();

		})();
	</script>

	<!-- Scripts -->
	
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->

<?php 
        if($dnd_status!='2')
         {
            include 'footer1.php';
            } ?>

			</body>
<script>

	
/* setInterval(disappearUpdate,6000);
setInterval(showUpdate,4000);


function showUpdate() {
		
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("bubble").innerHTML = this.responseText;
			
            }
        };
        xmlhttp.open("GET", "getupdate.php", true);
        xmlhttp.send();
		
  
}
function disappearUpdate()
{
   document.getElementById("bubble").innerHTML = "";    
} */
</script>
</html>