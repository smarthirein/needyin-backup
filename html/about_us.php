<?php require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>

</head>
<body>
<?php 
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
    include "prelogin-header2.php"; 
  } 
?>
       
<main>
	
	<section class="page-title-block">
		<div class="container">
			<article class="page-titlein">
				<h2 class="h2 flight txt-white">About <span class="fbold">Needyin</span></h2>
				<p>Happiness is to lead both professional and personal life in your own city</p>
			</article>
		</div>
	</section>

	<section class="page-content">
		<div class="container">
			
			
				
				<div class="row">
					<div class="col-md-6">
						
						<div class="resp-tabs-container ver_1 tab-content">
							
							<div>
								<p class="text-justify pb15">"A Friend In Need is a Friend In Deed” goes the adage and this drives the whole Business Philosophy of NeedyIn.</p>
								<h3 class="flight h3">Company <span class="fbold">Information</span></h3>
								
								<p class="pb15 pt15 text-justify">We strive to be an enabler for professionals seeking to be closer home & family due to circumstances which are beyond reasonable control and warrant a paradigm & often a life changing decision.  Needyin strives to bring together Professionals and Opportunities which enable them to balance their priorities for handling critical phases in one’s professional & Personal lives.</p>
								<p class="pb15 text-justify">NeedyIn is backed by a strong and meticulous Network of Employers’ database. Our Team possesses 100+ years of Leadership experience in HR & Talent Domains. 
								Our Team knows exactly what it takes to identify, engage and acquire the right talent . This Capability will assist the Professional in dire need of help and guide them in their quest to balance their lives. </p>
								
							</div>					
							
						</div>
					</div>
					<div class="col-md-6">
					
						 <?php include "our-team.php"; ?>
						
						
					</div>
			
			</div>
		</div>
	</section>

</main>
       
       
            <script>
                $(document).ready(function () {
                    $('#ChildVerticalTab_11').easyResponsiveTabs({
                        type: 'vertical'
                        , width: 'auto'
                        , fit: true
                        , tabidentify: 'ver_1', 
                        activetab_bg: '#0274bb', 
                        inactive_bg: '#fff', 
                    });
                });
            </script>
</body>

</html>