<div class="display-features">
    <!-- Post Graduation-->
	<?php $sql1 = "SELECT * FROM tbl_education where JUser_Id='".$JUser_Id."' ORDER BY  YearPassed DESC ";
			$query1 = mysqli_query($con, $sql1);
			while($row1 = mysqli_fetch_array($query1)){
				 $sql2 = "SELECT Qual_Name FROM tbl_qualification where Qual_Id='".$row1['Qual_Id']."' ";
					$query2 = mysqli_query($con, $sql2);
					$row2 = mysqli_fetch_array($query2);
					$Edu_Id=$row1['Edu_Id'];
				?>
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">
			<span class="fbold"><?php echo $row2['Qual_Name'];?></span></h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
        <div>
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Degree</h4>
                        <p><?php echo $row2['Qual_Name'];?></p>
                    </div>
                </div>				               
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Specialization Type </h4>
								<p>
								<?php $sql4 = "SELECT Speca_Id,Speca_Name FROM tbl_specialization WHERE Speca_Id='".$row1['Speca_Id']."'";
								$query4 = mysqli_query($con, $sql4);
								$row4 = mysqli_fetch_array($query4); echo $row4['Speca_Name'];?>
                                </p>	
								 <p><?php echo $row1['grade']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Name of School / University </h4>
                        <p><?php $sql3 = "SELECT University_Name FROM tbl_university where University_Id='".$row1['University_Id']."'";
					$query3 = mysqli_query($con, $sql3);
					$row3 = mysqli_fetch_array($query3); echo $row3['University_Name'];?></p>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Year of Passing</h4>
                        <p><?php echo $row1['YearPassed']; ?></p>
                    </div>
                </div>
            </div>
            <!--/row-->
            <!--row-->
            <div class="row showdetails ">
               
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Percentage</h4>
                        <p><?php echo $row1['Percentage']; ?>%</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="block-show ">
                        <h4>Full time / Part time</h4>
                        <p><?php echo $row1['partfulltime']; ?></p>
                    </div>
                </div>
            </div>
            <!--/row-->
        </div>
        <!-- show details -->
        <!--/ display details show-->
    </div>
	<?php  }?>
    <!--/ Post Graduation -->
  
    <!--/graduation-->
</div>