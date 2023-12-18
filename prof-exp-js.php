<?php

require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u Join tbl_currentexperience exp on u.JUser_Id=exp.JUser_Id
                              JOIN  tbl_location loc on exp.Loc_Id=loc.Loc_Id
                              WHERE u.JUser_Id=:uid");                           
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_SESSION['userSession']))
{
$userid=$_SESSION['userSession'];
$sqljspf2="SELECT `CurrentExp_Id`, `Loc_Id`, `Company_Name`, `CurrentSalL`, `CurrentSalT`, `ExpSalL`, `ExpMaxSalL`, `doJ`, `JDesc`, `Des`,  `alter_no`,`PaySlip` FROM `tbl_currentexperience` WHERE `JUser_Id`='$userid'";
$sqljsrespf2=mysqli_query($con,$sqljspf2);
$sqlressowpf2=mysqli_fetch_array($sqljsrespf2);
$countres=0;   
	
if(empty($sqlressowpf2[2])||empty($sqlressowpf2[7])||empty($sqlressowpf2[8])||empty($sqlressowpf2[9]))
{   
$countres++;    
}
}                           
?>
<div class="title-block-tab">
<h4 class="flight">Professional <span class="fbold">Experience</span>  </h4>
<?php   if($countres==0)
{  ?>
    <button  onclick="addnewexp()"><i class="fa fa-plus" aria-hidden="true"></i> Add Experience</button>
	<?php //if($sqlressowpf2['PaySlip'] ==''){ ?> 
	<a href="#addpayslip"><i class="fa fa-plus" aria-hidden="true"></i> Add Latest Payslip</a>
	<?php //} ?>
<?php }
else
{   ?>
    <button  onclick="showalert()"><i class="fa fa-plus" aria-hidden="true"></i> Add Experience</button>
	<?php //if($sqlressowpf2['PaySlip'] ==''){ ?> 
	<a href="#addpayslip"><i class="fa fa-plus" aria-hidden="true"></i> Add Latest Payslip</a>
	<?php //} ?>
    <?php 
} ?>        
</div>

<div class="display-features addexp" id="addnewexp">
    <form method="post" action="general-info.php" name="subexp1">
        
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="input-field">
                    <input type="text" class="validate" name="txtcmpy" id="txtcmpy">
                    <label>Name of Organization</label>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6 mt10">
              <div class="form-group">
                       <label>Designation <span class="mand">*</span></label>
                        <?php
                    
                        $sql = "SELECT Desig_Id,Desig_Name FROM tbl_desigination ORDER BY Desig_Name";
                        $query = mysqli_query($con, $sql);
                        if(!$query)
                        echo mysqli_error($con);
                        ?>
                        <select class="form-control classic" name="desi" id="desi" required>
                        <option value=""  selected>Select Designation </option>
                        <?php
                        while ($row1 = mysqli_fetch_array($query))
                        { 
                         extract($row1);
                        ?>
                        <option value="<?php echo $Desig_Id; ?>"><?php echo $Desig_Name; ?></option>
                        <?php } ?>
                        </select>
          </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="input-field dtrel">
                    <input type="text" name="txtdoj" id="txtdoj" class="pickdate1" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;">
                    <label>Date Of Joining</label>
                </div>
                 <script>
                               $('.pickdate1').pickadate({
                                    format: 'dd/mm/yyyy',
                                    selectMonths: true, 
                                    selectYears: 15, 
                                    max:new Date()                                  
                                });
                            </script>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="input-field dtrel" >
                <div id="releive">
                    <input name="txtdor" id="txtdor" type="text" class="datepicker" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;">
                    <label>Date Of Relieved</label>
                </div>
                   <script>
                                $('#txtdor').pickadate({
                                    format: 'dd/mm/yyyy',
                                    selectMonths: true, 
                                    selectYears: 15, 
                                    max:new Date()                                  
                                });
                            </script>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
                   <label>Location</label>
                    <?php
if($row['nri_status']=='N'){
                    $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location WHERE Cntry_Id=101 ORDER BY Loc_Name";

                    $query = mysqli_query($con, $sql);
                    if(!$query)
                    echo mysqli_error($con);
                    ?>
                    <select class="form-control classic" name="eloc" id="eloc" >
                    <option value="0"> Select Location </option>
                    <?php
                    while ($row1 = mysqli_fetch_array($query))
                    { 
                     extract($row1);
                    ?>
                    <option value="<?php echo $Loc_Id; ?>"><?php echo $Loc_Name; ?></option>
                    <?php } ?>
                    </select>
<?php }else{ $sql = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";

                    $query = mysqli_query($con, $sql);
                    if(!$query)
                    echo mysqli_error($con);?>
				
                    <select class="form-control classic" name="eloc" id="eloc" >
                    <option value="0"> Select Location </option>
                    <?php
                    while ($row1 = mysqli_fetch_array($query))
                    { 
                     extract($row1);
                    ?>
                    <option value="<?php echo $Cntry_Id; ?>"><?php echo $Cntry_Name; ?></option>
                    <?php } ?>
                    </select>
<?php }?>
                </div>

            </div> 
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
                   <label>Roles & Responsibilities</label>
                    <?php
                    $sql = "SELECT Func_Id,Func_Name FROM tbl_functionalarea ORDER BY Func_Name";
                    $query = mysqli_query($con, $sql);
                    if(!$query)
                    echo mysqli_error($con);
                    ?>
                    <select class="form-control classic" name="eres" id="eres" >
                    <option value="0" disabled selected> Roles & Responsibilities </option>
                    <?php
                    while ($row1 = mysqli_fetch_array($query))
                    { 
                     extract($row1);
                    ?>
                    <option value="<?php echo $Func_Id; ?>"><?php echo $Func_Name; ?></option>
                    <?php } ?>
                    </select>                                     
                </div>
            </div>
        </div>
        
        <div class="row showdetails ">
            <div class="col-md-12 col-xs-12">
                <div class="input-field">
                    <textarea class="materialize-textarea" name="txtjexp" id="txtjexp"></textarea>
                    <label for="textarea1">Job Description</label>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-6">
                <button class="btn waves-effect waves-light btn-blue-sm " type="submit" name="subexp" id="subexp" onclick="return validateaddexp()">Add Experience</button>
                <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a>
            </div>
        </div>
       
    </form>
</div>





<div class="display-features">
    
    <div class="display-details">
      
         <form method="post" action="general-info.php" name="Cexper">
         
        <article class="sub-title">
            <h4 class="pull-left"> <span class="fbold"><?php echo $row['Company_Name']; $currcomname=$row['Company_Name']; ?></span></h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="currexpedit_js()" id="edit-ic-exp"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
       
        <div id="editexp">           
               
                <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="input-field">
                            <input value="<?php echo $row['Company_Name'];?>" type="text" class="validate" name="Company_Name" id="companyname">
                            <label>Company Name</label>
                        </div>
                </div>
                    <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                        <div class="form-group">
                           <label>Designation </label>
                            <?php
                            $sql = "SELECT Desig_Id,Desig_Name FROM tbl_desigination ORDER BY Desig_Name";
                            $query = mysqli_query($con, $sql);
                            if(!$query)
                            echo mysqli_error($con);
                            ?>
                            <select class="form-control classic" name="cdesi" id="cdesi">
                                <option value="0"  > Select Designation </option>
                                <?php
                                while ($row1 = mysqli_fetch_array($query))
                                { 
                                 extract($row1);
                                ?>
                                <option value="<?php echo $Desig_Name;?>" <?php if(trim($row['Des']) == $Desig_Name) echo "selected"; else echo "";?>> <?php echo $Desig_Name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="input-field">
                           
                            <?php if($row['doJ']!="") { $datei=date_create($row['doJ']);
                            $currdoj= date_format($datei,"d/m/Y"); } ?>
  <input name="doj" id="doj" value="<?php echo $currdoj; ?>" type="text" class="datepickers" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;">
                            <label for="doj">Date Of Join</label>
                        </div>
                    </div>
     <script>
                                $('.datepickers').pickadate({
                                    format: 'dd/mm/yyyy',
                                    selectMonths: true, 
                                    selectYears: 70 ,   
                                   max:new Date()                       
                                });
                            </script>
          
               
                    <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                        <div class="form-group">
                        <label>Industry </label>
                <?php                                           
                    $sql2 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea ORDER BY Func_Name";
                    $query2 = mysqli_query($con, $sql2);
                    if(!$query2)
                    echo mysqli_error($con);
                    ?>
                    <select class="form-control classic" name="functional_area" id="functional_area2" >
                    <option value="0"> Select Industry </option>
                    <?php
                    while ($row2 = mysqli_fetch_array($query2))
                    { 
                     extract($row2);
                    ?>
                    <option value="<?php echo $row2['Func_Id']; ?>" <?php if(trim($row['Func_Id'])==$row2['Func_Id']){ echo "selected";}else { echo "";}?>><?php echo $row2['Func_Name']; ?></option>
                    <?php } ?>
                    </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="input-field">
                     
                        </div>
                    </div>
                </div>
               
                <div class="row showdetails ">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="input-field">
                            <textarea id="jobprofile" class="materialize-textarea" name="Desc"><?php echo $row['JDesc']; ?></textarea>
                            <label for="textarea1">Job Description</label>
                        </div>
                    </div>
                </div>
                <!--/row-->
          
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <button class="btn waves-effect waves-light btn-blue-sm " type="submit" name="editexp" value="editexp" onclick="return validatecexp()">Save</button>
                  <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a>
                  
                </div>
            </div>
           </form>
        </div>
       
       <div id="showexp">
           
            <div class="row showdetails ">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Designation</h4>
                        <p><?php echo $row['Des']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Joining </h4>
                        <p>
                        <?php if($row['doJ']!=""){ $datei=date_create($row['doJ']);
                        echo date_format($datei,"M d,Y"); } ?>
                        <!--<?php echo $row['doJ']; ?> -->
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Relieved</h4>
                        <p class="txt-blue">Currently working</p>
                    </div>
                </div>
				 <?php
if($row['nri_status']=='N') { ?>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Location </h4>
                        <p><?php echo $row['Loc_Name']; ?></p>
                    </div>
                </div>
				<?php } ?>
            </div>
           
            <div class="row showdetails ">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Roles & Responsibilities</h4>
                         <?php $user_query="select Func_Name from tbl_functionalarea where Func_Id='".$row['Func_Id']."'";
                         $rr= mysqli_query($con,$user_query); $rrs=mysqli_fetch_array($rr); ?>
                        <p><?php echo $rrs['Func_Name']; ?></p>
                    </div>
                </div>
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="block-show ">
                        <h4>Job Description</h4>
                        <p class="text-justify "><?php echo $row['JDesc']; ?></p>
                    </div>
                </div>
            </div>
          
        </div>

<div class="display-details"></div>

            <?php $sql1 = "SELECT * FROM tbl_experience where JUser_Id='".$row['JUser_Id']."'";
            $query1 = mysqli_query($con, $sql1);
            $dorval=0;
            $dojval=0;
            $datesofjoining=array();
            $datesofrelieving=array();
            $expidarray=array();
            $companynames=array();
            while($row1 = mysqli_fetch_array($query1)){
                    $Exp_Id=$row1['Exp_Id'];
                    $expidarray[]=$Exp_Id;
                    
                    $user_queryD1="select Desig_Name from tbl_desigination  where Desig_Id='".$row1['Desig_Id']."'";
                         $rrD1= mysqli_query($con,$user_queryD1); $rrsD1=mysqli_fetch_array($rrD1); 
                ?>      
<div class="display-details">
       
        <div id="editForm"></div>
            <article class="sub-title">
                <h4 class="pull-left"><span class="fbold"><?php echo $row1['Cmpy_Name']; $companynames[]=$row1['Cmpy_Name'];  ?></span></h4> 
              
                 <a class="pull-right" href="javascript:void(0);" title="Delete!" data-placement="top" onclick="return exp_delete(<?php echo $Exp_Id.",".$row['JUser_Id']?>)" id="delete-icon"><i class="fa fa-trash" aria-hidden="true"></i></a> 
             
              
              <a class="pull-right" href="javascript:void(0);" title="Edit!" data-placement="top" onclick="return edit_skills2(<?php echo $Exp_Id.",".$row['JUser_Id'].",".$dojval?>)" id="edit-icon2"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> 
             </article>
        


 <div id="editexp3<?php echo $Exp_Id;?>">
 </div>
        

        
        <div id="staticdata<?php echo $Exp_Id; ?>">
           
            <div class="row showdetails ">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Designation</h4>
                         <?php $user_queryD="select Desig_Name from tbl_desigination  where Desig_Id='".$row1['Desig_Id']."'";
                         $rrD= mysqli_query($con,$user_queryD); $rrsD=mysqli_fetch_array($rrD); ?>                      
                        <p><?php echo $rrsD['Desig_Name'];?></p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Joining </h4>
                        <p>
                        <?php                                       
                        if($row1['doJ']!="")
                        {
                            $datei=date_create($row1['doJ']);
                            echo date_format($datei,"M d,Y");
                        } 
                        $datesofjoining[$dojval++]=$row1['doJ']; 
                        ?>                      
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Date Of Relieved</h4>
                        <p>
                        <?php 
                        if($row1['dor']!="")
                        {
                            $datei=date_create($row1['dor']);
                            echo date_format($datei,"M d,Y");
                        }
                        $datesofrelieving[$dorval++]=$row1['dor']; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Location </h4>
                        <?php $user_queryL="select Loc_Name from tbl_location  where Loc_Id='".$row1['Loc_Id']."'";
                         $rrL= mysqli_query($con,$user_queryL); $rrsL=mysqli_fetch_array($rrL); ?>
                        <p><?php echo $rrsL['Loc_Name'];?></p>
                    </div>
                </div>
            </div>
          
            <div class="row showdetails ">
                <div class="col-md-3 col-xs-12 col-sm-6">
                    <div class="block-show ">
                        <h4>Roles & Responsibilities</h4>
                         <?php $user_queryR="select Func_Name from tbl_functionalarea  where Func_Id='".$row1['Roles_Resp']."'";
                         $rrR= mysqli_query($con,$user_queryR); $rrsR=mysqli_fetch_array($rrR); ?>                      
                        <p><?php echo $rrsR['Func_Name'];?></p>
                    </div>
                </div>
           </div>
         
            <div class="row showdetails ">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="block-show ">
                        <h4>Job Description</h4>
                        <p class="text-justify "><?php echo $row1['JDescri'];?></p>
                    </div>
                </div>
            </div>
            
            
        </div>
      
        </div>
        <?php  }?>
        
</div>
    
</div>
 <div id="addpayslip" class="modal">
           
                     <form name="payslip" action="general-info.php" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <h4 class="text-center">Upload Latest Payslip</h4>
                <!-- modal body -->
                <div class="profile-pic-edit text-center">                   
                        <div class="file-field input-field">
                            <div class="btn"> <span>Payslip</span>
                                <input type="file" id="payslip" name="payslip" required> </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" > </div>
                        </div>
                        <br>
                        <p>Supported Formats: doc, docx, pdf. Max file size:250KB Please note that this payslip document will be uploaded to your Needyin profile</p>
					 <p>
                                                                            <input type="checkbox" id="test5" name="test5" value="Y" title="Display to Employers when Shortlisted only" checked>
																			
                                                                            <label for="test5" style="color:#000;">Display to Employers when Shortlisted only</label>
																			 
                                                                        </p>
                </div>
                <!--/modal body-->
            </div>
            <div class="modal-footer text-center"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> 	<a class="waves-effect waves-green btn-flat" href="javascript:void(0)"><input type="submit"  name="Savepayslip" value="Save" onclick="return payslipfile()"/></a> </div>
  </form>     
             
        </div>
        <!--/ upload new resume-->
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>

        <script lang="javascript">      
            
                function validateaddexp()
            {
               
                var companyname=document.getElementById('txtcmpy').value;
                if(companyname=='')
                {
                    alert("Please Enter Company Name ");
                    document.getElementById('txtcmpy').focus();
                    return false;
                }
                var currcomname=<?php echo json_encode($companyname); ?>;
                if(companyname==currcomname)
                {                   
                    alert("You Have already added this Company as Current Experience");
                    document.getElementById('Company_Name').focus();
                    return false;;                                                          
                }               
                <?php   if(isset($companynames))
                { ?>                                                
                var companynames=<?php echo json_encode($companynames); ?>;
                var compexists=true;
                for(var i=0;i<companynames.length;i++)
                {
                    if(companynames[i]==companyname)
                    {
                        compexists=false;
                        alert("Can't add Same Company in Professional Experience");
                        return compexists;
                    }                                                           
                }               
                <?php      }  ?>                                                
                var desi=document.getElementById('desi').value;
                if(desi==0)
                {
                    alert("Please Select Designation ");
                    document.getElementById('desi').focus();
                    return false;
                }                               
                var txtdoj=document.getElementById('txtdoj').value;
             
                if(txtdoj=="")
                {
                    
                    alert("Please Select Date of Joining in the Company");
                    document.getElementById('txtdoj').focus();
                    return false;
                }                                               
                var f1 = new Date(txtdoj);
                var ftxtdoj = f1.toLocaleDateString();
                 datetxtdoj = txtdoj.split('/');
                var dateOne = new Date(datetxtdoj[2], datetxtdoj[1]-1, datetxtdoj[0]); //Year, Month, Date
                var datenow = new Date();
               
                if(dateOne>datenow)
                {
                    
                     alert("Please Select Valid Date of Joining in the Company, it can't be after today");
                    document.getElementById('txtdoj').focus();
                    return false;                                       
                }                                               
                var txtdor=document.getElementById('txtdor').value;                         
                if(txtdor=="")
                { 
    
                    alert("Please Select Date of Relieving");
                    document.getElementById('txtdor').focus();
                    return false;
                }                               
                var f2 = new Date(txtdor);
                var ftxtdor = f2.toLocaleDateString();
                            
                 datetxtdor = txtdor.split('/');            
                var dateTwo = new Date(datetxtdor[2], datetxtdor[1]-1, datetxtdor[0]); //Year, Month, Date           
              
                if(dateOne>=dateTwo)
                    {                                               
                    alert("Please Select Valid Date of Relieving");
                    document.getElementById('txtdor').focus();
                    return false;
                    }                                                                               
                    <?php  if(isset($currdoj)) {                        ?>
                    var currdoj="<?php echo $currdoj; ?>";
                    datecurrdoj = currdoj.split('/');
                    var fcurrdoj = new Date(datecurrdoj[2], datecurrdoj[1]-1, datecurrdoj[0]); 
                  
                    if(fcurrdoj<=dateOne || fcurrdoj<=dateTwo)
                    {
                    alert("Please Check your DOJ and DOR ,colliding with Current Experience");
                    document.getElementById('txtdor').focus();
                    return false;                                                                               
                    }                   
                    <?php }                                         
                     if(isset($datesofjoining)&&isset($datesofrelieving))
                     {?>                    
                    var datesofjoining=<?php echo json_encode($datesofjoining); ?>;
                    var datesofrelieving=<?php echo json_encode($datesofrelieving); ?>;
                   
                    for(alt=0;alt<datesofjoining.length;alt++)
                    {
                        var tempdoj=(datesofjoining[alt]);
                        var tempdor=(datesofrelieving[alt]);                        
                        atempdoj = tempdoj.split('-');
                        var ftempdoj = new Date(atempdoj[0], atempdoj[1]-1, atempdoj[2]);                                               
                        atempdor = tempdor.split('-');
                        var ftempdor = new Date(atempdor[0], atempdor[1]-1, atempdor[2]);           
                   
                        if((dateOne>=ftempdoj) && (dateOne<=ftempdor))
                        {                       
                        alert("Your DOJ is Colliding with other Experience");
                        document.getElementById('txtdoj').focus();
                        return false;
                        }                                                                   
                        if((dateTwo>=ftempdoj)&&(dateTwo<=ftempdor))        
                        {
                        alert("Your DOR  is Colliding with other Experience");
                        document.getElementById('txtdor').focus();
                        return false;
                        }                                           
                    }                                   
                             <?php }?>
                        var eloc=document.getElementById('eloc').value;
                        if(eloc==0)
                        {
                            alert("Please Select Location");
                            document.getElementById('eloc').focus();
                            return false;
                        }                              
                        var eres=document.getElementById('eres').value;
                        if(eres==0)
                        {
                            alert("Please Select Roles & Responsibilities");
                            document.getElementById('eres').focus();
                            return false;
                        }               
                        var txtjexp=document.getElementById('txtjexp').value;
                        if(txtjexp=="")
                        {
                            alert("Please Enter Job Description");
                            document.getElementById('txtjexp').focus();
                            return false;
                        }               
                        else 
                            return true; 
  }
			function currexpedit_js() {
    var ee1 = document.getElementById("editexp");
    ee1.style.display = "block";
    var ee2 = document.getElementById("showexp");
    ee2.style.display = "none";
    var ee5 = document.getElementById("edit-ic-exp");
    ee5.style.display = "none";
}


            function validatecexp()
            {
                        
                        var companyname=document.getElementById('companyname').value;
                        if(companyname=='')
                        {
                            alert("Please Enter Company Name ");
                            document.getElementById('companyname').focus();
                            return false;
                        }                                                                                       
                        var desi=document.getElementById('cdesi').value;
                        if(desi=="0")
                        {
                            alert("Please Select Designation ");
                            document.getElementById('cdesi').focus();
                            return false;
                        }                                               
                        var txtdoj=document.getElementById('doj').value;
                  
                        if(txtdoj=="")
                        {
                            alert("Please Select Date of Joining in the Company");
                            document.getElementById('doj').focus();
                            return false;
                        }                 
                        var f1 = new Date(txtdoj);
                        var ftxtdoj = f1.toLocaleDateString();
                         datetxtdoj = txtdoj.split('/');
                        var dateOne = new Date(datetxtdoj[2], datetxtdoj[1]-1, datetxtdoj[0]); //Year, Month, Date
						
                        var datenow = new Date();                   
                        if(dateOne>datenow)
                        {                           
                            alert("Please Select Valid Date of Joining in the Company, it can't be after today");
                            document.getElementById('txtdoj').focus();
                            return false;                                                       
                        }                                                                                                                                               
                        var eres=document.getElementById('functional_area2').value;
                        if(eres=="0")
                        {
                            alert("Please Select Roles & Responsibilities");
                            document.getElementById('functional_area2').focus();
                            return false;
                        }                       
                        var txtjexp=document.getElementById('jobprofile').value;
                        if(txtjexp=="")
                        {
                            alert("Please Enter Job Description");
                            document.getElementById('jobprofile').focus();
                            return false;
                        }                                                                                                       
         }
            function validateedit()
            {
                    var temppp=document.getElementById('tempval').value;
                    var companyname=document.getElementById('Cmpy_Name').value;
                    if(companyname=='')
                    {
                    alert("Please Enter Company Name ");
                    document.getElementById('Cmpy_Name').focus();
                    return false;
                    }                                                                               
                    var desi=document.getElementById('secondExp').value;
                    if(desi==0)
                    {
                        alert("Please Select Designation ");
                        document.getElementById('secondExp').focus();
                        return false;
                    }              
                    var txtdoj=document.getElementById('txtsecondDoJ').value;
                    if(txtdoj=="")
                    {
                        alert("Please Select Date of Joining in the Company");
                        document.getElementById('txtsecondDoJ').focus();
                        return false;
                    }
                    var f1 = new Date(txtdoj);
                    var ftxtdoj = f1.toLocaleDateString();
                    datetxtdoj = txtdoj.split('/');
                    var dateOne = new Date(datetxtdoj[2], datetxtdoj[0]-1, datetxtdoj[1]); 
                    var datenow = new Date();           
                    if(dateOne>datenow)
                    {                   
                        alert("Please Select Valid Date of Joining in the Company, it can't be after today");
                        document.getElementById('txtdoj').focus();
                        return false;                                   
                    }                               
                    var txtdor=document.getElementById('txtsecondDoR').value;
                    if(txtdor=="")
                    {
                        alert("Please Select Date of Relieving");
                        document.getElementById('txtsecondDoR').focus();
                        return false;
                    }               
                    var f2 = new Date(txtdor);
                    var ftxtdor = f2.toLocaleDateString();      
                    datetxtdor = txtdor.split('/');             
                    var dateTwo = new Date(datetxtdor[2], datetxtdor[0]-1, datetxtdor[1]);         
                                   
                    if(dateOne>=dateTwo)
                    {                       
                        alert("Please Select Valid Date of Relieving");
                        document.getElementById('txtsecondDoR').focus();
                        return false;
                    }                                                                               
                    <?php  if(isset($currdoj)) {?>
                    var currdoj="<?php echo $currdoj; ?>";
               
                    datecurrdoj = currdoj.split('/');
                    var fcurrdoj = new Date(datecurrdoj[2], datecurrdoj[1]-1, datecurrdoj[0]); 
                  
                    if(fcurrdoj<=dateOne || fcurrdoj<=dateTwo)
                    {
                    alert("Please Check DOJ and DOR ,colliding with Current Experience");
                    document.getElementById('txtsecondDoJ').focus();
                    return false;                                                                               
                    }                   
                    <?php }                                         
                     if(isset($datesofjoining)&&isset($datesofrelieving))
                     {?>                    
                        var datesofjoining=<?php echo json_encode($datesofjoining); ?>;
                        var datesofrelieving=<?php echo json_encode($datesofrelieving); ?>;
                        datesofjoining.splice(temppp,1);
                        datesofrelieving.splice(temppp,1);
                        for(alt=0;alt<datesofjoining.length;alt++)
                        {
                            var tempdoj=(datesofjoining[alt]);
                            var tempdor=(datesofrelieving[alt]);                    
                            atempdoj = tempdoj.split('-');
                            var ftempdoj = new Date(atempdoj[0], atempdoj[1]-1, atempdoj[2]);                                               
                            atempdor = tempdor.split('-');
                            var ftempdor = new Date(atempdor[0], atempdor[1]-1, atempdor[2]);                       
                            if((dateOne>=ftempdoj) && (dateOne<=ftempdor))
                            {                       
                            alert("Your DOJ is Colliding with other Experience");                       
                            document.getElementById('txtdoj').focus();
                            return false;
                            }                                                                   
                            if((dateTwo>=ftempdoj)&&(dateTwo<=ftempdor))        
                            {
                            alert("Your DOR  is Colliding with other Experience");
                            document.getElementById('txtsecondDoR').focus();
                            return false;
                            }                                           
                        }                                       
                     <?php }?>                
                var eloc=document.getElementById('SecondExpLoc').value;
                if(eloc==0)
                {
                    alert("Please Select Location");
                    document.getElementById('SecondExpLoc').focus();
                    return false;
                }                               
                var eres=document.getElementById('SecondRolesR').value;
                if(eres==0)
                {
                    alert("Please Select Roles & Responsibilities");
                    document.getElementById('SecondRolesR').focus();
                    return false;
                }                
                var txtjexp=document.getElementById('SecondDesp').value;
                if(txtjexp=="")
                {
                    alert("Please Enter Job Description");
                    document.getElementById('SecondDesp').focus();
                    return false;
                }               
                else 
                    return true;  
         } 
               function showalert()
               {           
                   alert("Please Complete Current Experience details");
                   return false;           
               }       
           </script>
        <script>
        var testval=0;
         function edit_skills2(exp_id,user_id,tempval)
        {
            if(testval==1)
            {
             return false;
            }                
            var xmlhttp;
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("editexp3"+exp_id).innerHTML=xmlhttp.responseText;
                document.getElementById("staticdata"+exp_id).style.display = 'none';
                if(exp_id!=0)
                {
                testval=1;
                }
          
                }
              }
            xmlhttp.open("GET","edit_prev_exp.php?exp_id="+exp_id+"&user_id="+user_id+"&temp="+tempval,true);
            xmlhttp.send();      
        }
        </script>
            <script>
                function exp_delete(exp_id,user_id)
             {  
             
                window.location.href = "del_prevexp.php?exp_id="+exp_id+"&user_id="+user_id;
        return true;
            }
           function Validatepayslip(oInput) {
	var _validFileExtensions = [".doc",".docx",".pdf"];    
	//alert("DDDD");
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
			 else
				 return true;
        }
    }
}
				function payslipfile()
{
	
	var payslip=document.getElementById('payslip').files[0].size;

	if(resume>250000)
	{
		
		alert("Resume size is more than 250KB ,please check");
		document.getElementById('payslip').focus();
		return false;
		
	}
	
	
}
            
            </script>
            