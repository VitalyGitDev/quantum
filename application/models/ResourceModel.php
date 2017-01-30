<?php
namespace Application\Models;

use Application\Core\Model;

class ResourceModel extends Model
{

		public $name;

    public $dirrectory;

    protected $category;

    public $repository;

    public $local_domain;

    public function load(array $params)
    {
        foreach(get_object_vars($this) as $field => $type) {
            if ($field != 'id' && property_exists($this, $field) && isset($params[$field])) {
                $this->$field = $params[$field];
            }
        }
    }

    public function save()
    {
        $sources = file_get_contents($this->services->get('appConfig')->get('resources'));
        //TODO: Need to throw an Exception if JSON is wrong.
        $sources = json_decode($sources, true);
        if (!empty($sources)) {
            $sources[$this->category]['container'][] = [
                'name' => $this->name,
                'url' => $this->local_domain,
            ];
        }
        //die("<pre>" . print_r($sources, 1) . "</pre>");
        file_put_contents($this->services->get('appConfig')->get('resources'), json_encode($sources));
    }
}
