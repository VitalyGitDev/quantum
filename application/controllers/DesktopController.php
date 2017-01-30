<?php
namespace Application\Controllers;

use Application\Core\BaseController;

class DesktopController extends BaseController
{
  public function actionIndex()
  {
      //$output = [];
      //exec('ps ', $output, $return_value);
      //die("<pre>" . print_r($output, 1) . "</pre>");
      //$this->services->get('appConfig')->all()

      $sources = file_get_contents($this->services->get('appConfig')->get('resources'));
      //TODO: Need to throw an Exception if JSON is wrong.
      $sources = json_encode(json_decode($sources, true));
      
//die("<pre>" . print_r($sources, 1) . "</pre>");
      $this->view->template = 'cube.php';
      $this->view->generate([
          'sources' => $sources,
          'sides' => [
              'front',
              'back',
              'right',
              'left',
              'top',
              'bottom',
          ]
      ]);
  }
}
