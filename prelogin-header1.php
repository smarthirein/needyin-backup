<?php define(SITEURL,"https://www.needyin.com");?>
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

<?php if($_GET['msg']=='dnd')
{ ?>
<div class="visible-div">
    <p>Your account is deactivated</p>
</div>
<?php } 
?>