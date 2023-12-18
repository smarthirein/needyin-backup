<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

 $query="select jdndstatus from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
                                  $query_res=mysqli_query($con,$query);
                                  $dnd=mysqli_fetch_array($query_res);
                                  $dnd_status=$dnd['jdndstatus'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Needyin</title>
        <!-- css includes-->
        <?php include"source.php" ?>
            <script>
                $(document).ready(function () {
                    $('.modal').modal();
                });
            </script>
            <script>
                $(document).ready(function () {
                    $('#ChildVerticalTab_2').easyResponsiveTabs({
                        type: 'vertical'
                        , width: 'auto'
                        , fit: true
                        , tabidentify: 'ver_1', // The tab groups identifier
                        activetab_bg: '#0274bb', // background color for active tabs in this group
                        inactive_bg: '#fff', // background color for inactive tabs in this group
                    });
                });
            </script>
             
            
            <?php if($dnd_status=='2'){ ?>
            <style>
              .chpw, .rediv{
                display: none!important;
              }
              .dnddiv{
                display: block;
              }
              </style>
              <?php } ?>
            
            
    </head>

    <body>
        <?php
include_once("analyticstracking.php");
         if($dnd_status=='2')
         {
            include "postlogin-header-inactive.php"; 
         } else
         {
            include "postlogin-header-jobseekar.php"; 
         }
      if(isset($_POST['submit']))
      {
          // print_r($_POST);
            if($_POST['dnd_mode']=='0')
            {
                $update_query="update tbl_jobseeker set jdndstatus='0' where JUser_Id=".$_SESSION['userSession'];
                $update_res=mysqli_query($con,$update_query);

                 $insert_query="INSERT INTO `tbl_dnd_jobseeker` (`job_id`, `JUser_Id`, `reason`, `jdndstatus`) VALUES ('".$_POST['jobs']."', '".$_SESSION['userSession']."', '".$_POST['reason']."', '".$_POST['dnd_mode']."')";
              $qq_res=mysqli_query($con,$insert_query);

            }   
            if($_POST['dnd_mode']=='1')
            {
                $update_query="update tbl_jobseeker set jdndstatus='1' where JUser_Id=".$_SESSION['userSession'];
                $update_res=mysqli_query($con,$update_query);

               $insert_query="INSERT INTO `tbl_dnd_jobseeker` (`job_id`, `JUser_Id`, `reason`, `jdndstatus`) VALUES ('".$_POST['jobs']."', '".$_SESSION['userSession']."', '".$_POST['reason']."', '".$_POST['dnd_mode']."')";
              $qq_res=mysqli_query($con,$insert_query);
                       
            }   
            if($_POST['dnd_mode']=='2')
            {
                $update_query="update tbl_jobseeker set jdndstatus='2' where JUser_Id=".$_SESSION['userSession']; 
                $update_res=mysqli_query($con,$update_query);

                $insert_query="INSERT INTO `tbl_dnd_jobseeker` (`job_id`, `JUser_Id`, `reason`, `jdndstatus`) VALUES ('".$_POST['jobs']."', '".$_SESSION['userSession']."', '".$_POST['reason']."', '".$_POST['dnd_mode']."')";
              $qq_res=mysqli_query($con,$insert_query); ?>
             
              <script>//alert("DND Status Updated Successfully");
                window.location.href="jobseekar_logout.php?msg=dnd";</script>
                       
          <?php  }   
             

        if($qq_res!="")
        { ?>
          
          <script> //alert("DND Status Updated Successfully");
          window.location.href="jobseeker-profile-update-password.php?msg=dnd";</script>
      <?php   }

    } ?>
            <!-- main-->
            <main>
                <section class="jobseekar-profile">
                    <?php if($dnd_status=='2')
                    { 
                    include "inner-menu-inactive.php" ;
                    } else {
                      include "inner-menu.php" ;
                    }
                    ?>
                        <!-- job seekar header -->
                        <!-- job seekar body -->
                        <section class="job-seekar-body">

                            <div class="js-profile-nav">
                                <!-- job seekear profile navigation -->
                                <div class="container">
                                 <div style="color:green;" id="msg_div">
                                 <center><b>
                                 <?php if($_GET['msg']=='dnd'){?>DND Status Updated Successfully<?php }
                                  else if($_GET['msg']=='inactive'){?>You are in Inactive mode please change your status<?php }
                                    else if($_GET['dmsg']=='dmsg'){?>Welcome back <?php echo ucfirst($jb_data['JFullName']); ?><?php }?>
                                   </b></center>
                                   </div>
                                    <!-- update resume block -->
                                    <div class="settings">
                                        <!-- tab main content starts-->
                                        <div id="ChildVerticalTab_2">
                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <ul class="resp-tabs-list ver_1">
                                                    <?php if($dnd_status!='2'){ ?>
                                                      
                                                        <li onclick="return remove_msg()">Change / Update Password</li>
                                                        <li onclick="return remove_msg()">Reasons &amp; Attachments</li>
                                                      <?php } ?>
                                                        <li>DND Mode <small style="float:
                                    none;">(Do Not Disturb Mode)</small></li>
                                                  
                                                    </ul>
                                                    <script>
                                                    function remove_msg(){
                                                     //alert("fdg");
                                                     document.getElementById('msg_div').style.display='none';
                                                    }
                                                    </script>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="resp-tabs-container ver_1 tab-content">
                                                        <!-- Change Password -->
                                                        <div class="chpw">
                                                            <div class="title-block-tab">
                                                                <h4 class="flight">Change / Update <span class="fbold">Password</span></h4> </div>
                                                            <!--change password -->
                                                            <div class="settings-changepw">
                                                                <form action="jobseeker-profile-update-password-process.php" method="post">
                                                                    <div class="input-field">
                                                                        <input id="password" type="password" class="validate" name="password"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                                        <label for="password">Old Password</label>
                                                                    </div>
                                                                    <div class="input-field">
                                                                        <input id="newpassword" type="password" class="validate" name="newpassword"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                                        <label for="newpassword">New Password</label>
                                                                    </div>
                                                                    <div class="input-field">
                                                                        <input id="conpassword" type="password" class="validate" name="conpassword"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                                        <label for="conpassword">Confirm Password</label>
                                                                    </div>
                                                                    <div class="input-field">
                                                                        <button class="btn btn-blue-sm" type="submit" name="Changepwd" onclick="return validatepassword()">Save & Update</button> <a href="index.php" class="btn btn-blue-sm">Cancel</a> </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- //Change Password -->
                                                        <!-- Attachments-->
                                                        <div class="rediv">
                                                            <div class="title-block-tab">
                                                                <h4 class="flight">Reasons <span class="fbold"> &amp; Attachments</span></h4> </div>
                                                            <!--<div class="myattach-div">
                                           <div class="row">
                                               <div class="col-md-4 col-xs-12 col-sm-6">
                                                   <div class="block-show">
                                                       <h4>Reason type</h4>
                                                       <p>Medical Emergency - Children</p>
                                                   </div>
                                               </div>
                                               <div class="col-md-8 col-xs-12 col-sm-6">
                                                   <div class="block-show">
                                                       <h4>Reason Attachments</h4>
                                                       <p class="attachments">
                                                       <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> Document Name </a>
                                                       <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> Document Name2 </a>
                                                       <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> Document Name 3 </a>
                                                       </p>
                                                   </div>
                                               </div>
                                               <div class="col-md-12">
                                                   <div class="block-show">
                                                       <h4>Reason Description</h4>
                                                       <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                   </div>
                                               </div>
                                               <div class="col-md-12 col-xs-12 col-sm-6">
                                                   <div class="block-show">
                                                       <h4>Payslips Attachments</h4>
                                                       <p class="attachments">
                                                           <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> May 2017 </a>
                                                           <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> April 2017 </a>
                                                           <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> March 2017 </a>  <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> May 2017 </a>
                                                           <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> April 2017 </a>
                                                           <a href="Upload/Reason/reason_1-reason.doc" download=""><i class="fa fa-download" aria-hidden="true"></i> March 2017 </a>
                                                       </p>
                                                   </div>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                   <!-- attachments-->
                                                            <?php include 'reasons-view-js-rec-view.php'; ?>

                                                        </div>
                                                        <!-- DND Mode -->
                     
                    
                              <div class="dnddiv">
 
                                <form name="frm" action="" method="post">
                                     <div class="title-block-tab">
                                      <h4 class="flight">DND <span class="fbold">Mode</span></h4>
                                      </div>
                                  <div class="dndcol">
                                          <div class="dnd">
                                              <p>
                                                  <input checked class="with-gap" name="dnd_mode" type="radio" id="dnd1" onclick="return jobs_list('active')" value="0" <?php if($dnd_status=='0'){ ?>Checked <?php } ?>/>
                                                  <label for="dnd1">Actively Seeking Job (Default)</label>
                                              </p>
                                              <p>
                                             <?php if($dnd_status=='2'){ ?>
                                                  <input class="with-gap" name="dnd_mode" type="radio" id="dnd2"  value="1" disabled/>
                                                  <label for="dnd2">Got a Job (Disable alerts & Updates) <span><small>(You will not get any Job alerts and updates from NeedyIn)</small></span></label>
                                              <?php } 
                                              else { ?>
                                                   <input class="with-gap" name="dnd_mode" type="radio" id="dnd2" onclick="return jobs_list('stop')" value="1"  <?php if($dnd_status=='1'){ ?>Checked <?php } ?>/>
                                                  <label for="dnd2">Got a Job (Disable alerts & Updates) <span><small>(You will not get any Job alerts and updates from NeedyIn)</small></span></label>
                                              <?php } ?>
                                              </p>
                                              <p>
                                                  <input class="with-gap" name="dnd_mode" type="radio" id="dnd3" onclick="return jobs_list('inactive')" value="2"  <?php if($dnd_status=='2'){ ?>Checked <?php } ?>/>
                                                  <label for="dnd3">Deactive Account <span><small>(You will not get any mails, updates and your account will be deactive )</small></span></label>
                                              </p>
                                          </div>
                                            <div class="reason_write">
                                                   <div class="form-group" id="jobs_select" style="display:none;">
                                                   <?php  $ap_query="select JobId from tbl_applied where JUser_Id='".$_SESSION['userSession']."'";
                                                         $ap_res=mysqli_query($con,$ap_query); 
                                                                 while($ap_data=mysqli_fetch_array($ap_res))
                                                                 {
                                                                  $ajobids[]= $ap_data['JobId'];
                                                                 }
                                                                $ajob_ids=array_filter(array_unique($ajobids));
                                                                $ajobs_cnt=count($ajob_ids);
                                                               // print_r($ajob_ids);
                                                       $sh_query="select JobId from tbl_shortlisted where JUser_Id='".$_SESSION['userSession']."'";
                                                       $sh_res=mysqli_query($con,$sh_query); 
                                                                 while($sh_data=mysqli_fetch_array($sh_res))
                                                                 {
                                                                  $sjobids[]= $sh_data['JobId'];
                                                                 }
                                                                  $sjob_ids=array_filter(array_unique($sjobids));
                                                                  $sjobs_cnt=count($sjob_ids);
                                                                  // print_r($sjob_ids);
                                                                  $job_ids=array_unique(array_merge($ajob_ids,$sjobids));
                                                                  if($ajobs_cnt=='0' || $ajobs_cnt=="")
                                                                  {
                                                                    $job_ids=$sjob_ids;
                                                                  }
                                                                 else if($sjobs_cnt=='0' || $sjobs_cnt=="")
                                                                  {
                                                                    $job_ids=$ajob_ids;
                                                                  }else{
                                                                    $job_ids=array_unique(array_merge($ajob_ids,$sjobids));
                                                                  }
                                                             // print_r($job_ids);
                                                                  $dnd_query1="select job_id,reason from tbl_dnd_jobseeker where jdndstatus='1' and  JUser_Id=".$_SESSION['userSession'];
                                                                  $dnd_res1=mysqli_query($con,$dnd_query1);
                                                                  $dnd_data1=mysqli_fetch_array($dnd_res1);
                                                       
                                                    ?>
                                                           <select class="form-control classic" name="jobs" id="jobs">
                                                               <option value="0">Select Job Name</option>
                                                                  <?php foreach($job_ids as $job) {  
                                                                        $jb_qq="select Job_Name,Comp_Name from tbl_jobposted where Job_Id='".$job."' and Job_Status=1"; 
                                                                              $jb_res=mysqli_query($con,$jb_qq);
                                                                              $jb_data=mysqli_fetch_array($jb_res);
                                                                              $jb_cnt=mysqli_num_rows($jb_res);
                                                                        if($jb_cnt>0)
                                                                        {

                                                                          $ds_qq="select Desig_Name from tbl_desigination where Desig_Id='".$jb_data['Job_Name']."'";
                                                                           $ds_res=mysqli_query($con,$ds_qq);
                                                                           $des_data=mysqli_fetch_array($ds_res);
                                                                           ?>

                                                             <option value="<?php echo $job;?>"  ><?php echo $des_data['Desig_Name']." ".'-'." ".$jb_data['Comp_Name'];?></option>
                                                                  <?php } 
                                                                  }?>
                                                             <option value="others">Others</option>
                                                           </select>
                                                      </div>
                                                       <div class="input-field" id="w_reason" style="display:none;" >
                                                              <textarea id="reason" name="reason" class="materialize-textarea" data-length="120"></textarea>
                                                              <label for="reasion1">Write A Reason</label>
                                                        </div>
                                                   <input type="submit" name="submit" class="btn btn-blue-sm" value="Submit" onclick="return dnd_valid();">
                                                
                                            </div>
                                  </div>
                                  </form>
                              </div>
                              <!--// DND Mode -->
                             
                          </div>
                      </div>
                                                <!-- / row-->
                                                <!-- tab main content ends-->
                  </div>
                  <!--/ update resume block -->
              </div>
          </div>
      </div>
      <!-- job seekar profile navigation -->
</section>
<!-- / job seekar body -->
</section>
</main>
            <!--/main-->
            <!-- profile picture upload-->
            <div id="modal1" class="modal editpic-modal">
                <div class="modal-content">
                    <h4 class="text-center">Chagne Profile Picture</h4>
                    <!-- modal body -->
                    <div class="profile-pic-edit text-center">
                        <figure><img src="img/profile-pic.jpg"></figure>
                    </div>
                    <!--/modal body-->
                </div>
                <div class="modal-footer text-center"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> <a href="#!" class="btn-flat file-field input-field"><span>Upload Picture</span> <input type="file"></a> <a href="#!" class=" waves-effect waves-green btn-flat">Save</a> <a href="#!" class=" waves-effect waves-green btn-flat">Delete</a> </div>
            </div>
            <!--/prifile picture upload -->
            <!-- updae text field -->
            <script>
                $(document).ready(function () {
                    Materialize.updateTextFields();
                });
            </script>
            <script>
            function jobs_list(val)
            {
                if(val=='stop')
                {
                    document.getElementById('jobs_select').style.display='block';
                    document.getElementById('w_reason').style.display='block';
                }
                if(val=='active')
                {
                    document.getElementById('jobs_select').style.display='none';
                    document.getElementById('w_reason').style.display='none';
                }
                if(val=='inactive')
                {
                    document.getElementById('jobs_select').style.display='none';
                    document.getElementById('w_reason').style.display='block';
                    //document.getElementById('reason').value="";
                }
            }
            </script>
            <script>
            function dnd_valid()
            {
                var rd=document.getElementById("dnd2").checked;
                if(rd == true)
                {
                    var jval=document.getElementById('jobs').value;
                    if(jval=='0')
                    {

                        alert("Please Select Job Name");
                        document.getElementById('jobs_select').style.display='block';
                        document.getElementById('w_reason').style.display='block';
                        return false;
                    }
                    var jr=document.getElementById('reason').value;
                     if(jr=="")
                    {

                      alert("Please Write Reason");
                      document.getElementById('reason').focus();
                      return false;
                    }
               } 
                
            }
            </script>
            <!-- footer-->
            <?php 
        if($dnd_status!='2')
         {
            //include 'footer.php';
            } ?>
                <!--/footer-->
                
               
               
                <script>
                    //center modal
                    function centerModal() {
                        $(this).css('display', 'block');
                        var $dialog = $(this).find(".modal-dialog");
                        var offset = ($(window).height() - $dialog.height()) / 2;
                        // Center modal vertically in window
                        $dialog.css("margin-top", offset);
                    }
                    $('.modal').on('show.bs.modal', centerModal);
                    $(window).on("resize", function () {
                        $('.modal:visible').each(centerModal);
                    });

                    function validatepassword() {
                    	var opwd = document.getElementById('password').value;
                        var npwd = document.getElementById('newpassword').value;
                        if(opwd==npwd)
                        {
                        	alert("Old Password and New Password can't be same");
                        	return false;
                        }
                        var verpwd = document.getElementById('conpassword').value;
                        if (!passwordverify(npwd)) {
                            document.getElementById('newpassword').focus();
                            return false;
                        }
                        if (npwd != verpwd) {
                            alert("New Password and Confirm Password Must be Same");
                            document.getElementById('conpassword').focus();
                            return false;
                        }
                    }
                </script>
    </body>
    

    </html>