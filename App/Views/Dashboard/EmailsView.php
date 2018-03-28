<?php
$pageName = "Emails";

Dashboard::printHeader($pageName, "grey");

$emails = BF::GenerateList($data["emails"], "<tr><td  class=\"ta-l\">?</td></tr>", ["Email_text"]);

$bodyText = <<<EOF
<div class="container-fluid header-based">
    <div class="row">
        <div class="col-md-12 ta-r">
            <div class="manage-buttons">
                <h1>{$pageName}</h1>
                <span style="height: 40px;display: inline-block"></span>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="strong">
                    <tr><th width="70" class="ta-l">Email</th></tr>
                </thead>
                <tbody>
                    {$emails}
                </tbody>
            </table>
        </div>
        <div class="col-md-12 ta-c">
            {$data["links"]}
        </div>
    </div>
</div>
EOF;
