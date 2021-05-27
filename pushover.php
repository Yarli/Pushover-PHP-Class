<?php
/*
  PHP Pushover API class for PHP
  Written by Adam French (Yarli) 27/05/2021 and is licenced under the GNU GPL v3.0 licence
  
  Example Usage.
    $p=new Pushover();
    if($p->sendMessage({
      "user"    => " **Your User Key here** ",
			"title"		=> "Subject goes here",
			"message"	=> "Your message goes here"
    })) {
      echo "Success";
    }
    else {
      echo "Failed to send";
    }
  
  Or the following if you don't want to check the status.
  $p=new Pushover();
    if($p->sendMessage({
      "user"    => " **Your User Key here** ",
			"title"		=> "Subject goes here",
			"message"	=> "Your message goes here"
    })
  
  Returns true or false depending if the send was successful.
  
  Support all keys exposed by the Pushover API. For a complete list see: https://pushover.net/api
  A summary of those keys are as follows, which was adapted from https://pushover.net/api
  * token (required if you haven't put it in the head of the class below) - your application's API token
  * user (required) - the user/group key (not e-mail address) of your user (or you), viewable when logged into our dashboard (often referred to as USER_KEY in our documentation and code examples)
  * message (required) - your message
  Some optional parameters may be included:
  * attachment - an image attachment to send with the message; see attachments for more information on how to upload files
  * device - your user's device name to send the message directly to that device, rather than all of the user's devices (multiple devices may be separated by a comma)
  * title - your message's title, otherwise your app's name is used
  * url - a supplementary URL to show with your message
  * url_title - a title for your supplementary URL, otherwise just the URL is shown
  * priority - send as -2 to generate no notification/alert, -1 to always send as a quiet notification, 1 to display as high-priority and bypass the user's quiet hours, or 2 to also require confirmation from the user
  * sound - the name of one of the sounds supported by device clients to override the user's default sound choice
  * timestamp - a Unix timestamp of your message's date and time to display to the user, rather than the time your message is received by our API
*/

if(!class_exists("Pushover",false)) {
	class Pushover {
 		private $Token=""; #Put your application token here. Go To https://pushover.net/apps/build to create your app token, or leave blank if your going to supply this each time you make a call to sendMessage.
		private $Endpoint="https://api.pushover.net/1/messages.json";
		
		public function sendMessage($Params=array()) {
			if(!is_array($Params)) die("Function parameters must be an array");
			if(!isset($Params['user'])) die("Require parameter 'user' is missing");
			if(!isset($Params['title'])) $Params['title']="Pushover Class";
			if(!isset($Params['message'])) die("Require parameter 'message' is missing");
			if(!isset($Params['priority'])) $Params['priority']="0";
			if(!isset($Params['expire'])) $Params['expire']="1200";
			if(!isset($Params['token'])) $Params['token']=$this->Token;

			if($Params['priority']==2 AND (!isset($Params['retry']) OR $Params['retry']<30 ) ) die("Field 'retry' should be a number of at least 30 if 'priority' is set to '2'.");
			if($Params['priority']==2 AND (!isset($Params['expire']) OR $Params['expire']>10800 ) ) die("Field 'expire' should be a number of at most 10800 if 'priority' is set to '2'.");

			$data=json_encode($Params);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$this->Endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close ($ch);
			if (isset($server_output['status']) AND $server_output['status'] == "1") { return true; } else { return false; }
		}
	}
}

?>
