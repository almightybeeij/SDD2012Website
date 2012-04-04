<html><head></head><body>

<?php

include('Mail.php');

echo "HERE WE GO!!<br>";

$recipients = 'software.design.development@gmail.com'; //CHANGE

$headers['From']    = 'software.design.development@gmail.com'; //CHANGE
$headers['To']      = 'software.design.development@gmail.com'; //CHANGE
$headers['Subject'] = 'Test message';

$body = 'Test message';

// Define SMTP Parameters

$params['host'] = 'ssl://smtp.gmail.com';
$params['port'] = '465';
$params['auth'] = 'true';
$params['username'] = 'software.design.development@gmail.com'; //CHANGE
$params['password'] = 'sddspring2012'; //CHANGE

/* The following option enables SMTP debugging and will print the SMTP 
conversation to the page, it will only help with authentication issues,
if PEAR::Mail is not installed you won't get this far. */

$params['debug'] = 'true';

// Create the mail object using the Mail::factory method

$mail_object =& Mail::factory('smtp', $params);

// Print the parameters you are using to the page

foreach ($params as $p){
        echo "$p<br />";
}

// Send the message
error_reporting(E_ALL);
$mail_object->send($recipients, $headers, $body);
?>
</body></html>