<?php
function InitHere()
{
    $result = "";

    $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/img/portfolio/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            $result .=  "File is an image - " . $check["mime"] . ".<br/>";
            $uploadOk = 1;
        } else {
            $result .=  "Файл не является изображением.<br/>\n";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        $result .=  "Файл с таким именем уже существует!<br/>\n";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["file"]["size"] > 400000) {
        $result .=  "Размер изображения больше 400КБ.<br/>\n";
        $uploadOk = 0;
    }
// Allow certain file formats
    if(
        $imageFileType != "jpg" &&
        $imageFileType != "png" &&
        $imageFileType != "jpeg" &&
        $imageFileType != "svg" &&
        $imageFileType != "gif"
    ) {
        $result .=  "Извините, только JPG, JPEG, PNG & GIF поддерживаем.<br/>\n";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $result .= "Изображение не загрузилось.<br/>\n";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $result .=  "Файл ". basename( $_FILES["file"]["name"]). " успешно загружен.<br/>";

            R::exec("INSERT INTO portfolio(id_content, image_one) VALUES(?, ?)", [intval($_POST["idContent"]), "/img/portfolio/" . basename($_FILES["file"]["name"])]);
        } else {
            $result .=  "Извините, возникли проблемы при загрузке файла.<br/>\n";
        }
    }

    return print($result);
}