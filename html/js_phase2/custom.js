
  $(window).resize(function(){
    /*sucees-stories*/
    var sucess_right = $('.sucess-right-block').height();
    var sucess_left = $('.sucess-left-block').css("height" , sucess_right);
    var sucess_left_height =  $('.sucess-left-block').height();
    /*//sucees-stories*/
  });
   $( window ).load(function() {
       /*sucees-stories*/
    var sucess_right = $('.sucess-right-block').height();
    var sucess_left = $('.sucess-left-block').css("height" , sucess_right);
    var sucess_left_height =  $('.sucess-left-block').height();
    /*//sucees-stories*/
    });


  $(document).ready(function(){

  /*login-page */
      $(".login-hire-block-image").hide();
      $(".login-block-image").hide();
		$(".forgot-block").hide();
        $(".login-hire-block").hover(function(){
        $(".login-hire-block-image, .login-block-text").hide();
        $(".login-hire-block-text, .login-block-image").show();
		$(".forgot-block").hide();
          $('.login-hire-block').removeClass('bg-img');
        })

        $(".login-pop-container").hover(function(){
          $('.login-hire-block').addClass('bg-img');
        $(".login-hire-block-image, .login-block-text").show();
        $(".login-hire-block-text, .login-block-image ").hide();
		$(".forgot-block").hide();
        })
 /*//login-page */

 /*swiper*/
    var swiper = new Swiper('.swiper-container.custom-vertical-swiper', {
    direction: 'vertical',
    effect: 'fade',
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },
    autoplay: {
    delay: 6000,
    disableOnInteraction: false,
    },
    });



    var swiper = new Swiper('.swiper-container.custom-horizontal-swiper', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
 
  fadeEffect: {
    crossFade: true
  },
    });
 
  /*//swiper*/  

 /*sucees-stories*/
  var sucess_right = $('.sucess-right-block').height();
  var sucess_left = $('.sucess-left-block').css("height" , sucess_right);
  var sucess_left_height =  $('.sucess-left-block').height();
 /*//sucees-stories*/

  // Navigation scrolls
  $(".navbar-nav li a").on('click', function(event) {
  $('.navbar-nav li').removeClass('active');
  $(this).closest('li').addClass('active');
  var $anchor = $(this);
  var nav = $($anchor.attr('href'));
  if (nav.length) {
  $('html, body').stop().animate({
  scrollTop: $($anchor.attr('href')).offset().top
  }, 1500, 'easeInOutExpo');

  event.preventDefault();
  }
  });

 $(".navbar-collapse a").on('click', function() {
  $(".navbar-collapse.collapse").removeClass('in');
  });


  $("a.mouse-hover, .logo-circle a ,.needyin-navbar a.navbar-brand").on('click', function(event) {
  var hash = this.hash;
  if (hash) {
  event.preventDefault();
  $('html, body').animate({
  scrollTop: $(hash).offset().top
  }, 1500, 'easeInOutExpo');
  }
  });


 
  $(window).bind('scroll', function() {
    var navHeight = (2 * $( window ).height()) - 70;
    if ($(window).scrollTop() > navHeight) {
    $('.needyin-navbar').addClass('fixed');
    }
    else {
    $('.needyin-navbar').removeClass('fixed');
    }
  });

/*drag*/
$(".logo-circle").hide();
  setTimeout(function(){ 
   $(".logo-circle").show();
   }, 3000);
  $('.cmp-img img').attr('draggable', false);
  $('#cmp-drag').on('mousedown', function(e){
  var $dragable = $('#cmp-img-top'),
  startWidth = $dragable.width(),
  pX = e.pageX;

  $(document).on('mouseup', function(e){
  $(document).off('mouseup').off('mousemove');
  });

  $(document).on('mousemove', function(me){
  var mx = (me.pageX - pX);          
  $dragable.css({width: startWidth + mx })
  });

  });
/*//drag*/

  });  
function validate() {   
  var email=document.getElementById("email").value;
  if(email=="") {
    alert("Please enter valid e-mail ID ");
    document.getElementById("email").focus();
    return false;
  }
  if(!emailverify(email)) { 
    document.getElementById("email").focus();
    return false;   
    }
  var pwd=document.getElementById("password").value;
  if(pwd=="") {
    alert("Please enter password.");
    document.getElementById("password").focus();
    return false;
    }                        
}

function emailverify(email)
{
  var x = email;
  var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Enter valid e-mail address");
        return false;
    
  }
  else {
    return true;
  }  
}

function forgot() {
    var pw1 = document.getElementById("forgot");
    pw1.style.display = pw1.style.display === "block" ? "none" : "block";
    var sin = document.getElementById("login");
    sin.style.display = sin.style.display === "block" ? "none" : "block";
}

function fvalidate() {		
	var lemail=document.getElementById("femail").value;
	if(lemail=="") {
		alert("Please enter e-mail ID ");
		document.getElementById("femail").focus();
		return false;
	}
	if(!emailverify(lemail)) {	
		document.getElementById("femail").focus();
		return false;		
	}	
	return true;
}
