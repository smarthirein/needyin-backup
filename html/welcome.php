<?php  require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="NeedyIn is a free online platform for job seekers who are immediate joiners and employers to meet their job requirements.">
    <title>Free Job Portals and Placement Consultants | Job Posting Sites in India - Needyin</title>
	 
        <link rel="stylesheet" type="text/css" href="imageslider/css/style3.css" />
		<script type="text/javascript" src="imageslider/js/our.js"></script>
    <?php include "source.php" ?>
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
    #Video1
    {
     position:absolute;
     top: 60px;
     left:150px;        
     width:auto;
	height:auto;	 
     border:2px solid blue;
     display:block;
     z-index:99;
     }
     }
       
      
    </style>
</head>
<body id="page">
 <video id="Video1" controls autoplay >
           <source src="https://www.needyin.com/videos/independence.mp4" type="video/mp4" />           
       </video>
	   <script>
      var vid = document.getElementById("Video1");
      vid.onended = function() {
            window.open("index.php", "_self");
      };
</script>
  <ul class="cb-slideshow">
  <li><span></span><div><h3>Want to be there for your old age parents ? <strong style="color:#005eb8 !important;">Needyin</strong> is here..</h3></div></li>
          <li><span></span><div><h3> When in need of Job think <strong style="color:#005eb8 !important;">Needyin </strong></h3></div></li>
         <li><span></span><div><h3><strong style="color:#005eb8 !important;">Needyin</strong> supports in moving you closer to your loved ones </h3></div></li>
         <li><span></span><div><h3><strong style="color:#005eb8 !important;">Needyin</strong> supports... </h3></div></li>
           <!-- <li><span></span><div><h3>Difficult to Balance Work and Life</h3></div></li>  -->
		    <!--  <li><span></span><div><h3> Fulfill your need to support your family with <strong style="color:#005eb8 !important;">Needyin</strong>  </h3></div></li>-->
        </ul>
<?php 
	include_once("analyticstracking.php");
 $query="select jdndstatus from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
                                  $query_res=mysqli_query($con,$query);
                                  $dnd=mysqli_fetch_array($query_res);
                                $dnd_status=$dnd['jdndstatus'];
?>
   <div class="loader"></div>
    <?php 
     if($dnd_status=='2')
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
                include "prelogin-header.php"; 
              } 
       }
	?>
        <!-- main-->
        <main>
       
            <section >
		<!-- here am removing class to this div for transparent image at home as if you want search add below div  class-->
                <!--<div class="pagebanner-in">-->
				<div class="">
                    <div class="bannerin">
                        <div class="container">
                            <!-- search -->
							<?php 
									if(isset($_SESSION['empSession']) || !isset($_SESSION['userSession']))
        {
									
		}
else{
			
		?>
                            <div class="row search-home nomrg">
                                <div class="search-home-in newsearch">
                                    <div class="row">
									
		<?php require_once "search.php"; ?>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
                            
                            <!--<div class="row">
                                <div class="col-md-12  text-center">
                                  
                                    <article>
                                        <h1 class="h1 txt-white">Exciting Career Opportunities </h1>
                                        <p class="txt-white flight">Get registered with Needyin and reunite with your immediate family at your preferred location. </p>
               					     </article>
                                    
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            
          
            
        <!--   <section class="ads-block">
                <div class="container">
                  <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                       <ul id="slides" class="slide01">
					     <li class="slide showing"><a href="signup-jobseekar.php"><img src="img/ads-img/ad-home01.jpg"></a></li>
                           <li class="slide"><a href="signup-jobseekar.php"><img src="img/ads-img/ad-home02.jpg"></a></li>
						    <li class="slide"><a href="signup-jobseekar.php"><img src="img/ads-img/ad-home03.jpg"></a></li>
						 
                        </ul>
                    </div>
                  </div>
                </div>
                <script>
                   var slides = document.querySelectorAll('#slides .slide');
                        var currentSlide = 0;
                        var slideInterval = setInterval(nextSlide,5000);

                        function nextSlide(){
                            slides[currentSlide].className = 'slide';
                            currentSlide = (currentSlide+1)%slides.length;
                            slides[currentSlide].className = 'slide showing';
                        }
                </script>
            </section>-->
		
			
			</section>
            
            <section class="top-employers">
                <div class="container">
                    <h3 class="h3 text-center flight">Top <span class="fbold">Employers</span></h3>
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic01.png"> <span class="comp-name">freelancer.com  </span>
                                <!--<span class="noofjobs">(225 Jobs)</span>--></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic02.png"> <span class="comp-name">wot if  </span>/a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic03.png"> <span class="comp-name">Merck  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic04.png"> <span class="comp-name">airbnb  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic05.png"> <span class="comp-name">cisco  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic06.png"> <span class="comp-name">Fedex  </span></a>
                            </figure>
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic07.png"> <span class="comp-name">Altmetric  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic08.png"> <span class="comp-name">EUA  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic09.png"> <span class="comp-name">Ascap  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic10.png"> <span class="comp-name">Caterpiller  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic11.png"> <span class="comp-name">Omnibus Press  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic12.png"> <span class="comp-name">City Pass  </span></a>
                            </figure>
                        </div>
                    </div>
                  
                </div>
            </section>
            
            </section>
          
        </main>
    <div id="bubble">
			</div>
        <?php 
        if($dnd_status!='2')
         {
            include 'footer.php';
            } ?>

			</body>
<script>

	
setInterval(disappearUpdate,6000);
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
}
</script>
</html>