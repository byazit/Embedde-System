<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <title>Pi control car!</title>
  
  <style type="text/css">
    body {
      font-family: sans-serif;
    }
  
      .main {
      border: 1px solid black;
      box-shadow: 10px 10px 5px #888;
      border-radius: 12px;
      padding: 20px;
      background-color: #ddd;
      margin: 25px;
      width: 450px;
      margin-left:auto;
      margin-right:auto;  
    }
    
    .logo {
      width:400px;
      margin-left: auto;
      margin-right: auto;
      display: block;
      padding: 15px;
    }
    
    .container {
      -webkit-perspective: 300; perspective: 300;
    }
  </style>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
  <div class="main">
      <h2>Pi Car Orientation</h2>
      <table>
        <tbody><tr>
          <td>Event Supported</td>
          <td id="doEvent">PiCarOrientation</td>
        </tr>
        <tr>
          <td>Tilt Left/Right [gamma]</td>
          <td id='doTiltLR'></td>
        </tr>
        <tr>
          <td>Tilt Front/Back [beta]</td>
          <td id="doTiltFB"></td>
        </tr>
        <tr>
          <td>Direction [alpha]</td>
          <td id="doDirection"></td>
        </tr>
      </tbody></table>
  </div>
  
  <div class="container" style="-webkit-perspective: 300; perspective: 300;">
    <img src="rabbit.jpg" id="imgLogo" class="logo">
  </div>
  
  <script type="text/javascript">
    init();
    var count = 0;
    var LR=1;
		var tiltLR=0;
    function init() {
      if (window.DeviceOrientationEvent) {
        document.getElementById("doEvent").innerHTML = "DeviceOrientation";
        // Listen for the deviceorientation event and handle the raw data
        window.addEventListener('deviceorientation', function(eventData) {
          // gamma is the left-to-right tilt in degrees, where right is positive
          tiltLR = eventData.gamma;
          
          // beta is the front-to-back tilt in degrees, where front is positive
          var tiltFB = eventData.beta;
          
          // alpha is the compass direction the device is facing in degrees
          var dir = eventData.alpha
          
          // call our orientation event handler
          deviceOrientationHandler(tiltLR, tiltFB, dir);
          }, false);
      } else {
        document.getElementById("doEvent").innerHTML = "Not supported on your device or browser.  Sorry."
      }
    }
  
    function deviceOrientationHandler(tiltLR, tiltFB, dir) {
			LR=Math.round(tiltLR);
      document.getElementById("doTiltLR").innerHTML = Math.round(tiltLR);
      document.getElementById("doTiltFB").innerHTML = Math.round(tiltFB);
      document.getElementById("doDirection").innerHTML = Math.round(dir);
      
      // Apply the transform to the image
      var logo = document.getElementById("imgLogo");
      logo.style.webkitTransform = "rotate("+ tiltLR +"deg) rotate3d(1,0,0, "+ (tiltFB*-1)+"deg)";
      logo.style.MozTransform = "rotate("+ tiltLR +"deg)";
      logo.style.transform = "rotate("+ tiltLR +"deg) rotate3d(1,0,0, "+ (tiltFB*-1)+"deg)";
    }
    
    
    // Some other fun rotations to try...
    //var rotation = "rotate3d(0,1,0, "+ (tiltLR*-1)+"deg) rotate3d(1,0,0, "+ (tiltFB*-1)+"deg)";
    //var rotation = "rotate("+ tiltLR +"deg) rotate3d(0,1,0, "+ (tiltLR*-1)+"deg) rotate3d(1,0,0, "+ (tiltFB*-1)+"deg)";
  </script>
<?php
					echo $t="<script>document.writeln(LR);</script>";
					echo "<td id='doTiltLR'></td>";
?>
  <form>
<select name="users" onchange="showUser.value">
<option value="1">Select a person:</option>
<option value="1">Peter Griffin</option>
<option value="2">Lois Griffin</option>
<option value="3">Joseph Swanson</option>
<option value="4">Glenn Quagmire</option>
</select>
</form>
<br>
<div id="txtHint"><b>Person info will be listed here.</b></div>
<br>



</body></html>
