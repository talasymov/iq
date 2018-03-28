<?php
IncludesFn::printHeader("News", "grey");

$bodyText = <<<EOF
<span class="header-blue">Заголовок новости</span>
<input class="news-name design-input" placeholder="Name" value="">
<span class="header-blue">Фото</span>
<input class="news-preview design-input" type="file">
<span class="header-blue">Контент</span>
<textarea id="text-content"></textarea>
<br />
<button class="add-news btn btn-info">
<i class="fa fa-plus" aria-hidden="true"></i>
Добавить новость
</button>
EOF;

$script = <<<EOF
<script src="/Libs/FrontEnd/ckeditor/ckeditor.js"></script>
<script src="/Libs/FrontEnd/core/admin.js"></script>
EOF;

