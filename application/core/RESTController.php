<?php
namespace Application\Core;

use Application\Core\ServiceLocator;

abstract class RESTController
{
    public $model;

    protected $modelClass;

    protected $services;

    public function __construct(ServiceLocator $services)
    {
        $this->services = $services;
        //TODO: Make with exception if no Model Class.
        if (! empty($this->modelClass)) {
            $this->model = new $this->modelClass($services);
        }
    }

    public function actionIndex()
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE
        if (!empty($this->model)) {
            echo (json_encode($this->model->all()));
            exit;
        }
    }

    public function actionGet($id)
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE
        if (!empty($this->model)) {
            echo (json_encode($this->model->get($id)));
            exit;
        }
    }

    public function actionCreate()
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE
        if (!empty($this->model)) {
            $this->model->load($_POST);
            //TODO: think about unix timestamp values as it is.
            $this->model->updated = date("Y-m-d H:i:s");
            $this->model->created = date("Y-m-d H:i:s");

            echo (json_encode(['status' => $this->model->saveRow()]));
            exit;
        }
    }

    public function actionRenew($id)
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE
        if (!empty($this->model)) {
            $this->model->get($id);
            //big question about this.
            parse_str(file_get_contents('php://input', false , null, -1 , (int)$_SERVER['CONTENT_LENGTH'] ), $_PUT);
            $this->model->load($_PUT);
            $this->model->updated = date("Y-m-d H:i:s");

            echo (json_encode(['status' => $this->model->updateRow()]));
            exit;
        }
    }

    public function actionDelete($id)
    {
        //TODO: STATUS CODES REPLY NEEDED FOR SUCCESS AND FALSE
        if (!empty($this->model)) {
            $this->model->get($id);
            echo (json_encode(['status' => $this->model->deleteRow()]));
            exit;
        }
    }
}
