# Pushover-PHP-Class
Pushover PHP class for sending Pushover messages via their API's

Example using status feedback to check if the delivery worked
```php
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
```
Another example but without the error checking. aka blind send
```php
$p=new Pushover();
if($p->sendMessage({
	"user"    => " **Your User Key here** ",
	"title"		=> "Subject goes here",
	"message"	=> "Your message goes here"
});
```
  
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
