<?php
$public_key = "i94249257993";
$private_key = "oGK7ySfbjQ4cjzSsLRFqTFrf5UozkmvZdNHGsd7t";

$sign = base64_encode( sha1(
$private_key .
$data .
$private_key
, 1 ));

AuxiliaryFn::StylePrint($sign);

R::exec("UPDATE OrdersGroup SET OrdersGroup_comment_payment = ? WHERE OrdersGroup_id = ?", [
    $sign["status"],
    $sign["order_id"]
]);