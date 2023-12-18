<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if(!$user->is_logged_in())
{
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{
	$user->logout();	
	if($_GET['msg']!="")
	{
			$user->redirect('index.php?msg=dnd');
	} else 
	{
	$user->redirect('index.php');
    }
}

?>