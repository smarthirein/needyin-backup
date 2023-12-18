<?php
/*$con = mysqli_connect("localhost","needyin","Hl7w3&p0");
mysqli_select_db($con, "needyin_");*/
$con2 = mysqli_connect("localhost","root","N@edy1n.C0m_D");
mysqli_select_db($con2, "needyin_phase2_dev");
$con = mysqli_connect("localhost","root","N@edy1n.C0m_D");
mysqli_select_db($con, "ni_screening_db");
$digital_ocean= mysqli_connect("localhost","root","N@edy1n.C0m_D");
mysqli_select_db($digital_ocean,"needyin_phase2_dev");

session_start();
define('CVFULL_PATH','/var/www/dev.needyin.com/html/multiresume-uploader/virtualenvironment/project_1/uploads');
define('CV_PATH','multiresume-uploader/virtualenvironment/project_1/uploads/');

define('PRO_PATH','/var/www/dev.needyin.com/html/');   
$siteurl = "http://dev.needyin.com";
class Database
{

	/* private $host = "localhost";
    private $db_name = "needyin_";
    private $username = "needyin";
    private $password = "Hl7w3&p0"; */ 
     private $host = "localhost";
     private $db_name = "ni_screening_db";
    // private $db_name = "needyin_phase1_dev";
    private $username = "root";
    private $password = "N@edy1n.C0m_D";
	 private $db_name_2 = "needyin_phase2_dev";
    private $username_2 = "root";
    private $password_2 = "N@edy1n.C0m_D";
    public $conn;   
	public $conn_phase2;
    public function dbConnection()
	{
        $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }         
        return $this->conn;
    }
	public function dbConnectionPhase2()
	{
        $this->conn_phase2=null;
        try
		{
            $this->conn_phase2= new PDO("mysql:host=localhost;dbname=".$this->db_name_2, $this->username_2, $this->password_2);
            $this->conn_phase2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }         
        return $this->conn_phase2;
        echo 'connected';
    }
}
?>
