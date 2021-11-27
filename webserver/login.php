<?php
   include_once("config.php");
   session_start();
   global $error;
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT user_id, previlege FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $user_previlege = $row['previlege'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         
         $_SESSION['login_user'] = $myusername;
		 $_SESSION['previlege'] = $user_previlege;
		 
         if($user_previlege=="dbadmin"){
             header("location:db_management/db_home");
         }
         else{
             header("Location:home_page");
         }
         
         
      }else {
         $error = "Your Username or Password is incorrect";
      }
   }
?>

<!--DOCTYPE-->
<html>
   <title>SFSL Data Portal</title>
   <head>
       <meta charset = "utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
       
        <style type = "text/css">
         body {
            font-family: Arial, "Helvetica", sans-serif;
            font-size:24px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:green solid 1px;
         }
		 .btn {
			 border:green solid 1px;
		 }
        </style>
<style>
    /* For device width smaller than 800px: */
    @media only screen and (max-device-width: 800px)
    body {
        background-image: url('data/cropped_small_bg.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        }
        /* For device width 801px and larger: */
    @media only screen and (min-device-width: 801px) {
    body { 
        background-image: url('data/image/iot_bg.jpg'); 
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
</style>

</head>
   
<body bgcolor = "#FFFFFF">

        
        <div id = "container"; align = "center">
            <div style = "position:relative; margin:15%">
            <div style = "width:320px; border: solid 1px green;align:center">
            <div style = "background-color:green; color:#FFFFFF; padding:3px"><b>SFSL Data Portal Login</b></div>
            
			<div style = "margin:30px;align:center">
             
               <form action = "" method = "post">
                <div id = "leftside"; align = "left"> 
                  <label>Username </label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password </label><input type = "password" name = "password" class = "box" /><br/><br />
                  </div>
                  <div align = "right">
                  <input type = "submit" value = "Login" class="btn"/><br/>
                  </div>
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
            </div>
            </div>
        </div>
   </body>
</html>