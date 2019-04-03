<?php

@session_start();

if(isset($_REQUEST['email_address'])) {
 
		$to = "your-email@domain.com";
		$from =  $_POST["email_address"];
		$subject = 'Contact Us';		
		$headers = "From: ".$_POST["email_address"]."\n";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$message = "<div align='center' style='height:100%; width:100%;'>
								<div style='width:100%; height:auto; float:left; position:relative; margin:135px 0 0 0; padding:0 0 14px 0'>
								
								<div align='center' style='max-width:382px; width:100%; background:#FFF; margin:-111px auto 10px auto; padding:10px 20px 25px 20px;display: inline-block;background-color: #2991d6;border-radius: 10px;'>
								<div style=' position:relative; background-color: #fff; padding: 10px; margin-top: 15px;'>
								<img alt='' align='center' style='width:100%; max-width:227px' src='http://wahabali.com/work/fajar-demo/images/logo.png'>
								</div>
								<div style='width:100%; max-width:320px; padding:30px 30px 30px 30px; float:left; height:auto; background:#FFF; box-shadow:0 11px 19px -19px #000000 inset; margin: 5px 0 0 0;border: 1px solid #2991d6;'>
								<div style='color: #2991d6 ; font-family:Lucida Sans Unicode, Lucida Grand, sans-serif; font-size: 18px; margin: 0 0 20px;'>
								Contact US FORM
								</div>
								<div>
								<div style=' width:100%; max-width:326px; float:left; margin:0 10px 0 0;'>
								
								<table class='table1' style='background:#F0F0F0; width:320px; color:#454545; font-size:12px; padding: 10px 0 10px 30px; float:left; margin:0 15px 0 0;border-radius: 7px 7px 7px 7px;'>
								
								<tr>
								<td height='41' style='color:#747474;height:41px;'width='151'>Name</td>
								<td height='41' width='157'>" . @$_POST["name"] . "</td>
								</tr>
								
                                <tr>
								<td height='41' style='color:#747474;height:41px;'>E-mail Address</td>
								<td height='41' style='color:#747474;height:41px;'>" . @$_POST["email_address"] . "</td>
								</tr>
								
								<tr>
								<td height='41' style='color:#747474;height:41px;'>Phone Number</td>
								<td height='41' style='color:#747474;height:41px;'>" . @$_POST["phone"] . "</td>
								</tr>
								
								<tr>
								<td height='41' style='color:#747474;height:41px;'>Message</td>
								<td height='41' style='color:#747474;height:41px;'>" . @$_POST["msg"] . "</td>
								</tr>
								
								
								</table>
								</div>
								</div>
								</div>
								</div>
								</div>



";
		
		
		
		
	    $send =	mail($to,$subject,$message,$headers);



			if($send)
			{
				$_SESSION['msg']  = "Your inquiry has been submitted successfully. We will contact you shortly.";
				
				 // Create a session variable called something like this after you start the session:
				  $_SESSION['user_start'] = time();

			}
			 echo $_SESSION['msg'];

}


if(isset($_REQUEST['news_email_address'])){
		$to = "your-email@domain.com";
		$from =  $_POST["news_email_address"];
		
		
		$subject = 'Contact Us';		
		$headers = "From: ".$_POST["news_email_address"]."\n";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$message = "<div align='center' style='height:100%; width:100%;'>
								<div style='width:100%; height:auto; float:left; position:relative; margin:135px 0 0 0; padding:0 0 14px 0'>
								
								<div align='center' style='max-width:382px; width:100%; background:#FFF; margin:-111px auto 10px auto; padding:10px 20px 25px 20px;display: inline-block;background-color: #2991d6;border-radius: 10px;'>
								<div style=' position:relative; background-color: #fff; padding: 10px; margin-top: 15px;'>
								<img alt='' align='center' style='width:100%; max-width:227px' src='http://wahabali.com/work/fajar-demo/images/logo.png'>
								</div>
								<div style='width:100%; max-width:320px; padding:30px 30px 30px 30px; float:left; height:auto; background:#FFF; box-shadow:0 11px 19px -19px #000000 inset; margin: 5px 0 0 0;border: 1px solid #6fa12e;'>
								<div style='color: #6fa12e ; font-family:Lucida Sans Unicode, Lucida Grand, sans-serif; font-size: 18px; margin: 0 0 20px;'>
								Contact US FORM
								</div>
								<div>
								<div style=' width:100%; max-width:326px; float:left; margin:0 10px 0 0;'>
								
								<table class='table1' style='background:#F0F0F0; width:320px; color:#454545; font-size:12px; padding: 10px 0 10px 30px; float:left; margin:0 15px 0 0;border-radius: 7px 7px 7px 7px;'>
					
								
                                <tr>
								<td height='41' style='color:#747474;height:41px;'>E-mail Address</td>
								<td height='41' style='color:#747474;height:41px;'>" . @$_POST["news_email_address"] . "</td>
								</tr>
								
								
								
								</table>
								</div>
								</div>
								</div>
								</div>
								</div>



";
		
		
		
	    $send =	mail($to,$subject,$message,$headers);



			if($send)
			{
				$_SESSION['msg']  = "Your inquiry has been submitted successfully. We will contact you shortly.";
				
				 // Create a session variable called something like this after you start the session:
				  $_SESSION['user_start'] = time();

			}
			 echo $_SESSION['msg'];


}
?>