<?php
class View
{
  public function __construct()
  {

  }
  public function GetTemplate($templatePath, $filePath, $data = null)
  {
      if(file_exists(DIR_VIEWS . $filePath) && file_exists(DIR_VIEWS . "Templates/" . $templatePath))
      {
          require_once(DIR_VIEWS . $filePath);

          require_once(DIR_VIEWS . "Templates/" . $templatePath);

          return true;
      }

      BF::NotFound();
  }
}