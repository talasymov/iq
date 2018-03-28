<?php
$public_key = "i94249257993";
$private_key = "oGK7ySfbjQ4cjzSsLRFqTFrf5UozkmvZdNHGsd7t";

$sign = base64_encode( sha1(
    $private_key .
    $_POST["data"] .
    $private_key
    , 1
));

$statusOrder = json_decode(base64_decode($_POST["data"]));

$json = '{"action":"pay","payment_id":541737167,"status":"sandbox","version":3,"type":"buy","paytype":"card","public_key":"i94249257993","acq_id":414963,"order_id":"63","liqpay_order_id":"ODR9QASC1509552207588087","description":"Intimate Question","sender_card_mask2":"473118*90","sender_card_bank":"pb","sender_card_type":"visa","sender_card_country":804,"ip":"195.78.245.137","amount":1.0,"currency":"USD","sender_commission":0.0,"receiver_commission":0.03,"agent_commission":0.0,"amount_debit":27.03,"amount_credit":27.03,"commission_debit":0.0,"commission_credit":0.74,"currency_debit":"UAH","currency_credit":"UAH","sender_bonus":0.0,"amount_bonus":0.0,"mpi_eci":"7","is_3ds":false,"create_date":1509552207622,"end_date":1509552207622,"transaction_id":541737167}';

if($_POST["signature"] == $sign)
{
    R::exec("UPDATE OrdersGroup SET OrdersGroup_comment_payment = ? WHERE OrdersGroup_id = ?", [
        $statusOrder->status,
        $statusOrder->order_id
    ]);
}
else
{
    R::exec("UPDATE OrdersGroup SET OrdersGroup_comment_payment = ? WHERE OrdersGroup_id = ?", [
        "false",
        40
    ]);
}
