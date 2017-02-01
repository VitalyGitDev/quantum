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
        if (!empty($this->model)) {
            $this->model->load($_POST);
            if ($this->model->save()) {
                echo (json_encode([
                  'status' => 'success',
                  'message' => 'Model was successfully saved.'
                ]));
            } else {
                echo (json_encode([
                  'status' => 'error',
                  'message' => 'Error occured during model saving.'
                ]));
            }
            //header('Location: http://resources.local');
            exit;
        } else {
            echo (json_encode([
              'status' => 'error',
              'message' => 'Model data are empty.'
            ]));
            //header('Location: http://resources.local');
            exit;
        }
    }

    public function actionDelete($id)
    {
        if (!empty($this->model)) {
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
                ]));
            }
        } else {
            echo (json_encode([
              'status' => 'error',
              'message' => 'Model data are empty.'
            ]));
            //header('Location: http://resources.local');
        }

        exit;
    }

}
