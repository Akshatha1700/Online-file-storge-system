<?php
session_start();
$baseurl='http://localhost/OnlineFileStorageSystem/';
$username = $_SESSION['name'];
$password = $_SESSION['pass'];
if(!file_exists("uploads"))
	mkdir("uploads");
?>

<!DOCTYPE html>
<html>
    <head>
        
        <title>PHP File Storage</title>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
        <script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&display=swap" rel="stylesheet">
        
        <style>
       body{
                    background: url(adminbg.jpg) no-repeat fixed center; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover; 
                    color: white;
                }
            body{
                
                margin: 0;
                font-family: 'Dosis', sans-serif;
            }
            
            input{
                padding: 10px;
                margin-bottom: 5px;
                margin-top: 5px;
                border-radius: 10px;
                border: none;
                outline: none;
            }
            
            input[type=submit]{
                cursor: pointer;
                background-color: lime;
                font-weight: bold;
            }
            
            label{
                display: block;
            }
            
            h1, h2, h3, h4, h5, p{
                margin: 0;
                margin-bottom: 15px;
            }
            
            .filethumb{
                display: inline-block; vertical-align: top; text-align: center;
                width: 96px;
                border: 2px solid white;
                border-radius: 10px;
                margin: 20px;
                padding: 10px;
                transition: border .5s;
                
            }
            
            .filethumb:hover{
                border: 2px solid lime;
            }
            
            a{
                color: inherit;
                text-decoration: none;
            }
            
            .alert{
                padding: 15px;
                background-color: black;
                border-radius: 5px;
                margin: 30px;
                color: white;
                font-weight: bold;
                position: fixed;
                left: 0;
                bottom: 0;
            }
            
            .uploadform{
                padding: 20px;
                border: 2px solid white;
                border-radius: 10px;
                background-color: black;
                display: inline-block;
                transition: border .5s;
                margin: 20px;
                margin-top: 75px;
            }
            
            .uploadform:hover{
                border: 2px solid lime;
            }
            
            #topribbon{
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                background-color: black;
            }
            
            .tritem{
                display: inline-block;
                padding: 10px;
            }
            
            .tritem:hover{
                background-color: #171717;
            }
            
            .contentwrapper{
                padding: 10px;
            }
        </style>
        
    </head>
    <body>

<div id="topribbon">
                    <a href="<?php echo $baseurl ?>"><div class="tritem"><i class="fa fa-home"></i> Home</div></a>
                    <a href="<?php echo $baseurl ?>?filestorage"><div class="tritem"><i class="fa fa-archive"></i> File Storage</div></a>
                    <a href="<?php echo $baseurl ?>?logout"><div class="tritem"><i class="fa fa-sign-out"></i> Sign Out</div></a>
</div>

<div class="contentwrapper">
<?php
if(isset($_GET["filestorage"]))
{
	?>
	<h1>File Storage</h1>
	<?php
	if(isset($_POST["submitfile"]))
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["newfile"]["name"]);
		move_uploaded_file($_FILES["newfile"]["tmp_name"], $target_file);
	}
	if(isset($_GET["delete"]))
	{
		if(file_exists("uploads/" . $_GET["delete"]))
		{
			unlink("uploads/" . $_GET["delete"]);
			echo "<div class='alert'>File is deleted successfully.</div>";
		}
	}
	$dirpath = "uploads/*";
	$files = array();
	$files = glob($dirpath);
	usort($files, function($x, $y)
	{
		return filemtime($x) < filemtime($y);
	});
	echo "<div>";
	foreach($files as $item)
	{
		echo "<div class='filethumb'>";
		//echo "<div>" . $item . "</div>";
		echo "<a href='" .$item. "' target='_blank'><div><i class='fa fa-file' style='font-size: 40px;'></i></div>";
		echo "<div>" . str_replace("uploads/", "", $item) . "</div></a>";
		echo "<a href='?filestorage&delete=" .str_replace("uploads/", "", $item). "'><div style='color: red; margin-top: 20px; font-size: 10px;'><i class='fa fa-trash'></i> Delete</div></a>";
		echo "</div>";
	}
	if(count($files) == 0)
	{
	?>
		<p>You have no file here. Try to begin uploading using the upload form at the bottom of this page.</p>
	<?php    
	}
	echo "</div>";
	?>
	<div class="uploadform">
	<form method="post" enctype="multipart/form-data">
	<label><i class="fa fa-file"></i> Upload new file</label>
	<input class="fileinput" name="newfile" type="file">
	<input name = "submitfile" type="submit" value="Upload">
	</form>
	</div>
	<?php
	}
	else if(isset($_GET["logout"]))
	{
	session_destroy();
	?>
	<h1>Sign out</h1>
	<p>You are signed out. Good bye!</p>
	<script>
	setTimeout(function()
	{
		location.href = "http://localhost/OnlineFileStorageSystem/log.html";
	}, 2500);
	</script>
	<?php
}
else
{
?>
	<h1>Home</h1>
                  <p>This is the home page of the Online File Storage System Website.</br> This website allows you to store your data and access it whenever required.</br> You also have the 	option to be able to download the files that are stored or even delete it.</br></br>Don't forget to sign out after the required job is done!</br></br></br>
	<h3 align='center'>Thank you!</h3>
	</br></br></br></br></br></br></br></br></br></br></br></br>  
	</p>
                  <?php
}
?>
</div>
<script>
setTimeout(function()
{
	$(".alert").fadeOut();
}, 2500);
</script>
</body>
</html>