<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u Join tbl_currentexperience exp on u.JUser_Id=exp.JUser_Id
							  Join  tbl_education edu on  exp.JUser_Id=edu.JUser_Id 
                              

                              WHERE u.JUser_Id=:10");
$stmt->execute(array(":10"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Persona</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <header class="personaHeader">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="#" href="#"><h2><?php echo $row['JFullName']; ?><!--Ramesh Garikamokkala--></h2></a>
        </div>
      </div>
    </nav>
  </header>
  <!---Header Ends--->
  <!---Seacond start-->
  <section>
    <div class="container-fluid personaContent">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-4 col-sm-4 col-xs-4">
		   


		  <div class="imgContent">
		    <ul class="mainContent">
			   <li><?php 
						echo $row['DoB'];?><!--Age--></li>
			   <li> </li>
			   <li><?php echo $row['NoticePeriod']?> <!--days-->
        <!-- Status--></li>
				<li><?php 
                                                   
                                                echo $row['Loc_Id'] ?><!--Location--></li>
				<li><!--Contact No-->+91 <?php echo $row['JPhone']; ?></li>
			</ul>
		  </div>
        </div>
		
        <div class="col-md-4 col-sm-4 col-xs-4">
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
            <h4>Personal Information</h4>
          </div>
          <div class="form">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email"  value="<?php echo $row['JEmail']; ?>" class="form-control" id="inputEmail4" placeholder="Personal Email Id">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="experience" class="form-control" id="inputPassword4" placeholder="Experience" value="<?php echo $row['JTotalEy']; ?> -<?php echo $row['JTotalEm']; ?>" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Current CTC (Lacs)" value="<?php echo $row['CurrentSalL']; ?>]"> 
                                                
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Expected CTC (Lacs)" value=" Min: <?php echo $row['ExpSalL'];  ?> - Max: <?php echo $row['ExpMaxSalL']; ?> ">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Preferred Location" value= "<?php echo $row['locname'];?>">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Notice Period" value="<?php echo $row['NoticePeriod']?> <!--days-->>
     
                </div>
				 <div class="form-group col-md-12 col-sm-12 col-xs-12">
                  <textarea class="form-control" rows="2" id="comment" placeholder="ProfileSummary" value=" <?php echo $row['profile_summary']; ?>"></textarea>
                </div>	
                 	<div class="form-group col-md-12 col-sm-12 col-xs-12">
				  <button type="button" class="btn btn-success pull-right">more</button>
				 </div> 
              </div>			
            </form>
			
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">		
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
            <h4>Professional Experience</h4>
          </div>
          <div class="form2">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Name Of Organisation" value="<?php echo $row['Company_Name'];?>">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Designation" value="<?php echo $row['Des']; ?>">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                 <input type="email" class="form-control" id="inputEmail4" placeholder="Date of Joining" value="<?php echo $row['doJ'];?>">
							
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Date of Relieved" value="<?php $date=date_create($row1['dor']);
						     echo date_format($date,"M d,Y");?>">
						
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Location" 
				                                      <?php 

                                                    echo  $row['Loc_Id']; ?>
                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Roles & Responsibilites" value="<?php echo $row['Func_id']; ?>">
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
                  <textarea class="form-control" rows="2" id="comment" placeholder="Description" value="<?php echo $row['JDesc']; ?>"></textarea>
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
				 <button type="button" class="btn btn-success pull-right">More</button>
				 </div>
              </div>
            </form>
          </div>
        </div>
		 <div class="col-md-4 col-sm-4 col-xs-4">
         <div class="keyContent">		 
			  <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Skills</h4>
			  </div>
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="keySkillsContent">
				    <?php   
                           echo $row['pri_skills']                                                 
                         ?>
                    
                        
                          
		
				</div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
				</div>
			  </div>
		  </div>
		  <div class="markspercantage">
		         <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Qualification</h4>
			  </div>
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="keySkillsContent">
				   <div id="wrapper" class="center">
				   <div class="col-md-4 col-sm-6 col-xs-12">
						<svg class="progress blue noselect" data-progress="55" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0%</text>
							
						</svg>
						</div>
						 <div class="col-md-4 col-sm-6 col-xs-12">
						<svg class="progress green noselect" data-progress="100" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0%</text>
							
						</svg>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
						<svg class="progress green noselect" data-progress="100" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0%</text>
							
						</svg>
                         </div>
				</div>
				</div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
				</div>
			  </div>
		  </div>
        </div>
          <div class="col-md-4 col-sm-4 col-xs-4">		
			  <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Address Information</h4>
			  </div>
			  <div class="form3">
				<form>
				   <div class="form-group col-md-12 col-sm-12 col-xs-12">
					  <textarea class="form-control" rows="2" id="comment" placeholder="Address"></textarea>
					</div>
					 <div class="form-group col-md-12 col-sm-12 col-xs-12">
					  <textarea class="form-control" rows="2" id="comment" placeholder="Reason To Relocate" value="<?php echo $row['jReasonType']; ?>"></textarea>
					</div>
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
					 </div>
				</form>
			  </div>
          </div>
		    		  
      </div>
    </div>
	<!------seacond row------>
	
	  <!----second row ends--->
    </div>
    </div>
  </section>
</body>
<script>
var forEach = function (array, callback, scope) {
	for (var i = 0; i < array.length; i++) {
		callback.call(scope, i, array[i]);
	}
};
window.onload = function(){
	var max = 2160;
	forEach(document.querySelectorAll('.progress'), function (index, value) {
	percent = value.getAttribute('data-progress');
		value.querySelector('.fill').setAttribute('style', 'stroke-dashoffset: ' + ((100 - percent) / 100) * max);
		value.querySelector('.value').innerHTML = percent + '%';
	});
}
</script>
</html>