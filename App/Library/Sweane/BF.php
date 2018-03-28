<?php
class BF
{
    const tableNameUser = "Users";
    const nameUser = "UserName";
    const idUser = "Users_id";
    const loginUser = "Users_login";
    const passwordUser = "Users_password";
    const permissionUser = "Users_permission";

    public static function ReturnWaterMark($image) {
	return $image;
        $imgPath = $_SERVER["DOCUMENT_ROOT"] . $image;
        $imgExt = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

        $newImageName = '/WaterMark/' . md5($imgPath) . '.' . $imgExt;
        $newImagePath = $_SERVER["DOCUMENT_ROOT"] . $newImageName;

        if(file_exists($newImagePath))
        {
            return '/WaterMark/' . md5($imgPath) . '.' . $imgExt;
        }

        $stampPath = $_SERVER["DOCUMENT_ROOT"] . '/znak-voter.png';

        if($imgExt == "jpg" || $imgExt == "jpeg")
        {
            $im = imagecreatefromjpeg($imgPath);
        }
        else
        {
            $im = imagecreatefrompng($imgPath);
        }

        $stamp = imagecreatefrompng($stampPath);

        $infoImg = getimagesize($imgPath);

        // Установка полей для штампа и получение высоты/ширины штампа
        $marge_right = $infoImg[0] / 2 - 200;
        $marge_bottom = $infoImg[1] / 2 - 200;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // // Слияние штампа с фотографией. Прозрачность 50%
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

        // Сохранение фотографии в файл и освобождение памяти
        imagepng($im, $newImagePath);
        imagedestroy($im);

        return $newImageName;
    }

    public static function CheckUserInSystem($login = false, $password = false)
    {
        if(!$login && !$password)
        {
            $login = BF::ClearCode("login", "str", "session");
            $password = BF::ClearCode("password", "str", "session");
        }

        $check = R::getRow("SELECT * FROM " . BF::tableNameUser . " WHERE " . BF::loginUser . " = ? AND " . BF::passwordUser . " = ?", [$login, $password]);

        if(intval($check[BF::idUser]) > 0)
        {
            return 1;
        }

        BF::QuitUser();

        return 0;
    }

    public static function ConfirmUser($email)
    {
        R::exec("UPDATE Users SET Users_confirm = 1 WHERE Users_email LIKE '" . BF::ClearCode($email, "str") . "'");

        return;
    }

    public static function ReturnInfoUser($return)
    {
        $login = BF::ClearCode("login", "str", "session");
        $password = BF::ClearCode("password", "str", "session");

        if(BF::CheckUserInSystem($login, $password) == true)
        {
            $user = R::getRow("SELECT " . BF::idUser . ", " . BF::permissionUser . ", CONCAT(Users_name, ' ', Users_surname) as " . BF::nameUser . " FROM " . BF::tableNameUser . " WHERE " . BF::loginUser . " = ?  AND " . BF::passwordUser . " = ?", [$login, $password]);

            return $user[$return];
        }

        return false;
    }

    public static function RedirectUser($redirectTo, $needResult) // Redirect To, if result 1, Or Need Result, if result 0
    {
        $login = BF::ClearCode("login", "str", "session");
        $password = BF::ClearCode("password", "str", "session");

        if($needResult == 1)
        {
            if(BF::CheckUserInSystem($login, $password) == 1)
            {
                header("Location: /" . $redirectTo);
            }
        }
        else
        {
            if(BF::CheckUserInSystem($login, $password) == 0)
            {
                header("Location: /" . $redirectTo);

                die();
            }
        }

        return false;
    }

    public static function IfUserInSystem()
    {
        $login = BF::ClearCode("login", "str", "session");
        $password = BF::ClearCode("password", "str", "session");

        if($login != null && $password != null)
        {
            return true;
        }

        return false;
    }

    public static function LoginUser($login, $password)
    {
        $_SESSION["login"] = $login;
        $_SESSION["password"] = $password;
    }

    public static function QuitUser()
    {
        unset($_SESSION["login"]);
        unset($_SESSION["password"]);
    }

    public static function GeneratePass($text)
    {
        $text = "_23_asd_" . $text . "_asd_324";
        $password = md5($text);
        return $password;
    }

    public static function IncludeScripts($array)
    {
        $script = "";

        foreach($array as $value)
        {
            $script .= <<<EOF
<script type="text/javascript" src="/Libs/FrontEnd/{$value}.js"></script>
EOF;
        }

        return print($script);
    }

    public static function IncludeStyles($array)
    {
        $style = "";

        foreach($array as $value)
        {
            $style .= <<<EOF
<link rel="stylesheet" href="/Libs/FrontEnd/{$value}.css">
EOF;
        }

        return print($style);
    }

    public static function CreateLikeQuery($arrayWithColumns, $searchText)
    {
        $query = "";

        $explodeText = explode(" ", $searchText);
        $countWords = count($explodeText);
        $countColumns = count($arrayWithColumns);

        for ($i = 0; $i < $countWords; $i++)
        {
            $word = $explodeText[$i];

            $text = "";

            for ($y = 0; $y < $countColumns; $y++)
            {
                $value = $arrayWithColumns[$y];

                if($y != $countColumns - 1 && $countColumns != 1)
                {
                    $text .= "{$value} LIKE '%{$word}%' OR ";

                    continue;
                }
                else if($countColumns == 1)
                {
                    $text .= "{$value} LIKE '%{$word}%'";

                    continue;
                }

                $text .= "{$value} LIKE '%{$word}%'";
            }

            if($i != $countWords - 1 && $countWords != 1)
            {
                $query .= "({$text}) AND ";

                continue;
            }
            else if($countWords == 1)
            {
                $query .= $text;

                continue;
            }

            $query .= "({$text})";
        }

        return $query;
    }

    public static function ClearText($data)
    {
        return html_entity_decode(html_entity_decode($data));
    }

    public static function ClearCode($data, $type = null, $from = "array")
    {
        $data = BF::CheckFrom($data, $from);

        switch($type) {
            case("int"):
                $data = intval($data);
                break;
            case("float"):
                $data = floatval($data);
                break;
            case("bool"):
                $data = boolval($data);
                break;
            case("double"):
                $data = doubleval($data);
                break;
            case("str"):
                if($data != null)
                {
                    $data = htmlentities(strval($data));
                }
                else
                {
                    $data = false;
                }
                break;
            case("array"):
                if(is_array($data))
                {
                    $data = $data;
                }
                else
                {
                    $data = false;
                }
                break;
            default:
                $data = false;
                break;
        }
        return $data;
    }

    public static function CheckFrom($var, $from = "array")
    {
        switch ($from)
        {
            case("array"):
                if(isset($var))
                {
                    return $var;
                }
                break;
            case("post"):
                if(isset($_POST[$var]) && $_POST[$var] != null)
                {
                    return $_POST[$var];
                }
                break;
            case("get"):
                if(isset($_GET[$var]) && $_GET[$var] != null)
                {
                    return $_GET[$var];
                }
                break;
            case("cookie"):
                if(isset($_COOKIE[$var]) && $_COOKIE[$var] != null)
                {
                    return $_COOKIE[$var];
                }
                break;
            case("session"):
                if(isset($_SESSION[$var]) && $_SESSION[$var] != null)
                {
                    return $_SESSION[$var];
                }
                break;
            default:
                return false;
        }

        return false;
    }

    public static function ReturnStatusAccount($countProjects, $countTasks)
    {
        if( ($countProjects >= 0 && $countProjects <= 3) && ($countTasks >= 0 && $countTasks <= 5) )
        {
            return ["dashboard_account_status_basic", 0];
        }
        else if( ($countProjects > 3 && $countProjects <= 5) && ($countTasks > 5 && $countTasks <= 8) )
        {
            return ["dashboard_account_status_medium", 5];
        }
        else if($countProjects > 6 && $countTasks > 8)
        {
            return ["dashboard_account_status_pro", 15];
        }

        return false;
    }

    public static function UploadFile($name, $path)
    {
        $dataInfo = [];

        if($_FILES[$name]["tmp_name"] != null)
        {
            $target_dir = $_SERVER["DOCUMENT_ROOT"] . $path;
            $target_file = $target_dir . basename($_FILES[$name]["name"]);

            $dataInfo["fileInfo"] = $target_file;

            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES[$name]["tmp_name"]);

            if($check !== false) {
                $dataInfo["imageMime"] = $check["mime"];
                $uploadOk = 1;
            } else {
                $dataInfo["imageMime"] = "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $dataInfo["imageExists"] = "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size

            $dataInfo["imageSize"] = $_FILES[$name]["size"];

            if ($_FILES[$name]["size"] > 1000000) {
                $uploadOk = 0;
            }
            $dataInfo["imageType"] = "Support";

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                $dataInfo["imageType"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $dataInfo["imageUploaded"] = "Sorry, your file was not uploaded.";
                $dataInfo["imageStatus"] = false;
                // if everything is ok, try to upload file
            } else {
//                AuxiliaryFn::StylePrint($target_file);

                if(!is_dir(dirname($target_file))) mkdir(dirname($target_file));

                if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
                    $dataInfo["imageUploaded"] = "The file has been uploaded.";
                    $dataInfo["imageUploadedName"] = BF::CreateLinkFromString(basename( $_FILES[$name]["name"]));
                    $dataInfo["imageStatus"] = true;
                } else {
                    $dataInfo["imageUploaded"] = "Sorry, there was an error uploading your file.";
                    $dataInfo["imageStatus"] = false;
                }
            }
        }
        else
        {
            $dataInfo["imageStatus"];
        }

        return $dataInfo;
    }

    public static function ReturnGender($value)
    {
        $gender = [
            1 => "Miss",
            2 => "Mrs.",
            3 => "Mr."
        ];

        return $gender[$value];
    }

    public static function ReturnCondition($data, $var1, $var2)
    {
        if($var1 == $var2)
        {
            return $data;
        }

        return false;
    }

    public static function ReturnPercent($parent, $child)
    {
        if($parent == 0)
        {
            return 0;
        }

        return intval($child * 100 / $parent);
    }

    public static function GenerateList($array, $shell, $data, $count = null, $classShell = null)
    {
        $menuLi = "";
        $shellParent = "";
        $y = 1;

        /*
         * Перебираем массив с новостями
         */

        foreach ($array as $value)
        {
            $i = 0;
            $shellPrepare = $shell;

            while($position = strpos($shellPrepare, "?"))
            {
                if(isset($data[$i]))
                {
                    $shellPrepare = BF::StringReplaceFirst("?", $value[$data[$i]], $shellPrepare);

                    $i++;
                }
                else
                {
                    return false;
                }
            }

            $menuLi .= $shellPrepare;

            if($count != null && $y == $count)
            {
                $shellParent .= "<div " . $classShell . ">" . $menuLi . "</div>";
                $menuLi = "";
                $y = 0;
            }

            $y++;
        }

        if(--$y != $count)
        {
            $shellParent .= "<div " . $classShell . ">" . $menuLi . "</div>";;
        }

        if($count != null)
        {
            return $shellParent;
        }

        return $menuLi;
    }

    public static function GenerateListSimple($array, $shell, $data)
    {
        $menuLi = "";

        $array = explode($data, $array);

        foreach ($array as $value)
        {
            $i = 0;
            $shellPrepare = $shell;

            while($position = strpos($shellPrepare, "?"))
            {
                $shellPrepare = BF::StringReplaceFirst("?", $value, $shellPrepare);

                $i++;
            }


            if(isset($value) && $value != null)
            {
                $menuLi .= $shellPrepare;
            }
        }

        return $menuLi;
    }

    public static function StringReplaceFirst($from, $to, $subject)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $subject, 1);
    }

    public static function GetPathCategory($category)
    {
        $categoryDB = R::getRow("SELECT * FROM Categories WHERE Categories_id = ?", [
            $category
        ]);

        return $categoryDB["Categories_name"];
    }

    public static function CreateLinkFromString($string) {

        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

            '  ' => ''
        );

        $str = strtr($string, $converter);

        $str = strtolower($str);

        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

        $str = trim($str, "-");

        $str = str_replace("---", "-", $str);
        $str = str_replace("--", "-", $str);

        return $str;
    }

    public static function BreadCrumbsProduct($idProduct)
    {
        $product = R::getRow("SELECT RootCategory.CategoryName, ID_subCategory, ID_product, SubCategory.CategoryName AS SubName, ProductName  FROM Products
      
        INNER JOIN RootCategory ON RootCategory.ID_rootCategory = Products.ProductCategory
        
        INNER JOIN SubCategory ON SubCategory.MainCategory_FK = RootCategory.ID_rootCategory
        
        WHERE ID_product = ?
        ", [
            $idProduct
        ]);

        $shell = <<<EOF
        <ol class="breadcrumb">
          <li><a href="/">{$product["CategoryName"]}</a></li>
          <li><a href="/category/{$product["ID_subCategory"]}">{$product["SubName"]}</a></li>
          <li><a href="/product/{$product["ID_product"]}">{$product["ProductName"]}</a></li>
        </ol>
EOF;

        return $shell;
    }

    public static function BreadCrumbsCategory($idSubCategory)
    {
        $product = R::getRow("SELECT RootCategory.CategoryName, ID_subCategory, SubCategory.CategoryName AS SubName FROM SubCategory
      
        INNER JOIN RootCategory ON RootCategory.ID_rootCategory = SubCategory.MainCategory_FK
        
        WHERE ID_subCategory = ?
        ", [
            $idSubCategory
        ]);

        $shell = <<<EOF
        <ol class="breadcrumb">
          <li><a href="/">{$product["CategoryName"]}</a></li>
          <li><a href="/category/{$product["ID_subCategory"]}">{$product["SubName"]}</a></li>
        </ol>
EOF;

        return $shell;
    }

    public static function DifferenceDate($datePast, $datePresent = null) // Y-m-d
    {
        if($datePresent == null)
        {
            $datePresent = date("Y-m-d");
        }

        $datetime1 = new DateTime($datePast);
        $datetime2 = new DateTime($datePresent);
        $interval = $datetime1->diff($datetime2);

        return intval($interval->format('%R%a'));
    }

    public static function IpInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }

        return $output;
    }

    public static function AddActionToChronology($action)
    {
        R::exec("INSERT INTO Chronology(Chronology_action, Chronology_user) VALUES(?, ?)", [
            BF::ClearText($action),
            BF::ReturnInfoUser(BF::idUser)
        ]);
    }

    public static function NotFound()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: /404/');

        die();
    }

    public static function RedirectPage($link)
    {
        header('Location: /' . $link);

        die();
    }

}
