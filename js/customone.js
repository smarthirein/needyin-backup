$(window).scroll(function () {
    if( $(window).scrollTop() > $('.pheader').offset().top && !($('.pheader').hasClass('posi'))){
    $('.pheader').addClass('posi');
	 } else if ($(window).scrollTop() == 0){
    $('.pheader').removeClass('posi');
    }
});
function txtarea(id,len)
{

pal=val.value.length
	if(pal<min || pal>max)
	{
		alert("Number of characters in "+name+" can be at least  "+min+"  and at most "+max+" You have entered "+pal);
		return false;
	}
	else
		return true;
		
	
}
function passwordverify(pwd)
{
	
	var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{6,})");
				//var pwd=document.getElementById('txtPwd').value;
            	if(!strongRegex.test(pwd))
            	{

            		alert("Password must contain a Upper case character, a lower case character , one number and a special character (!@#$%^&*) with minumum length of 8 characters");
            		//document.getElementById('txtPwd').focus();
            		return false;
            	}
				else 
					return true;
	
	

	
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
	else 
	{return true;}	
	
	
	
	
}
/*function experience(min,max)
{	if(min=='0'&&max=='0')
	{
		
		
		alert("Please give your experience");
		return false;
		
	}
	else if(min>max)
	{
		alert("Minimum Experience can't be more than Maximum experience");
		return false;
		
	}
	else 
		return true;
	
	
}
 */