<?php
IncludesFn::printHeader("Check Your Email", "customer-account-login grey", $seo);

$userInfo = R::getRow("SELECT * FROM Users WHERE Users_id = ?", [
    BF::ReturnInfoUser(BF::idUser)
]);

$message = <<<EOF
<div style="text-align: center; padding: 20px">
    <p>Dear friend!</p>
    <p>Your lingerie for domination is already paid and we are going to start to prepare your order in next few hours.</p>
    <p>See you soon,</p>
    <p>Wish you happy domination.</p>
    <p>Your IQ.</p>
</div>
EOF;

$to = $userInfo["Users_email"];

$subject = 'Already paid';

$headers = "From: office@intimatequestion.com\r\n";
$headers .= "Reply-To: office@intimatequestion.com\r\n";
$headers .= "CC: office@intimatequestion.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subject, $message, $headers);

$bodyText = <<<EOF
<div class="check-your-email">
Dear friend!<br />
Your lingerie for domination is already paid and we are going to start to prepare your order in next few hours.<br />
See you soon,<br />
Wish you happy domination.<br />
Your IQ.
</div>
EOF;
