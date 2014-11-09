<?php 
session_start();
$LG ="";
if(!isset($_SESSION["login"]))  
	 {
		 $LG = "<a href='login.php'>Login</a>"; }
	 else
	 {
		$LG = "<a href='page2.php'>Logout</a>"; 
	}
	 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>

  <meta charset="UTF-8">

  <title>Welcome</title>
<style> 
.onoffswitch {
    position: relative; width: 130px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "LOCKED";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "UNLOCKED";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    border: 2px solid #999999; border-radius: 20px;
    position: absolute; top: 0; bottom: 0; right: 96px;
    -moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
    -o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
</style>
	<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    	<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<script>
        $( function() {   
            var externalURL = "YNDvfcWn8MYH";	//"H-1QuKQ0IZZu";
            var pollRate ="1000";

            function poll(){
                // Construct an ajax() GET request.
                
                $.ajax({
                    type: "get",
                    url: "https://agent.electricimp.com/"+externalURL,  // URL of our imp agent.
                    dataType: "json",   // Expect JSON-formatted response from agent.
                    success: function(agentMsg) {   // Function to run when request succeeds.

                        // jQuery find "pin1" id and overwrite its data with "pin1" key value in agentMsg
                        
                       if (agentMsg.sensor == 0)
				{$("#pin7").html("off");}
			else if (agentMsg.sensor == 1)
				 {$("#pin7").html("on"); }
			else {$("#pin7").html("unavailable");}
                       
                    },
                    error: function(err) {
                        console.log("err"+ err.status)
                    }
                });
            }

            // setInterval is Javascript method to call a function at a specified interval.
            
            setInterval(function(){ poll(); }, pollRate);

          
           
        });
    </script>
</head>
<body>

  <div class="login-card">
    <h1>Welcome</h1><br>

       <p><center>Welcome to our Capstone Project. Select your option below </center> </p>
<p> <center>

<div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
    <label class="onoffswitch-label" for="myonoffswitch">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>

</center></p>
<center><a id= "lockstatus"> </a> </center>
<!--<button type = "button" onclick="check()">Lock Door</button> <a id = "lock"></a> 
<button type = "button" onclick="uncheck()">Unlock Door</button> <a id = "unlock"></a> -->


    <UL id="example_tree">
	<LI><span>Check Sensor Status</span>
	  <UL>Sensor is <span id = "pin7"> </span> </UL>
	</LI>
	<LI><span>Check Lock Status</span></LI>
	
</UL>


<script>
document.getElementById("myonoffswitch").onchange = function() {myFunction()};

function myFunction() {
    var checkID = document.getElementById("myonoffswitch") ; 
    if (checkID.checked == true) 
    {
     document.getElementById("lockstatus").innerHTML = "Door is Locked &#x2713";
    var value = 1; 
    var agentAction =JSON.stringify(value); 
    $.ajax({
        type: "POST", 
        url: "https://agent.electricimp.com/YNDvfcWn8MYH", 
        data: agentAction,
        dataType: "json", 
        success: function(agentMsg) {
            document.getElementById("lockstatus").innerHTML = "Door is Locked &#x2713";
        }, 
         error: function(err) {
                        console.log("err"+ err.status)
                    }

    }); 
    

    }

    if (checkID.checked == false)
    {
    document.getElementById("lockstatus").innerHTML ="Door is Unlocked &#x2713"; 
    var value = 0; 
    var agentAction =JSON.stringify(value); 
    $.ajax({
        type: "POST", 
        url: "https://agent.electricimp.com/YNDvfcWn8MYH", 
        data: agentAction,
        dataType: "json", 
        success: function(agentMsg) {
            document.getElementById("lockstatus").innerHTML = "Door is Unlocked &#x2713";
        }, 
         error: function(err) {
                        console.log("err"+ err.status)
                    }

    }); 
    
    }
}
</script>

 



<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
$(function(){
$('#example_tree').find('SPAN').click(function(e){
	$(this).parent().find('UL').toggle();
});
});
</script>



        
<br />   
<P align="center">

<a href='page2.php'>Logout</a>

</div>

</body>
</html>
