<div class="display-features reasonatt">
  
    <div class="row">
   
    <div class="display-details">
       
        <article class="sub-title">
            <h4 class="pull-left">Reasons to Relocate</h4> </article>
       
        <div>
         
			<?php 
				$jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$_SESSION['userSession'];
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);
?>
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Reason Type</h4>
                        <p><?php echo $jrow['jReasonType']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
					
                        <h4>Reason Document</h4>
						<?php $jr1=explode(",",$jrow['JReasonAttach']);
                              $jr1_cnt=count(array_filter(($jr1)));?>
                        <p class="attachments">
					<?php	
                    if($jr1_cnt!="0")
                    {
                    foreach ($jr1 as $value) {?>
   <a href="<?php echo $value; ?>" download><i class="fa fa-download" aria-hidden="true"></i> Download Reason</a>
<?php } 
} else { ?>
No Attached Documents
<?php } ?>
						</p>
                    </div>
                </div>
            
                 
            </div>
            
            <div class="row showdetails ">
                <div class="col-md-12 ">
                    <div class="block-show ">
                        <h4>Reason Description</h4>
                        <p class="text-justify "> <?php echo $jrow['jReasonSummary']; ?></p>
                    </div>
                </div>
            </div>
          
        </div>
        
    </div>
   
   
    </div>
   
</div>      
  