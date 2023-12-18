<?php
// $con = mysqli_connect("localhost","needyin","Hl7w3&p0");
// mysqli_select_db($con, "needyin_");

$con = mysqli_connect("localhost","root","N@edy1n.C0m_D");
mysqli_select_db($con, "ni_screening_db");
$con2 = mysqli_connect("localhost","root","N@edy1n.C0m_D");
mysqli_select_db($con2, "needyin_phase2_dev");

?>
<?php

// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// $sql = "SELECT emp_id FROM tbll_emplyer limit 1";
// $result = mysqli_query($con, $sql);
// if (mysqli_num_rows($result) > 0) {
//     while($row = mysqli_fetch_assoc($result)) {
//         print_r('emp_id is:');
//         print_r($row['emp_id']);
//     }
// } else {
//     echo "0 results";
// }
// $con->close();
?>