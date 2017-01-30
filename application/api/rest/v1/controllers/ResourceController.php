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
//die("<pre>" . print_r($this->model, 1) . "</pre>");
            echo (json_encode(['status' => $this->model->save()]));
            //header('Location: http://resources.local');
            exit;
        } else {
            echo (json_encode(['status' => 'Model data are empty.']));
            //header('Location: http://resources.local');
            exit;
        }
    }

}
