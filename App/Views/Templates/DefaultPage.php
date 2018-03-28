<?php
require_once (DIR_INCLUDE . "Header.php");

$newHtml = <<<EOF
{$bodyText}
EOF;

print($newHtml);

require_once (DIR_INCLUDE . "Footer.php");
