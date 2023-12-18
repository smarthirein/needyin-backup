<?php
require_once 'source.php';
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
					  
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u							
                              WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
 

$csal="select * from tbl_currentexperience where JUser_Id=".$_SESSION['userSession'];

$csal_res=mysqli_query($con,$csal);
$csal_data=mysqli_fetch_array($csal_res);

?>
    <script language="javascript">
        $(document).on('keypress', '#full_name', function (event) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
		
		
    </script>
	<script src="js/masking-input.js" data-autoinit="true"></script>
	  <link rel="stylesheet" href="css/masking-input.css"/>
    <div class="title-block-tab">
        <h4 class="flight">GENERAL <span class="fbold">INFORMATION</span></h4> </div>
    <div class="display-features">
       
        <div class="display-details">
          
            <article class="sub-title">
                <h4 class="pull-left">PROFILE <span class="fbold">OVERVIEW</span></h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="showprofileoverview()" id="edit-ic-profileov"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
          
            <div id="edit-profile-overview" class="hide-details">
                <form method="post" action="general-info.php" name="general-info" novalidate>
                    <div class="row">
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field">
                                <input value="<?php echo $row['JFullName']; ?>" name="full_name" id="full_name" maxlength="55" type="text" class="validate" pattern=".{3,}" title="Three Characters are Minimum for Name" maxlength="50" required>
                                <label>Complete Name<span class="mand">*</span></label>
                            </div>
                        </div>
                        <?php if($row['DoB']!=""){ 
                                    $dateb=date_create($row['DoB']);
                                $dob= date_format($dateb,"d-m-Y");} ?>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field">
                                 <input value="<?php echo $dob; ?>" name="date" id="date" type="text" class="datepickerb" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;">
								 <label>Date of Birth<span class="mand">*</span></label>
                                
                            </div>
                        </div>
							<script>	$('.datepickerb').pickadate({
                                        selectMonths: true, 
                                        selectYears: 90, 
                                        format: 'dd-mm-yyyy',
                                        max:new Date()  });
                            </script>
                       
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field gender">
                                <label>Select Gender<span class="mand">*</span></label>
                                <p>
                                    <input class="with-gap" name="gender" <?php if(trim($row[ 'Gender'])=='Male' ){ echo "checked";}else { echo "";}?> value="Male" type="radio" id="test1" />
                                    <label for="test1">Male</label>
                                </p>
                                <p>
                                    <input class="with-gap" name="gender" <?php if(trim($row[ 'Gender'])=='Female' ){ echo "checked";}else { echo "";}?> value="Female" type="radio" id="test2" />
                                    <label for="test2">Female</label>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field">
                                <input value="<?php echo $row['JPhone']; ?>" name="JPhone" id="JPhone" type="text" class="validate" maxlength="10" onkeypress="return isNumber()" required readonly>
                                <label>Contact Number<span class="mand">*</span></label>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row showdetails">
                      <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field">
                                <input value="<?php echo $csal_data['alter_no']; ?>" name="alter_no" id="alter_no" id="alter_no" type="text" class="validate" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  maxlength="10" required>
                                <label>Alternative Phone Number<span class="mand">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="input-field">
                                <input value="<?php echo $row['JEmail']; ?>" maxlength="55" name="JEmail" id="JEmail" type="email"  readonly>
                                <label>Personal Email ID<span class="mand">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="row edityear">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                       <label>Exp yrs <span class="mand">*</span></label>
                                        <select class="form-control classic" name="years" id="years">
                                            <option value="0" selected="selected">Years</option>
                                            <?php for($i=1;$i<=25;$i++){?>
                                                <option value="<?php echo $i;?>"<?php if(trim($row['JTotalEy'])==$i){ echo "selected";}else{ echo "";}?>><?php echo $i;?></option>
                                                <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                       <label>Months <span class="mand">*</span></label>
                                        <select class="form-control classic" name="months" id="months">
                                            <option value="0" selected="selected">Months</option>
                                            <?php for($i=0;$i<=11;$i++){?>
                                                <option value="<?php echo $i;?>" <?php if(trim($row['JTotalEm'])==$i){ echo "selected";}else { echo "";}?>><?php echo $i;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6 edityear mt10">
                            <div class="form-group">
                                <label>Preferred Location <span class="mand">*</span></label>
                                <?php 
                               
                                if($row['JPLoc_Id']=='5743')
                                { ?>
                                    <select class="form-control classic" name="Cloc" id="Cloc" required>
                                         <option value="5743">India</option> 
                                    </select>
                               <?php  } else {
                                $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101'ORDER BY Loc_Name";
                                                            $query = mysqli_query($con, $sql);
                                                            if(!$query)
                                                            echo mysqli_error($con);
                                                            ?>
										<select class="form-control classic" name="Cloc" id="Cloc" required>
                                        <option value="" selected> Select Location </option>
										<?php
										while ($row1 = mysqli_fetch_array($query))
                                              { 
                                            extract($row1);
                                             ?>
								<option value="<?php echo $Loc_Id;?>"<?php if(trim($row['JPLoc_Id'])==$Loc_Id){ echo "selected";}else { echo "";}?>><?php echo $Loc_Name;?>				
                                            <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    </div>	
                   
                   <div class="row showdetails">
                        <div class="col-md-3 col-xs-12 col-sm-6">
                                                <div class="input-field">                                                      
                                                <input value="<?php echo $csal_data['CurrentSalL'];?>" name="CSL" id="input-format" maxlength="4" type="text"  class="validate"  onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'">
                                                <label>Current CTC (Lacs) <span class="mand">*</span> </label>
												</div>
                         </div>                  
                              
                        
                        <div class="col-md-3 col-xs-12 col-sm-6">
                         <div class="row">
                              <label>Expected CTC (Lacs)<span class="mand">*</span></label>
				                  <div class="col-md-6 col-md-6">
                                    <div class="form-group">
				                        <input value="<?php echo $csal_data['ExpSalL']; ?>" name="ESL" id="input-format" class="validate"   placeholder="MinSalary"  type="text" maxlength="4"    title="Must Mention MinSalary"  onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                 
                                        </div>
				                 </div>	  
				                  <div class="col-md-6 col-md-6">
									  <div class="form-group"> 					 
                                           <input value="<?php echo $csal_data['ExpMaxSalL'];  ?>" name="EMSL" id="input-format" class="validate" placeholder="Max Salary"    maxlength="4" type="text"  title="Must Mention Max Salary" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                       </div>
                            
                                 </div>              
                          </div>                 
														  
			            </div>			
       							
                            
                        
<div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="form-group">
                               <label>Industry Information <span class="mand">*</span></label>
                                <?php 											
									$sql1 = "SELECT Indus_Id,Indus_Name FROM tbl_industry ORDER By Indus_Name";
									$query1 = mysqli_query($con, $sql1);
									if(!$query1)
									echo mysqli_error($con);
								?>
											<select class="form-control classic" name="industry" id="industry" onChange="check1(this);">
											<option value="0">Select Industry</option>
											<option value="Others">Others</option>
											<?php
											while ($row1 = mysqli_fetch_array($query1))
											{ 
											extract($row1);
											?>
                                            <!--<option value="<?php echo $row1['Indus_Id']; ?>"<?php if(trim($row['Indus_Id'])==$row1['Indus_Id']){ echo "selected";}else { echo "";}?>>
                                                <?php echo $row1['Indus_Name']; ?>
                                            </option>-->
											<option value="<?php echo $row1['Indus_Id']; ?>" <?php if($row1['Indus_Id']==$row['Indus_Id'])echo "selected";?>><?php echo $row1['Indus_Name']; ?></option>
                                            <?php } ?>
										</select>					
                            </div>
								<div id="other-indus" style="display:none;">
																<label><input id="other-inputs" name="newindus" onfocusout="myindus()" style="height:15px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Industry"></input>
																</label>
																</div>
																<script>
																function check1(elem) {																			
																	 if (elem.value == "Others") {
																		document.getElementById("other-indus").style.display = 'block';
																	} else {
																		document.getElementById("other-indus").style.display = 'none';
																	}
																}
																function myindus(){															
																	document.getElementById("other-indus").style.color="blue";
																	  document.getElementById("other-indus").style.font="italic bold 0.5rem arial,serif";

																}</script>
							 </div>	
                       
                        <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                            <div class="form-group">
                               <label>Functional Area<span class="mand">*</span> </label>
                                <?php 											
					$sql2 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea ORDER By Func_Name";
					$query2 = mysqli_query($con, $sql2);
					if(!$query2)
					echo mysqli_error($con);
					?>
                                    <select class="form-control classic" name="functional_area" id="functional_area" onChange="func_check(this);">
                                        <option value="0"  selected> Select Functional Area </option>
										 <option value="Others"> Others </option>
                                        <?php
											while ($row2 = mysqli_fetch_array($query2))
											{ 
											 extract($row2);
											?>
									  <!-- <option value="<?php echo $row2['Func_Id']; ?>" <?php if(trim($row[ 'Func_Id'])==$row2[ 'Func_Id']){ echo "selected";}else { echo "";}?>> <?php echo $row2['Func_Name']; ?>  </option>-->
									  <option value="<?php echo $row2['Func_Id']; ?>" <?php if($row2['Func_Id']==$row['Func_Id'])echo "selected"; else "";?>><?php echo $row2['Func_Name']; ?></option>
									 <?php } ?>
                                    </select>
                            </div>
							<div id="other-func" style="display:none;">
																<label>	<input id="other-funcs" name="newfunc" onfocusout="myfunc()" style="height:15px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Functional Area"></input>
																</label>
																</div>
																<script>
																			function func_check(elem) {	
																		if (elem.value == "Others") {
																		document.getElementById("other-func").style.display = 'block';
																	} else {
																		document.getElementById("other-func").style.display = 'none';
																	}
																}
																function myfunc(){															
																		document.getElementById("other-func").style.color="blue";
																	 document.getElementById("other-func").style.font="italic bold 0.5rem arial,serif";

																}</script>
                        </div>
               
                   </div>
                    <div class="row showdetails ">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="input-field">
                                <textarea id="profile" name="profile" class="materialize-textarea"   maxlength="250" onchange="return txtarea('100','250',this,'Profile Summary')" value="<?php echo $row['profile_summary'];?>"><?php echo $row['profile_summary']; ?></textarea>
                                <label for="textarea1">Profile Summary <span class="mand">*</span></label>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" name="Savedinfo" value="Save" class="btn waves-effect waves-light btn-blue-sm " onclick="return validate()"/>
                           <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a> </div>
                    </div>
                </form>
            </div>
           
            <div id="show-profile-overview">
                <div class="row showdetails ">
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Complete Name</h4>
                            <p>
                                <?php echo $row['JFullName']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Date of Birth </h4>
                            <p>
								<?php if($row['DoB']!=""){ 
                                    $dateb=date_create($row['DoB']);
                             echo date_format($dateb,"M d,Y");}?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Gender</h4>
                            <p>
                                <?php echo $row['Gender']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Contact Number </h4>
                            <p>+91
                                <?php echo $row['JPhone']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row showdetails ">
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Personal Email ID</h4>
                            <p>
                                <?php echo $row['JEmail']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Experience</h4>
                            <p>
                                <?php echo $row['JTotalEy']; ?> Years - <?php echo $row['JTotalEm']; ?> Months
							</p>
                        </div>
                    </div>
                     <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Current CTC (Lacs)</h4>
                            <p>
                                <?php  echo $csal_data['CurrentSalL']; ?>&nbsp;
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Expected CTC (Lacs)</h4>
                            <p>
                                Min: <?php echo $csal_data['ExpSalL'];  ?> - Max: <?php echo $csal_data['ExpMaxSalL']; ?> 
							</p>
                        </div>
                    </div>
                    
                </div>
               
                <?php 
                if($row['JPLoc_Id']=='5743')
                {
                    $locname="India";
                } else
                {
                $qq_loc="select Loc_Name from tbl_location where Loc_Id='".$row['JPLoc_Id']."'";
                       $qq_res=mysqli_query($con,$qq_loc);
                       $loc_data=mysqli_fetch_array($qq_res);
                        $locname=$loc_data['Loc_Name'];
                       }?>
                <div class="row showdetails ">
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Preferred Location</h4>
                               <p><?php 

                               echo $locname;?>
                                </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Notice Period</h4>
                            <p><?php if($csal_data['NoticePeriod']=='1'){ echo "Immediate"; } else { echo $csal_data['NoticePeriod']; ?> days<?php } ?>
                                </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Industry Information</h4>
                            <?php $user_query="select Indus_Name from tbl_industry  where Indus_Id='".$row['Indus_Id']."'";
						 $rr= mysqli_query($con,$user_query); $rrs=mysqli_fetch_array($rr); ?>
                                <p>
                                    <?php echo $rrs['Indus_Name']; ?>
                                </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="block-show ">
                            <h4>Functional Area</h4>
                            <?php $user_query1="select Func_Name from tbl_functionalarea where Func_Id='".$row['Func_Id']."'";
						 $rr1= mysqli_query($con,$user_query1); $rrs1=mysqli_fetch_array($rr1); ?>
                                <p>
                                    <?php echo $rrs1['Func_Name']; ?>
                                </p>
                        </div>
                    </div>
                </div>
                <!--row-->
                <div class="row showdetails">
                    <div class="col-md-12">
                        <div class="block-show ">
                            <h4>Profile Summary</h4>
                            <p class="text-justify ">
                                <?php echo $row['profile_summary']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            
            </div>
      
        </div>
      
        <div class="display-details">
            
            <article class="sub-title">
                <h4 class="pull-left">LANGUAGES <span class="fbold">KNOWN</span></h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="editlangshow()" id="edit-lang-ic"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
            
            <div id="edit-languages-known" class="hide-lang">
                <form method="post" action="general-info.php" name="language-info">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table lang-edittable" id="tbl">
                                <thead>
                                    <td>Language</td>
                                    <td class=" text-center ">Read</td>
                                    <td class="text-center ">Write</td>
                                    <td class="text-center ">Speak</td>
                                    <!--<td class="text-center ">Delete</td>-->
                                </thead>
                                <tbody>
                                    <?php  
						
							  $lang_query="select * from lang_known where JUser_Id='".$row['JUser_Id']."' ";
							  $lang_res= mysqli_query($con,$lang_query); 
							  $lang_count=mysqli_num_rows($lang_res);
						      
							
						 if($lang_count==0)
						 {
								for($ii=1;$ii<=3;$ii++)
                                {	?>
                                            <tr>
                                                <td>
                                                 <div class="form-group">
                                                        
                                                <select name="language<?php echo $ii;?>" id="lang<?php echo $ii;?>" class="form-control classic">
                                                <option value="" disabled="disabled" >Select Language</option>
												<option value="0">Other</option>
                                                        <?php 
                                                        $user_query2="select lan_id,lang_type from tbl_language";
                                                          $lag_result= mysqli_query($con,$user_query2); 
                                                        while($languges=mysqli_fetch_array($lag_result)){ ?>
                                                            <option value="<?php echo $languges['lan_id'];?>" ><?php echo $languges['lang_type'];?></option>
                                                            <?php } ?> 
                                                 </select>
                                                 </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="read<?php echo $ii;?>" id="read<?php echo $ii;?>"/>
                                                    <label for="read<?php echo $ii;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="write<?php echo $ii;?>" id="write<?php echo $ii;?>" />
                                                    <label for="write<?php echo $ii;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="speak<?php echo $ii;?>" id="speak<?php echo $ii;?>" />
                                                    <label for="speak<?php echo $ii;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center"></td>
                                            </tr>
                                            
                                 <?php }

                                  }  else { 
                                      	$x=1;
                                      for($ii=1;$ii<=3;$ii++)
                                      {
										  $lang_data=mysqli_fetch_array($lang_res);
                                      	?>
                                           <tr>
                                                <td>
                                                 <div class="form-group">
                                                        
                                                <select name="language<?php echo $x;?>" id="lang<?php echo $ii;?>" class="form-control classic">
                                                <option value="" disabled="disabled">Select Language</option>
												<option value="0">Other</option>
                                                        <?php 
                                                        $user_query2="select lan_id,lang_type from tbl_language";
                                                          $lag_result= mysqli_query($con,$user_query2); 
                                                        while($languges=mysqli_fetch_array($lag_result)){ ?>
                                                            <option value="<?php echo $languges['lan_id'];?>" 
                                                            <?php if($lang_data['lang_id']==$languges['lan_id']) { echo "selected"; }?>><?php echo $languges['lang_type'];?></option>
                                                            <?php } ?> 
                                                 </select>
                                                 </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="read<?php echo $x;?>" id="read<?php echo $x;?>"  <?php if(trim($lang_data['lang_read'])=='on' ){ echo "checked";}else { echo "";}?>/>
                                                    <label for="read<?php echo $x;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="write<?php echo $x;?>" id="write<?php echo $x;?>" <?php if(trim($lang_data['lang_write'])=='on' ){ echo "checked";}else { echo "";}?>/>
                                                    <label for="write<?php echo $x;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="speak<?php echo $x;?>" id="speak<?php echo $x;?>" <?php if(trim($lang_data['lang_speak'])=='on' ){ echo "checked";}else { echo "";}?>/>
                                                    <label for="speak<?php echo $x;?>">&nbsp;</label>
                                                </td>
                                                <td class="text-center"></td>
                                            </tr>

                                      <?php $x++;} } ?>
							  
                            </table>
                          
                            </div>
                    </div>
                 
                    <div class="row ">
                        <div class="col-md-12">
                            <input type="submit" name="langinfo" value="Save" class="btn waves-effect waves-light btn-blue-sm " onclick="return lang_validation()">
                          
                        </div>
                    </div>
                </form>
            </div>
           
            <div id="show-languages-known">
                <div class="row showdetails">
                    <?php 
						
					 $user_queryl="select * from lang_known where JUser_Id='".$row['JUser_Id']."' ";
						 $rrlk= mysqli_query($con,$user_queryl); 
							while($rlk=mysqli_fetch_array($rrlk)){	
								$user_query1="select lan_id,lang_type from tbl_language where lan_id='".$rlk['lang_id']."'";
						        $rrl= mysqli_query($con,$user_query1); 
						        $rrl1=mysqli_fetch_array($rrl);?>
                        <div class="col-md-3 col-sm-6">
                            <div class="block-show">
                                <h4>
                                <?php 
                                echo $rrl1['lang_type'];
                            ?>
                                </h4>
                                <p class="lang-all">
                               <?php if(trim($rlk['lang_speak'])=='on'){?> <span> <?php echo "Speak";?></span><?php } ?>
                            <?php if(trim($rlk['lang_write'])=='on'){?> <span><?php  echo "Write"; ?></span><?php }?>
                             <?php if(trim($rlk['lang_read'])=='on'){?> <span><?php  echo "Read"; ?></span><?php }?>
                                </p>
                            </div>
                        </div>
                        <?php 
						 }?>
                </div>
               
            </div>
           
        </div>
        <div class="display-details">
          
            <article class="sub-title">
                <h4 class="pull-left">PASSPORT <span class="fbold">DETAILS</span></h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="editpp()"><i class=" fa fa-pencil-square-o " aria-hidden="true" id="ppic"></i></a> </article>
          
            <?php 	$sql3 = "SELECT * FROM tbl_passport where JUser_Id='".$row['JUser_Id']."'";
					$query3 = mysqli_query($con, $sql3);
					$row3 = mysqli_fetch_array($query3);
                   
					?>
                <div id="editpp" class="hide-details">
                    <form action="general-info.php" method="POST">
                        <div class="row">
                            <div class="col-md-3 col-xs-12 col-sm-6">
                                <div class="input-field">
                                  
									<input id="txtpno" type="text" value="<?php echo $row3['Number']; ?>"name="txtpno" placeholder="N5522767" pattern="\w\d\d\d\d\d\d\d" class=" validate masked" data-charset="_XXXXXXX" title="click">									
									<script src="js/masking-input.js" data-autoinit="true"></script>									
                                </div>
                            </div>
							
                            <div class="col-md-3 col-xs-12 col-sm-6 dtfield">
                                <div class="input-field input-fieldnew">
                                <?php if($row3['DoI']!=""){ $datei=date_create($row3['DoI']);
                                    $dt= date_format($datei,"d-m-Y"); } ?>
                                   <label>Date of Issue</label>
                                    <input value="<?php echo $dt; ?>" type="text" class="datepicker1" name="txtDOI" id="txtDOI" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;">
                                    
                                </div>
                            </div>
						<script>
							$('.datepicker1').pickadate({
                                    selectMonths: true, 
                                    selectYears: 70, 
                                    max:new Date(),
                                    format: 'dd-mm-yyyy' });
	                       </script>
                            <div class="col-md-3 col-xs-12 col-sm-6 dtfield">
                                <div class="input-field input-fieldnew">
                               <?php if($row3['DoED']!=""){ $dated=date_create($row3['DoED']);
                                    $dtt= date_format($dated,"d-m-Y"); } ?>
                                    <label>Date of Expiry</label>
                                    <input value="<?php echo $dtt; ?>" type="text" class="datepicker2" name="txtDOE" id="txtDOE" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;" >
                                   
                                </div>
                            </div>
							<script>	$('.datepicker2').pickadate({
                                selectMonths: true, 
                                  selectYears: 70,
                            format: 'dd-mm-yyyy' });
	                     </script>
                            <div class="col-md-3 col-xs-12 col-sm-6 mt10">
                                <div class="form-group">
												   <label>Place of Issue </label>
													<?php 											
								 $sql1 = "SELECT Loc_Id,Loc_Name FROM tbl_location ORDER BY Loc_Name";
									$query1 = mysqli_query($con, $sql1);
									if(!$query1)
									echo mysqli_error($con);
									?>
														<select class="form-control classic" name="PLocation" id="PLocation">
															<option value="" selected> Select Location </option>
															<?php
									while ($row1 = mysqli_fetch_array($query1))
									{ 
									 extract($row1);
									?>
																<option value="<?php echo $row1['Loc_Id']; ?>" <?php if(trim($row3['Loc_Id'])==$row1['Loc_Id']){ echo "selected";}else { echo "";}?>><?php echo $row1['Loc_Name']; ?>
																</option>
																<?php } ?>
														</select>
								</div>
                            </div>
							<div class="col-md-3 col-xs-12 col-sm-6 mt10">
                                <div class="form-group">
							      <label>Resident of</label>
									<?php 											
									$sql1 = "SELECT Cntry_Id,Cntry_Name FROM tbl_country ORDER BY Cntry_Name";
									$query1 = mysqli_query($con, $sql1);
									if(!$query1)
									echo mysqli_error($con);
									?>
								<select class="form-control classic" name="RCountry" id="RCountry">
									<option value="0" selected disabled> Select Country </option>
									<?php while ($row1 = mysqli_fetch_array($query1))
									{ 
									?><option value="<?php echo $row1['Cntry_Id']; ?>" <?php if(trim($row['Jcitizen'])==$row1['Cntry_Id']){ echo "selected";}else { echo "";}?>><?php echo $row1['Cntry_Name']; ?></option>
								    <?php } ?>
								</select>														
								</div>
                            </div>
							
								<div class="col-md-6 col-xs-6 col-sm-6 mt15 custom-btn">
											<div>
												<?php
												$sql1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
												$result1 = mysqli_query($con,$sql1);
												$data1=mysqli_fetch_array($result1);
												$skills1 = explode(',',$data1['JCauthorised']);
												foreach($skills1 as $ii){
												$q2 = "SELECT * FROM tbl_country WHERE Cntry_Id ='".$ii."'";
												$r2 = mysqli_query($con,$q2);
												$res2 = mysqli_fetch_array($r2);
												$skillsArr[] = $res2['Cntry_Id'];
												}
												?>                      						                          
												<div class="form-group auth-country">
												
													<?php 
													$ms_sql="select * from tbl_country Order By Cntry_Name";
														   $ms_result = mysqli_query($con,$ms_sql);
														   ?>
													<label>Authorized to Work</label>
													<select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true"  name="acountry[]" id="acountry">   
													<?php while ($ms_data = mysqli_fetch_array($ms_result)) { ?> 

													<option value="<?php echo $ms_data['Cntry_Id']; ?>" <?php if (in_array($ms_data['Cntry_Id'],$skillsArr)){ echo 'selected'; } ?> > <?php echo $ms_data['Cntry_Name']; ?>

													</option>
													<?php } ?>
													
													</select>
												</div>
											</div>
								</div>
						
                        <script>
                         var last_valid_selection = null;
                            $('#acountry').change(function(event) {
                                if ($(this).val().length >3) {
                                alert('You can only choose 3 Country !');
                                $(this).val(last_valid_selection);
                                } else {
                                last_valid_selection = $(this).val();
                                }
                            });                             
                        </script>
                       					
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <button class="btn waves-effect waves-light btn-blue-sm " type="submit" name="submitpsp" onclick="return validatepsp()">Save</button>
                               
                            </div>
                        </div>
                    </form>
                </div>
               
              <?php $ss = "SELECT * FROM tbl_passport where JUser_Id='".$row['JUser_Id']."'";
                    $qs = mysqli_query($con, $ss);
                   $p_cnt=mysqli_num_rows($qs);?>
                <div id="showpp">
                <?php if($p_cnt!='0'){ ?>
                    <div class="row showdetails ">
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Passport Number</h4>
                                <p style="text-transform:uppercase">
                                    <?php echo $row3['Number']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Date of Issue</h4>
                                <p>
									<?php if($row3['DoI']!=""){ $datei=date_create($row3['DoI']);
									echo date_format($datei,"M d,Y"); } ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Date of Expiry</h4>
                                <p>
									<?php if($row3['DoED']!=""){ $datex=date_create($row3['DoED']);
									echo date_format($datex,"M d,Y"); } ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Place of Issue</h4>
                                <?php $user_query1="Select Loc_Name from tbl_location where Loc_Id='".$row3['Loc_Id']."'";
						        $rr1= mysqli_query($con,$user_query1); $rrs1=mysqli_fetch_array($rr1); ?>
                                    <p>
                                        <?php echo $rrs1['Loc_Name']; ?>
                                    </p>
                                  
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
							  <div class="block-show ">
								<h4>Resident Of Country</h4>                                  
								<?php $acountry="Select Cntry_Name from tbl_country where Cntry_Id='".$row['Jcitizen']."'";
								 $ac1= mysqli_query($con,$acountry); $acc1=mysqli_fetch_array($ac1); ?>									
								 <p><?php if($acc1['Cntry_Name']!="") echo $acc1['Cntry_Name']; else echo"None";?></p>
							  </div>
						</div>
					<div class="col-md-6 col-sm-6">
						<div class="block-show auth_count">
                        <h4>Authorized to Work</h4>                       
							<?php 
							   $sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$_SESSION['userSession']."'";
							   $result = mysqli_query($con,$sql);
							   $row1 = mysqli_fetch_array($result);
							   $acountry=$row1['JCauthorised'];
							   $acountryid=explode(",",$acountry );
                             
                               $count=count(array_filter($acountryid));						
							if($count!=0)
                             {
                                $q=1;
                               foreach($acountryid as $acountryids)  { ?>         
						<?php 
                                $ms_sql1="select Cntry_Id,Cntry_Name from tbl_country where Cntry_Id=".$acountryids;
                                $ms_result1 = mysqli_query($con,$ms_sql1);
                                $ms_data1 = mysqli_fetch_array($ms_result1);								
                        ?> 
						<span><?php echo $ms_data1['Cntry_Name']; if($count==$q){ break;} ?>,</span>
                           <?php $q++;  }  
                           }
                           else { ?>                          
                               <p>None</p>                               
                           <?php  }
                            ?>  
						</div>
					</div>
 
                    </div>
                   
                   <?php } else {?>
                         No Details
                   <?php } ?>
                </div>
                
               
        </div>
       


	<script lang="javascript">
	
function validate()

{
	
	var name=document.getElementById('full_name').value;
	if(name=="")
	{
		alert("Please Enter Full Name");
		document.getElementById('full_name').focus();
            		return false;
		
	}
	var dob=document.getElementById('date').value;
	if(dob=="")
	{
		alert("Please Select DOB");
		document.getElementById('date').focus();
            		return false;
		
	}
            
	var phone=document.getElementById('JPhone').value;
	if(phone=="")
	{
		alert("Please Enter Phone Number");
		document.getElementById('JPhone').focus();
            		return false;
		
	}
	var radiosgender = document.getElementsByName("gender");
			var Gender = false;

			var i = 0;
			while (!Gender && i < radiosgender.length) {
        if (radiosgender[i].checked) Gender = true;
        i++;        
				}

			if (!Gender) 
			{alert("Please Select Gender Type !");
				return Gender;
				}
		var alnum=document.getElementById('alter_no').value;
            	if(alnum=='')
            	{
            		alert("Please Enter Alternative Number");
            		document.getElementById('alter_no').focus();
            		return false;
            	}
				
				if(alnum.length!=10)
				{
					alert("Please Enter Valid Alternate Mobile Number");
            		document.getElementById('alter_no').focus();
            		return false;
				}
				var exp=document.getElementById('years').value;
				var expmon=document.getElementById('months').value;
            	if(exp=="0"&&expmon=="0")
            	{
            		alert("Please Enter Experience");
            		document.getElementById('years').focus();
            		return false;
            	}
            	var Ploc=document.getElementById('Cloc').value;
			var cloc="<?php echo $csal_data['Loc_Id'];   ?>";
			
            	if(Ploc=='')
            	{
            		alert("Please Select Preferred Location");
            		document.getElementById('Cloc').focus();
            		return false;
            	}
			if(cloc==Ploc)
			{
				alert("Preferred Location and Current Location Can't be Same");
            		document.getElementById('Cloc').focus();
            		return false;
			}
			
			
		
			
			
			
			
			
			
			
			
			

	
	var indus=document.getElementById('industry').value;
            	if(indus==0)
            	{
            		alert("Please Select Industry Type !");
            		document.getElementById('industry').focus();
            		return false;
            	}
	
 							  
	
	var func_area=document.getElementById('functional_area').value;
            	if(func_area=='0')
            	{
            		alert("Please Select Functional Area Type !");
            		document.getElementById('functional_area').focus();
            		return false;
            	}
				ps=document.getElementById('profile').value;
				pslength=ps.length;
				if(pslength==0)
				{
					alert("Please Enter Profile Summary");
					document.getElementById('profile').focus();
					return false;
					
				}
				
	else return true;
}
function validatepsp()
{
	var passportnum=document.getElementById('txtpno').value;
	if(passportnum=='')
	{
		alert("Please Enter Passport Number");
		return false;
	}
         else if(passportnum!='')
            	{
            		
					var pspdoi=document.getElementById('txtDOI').value;
					
					if(pspdoi=="")
            	{
            		alert("Please Select Date of Issue");
            		document.getElementById('txtDOI').focus();
            		return false;
            	}

				 var f1 = new Date(pspdoi);
				var fpspdoi = f1.toLocaleDateString();
				var datepspdoi = fpspdoi.split('-');
				 var passdoi = pspdoi.split('-');
                var pass_doi = new Date(passdoi[2], passdoi[1]-1, passdoi[0]); 
                 var datedoi = pspdoi;
                var datenow = new Date();
			
					var pspdoe=document.getElementById('txtDOE').value;
					var f2 = new Date(pspdoe);
				    var fpspdoe = f2.toLocaleDateString();
					var passdoe = pspdoe.split('-');
			
                var pass_doe = new Date(passdoe[2], passdoe[1]-1, passdoe[0]); 
				    var datepspdoe = fpspdoe.split('-');
				
				
				var diffYear=pass_doe.getFullYear()-pass_doi.getFullYear();
				var diffDate=pass_doe.getDate()-pass_doi.getDate();
				var diffMonth=pass_doe.getMonth()-pass_doi.getMonth();
                    var datedoe = pspdoe;
					if(pspdoe=="")
            	   {
            		alert("Please Select Date of expiration");
            		document.getElementById('txtDOE').focus();
            		return false;
            	    }
			
                     if(pspdoi == pspdoe)
					{
						alert("Date Of Issue & Date Of Expiry can't be same");
            		    document.getElementById('txtDOE').focus();
            		    return false;
					}
					var dates_array=[-1,29,30];
	
					var indexDate=dates_array.indexOf(diffDate);
					if(indexDate == 1 || indexDate==2)
					{
						diffMonth=0;
					}
					if(diffYear!=10 || diffMonth!=0 || indexDate<0)
					{
						alert("Please Select Valid Date of Expiry");
            		    document.getElementById('txtDOE').focus();
            		    return false;
					}

					var pspplace=document.getElementById('PLocation').value;
					
					if(pspplace=="")
            	{
            		alert("Please Select Passport Issue Location");
            		document.getElementById('PLocation').focus();
            		return false;
            	}
					
            	}
				else 
					return true;
}
function lang_validation()
{
    var lang1=document.getElementById('lang1').value;
   
    var lang2=document.getElementById('lang2').value;
  
    var lang3=document.getElementById('lang3').value;
 
  
    if(lang1== "1" || lang2== "1" || lang3== "1")
    {
		if(lang1== "1")
		{
			var read=document.getElementById('read1');
			var write=document.getElementById('write1');
			var speak=document.getElementById('speak1');
			if(!read.checked && !write.checked && !speak.checked)
			{
				alert("Please select an option");
				return false;
			}
		}
		if(lang2== "1")
		{
			var read=document.getElementById('read2');
			var write=document.getElementById('write2');
			var speak=document.getElementById('speak2');
			if(!read.checked && !write.checked && !speak.checked)
			{
				alert("Please select an option");
				return false;
			}
		}
		if(lang3== "1")
		{
			var read=document.getElementById('read3');
			var write=document.getElementById('write3');
			var speak=document.getElementById('speak3');
			if(!read.checked && !write.checked && !speak.checked)
			{
				alert("Please select an option");
				return false;
			}
		}
		
        return true;
    }
    else
    {
           alert("English is mandatory");
        document.getElementById('lang1').focus();
        return false;
    }
}
</script>