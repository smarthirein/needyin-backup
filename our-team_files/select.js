var popUpMap,
	elem;

function showMapInPopup(){
	jQuery('#locationMapContainer').dialog({
					autoOpen: false,
					modal: true,
					title: elem.data('title'),
					width: 450,
					height: 530,
					buttons: {
						 Close: function() {
							 	jQuery( this ).dialog( "close" );
						 }
					},
					open: function(){
						var infowindow = new google.maps.InfoWindow({
								content : "<div clas='google-marker-info'><a href='"+elem.attr('href')+"'>"+elem.data('title')+"</a><div>" + elem.data('descr') + "</div></div>"
						});
						var mapOptions = {
					        	zoom: 15,
					          	center: new google.maps.LatLng(elem.data('latitude'), elem.data('longitude')),
					          	mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						
						popUpMap = new google.maps.Map(document.getElementById('popup-map'), mapOptions);
						
						var marker = new google.maps.Marker({
				                position: new google.maps.LatLng(elem.data('latitude'), elem.data('longitude')),
				                map: popUpMap,
				                title: elem.data('title')
						});
						infowindow.open(popUpMap, marker);
						google.maps.event.addListener(marker, 'click', function() {
								infowindow.open(popUpMap, this);
						});
					}
		})
		.dialog('open');
}

jq(document).ready(function() {
	jq("html, span.multiselect div.optList div.bButtons a.ok").click(function(){
		jq("ul.optList, div.optList").hide().parents("span.fl").css({zIndex: 1 });
	});

	jq("span.multiselect div.optList li[class^=optinLevel]").click(function(e) {
		return false;
	});

	/*
	 * show job map information
	 */
	jQuery('.job_location').click(function(){
			var dialogContainer = jQuery('#locationMapContainer');
			elem = jQuery(this);
			if(dialogContainer.length == 0){
				jQuery('body').append('<div id="locationMapContainer"><div id="popup-map" class="popup-map"></div></div>');
				
				dialogContainer = jQuery('#locationMapContainer');
				
				var script = document.createElement("script");
		        script.type = "text/javascript";
		        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en&callback=showMapInPopup';
		        document.getElementsByTagName('head')[0].appendChild(script);
			}else{
				showMapInPopup();
			}
			
			return false;
	});
	
	/*
	 * show help information about keyword search criteria
	 */
	jQuery('.shadowed-keyword .keyword_tooltip').click(function(){
				var showDialog = jQuery('.tooltip-dialog');
				if(jQuery(this).data('status') == 'hide'){
					jQuery(this).data('status', 'show');
					var elemPosition = jQuery(this).offset(),
						left = elemPosition.left+10,
						windowWidth = jQuery(window).width();

					if(showDialog.length==0){
						jQuery('body').append("<div class='tooltip-dialog rounded'></div>");
						showDialog = jQuery('.tooltip-dialog');
					}
					showDialog.html(jQuery(this).next().html());
					if(left+showDialog.outerWidth(true) > windowWidth && windowWidth > 900){
						left = windowWidth - showDialog.width()-50;
					}
					
					if(left < 0)
						left = 0;
					showDialog.css({
								"top": 		elemPosition.top-30,
								"left":		left,
								"display": 	"block",
								"position": "absolute"
					});

					jQuery('body').unbind('click')
								.click(function(event){
												var clientX = event.clientX,
													clientY = event.clientY,
													width = showDialog.width(),
													height = showDialog.height(),
													dialogPosition = showDialog.offset();
												elemTop = dialogPosition.top-jQuery(window).scrollTop(),
												elemLeft = dialogPosition.left-jQuery(window).scrollLeft();
												if(elemLeft < clientX && (elemLeft+width) > clientX && elemTop < clientY && (elemTop+height) > clientY){
												}else{
													showDialog.hide();
												}
					});
				}else{
					jQuery(this).data('status', 'hide');
					showDialog.hide();
				}
				return false;
	});
	
	/*
	 * initialize maskedinput
	 */
	jq("input.only-digit").each(function(){
			var allowedFormat = "9";
			if(jQuery(this).attr('maxlength') > 1)
				allowedFormat += "?";
			for(var i=1; i<jQuery(this).attr('maxlength'); i++)
				allowedFormat += "9";
			jQuery(this).mask(allowedFormat);	
	});
	jq("span.select input").each(function(){
			var selectedNode;
			if (this.value && this.value != -1) {
				selectedNode = jq(this).parents("span.select").find("li[value='" + this.value + "']");
			} else {
				selectedNode = jq(jq(this).parents("span.select").find("li:first"));
			}
			selectedNode.addClass("selected");
			jq(jq(this).parents("span.select").find("a.selectBtn span:first")).text(selectedNode.children().text());
	});

	jq("span.multiselect select").each(function(){
			var parent = jq(this).parents("span.multiselect"),
				options = jq(this).children(),
				lists = parent.find("li"),
				texts = [];
			for (i=0, j=0; i<options.length; i++) {

				if (options.eq(i).is(":selected")) {
					texts[j] = lists.eq(i).addClass("selected").children().text();
					j++;
				}
			}
			var txt = (texts.join(", ")) ? texts.join(", ") : parent.find("h6").text();
			parent.find("a.selectBtn").find("span").attr("title", txt).text(txt);
	});

	jq("span.select a.selectBtn").click(function(){
		var parent = jq(this).parents("span.fl");
		if ( parent.find("ul.optList").is(":hidden") ) {
			jq("ul.optList:visible, div.optList:visible").hide().parents("span.fl").css({zIndex: 1});
			parent.css({zIndex: 9999}).find("ul.optList").show();
		} else {
			parent.css({zIndex: 1}).find("ul.optList").hide();
		}
		return false;
	});

	jq("span.select ul.optList li").click(function(){
		var parent = jq(this).parents("span.fl");
		var selText = jq(this).find("a").text();
		jq(this).siblings().removeClass("selected");
		jq(this).addClass("selected");
		parent.find("a.selectBtn").find("span").text(selText);
		parent.find("ul.optList").hide().end().css({zIndex: 1});
		if (jq(this).attr("value") in [0, 1])
			parent.find("input").removeAttr("value");
		else
			parent.find("input").get(0).value = jq(this).attr("value");
		return false;
	});

	jq("span.multiselect a.selectBtn").click(function(){
		var parent = jq(this).parents("span.fl");
		if ( parent.find("div.optList").is(":hidden") ) {
			jq("ul.optList:visible, div.optList:visible").hide().parents("span.fl").css({zIndex: 1});
			parent.css({zIndex: 9999}).find("div.optList").show();
		} else {
			parent.css({zIndex: 1}).find("div.optList").hide();
		}
		return false;
	});

	jq("span.select a.selectBtn, span.multiselect a.selectBtn").each( function(){
		var parent = jq(this).parents("span.select") || jq(this).parents("span.multiselect");
		var selected = parent.find("li.selected");
		var texts = [];

		if (selected.length > 0) {
			for (var i = 0; i < selected.length; i++) {
				texts[i] = selected.eq(i).find("a").text();
			}
			jq(this).find("span").text(texts.join(", "));
		} else {

		};
	});	
	
    jq("input[type=text]").each(fieldLabelRemove);
    jq("textarea").each(fieldLabelRemove);

    jq("form").submit(function(){
		jq(this).find("input[type=text]").each(function(){
            var label = jq(this).parents(".fl").find("label");

            if (label.text() == this.value) {
				this.value = '';
			}
		});
        jq(this).find("textarea").each(function(){
            var label = jq(this).parents(".fl").find("label");

            if (label.text() == this.value) {
				this.value = '';
			}
		});
	});

	jq("input[type=password]").each(function() {
		//var confirmTxt = jq(this).parents("span.fl").prev().find("input").is("[type=password]") ? "Confirm " : "";
		//var insTag = "<input type='text' value='"+confirmTxt+"Password*' />";
		var insTag = "<input type='text' value='"+jq(this).parents("span.fl").find("label").text()+"' />";//confirmTxt+"Password*' />";
		var fakeInp;

		function removeFakeInp() {
			var Inp = jq(this).prev();
			jq(this).remove();
			Inp.show().focus();
		}

		var _this = this;
		var showFakeInp =  function () {
			if (jq(_this).val() == "") {
				var tabI = jq(_this).attr("tabindex");
				jq(_this).hide().after(insTag);
				fakeInp = jq(_this).next("input");
				fakeInp.bind("focus", removeFakeInp);
				fakeInp.attr("tabindex",tabI);
			}
		};

		jq(this).bind("blur",showFakeInp);

		showFakeInp();

	});


});

function fieldLabelRemove(){
	var label = jq(this).parents(".fl").find("label").text();
    if (!this.value && !jQuery(this).hasClass('append-disabled')) {
        this.value = label;
    }
    
    jq(this).bind("blur", function(){
    	var el = jq(this);
    	if (!el.val()  && !jQuery(this).hasClass('append-disabled'))
    		el.val(label);
	});
    
    jq(this).bind("focus", function(){
    	var el = jq(this);
    	if (el.val() === label  && !jQuery(this).hasClass('append-disabled'))
    		el.val("");
	});
}

function confirmDialog(message, url) {
    if (confirm(message)) {
        location.href = url;
    }
}

Date.prototype.format=function(format){var returnStr='';var replace=Date.replaceChars;for(var i=0;i<format.length;i++){var curChar=format.charAt(i);if(replace[curChar]){returnStr+=replace[curChar].call(this);}else{returnStr+=curChar;}}return returnStr;};Date.replaceChars={shortMonths:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],longMonths:['January','February','March','April','May','June','July','August','September','October','November','December'],shortDays:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],longDays:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],d:function(){return(this.getDate()<10?'0':'')+this.getDate();},D:function(){return Date.replaceChars.shortDays[this.getDay()];},j:function(){return this.getDate();},l:function(){return Date.replaceChars.longDays[this.getDay()];},N:function(){return this.getDay()+1;},S:function(){return(this.getDate()%10==1&&this.getDate()!=11?'st':(this.getDate()%10==2&&this.getDate()!=12?'nd':(this.getDate()%10==3&&this.getDate()!=13?'rd':'th')));},w:function(){return this.getDay();},z:function(){return"Not Yet Supported";},W:function(){return"Not Yet Supported";},F:function(){return Date.replaceChars.longMonths[this.getMonth()];},m:function(){return(this.getMonth()<9?'0':'')+(this.getMonth()+1);},M:function(){return Date.replaceChars.shortMonths[this.getMonth()];},n:function(){return this.getMonth()+1;},t:function(){return"Not Yet Supported";},L:function(){return"Not Yet Supported";},o:function(){return"Not Supported";},Y:function(){return this.getFullYear();},y:function(){return(''+this.getFullYear()).substr(2);},a:function(){return this.getHours()<12?'am':'pm';},A:function(){return this.getHours()<12?'AM':'PM';},B:function(){return"Not Yet Supported";},g:function(){return this.getHours()%12||12;},G:function(){return this.getHours();},h:function(){return((this.getHours()%12||12)<10?'0':'')+(this.getHours()%12||12);},H:function(){return(this.getHours()<10?'0':'')+this.getHours();},i:function(){return(this.getMinutes()<10?'0':'')+this.getMinutes();},s:function(){return(this.getSeconds()<10?'0':'')+this.getSeconds();},e:function(){return"Not Yet Supported";},I:function(){return"Not Supported";},O:function(){return(-this.getTimezoneOffset()<0?'-':'+')+(Math.abs(this.getTimezoneOffset()/60)<10?'0':'')+(Math.abs(this.getTimezoneOffset()/60))+'00';},T:function(){var m=this.getMonth();this.setMonth(0);var result=this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/,'$1');this.setMonth(m);return result;},Z:function(){return-this.getTimezoneOffset()*60;},c:function(){return"Not Yet Supported";},r:function(){return this.toString();},U:function(){return this.getTime()/1000;}};

function onMultiSelectValueClick(e, elem) {
    var parent = jq(elem).parents("span.fl");
    var texts = [];

    if (e.ctrlKey  || e.metaKey) {
        if ( jq(elem).hasClass("selected") ) {
            jq(elem).removeClass("selected");
            parent.find('select option[value="'+ jq(elem).attr('value') + '"]').prop("selected", false);
        } else {
            jq(elem).addClass("selected");
            parent.find('select option[value="'+ jq(elem).attr('value') + '"]').prop('selected', true);
        }
    } else {
        jq(elem).siblings().removeClass("selected");
        jq(elem).addClass("selected");
        parent.find('select option').each(function(){
        	jq(this).prop('selected', false);
        });
        parent.find('select option[value="'+ jq(elem).attr('value') + '"]').prop('selected', true);
        parent.find("div.optList").hide().end().css({zIndex: 1});
    }

    var j = 0;
    parent.find('.optList li').each(function(){
    	if (jq(this).hasClass("selected")) {
    		texts[j]=jq(this).find("a").text();
    		j++;
    	}
    });

    var txt = (texts.join(", ")) ? texts.join(", ") : parent.find("h6").text();
    parent.find("a.selectBtn").find("span").attr("title", txt).text(txt);
    return false;
}

function objectDetail(o) {
    var s = '';
    for(prop in o) {
        s += prop + '-' + o[prop]+'\n';
    }
    return s;
}

function addOptions(elChildCriterion, data, idEl, nameEl, multiselect, layout)
{
    var li;
    var opt;
    var el;
    if ('adm'!=layout) {
    	el = document.getElementById(elChildCriterion+('adm'!=layout?'_ul':''));
    	jq(el).children("li").remove();
    }
    var select = jq("select#"+elChildCriterion);
    jq('select#'+elChildCriterion).children().remove();
    var liText='';
    for(var i=0;i<data.length;i++)
    {
        if ('adm'!=layout) {
        	if (isIE() && getInternetExplorerVersion()<8.0) {
        		liText += "<li class='optinLevel1' value='";
        		if (data[i][idEl]>-1)
        			liText += data[i][idEl];
        		liText += "'>" + '<a href="javascript:void(0)">'+data[i][nameEl]+'</a>';
        		liText += "</li>";
        	}
        	else {
	            li = document.createElement("li");
	            li.className = 'optinLevel1';
	            if (data[i][idEl]==-1) {
	            	li.value = '';
	            }
	            else { 
	            	li.value = data[i][idEl];
	            }
	            li.innerHTML = '<a href="javascript:void(0)">'+data[i][nameEl]+'</a>';
	            el.appendChild(li);
        	}
        	if (isIE() && getInternetExplorerVersion()<8.0)
        		el.innerHTML = liText;
        }
        if (select.length>0) {
	        if (data[i][idEl]==-1)
	        	opt = new Option(data[i][nameEl], '');
	        else {
	        	opt = new Option(data[i][nameEl], data[i][idEl]);
	        }
        	if (isIE()) opt.innerText = data[i][nameEl];
	        select.append(opt);
        }
    }
    if ('adm'!=layout)   
        jq(el).children("li").click(function(e){
        	return onMultiSelectValueClick(e, this);
        });
}


function resetForm(formElem) {
    formElem = jq(formElem);
    formElem.find("span.multiselect div.optList li.selected").each(function(){
        jq(this).removeClass("selected");
    });
    formElem.find("span.multiselect option").each(function() {
    	jq(this).removeAttr("selected");
    });
    formElem.find("span.multiselect").each( function() {
        var txt = jq(this).parent().find("label").text();
        jq(this).find("a.selectBtn").find("span").attr("title", txt).text(txt);
    });
    formElem.find("span.select option").each(function() {
    	jq(this).removeAttr("selected");
    });
    formElem.find("span.select").each( function() {
        var txt = jq(this).parent().find("label").text();
        jq(this).find("a.selectBtn").find("span").attr("title", txt).text(txt);
    });
    formElem.find("input[type='text']").each(function(){
        this.value = "";
        this.onblur();
    });
}

function showHideKeywordTooltip(id){
	jQuery('#'+id).parents('.fline').next('.help').toggle();
}