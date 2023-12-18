//job seekar profile edit information script
function showprofileoverview() {
    var p1 = document.getElementById("edit-profile-overview");
    p1.style.display = "block";
    var p2 = document.getElementById("show-profile-overview");
    p2.style.display = "none";
    var p5 = document.getElementById("edit-ic-profileov");
    p5.style.display = "none";
};

function editprofileoverview() {
    var p3 = document.getElementById("show-profile-overview");
    p3.style.display = "block";
    var p4 = document.getElementById("edit-profile-overview");
    p4.style.display = "none";
    var p6 = document.getElementById("edit-ic-profileov");
    p6.style.display = "block";
};
//success alert
function albox() {
    var abox = document.getElementById("myAlert");
    abox.style.display = "block";
};
// job languages known edit informatino script
function editlangshow() {
    var l1 = document.getElementById("edit-languages-known");
    l1.style.display = "block";
    var l2 = document.getElementById("show-languages-known");
    l2.style.display = "none";
    var l5 = document.getElementById("edit-lang-ic");
    l5.style.display = "none";
}

function showlangknown() {
    var l3 = document.getElementById("edit-languages-known");
    l3.style.display = "none";
    var l4 = document.getElementById("show-languages-known");
    l4.style.display = "block";
    var l6 = document.getElementById("edit-lang-ic");
    l6.style.display = "block";
}
//social profiles edit and show script
function editsoc() {
    var s1 = document.getElementById("edit-social");
    s1.style.display = "block";
    var s2 = document.getElementById("show-soc");
    s2.style.display = "none";
    var s5 = document.getElementById("edit-soc-ic");
    s5.style.display = "none";
}

function showsoc() {
    var s3 = document.getElementById("edit-social");
    s3.style.display = "none";
    var s4 = document.getElementById("show-soc");
    s4.style.display = "block";
    var s6 = document.getElementById("edit-soc-ic");
    s6.style.display = "block";
}
//add social network to your profile
function addsoc() {
    var s1 = document.getElementById("addsocial");
    s1.style.display = "block";
}
//passport details hide and show
//social profiles edit and show script
function editpp() {
    var s1 = document.getElementById("editpp");
    s1.style.display = "block";
    var s2 = document.getElementById("showpp");
    s2.style.display = "none";
    var s5 = document.getElementById("ppic");
    s5.style.display = "none";
}

function showpp() {
    var s3 = document.getElementById("editpp");
    s3.style.display = "none";
    var s4 = document.getElementById("showpp");
    s4.style.display = "block";
    var s6 = document.getElementById("ppic");
    s6.style.display = "block";
}
//edit education
/*function editedu() {
    var st1 = document.getElementById("editstudy");
    st1.style.display = "block";
    var st2 = document.getElementById("showstudy");
    st2.style.display = "none";
    var st5 = document.getElementById("edit-ic-edu");
    st5.style.display = "none";
}*/
function editedu(eid,uid) {
                        console.log(eid+","+uid);
                        $.ajax({
                          type: "POST",
                          url: "edit_education.php",
                          data: {userid : eid,juserid : uid}, 
                          success: function(response) {
                            //alert(response);
                            $("#editForm").html(response);
                            var st1 = document.getElementById("editstudy");
                            st1.style.display = "block";
                            var st2 = document.getElementById("showstudy");
                            st2.style.display = "none";
                            var st5 = document.getElementById("edit-ic-edu");
                            st5.style.display = "none";
                            $("select").css('display','block');
                          }
                        });
                    }


function showedu() {
    var st3 = document.getElementById("editstudy");
    st3.style.display = "none";
    var st4 = document.getElementById("showstudy");
    st4.style.display = "block";
    var st6 = document.getElementById("edit-ic-edu");
    st6.style.display = "block";
}
//add education
function addedu() {
    var ae1 = document.getElementById("add-education");
    ae1.style.display = "block";
     var msg2 = document.getElementById("dis_msg");
    msg2.style.display = "none";

}

function hideedu() {
    var ae3 = document.getElementById("add-education");
    ae3.style.display = "none";
}
//edit experience
function editexp() {
    var ee1 = document.getElementById("editexp");
    ee1.style.display = "block";
    var ee2 = document.getElementById("showexp");
    ee2.style.display = "none";
    var ee5 = document.getElementById("edit-ic-exp");
    st5.style.display = "none";
}

function showexp() {
    var ee3 = document.getElementById("editexp");
    ee3.style.display = "none";
    var ee4 = document.getElementById("showexp");
    ee4.style.display = "block";
    var ee6 = document.getElementById("edit-ic-exp");
    ee6.style.display = "block";
}
//new experience adding
function addnewexp() {
    var ne1 = document.getElementById("addnewexp");
    ne1.style.display = "block";
}

function cancelexp() {
    var ne3 = document.getElementById("addnewexp");
    ne3.style.display = "none";
}
//edit skills
function editskills() {
    var esk1 = document.getElementById("editskills");
    esk1.style.display = "block";
    var esk2 = document.getElementById("showskills");
    esk2.style.display = "none";
    var esk5 = document.getElementById("edit-ic-skills");
    esk5.style.display = "none";
}
function editsecskills() {
    var sk1 = document.getElementById("editsecskills");
    sk1.style.display = "block";
    var sk2 = document.getElementById("showsecskills");
    sk2.style.display = "none";
    var sk5 = document.getElementById("edit-sc-skills");
    sk5.style.display = "none";
}
function showexp() {
    var esk3 = document.getElementById("editskills");
    esk3.style.display = "none";
    var esk4 = document.getElementById("showskills");
    esk4.style.display = "block";
    var esk6 = document.getElementById("edit-ic-skills");
    esk6.style.display = "block";
}
function showsecexp() {
    var sk3 = document.getElementById("editsecskills");
    sk3.style.display = "none";
    var sk4 = document.getElementById("showsecskills");
    sk4.style.display = "block";
    var sk6 = document.getElementById("edit-sc-skills");
    sk6.style.display = "block";
}
//edit professional experience
/*function editskills2() {
    var dsk1 = document.getElementById("editexp2");
    dsk1.style.display = "block";
    var dsk2 = document.getElementById("staticdata");
    dsk2.style.display = "none";
    var dsk5 = document.getElementById("edit-icon2");
    dsk5.style.display = "none";
}*/

function editskills2(exid,uid) {
                        console.log(exid+","+uid);
                        $.ajax({
                          type: "POST",
                          url: "general-info.php",
                          data: {userid : exid,juserid : uid}, 
                          success: function(response) {
                            //alert(response);
                            $("#editForm").html(response);
                            var dsk1 = document.getElementById("editexp2");
                            dsk1.style.display = "block";
                            var dsk2 = document.getElementById("staticdata");
                            dsk2.style.display = "none";
                            var dsk5 = document.getElementById("edit-icon2");
                            dsk5.style.display = "none";
                            $("select").css('display','block');
                          }
                        });
                    }

function showexp3() {
    var dsk3 = document.getElementById("editexp2");
    dsk3.style.display = "none";
    var dsk4 = document.getElementById("staticdata");
    dsk4.style.display = "block";
    var dsk6 = document.getElementById("edit-icon2");
    dsk6.style.display = "block";
}