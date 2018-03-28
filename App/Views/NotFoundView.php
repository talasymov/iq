<?php
IncludesFn::printHeader("Not Found", "grey");

$bodyText = <<<EOF
<!--<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ta-c not-found center-all">
            <img src="/Images/Icons/logo-cut-02.svg">
            <h1>404</h1>
            <h2>Not Found</h2>
            <h3><a href="/">Back to site</a></h3>
        </div>
    </div>
</div>-->
<div class="ta-c not-found center-all">
    <img src="/App/Views/Include/logo.png" width="200">
    <h1>404</h1>
    <h2>Not Found</h2>
    <h3><a href="/">Back to Home Page</a></h3>
</div>
</body>
</html>
EOF;
