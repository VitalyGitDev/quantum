<?php
namespace Api\Rest\Controllers;

use Application\Models\ResourceModel as Model;
use Application\Core\RESTController;
use Application\Core\ServiceLocator;

//TODO: rename this controller and make ResourceController as basic for this type of controllers.
class ResourceController extends RESTController
{
    public function __construct(ServiceLocator $services)
    {
        $this->modelClass = Model::class;
        parent::__construct($services);
    }

    public function actionCreate()
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE

        $this->model->load($_POST);
        if ($this->model->save()) {
            echo (json_encode([
              'status' => 'success',
              'message' => 'Model was successfully saved.',
              'data' => json_encode($this->model->all([
                                      'category' => $this->model->getCategoryName()
                                    ])),
            ]));
        } else {
            echo (json_encode([
              'status' => 'error',
              'message' => 'Error occured during model saving.'
            ]));
        }
        //header('Location: http://resources.local');
        exit;
    }

    public function actionDelete($id)
    {
      //die("<pre>" . print_r($this->model->getCategoryName($id), 1) . "</pre>");
        $status = $this->model->remove($id);
        if ($status === false) {
            echo (json_encode([
              'status' => 'error',
              'message' => $status,
            ]));
        } else {
            echo (json_encode([
              'status' => 'success',
              'message' => 'Model was successfully removed. ' . print_r($status, 1),
              'data' => json_encode($this->model->all([
                                      'category' => $this->model->getCategoryName($id)
                                    ])),
            ]));
        }

        exit;
    }

}
