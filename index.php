<?php
	echo "";
?>
<!DOCTYPE html>
<html>
<meta charset = "utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
<style>
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, "Helvetica", sans-serif;
  
       
}

.bgimg {
  background-image: url('data/image/lab_photo.jpg');
  height: 100%;
  width:100%;
  background-position: center;
  background-size: cover;
  position: fixed;
  color: black;
  font-family: "Courier New", Courier, monospace;
  font-size: 25px;
}

.topleft {
  position: absolute;
  top: 0;
  left: 16px;
}
.logo {
	 width: 150px;
	 height: 150px;
}

.bottomleft {
  position: absolute;
  bottom: 0;
  left:50%;
  text-align: center;
  transform: translate(-50%, -50%);
}

.middle {
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

hr {
  margin: auto;
  width: 40%;
}
.welcomemsg {
	font-size:32px;
}

.copyright {
	font-size:18px;
	font-weight:bold;
	color:black;
}

/* For device width smaller than 800px: */
@media only screen and (max-device-width: 800px) {
	body {
		background-image: url('data/cropped_small_bg.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
     }
	 .topleft {
		  position: absolute;
		  top: 0;
		  left: 5px;
		}
	.logo {
		 width: 80px;
		 height: 80px;
	} 
	.welcomemsg {
		padding-top:30px;
		font-size:24px;
}
}
</style>
<body>

<div class="bgimg">
  <div class="topleft">
    <p><img src="data/image/lab logo.png" alt="SFSL Logo" class="logo"></p>
  </div>
  <div class="middle">
    <h2 class="welcomemsg">WELCOME TO SMART FARM SYSTEM LABORATORY</h2>
    <hr>
    <h4>For laboratory member <br><a href="data/login">click here</a></h4>
  </div>
  <div class="bottomleft">
    <p class="copyright">&#169;Smart Farm Systems Laboratory 2020</p>
  </div>
</div>

</body>
</html>