<?php
class Files
{
    public static function GetDataFolder($dir)
    {
        $message = [
            "dir" => [

            ],
            "files" => [

            ]
        ];

        $dir = DIR_ROOT . $dir;

        $dir = str_replace("//", "/", $dir);

        if(is_dir($dir))
        {
            if($listDir = opendir($dir))
            {
                while(($file = readdir($listDir)) !== false)
                {
                    if(file_exists($dir . $file))
                    {
                        if(trim($file) != "." && trim($file) != "..")
                        {
                            $dirImage = explode("/Images", $dir);

                            $fileInfo = [
                                "dir" => $dir,
                                "path" => str_replace("//", "/", DIR_IMAGES_NON_ROOT . $dirImage[1] . $file),
                                "name" => $file,
                                "type" => filetype($dir . $file),
                                "time" => filemtime($dir . $file)
                            ];

                            if(filetype($dir . $file) == "dir")
                            {
                                $message["dir"][] = $fileInfo;
                            }
                            else
                            {
                                $message["files"][] = $fileInfo;
                            }

                        }
                    }
                }
                closedir($listDir);
            }
        }

        return $message;
    }

    public static function StyleFiles($dir)
    {
        $div = "";

        function SortByDate($a, $b)
        {
//            AuxiliaryFn::StylePrint($a);
//            AuxiliaryFn::StylePrint($b);

            if($a["time"] < $b["time"])
            {
                return 1;
            }
            else if($a["time"] == $b["time"]) {
                return 0;
            }
            else
            {
                return -1;
            }
            return strcmp($a["time"], $b["time"]);
        }

        $files = Files::GetDataFolder($dir);

//        AuxiliaryFn::StylePrint($files);

        usort($files["files"], "SortByDate");

        foreach ($files as $value)
        {
            foreach ($value as $subValue)
            {
                $class = "file";
                $element = "<img src='" . $subValue["path"] . "' />";

                if($subValue["type"] == "dir")
                {
                    $class = "dir";
                    $element = "<i class=\"fa fa-folder\" aria-hidden=\"true\"></i>";
                }

                $div .= "<div class='file-one file-one-" . $class . "' data-dir='" . $subValue["path"] . "'>" . $element . "<strong>" . $subValue["name"] . "</strong>" . "</div>";
            }
        }

        return $div;
    }
}