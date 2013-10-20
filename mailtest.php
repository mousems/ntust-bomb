
<?php
$subject = '安安測試';

$message = '
<html>
<body>
http://ntust-bomb.org
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
$headers .= 'From: NTUST-bomb <b10115012@mail.ntust.edu.tw>' . "\r\n";

// Mail it
mail('b10115012@mail.ntust.edu.tw', $subject, $message, $headers);

?>
