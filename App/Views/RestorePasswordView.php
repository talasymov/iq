<?php
IncludesFn::printHeader("Restore Password", "customer-account-login grey", $seo);

R::exec("UPDATE Users SET Users_password = ? WHERE Users_login LIKE '" . BF::ClearCode($data["arguments"]["account"], "str") . "'", [
    BF::ClearCode($data["arguments"]["time"], "str")
]);

$bodyText = <<<EOF
<div class="check-your-email">
Password successfully reset :)<br />
You can <a href="/login/" class="link-under">log in</a> to your account.
</div>
EOF;
