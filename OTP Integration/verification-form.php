<div class="error"></div>
<div class="success"></div>
<form id="frm-mobile-verification">
	<div class="form-row">
		<label>OTP is sent to Your Mobile Number</label>		
	</div>
<link href="style.css" type="text/css" rel="stylesheet" />
	<div class="form-row">
		<input type="text"  id="mobileOtp" class="form-input" placeholder="Enter the OTP">		
	</div>

	<div class="row">
		<input id="verify" type="button" class="btnVerify" value="Verify" onClick="verifyOTP();">	
		  
				
	</div>
</form>
<div><h4>Time left :<h4> <span id="timer"></span></div>

<script>let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  alert('Timeout for otp');

 window.location = 'index(otp).php';
}

timer(60);</script>	
<a href="">Resend</a>