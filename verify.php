<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$statusY = "V";
	$statusN = "N";
	
	$stmt = $user->runQuery("SELECT JUser_Id,JuserStatus FROM tbl_jobseeker WHERE JUser_Id=:uID AND JtokenCode=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['JuserStatus']==$statusN)
		{
			$stmt = $user->runQuery("UPDATE tbl_jobseeker SET JuserStatus=:status WHERE JUser_Id=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			//for adding updated date in 'tbl_user_admin_curationdts' for validation start date
			$up_dt1 =  NOW();
			$stmt = $user->runQuery("UPDATE tbl_user_admin_curationdts SET V_updt=:status WHERE JUser_Id=:uID");
			$stmt->bindparam(":status",$up_dt1);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();
			
			?>
			<script lang="javascript">
			
		alert("Your Account is Now Activated");
		window.location='login.php';

</script>		
<?php	  
		}
		else
		{
			?>
<script lang="javascript">
			
		alert("Your Account is Allready Activated ");
		window.location='login.php';

</script>		
		   <?php   
		}
	}
	else
	{
		?>
<script lang="javascript">
			
		alert(" No Account Found ");
		window.location='index.php';

</script>	
		<?php
	}	
}

?>
<?php  require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('#default, .select-dropdown').focus(function () {
                    $('.pagebanner-in').addClass('darkbg');
                })
                $('#default, .select-dropdown').blur(function () {
                    $('.pagebanner-in').removeClass('darkbg');
                });
            });
        </script>
</head>

<body>
    <?php 
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } else {
    include "prelogin-header.php"; 
    } ?>
        
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