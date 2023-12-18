/**destory the select picer **/                      
 $('.selectpicker').material_select('destroy');
/**destroy the select picker from **/

$(window).scroll(function () {
    if( $(window).scrollTop() > $('.pheader').offset().top && !($('.pheader').hasClass('posi'))){
    $('.pheader').addClass('posi');
	 } else if ($(window).scrollTop() == 0){
    $('.pheader').removeClass('posi');
    }
});
//onscroll add class to left searchblock in list of jobs
 $(document).ready(function () {
     var s = $(".fixedtopblock");
     var pos = s.position();
     $(window).scroll(function () {
         var windowpos = $(window).scrollTop();
         if (windowpos >= pos.top & windowpos >= 500) {
             s.addClass("fixed-search-top");
         }
         else {
             s.removeClass("fixed-search-top");
         }
     });
 });

//on scroll add class to right search block
$(document).ready(function () {
     var s = $(".rightfix");
     var pos = s.position();
     $(window).scroll(function () {
         var windowpos = $(window).scrollTop();
         if (windowpos >= pos.top & windowpos >= 500) {
             s.addClass("fixed-search-rt");
         }
         else {
             s.removeClass("fixed-search-rt");
         }
     });
 });

//onscroll add class to left searchblock in list of jobs
 $(document).ready(function () {
     var s = $(".fixedtopblock-two");
     var pos = s.position();
     $(window).scroll(function () {
         var windowpos = $(window).scrollTop();
         if (windowpos >= pos.top & windowpos >= 500) {
             s.addClass("fixed-search-top-two");
         }
         else {
             s.removeClass("fixed-search-top-two");
         }
     });
 });







jQuery(document).on('click', '.mega-dropdown', function (e) {
        e.stopPropagation()
    })
    //search select city 
$(".dropdown-button").dropdown();

/**
$(document).ready(function () {
    $('select').material_select();
});
**/

//login hide and show blocks 
function forgot() {
    var pw1 = document.getElementById("forgotpw");
    pw1.style.display = "block";
    var sin = document.getElementById("signin");
    sin.style.display = "none";
}

function showlogin() {
    var pw1 = document.getElementById("forgotpw");
    pw1.style.display = "none";
    var sin = document.getElementById("signin");
    sin.style.display = "block";
}
//onscroll add class to left searchblock in list of jobs
$(document).ready(function () {
    var s = $("#search-left-block");
    var pos = s.position();
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top & windowpos >= 450) {
            s.addClass("fixed-search-top");
        }
        else {
            s.removeClass("fixed-search-top");
        }
    });
});
//onscroll add class to right search block in list of jobs
/*$(document).ready(function () {
    var r = $("#right-list");
    var pos = r.position();
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos > pos.top & windowpos > 450) {
            r.addClass("fixed-searchright-top");
        }
        else {
            r.removeClass("fixed-searchright-top");
        }
    });
});*/
//view recruiter details toggle
$(document).ready(function () {
    $("#rec-cont-det").click(function () {
        $(".Recruiter-contact-details").toggle(200);
    })
});
$(document).ready(function () {
    $('.tooltipped').tooltip({
        delay: 50
    });
});
//snackbar jquery toggle
$(document).ready(function () {
    $("#applybtn").click(function () {
        $("#apply-thisjob").toggle(200).delay(5000).fadeOut();
    });
});
$(document).ready(function () {
    $("#short-btn").click(function () {
        $("#shortlist-candidate").toggle(200).delay(5000).fadeOut();
    });
});
$(document).ready(function () {
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});


/**calander controls **/
$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });

