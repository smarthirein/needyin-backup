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
	include_once("analyticstracking.php");
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
?>
        <!-- main-->
<main>
	<!-- page title -->
	<section class="page-title-block">
		<div class="container">
			<article class="page-titlein">
				<h2 class="h2 flight txt-white">About <span class="fbold">Needyin</span></h2>
				<p>Happiness is to lead both professional and personal life in your own city</p>
			</article>
		</div>
	</section>
	<!--/ page title -->
	<!-- page static content body -->
	<section class="page-content">
		<div class="container">
			<!-- main content starts-->
			<div id="ChildVerticalTab_11">
				<!-- row -->
				<div class="row">
					<div class="col-md-3">
						<ul class="resp-tabs-list ver_1">
							<li>About Us</li>
							<!--<li>What we do</li> -->
						   <!-- <li>Who we are</li>
							<li>Our Journey so far</li>
							<li>Team</li>-->
						</ul>
						<br><br><br>
						<img src="img/aboutni_2.jpg"  class="img-responsive" style="height:200px;width:400px">
					</div>
					<div class="col-md-9">
						<div class="resp-tabs-container ver_1 tab-content">
							<!-- About us-->
							<div>
								<p class="text-justify pb15">"A Friend In Need is a Friend In Deed” goes the adage and this drives the whole Business Philosophy of NeedyIn.</p>
								<h3 class="flight h3">Company <span class="fbold">Information</span></h3>
								<!--
								<ul class="content-list">
									<li>LinkedIn's founders are Reid Hoffman, Allen Blue, Konstantin Guericke, Eric Ly and Jean-Luc Vaillant. LinkedIn started out in the living room of co-founder Reid Hoffman in 2002.</li>
									<li>The site officially launched on May 5, 2003. At the end of the first month in operation, LinkedIn had a total of 4,500 members in the network.</li>
									<li>The company has a diversified business model with revenues coming from talent solutions, marketing solutions and premium subscription products.</li>
									<li>LinkedIn's global headquarters are in Mountain View, California, with EMEA headquarters in Dublin and APAC headquarters in Singapore. LinkedIn U.S. offices are in Chicago, Los Angeles, New York, Omaha, San Francisco, Sunnyvale and Washington D.C. International LinkedIn offices are located in Amsterdam, Bangalore, Beijing, Dubai, Dublin, Graz, Hong Kong, London, Madrid, Melbourne, Milan, Mumbai, Munich, New Delhi, Paris, Perth, São Paulo, Shanghai, Singapore, Stockholm, Sydney, Tokyo and Toronto.</li>
									<li>LinkedIn is currently available in 24 languages: Arabic, English, Simplified Chinese, Traditional Chinese, Czech, Danish, Dutch, French, German, Indonesian, Italian, Japanese, Korean, Malay, Norwegian, Polish, Portuguese, Romanian, Russian, Spanish, Swedish, Tagalog, Thai and Turkish.</li>
									<li>LinkedIn has more than 10,000 full-time employees with offices in 30 cities around the world. LinkedIn started off 2012 with about 2,100 full-time employees worldwide, up from around 1,000 at the beginning of 2011 and about 500 at the beginning of 2010.</li>
								</ul>
								-->
								<p class="pb15 pt15 text-justify">We strive to be an enabler for professionals seeking to be closer home & family due to circumstances which are beyond reasonable control and warrant a paradigm & often a life changing decision.  Needyin strives to bring together Professionals and Opportunities which enable them to balance their priorities for handling critical phases in one’s professional & Personal lives.</p>
								<p class="pb15 text-justify"><!--A product of Careator Technologies Private Limited (<a href="http://www.careator.com/" target="_blank">www.careator.com</a>), -->NeedyIn is backed by a strong and meticulous Network of Employers’ database. Our Team possesses 100+ years of Leadership experience in HR & Talent Domains. 
								Our Team knows exactly what it takes to identify, engage and acquire the right talent . This Capability will assist the Professional in dire need of help and guide them in their quest to balance their lives. </p>
								<!--<p class="text-justify">Needyin connects Demand from Best Employers with the Supply of Professionals thru a carefully drawn up curation process and personal attention to the sensitivities of each Professional, thus creating a Winning Formula for every constituent Stakeholder involved. We enable Employers to identify World Class Talent with great skills to come on to their board and build success.</p>-->
							</div>
							<!-- //about us-->
							<!-- What we do-->
							<div>
								<div>
									<!--<p class="text-justify pb15">The concept of Needyin was inspired in 2011. However, it was not until a product convention in 2014 which provided the founders with the impetus to launch Hiree. Since its launch in Jan 2014, Hiree is growing at a very fast pace and helping jobseekers find better job offers. Hiree is also used by many recruiters from Fortune500 companies to meet their hiring needs.</p>-->
									<div class="row">
										<div class="col-md-3 col-sm-3">
											<figure><img src="img/about01.png" class="img-responsive"></figure>
										</div>
										<div class="col-md-9 col-sm-9">
											<h3 class="flight h3">Expedite the <span class="fbold">hiring process</span></h3>
											<p class="pb15">Every idea starts with a problem. Ours was simple - hiring process is too slow to meet our current needs. Hence, Needyin was born to expedite hiring process.</p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-9 col-sm-9">
											<h3 class="flight h3 text-right">Help jobseekers find <span class="fbold">better offers, superfast</span></h3>
											<p class="pb15 text-right">Along with many other peaks, Hiree proudly wears the tag of "Fastest from Seed-to-Series in the recruitment space,with its Series-A funding in Jan 2015."</p>
										</div>
										<div class="col-md-3 col-sm-3">
											<figure><img src="img/about02.png" class="img-responsive"></figure>
										</div>
									</div>
									<p class="pb15 pt15 text-justify">The concept of Needyin was inspired in 2011. However, it was not until a product convention in 2014 which provided the founders with the impetus to launch Hiree. Since its launch in Jan 2014, Hiree is growing at a very fast pace and helping jobseekers find better job offers. Hiree is also used by many recruiters from Fortune500 companies to meet their hiring needs.</p>
									<p class="pb15 text-justify">Launched in 2016, Needyin.com, is the largest and the most innovating job portal online. Within a short period, Sixapril.com has crossed 20,000 candidates, 1700+ recruiters. It has changed the view of hiring candidates by integrating social and personal networks of candidates for enhancing the easy way to recruit. Even, the recruiters at Sixapril.com are at an option to reach out to a particular candidate, which make the whole way a lot easier than other sites.</p>
								</div>
							</div>
							<!--// What we do-->
							<!-- Who we are-->
							<div>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
							</div>
							<!--// who we are-->
							<!-- Our Journey so far-->
							<div>
								<ul class="timeline">
									<li>
										<div class="timeline-badge info"><i class="fa fa-cogs" aria-hidden="true"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading"> </div>
											<div class="timeline-body">
												<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
											</div>
										</div>
									</li>
									<li>
										<div class="timeline-badge danger"><i class="fa fa-cogs" aria-hidden="true"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading">
												<h4 class="timeline-title">Mussum ipsum cacilds</h4> </div>
											<div class="timeline-body">
												<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
											</div>
										</div>
									</li>
									<li>
										<div class="timeline-badge info"><i class="fa fa-cogs" aria-hidden="true"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading">
												<h4 class="timeline-title">Mussum ipsum cacilds</h4> </div>
											<div class="timeline-body">
												<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<!-- // Our Journey So far -->
							<!-- Team -->
							<div>
								<p>Tillage and soil preparation, plant protection, post-harvest management and more according to emerging and local conditions and demands. </p>
								<h3 class="flight h3">Management <span class="fbold">  Team</span></h3>
								<!-- team pictures -->
								<div class="row teampic">
									<div class="col-md-4 col-sm-4">
										<figure> <img src="img/profile-pic.jpg" class="img-cover" data-object-fit="cover"> </figure>
										<article class="text-center team-desc">
											<h4 class="h4">Aditya Dammuluri</h4>
											<p class="txt-blue">Founder & CEO</p>
										</article>
									</div>
									<div class="col-md-4 col-sm-4">
										<figure> <img src="img/profile-pic1.jpg" class="img-cover" data-object-fit="cover"> </figure>
										<article class="text-center team-desc">
											<h4 class="h4">Ramesh Garikamokkala</h4>
											<p class="txt-blue">Director</p>
										</article>
									</div>
									<div class="col-md-4 col-sm-4">
										<figure> <img src="img/nav-login-recruiter-img.jpg" class="img-cover" data-object-fit="cover"> </figure>
										<article class="text-center team-desc">
											<h4 class="h4">Sudhakar KR</h4>
											<p class="txt-blue">Director</p>
										</article>
									</div>
								</div>
								<!--/ team pictures -->
							</div>
							<!--// Team-->
						</div>
					</div>
				</div>
				<!-- / row-->
				<!-- main content ends-->
			</div>
		</div>
	</section>
	<!--/ page static content body -->
</main>
        <!--/main-->
        <?php// include"footer.php"?>
            <script>
                $(document).ready(function () {
                    $('#ChildVerticalTab_11').easyResponsiveTabs({
                        type: 'vertical'
                        , width: 'auto'
                        , fit: true
                        , tabidentify: 'ver_1', // The tab groups identifier
                        activetab_bg: '#0274bb', // background color for active tabs in this group
                        inactive_bg: '#fff', // background color for inactive tabs in this group
                    });
                });
            </script>
</body>

</html>