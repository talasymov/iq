<?php
class Controller
{
  public $model;
  public $view;

  public function __construct($nameModel)
  {
    $this->model = new $nameModel;
    $this->view = new View();
  }
}