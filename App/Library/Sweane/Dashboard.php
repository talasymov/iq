<?php
class Dashboard
{
    public static function printHeader($title, $bodyClass = null, $info = null)
    {
        $menuVisible = BF::ClearCode("menu", "str", "cookie");

        $header = <<<EOF
<!DOCTYPE html>
<html>
<head>

<title>{$title}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/Libs/FrontEnd/css/eric-meyer-reset.css" title="no title">
<link rel="stylesheet" href="/Libs/FrontEnd/bootstrap-3.3.7/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="/Libs/FrontEnd/owl/owl.carousel.css">
<link rel="stylesheet" href="/Libs/FrontEnd/owl/owl.theme.default.css">
<link rel="stylesheet" href="/Libs/FrontEnd/css/fonts.css" title="no title">
<link rel="stylesheet" href="/Libs/FrontEnd/css/main.css" title="no title">
<link rel="stylesheet" href="/Libs/FrontEnd/css/font-awesome.css">

{$info}

</head>
<body class="{$bodyClass} {$menuVisible}">
<div class="copy-body">
EOF;
        print($header);

    }
}