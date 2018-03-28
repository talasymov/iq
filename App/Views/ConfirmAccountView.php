<?php
IncludesFn::printHeader("Check Your Email", "customer-account-login grey", $seo);

R::exec("UPDATE Users SET Users_confirm = 1 WHERE Users_login LIKE '" . BF::ClearCode($data["arguments"]["account"], "str") . "'");

$bodyText = <<<EOF
<div class="check-your-email">
Dear friend,<br />
Your order is accepted!<br />
In the near future we will contact you to send your lingerie for domination.<br />
Your IQ
</div>
EOF;
