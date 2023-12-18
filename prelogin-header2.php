<?php define(SITEURL,"https://www.needyin.com");
?>
<!--
<header class="pheader bslider">
    <div class="container nopadmob ">
      <nav class="navbar navbar-default navbar-static">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbarpre"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="<?php echo SITEURL;?>"><img src="img/logo.png"></a>
            </div>
            <div id="navbarpre" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                 
                    <li> <a href="job-seeker-login.php"> Job Seekers  </a> </li>
                    <li> <a href="recruiter.php">Employer Zone  </a> </li>
                    
                </ul>
            </div>
           
        </nav>
		 
  </div>
	
</header>-->



<nav class="navbar1 navbar1-default navbar1-fixed-top" style="background:#fff !important;color:#000 !important;">
      <div class="container">
        <div class="navbar1-header">
         <button type="button" class="navbar1-toggle collapsed" data-toggle="collapse" data-target="#navbar1-collapse" aria-expanded="false" aria-controls="navbar1"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

          </button>
		  
          <a class="navbar1-brand" href="index.php" title=""><img src="img/logo.png"/ width="200px"></a>
          
		  
		  
		  </div>
		  <a class="nav navbar1-brand navbar-right" href="index1.php" title="" ><img id="home_logo_id" src="img/home_logo.png"/ width="20px" style="position: relative;top: -66px;" ></a>
        </div>

        <div id="navbar1-collapse" class="navbar1-collapse collapse">
          <ul class="nav navbar1-nav navbar1-right">
            <li class="active"><a href="#welcome">Home</a></li>          
            <li><a href="#events">About us</a></li>		
			<li><a href="#howitworks">How It Works</a></li>
            <li><a  href="#contact">Contact Us</a></li>	
            
		
		  <li><a href="job-seeker-login.php">JobSeeker</a></li>
            <li><a href="recruiter.php" >Employer Zone</a></li>	
		  </ul>
        </div>
      </div>
    </nav>
<style>
@media screen and (max-width: 520px){
	#home_logo_id {
		position: relative;
		left: 270px;
		top: -66px;
	}
}
</style>


<?php if($_GET['msg']=='dnd')
{ ?>
<div class="visible-div">
    <p>Your account is deactivated</p>
</div>


<?php } 
?>