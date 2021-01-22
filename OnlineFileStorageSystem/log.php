<?php
session_start();
$baseurl="http://localhost/OnlineFileStorageSystem/";
$name = $_POST['uname'];
$password = $_POST['pass'];
$con = mysqli_connect("localhost","user","password");
if (!($con))
{
	die("error while connecting to the database");
}
else
{
	print("<br />");
}

$errmsg_arr = array();
$errflag = false;
if($name== '') 
{
	$errmsg_arr[] = 'Login ID missing';
	$errflag = true;
}
if($password== '') 
{
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
}
if($errflag)
 {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		echo 'Password or Username must be filled out';
	
		echo "<br><a href='http://localhost/OnlineFileStorageSystem/log.html'>Login failed</a>";
		exit();
}
$db = mysqli_select_db($con,"login");
$qry="SELECT * FROM log_detail WHERE Username='$name' AND Password='$password'";

if($result=mysqli_query($con,$qry)) 
{
if(mysqli_num_rows($result) > 0)
		 {
			
			session_regenerate_id();
			$_SESSION['name'] = $name;
			$_SESSION['pass'] = $password;
			session_write_close();
			
                                                    echo "<a href='http://localhost/OnlineFileStorageSystem/'>Click here to continue</a>";
			exit();
		}
		else 
		{
			//Login failed
			print "Wrong Username/Password";
			echo "<br><a href='http://localhost/OnlineFileStorageSystem/log.html'>Login Failed</a>";
			exit();
		}
	}
	else 
	{
		die("Query failed");
	}

?>
