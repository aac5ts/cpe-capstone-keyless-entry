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

	<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    	<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<script>
        $( function() {   
            var externalURL ="H-1QuKQ0IZZu";
            var pollRate ="1000";

            function poll(){
                // Construct an ajax() GET request.
                
                $.ajax({
                    type: "get",
                    url: "https://agent.electricimp.com/"+externalURL,  // URL of our imp agent.
                    dataType: "json",   // Expect JSON-formatted response from agent.
                    success: function(agentMsg) {   // Function to run when request succeeds.

                        // jQuery find "pin1" id and overwrite its data with "pin1" key value in agentMsg
                        
                       if (agentMsg.pin9 == 0)
				{$("#pin9").html("off");}
			else {$("#pin9").html("on"); }
                       
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

       <p><center>Welcome to our Capstone Project. Select your option below </center>



<UL id="example_tree">
	<LI><span>Turn LED ON/OFF</span>
	
		<UL>
			<LI><span><a href="https://agent.electricimp.com/H-1QuKQ0IZZu?led=1">ON</a></span></LI>
			<LI><span><a href="https://agent.electricimp.com/H-1QuKQ0IZZu?led=0">OFF</a></span></LI>	
		</UL>
	</LI>
	<LI><span>Check LED Status</span>
		<UL>LED is <span id = "pin9"> </span> </UL>
	</LI>
	<LI><span>Check Lock Status</span></LI>
	<LI><span>Lock Door</span></LI>
	<LI><span>Unlock Door</span></LI>
</UL>

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
