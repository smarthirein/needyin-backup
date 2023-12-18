<footer id="footer-top">
		<script type="text/javascript" src="js/objectFitPolyfill.min.js"></script>
 


	
<?php
$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once 'source1.php';
$actual_link = "$_SERVER[REQUEST_URI]";
?>
	
   <section class="footer-in">
		
        <div class="container">
			
          
            <article class="footer-rights text-center">

			                    <div class="row">
                       
                      <div class="col-md-3"> <p class="flight txt-white " style="float:left">Copyright 2017 Needyin. All Rights Reserved</p>
					  </div>
					   <div class="col-md-6"><p class="flight txt-white " style="float:center"><span class="txt-white">|</span><a href="about_us.php"><span class="txt-white"> About Us  </span></a>|<a href="faq.php"><span class="txt-white">  FAQ<font size="1">s</font>  </a></span>|<a href="terms-conditions.php"><span class="txt-white">  Terms & Conditions </a></span>|<a href="privacy.php"><span class="txt-white">  Privacy Policy  </a></span>
					   |<a href="contact.php"><span class="txt-white">  Contact Us  </span></a><span class="txt-white">|</span><br>
						   <div style="font-size:10px;" class="flight txt-white " >Best viewed in Chrome and MS Edge <span class="hover_img">
     					  <a href="#" style="color:black;">.<span><img src="http://hitwebcounter.com/counter/counter.php?page=6712176&style=0038&nbdigits=5&type=ip&initCount=0"   border="0" width="65" style="float:right;" ></span></a>
		            	</span></div>
						
						   </p>
					   </div>
					   <div class="col-md-3">
					   <p class="footer-social flight txt-white" style="float:right">
                                   <span class="txt-white">info@needyin.com</span>
                                    <a href="https://www.facebook.com/needyin/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="https://www.linkedin.com/in/needyin-technologies-534a4b147/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                    <a href="https://twitter.com/Needyin" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </p>
					  </div>
					  </div>
               
				
            </article>
		

			
        </div>
		
    </section>  <!--<section class="probootstrap-copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <p class="copyright-text">&copy; 2017 <a href="https://needyin.com/">NeedyIn</a>. All Rights Reserved.</p>
          </div>
          <div class="col-md-4">
            <ul class="probootstrap-footer-social right">
			<li><a href="#">info@needyin.com</a></li>
              <li><a href="https://twitter.com/Needyin"><i class="icon-twitter"></i></a></li>
              <li><a href="https://www.facebook.com/needyin/"><i class="icon-facebook"></i></a></li>
              <li><a href="https://www.linkedin.com/company/needyintechnologies"><i class="icon-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </section> -->
	<script lang="javascript">
	function validateemail()
	{
	var email=document.getElementById('subcribe-email').value;
            	if(email=="")
            	{
            		alert("Please Enter  email");
            		document.getElementById('subcribe-email').focus();
            		return false;
            	}
				
				if(!emailverify(email))
				{
					
					document.getElementById('subcribe-email').focus();
            		return false;
					
					
				}
	}
	</script>
	
<script>
$.getJSON('//freegeoip.net/json/?callback=?', function(data) {
  
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "ipaddress.php?ip="+data.ip+"&city="+data.city+"&country="+data.country_name+"&latitude="+data.latitude+"&longitude="+data.longitude, true);
        xmlhttp.send();
});

</script>
</footer>



