jq("document").ready( function (){
	var v = getInternetExplorerVersion(); 
	if (v>-1) {
		if (v<7.0) {
			jq("#browserMsg").show('fast');
		}				
		if (v<9.0) {
	    	jq('.rounded').each(function() {PIE.attach(this);});
	    	jq('.rounded_circle').each(function() {PIE.attach(this);});
	    	jq('.rounded_left').each(function() {PIE.attach(this);});
	    	jq('.rounded_top').each(function() {PIE.attach(this);});
	    	jq('.bottom_rounded').each(function() {PIE.attach(this);});
			jq('.shadowed').each(function() {PIE.attach(this);});
			jq('.small_rounded').each(function() {PIE.attach(this);});
			jq('.main_shadowed').each(function() {PIE.attach(this);});
			jq('.menu_shadowed').each(function() {PIE.attach(this);});
			jq('.menu_rounded_left').each(function() {PIE.attach(this);});
			jq('.menu_rounded_right').each(function() {PIE.attach(this);});
		}
	}
	jQuery('.captcha_img').each(function(){
		var	captcha = jQuery(this),
		src = captcha.data('src')+'?rnd='+Math.random();

		if(captcha.data('def-width')!=null && captcha.data('def-width')!=0)
			src+= ('&width='+captcha.data('def-width'));
		if(captcha.data('def-height')!=null && captcha.data('def-height')!=0)
			src+= ('&height='+captcha.data('def-height'));
		captcha.attr('src', src);
	});
});