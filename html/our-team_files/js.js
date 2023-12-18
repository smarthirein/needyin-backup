function createCookieConfirmed(name,value,days) {
	if (readCookie("CookieEnabled") != 'false') createCookie(name,value,days);
}
function moveViaBackURL() {
	var backUrl = readCookie("backURL");
	window.location = (backUrl==null) ? "/cm/jobs" : backUrl;
}
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function setCookies(){
	if(location.href.indexOf("candidate/job_search/quick/results")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", "/candidate/job_search/quick/results", 1);
	} else if(location.href.indexOf("cm/job_search")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	}else if(location.href.indexOf("candidate/job_search/advanced/results")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	}else if(location.href.indexOf("cm/specialism/")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	}else if(location.href.indexOf("candidate/search/quick/results")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	} else if(location.href.indexOf("clients/candidate_profile_search")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	} else if(window.location.pathname.length == 1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	}else if(location.href.indexOf("cm/home")!=-1){
		eraseCookie("backURL");
		createCookie("backURL", location.href, 1);
	}
}

function holderHeight() {
	tmp = (document.getElementById("holder").offsetHeight - 55) + "px";
	
	b = document.getElementById("bottom");
	b.style.top = tmp;
}

function vis() {
	if(document.getElementById('cont_pos')) {
		document.getElementById('cont_pos').style.visibility = 'visible';
	}
}

function multilevel(data) {
    for (var i = 0; i < data.length; i++) {
        var spaces = '';
        var level = 0;

        if (data[i].shift > 0) {
            level = data[i].shift;
        } else if (data[i].level > 0) {
            level = data[i].level;
        }
        if (level > 1) {
            for (var j = 1; j < level; j++) {
                spaces += '   ';
            }
        }
        data[i].name = spaces + data[i].name;
    }
}

function searchfunc(){
	document.getElementById('div-login').style.display = "none";
	document.getElementById('div-search').style.display = "block";	
	document.getElementById('div-browse').style.display = "none";
	document.getElementById('srch').style.background = "url(/_img/bg-tabs-srch-act.gif) top right no-repeat";
	document.getElementById('lgn').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	if (document.getElementById('brws')){
	document.getElementById('brws').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	document.getElementById('brws').style.color = "#88460F";
	}
	document.getElementById('srch').style.color = "#D56E19";
	document.getElementById('lgn').style.color = "#88460F";
    DWRHelper.saveState("search", function foo(data) {});
}
function loginfunc(){
	document.getElementById('div-login').style.display = "block";
	document.getElementById('div-search').style.display = "none";	
	document.getElementById('div-browse').style.display = "none";
	document.getElementById('lgn').style.background = "url(/_img/bg-tabs-act.gif) top right no-repeat";
	if (document.getElementById('srch')){
	document.getElementById('srch').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	document.getElementById('srch').style.color = "#88460F";
	}
	if (document.getElementById('brws')) {
	document.getElementById('brws').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	document.getElementById('brws').style.color = "#88460F";
	}
	document.getElementById('lgn').style.color = "#D56E19";
    DWRHelper.saveState("login", function foo(data) {});
}
function browsefunc(){
	document.getElementById('div-login').style.display = "none";
	document.getElementById('div-search').style.display = "none";	
	document.getElementById('div-browse').style.display = "block";
	document.getElementById('brws').style.background = "url(/_img/bg-tabs-act.gif) top right no-repeat";
	document.getElementById('brws').style.color = "#D56E19";
	if (document.getElementById('srch')){
	document.getElementById('srch').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	document.getElementById('srch').style.color = "#88460F";
	}
	document.getElementById('lgn').style.background = "url(/_img/bg-tabs.jpg) top right no-repeat";
	document.getElementById('lgn').style.color = "#88460F";
    DWRHelper.saveState("browse", function foo(data) {});
}

// LIMIT MULTIPLE SELECTED OPTIONS
var selectedOptions = [];
function checkCountSelected(select, maxNumber) {
   
    for (var i = 0; i < select.options.length; i++) {

        if (select.options[i].selected && select.options[i].value == '-1') {
            for (var j = 0; j < select.options.length; j++) {
                if (j != i) {
                    select.options[j].selected = false;    
                }
            }
        }

        if (select.options[i].selected && !new RegExp(i, 'g').test(selectedOptions.toString())) {
            selectedOptions.push(i);
        }

        if (!select.options[i].selected && new RegExp(i, 'g').test(selectedOptions.toString())) {
            selectedOptions = selectedOptions.sort(function(a, b) {
                return a - b
            });
            for (var j = 0; j < selectedOptions.length; j++) {
                if (selectedOptions[j] == i) {
                    selectedOptions.splice(j, 1);
                }
            }
        }

        if (selectedOptions.length > maxNumber) {
            select.options[i].selected = false;
            selectedOptions.pop();
        }
    }

}

function confirmDialog(message, url) {
    if (confirm(message)) {
        location.href = url;
    }
}

function saveState(state) {
    DWRHelper.saveState(state, function foo(data) {});
}

function fixSelect(id){
	var classPrefix = "optinLevel";
	var prefix = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if (isIE()){
		if (document.getElementById(id)){
			var elem = document.getElementById(id);
			if (elem.options && elem.options.length>0){
				var options = elem.options;
				for (var i=0;i<options.length;i++){
					var clName = options[i].className;
					if (clName.indexOf(classPrefix)!=-1){
						var level = clName.substring(classPrefix.length);
						if (level>1){
							for (var j=1;j<level;j++){
								options[i].innerHTML=prefix+options[i].innerHTML;
							}
						}
					}
				}
			}
		}
	}
}

function isIE(){
      return /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent);
}

function clearValue(el, defValue) {
	if (el.value==defValue)
		el.value = '';
}
function fillValue(el, defValue) {
	if (el.value=='')
		el.value = defValue;
}
function isSafari() { return navigator.userAgent.indexOf('Safari') > 0; }
function isIE() { return navigator.appName == 'Microsoft Internet Explorer'; }
function isChrome() { return navigator.userAgent.toLowerCase().indexOf('chrome') > -1; }
function getInternetExplorerVersion() {
	//Returns the version of Internet Explorer or a -1
	//(indicating the use of another browser).
	var rv = -1; // Return value assumes failure.
	if (isIE()) {
		var ua = navigator.userAgent;
		var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
	}
	return rv;
}

function setEntityDefValue(el, value) {
	if (el.attr('value')=='')
		el.attr('value', value);
}

