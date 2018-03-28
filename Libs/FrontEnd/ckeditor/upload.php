<?php
if (!empty($_FILES)) {
    if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $sourcePath = $_FILES['upload']['tmp_name'];

        $company = $_POST["company"];
        $customers = $_POST["customers"];
        $linkDir = "/Images/UploadFiles/";

        $nameFile = ReplaceName($_FILES['upload']['name']);
        $targetPath = $_SERVER["DOCUMENT_ROOT"] . $linkDir . $nameFile;

        if (!file_exists($linkDir)) {
            mkdir( $_SERVER["DOCUMENT_ROOT"] . $linkDir, 0777);
        }

        if (move_uploaded_file($sourcePath, $targetPath)) {
            ?>
            Success
            <?php
        }
    }
}

function CupSpace($data)
{
    return str_replace(" ", "", $data);
}
function ReplaceName($data)
{
    $data = str_replace(" ", "", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace("\"", "", $data);
    $data = str_replace("&", "", $data);
    $data = str_replace("^", "", $data);
    $data = str_replace("%", "", $data);
    $data = str_replace("#", "", $data);
    $data = str_replace("?", "", $data);
    $data = str_replace("/", "", $data);
    $data = str_replace("\\", "", $data);

    return $data;
}
?>
