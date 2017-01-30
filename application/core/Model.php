<?php
namespace Application\Core;

use Application\Core\DbConnector;
use Application\Core\ServiceLocator;

abstract class Model {

    const FIELDS_TYPES = [
        'id' => 'INT AUTO_INCREMENT',
    ];

    public $db = null;

    protected $tableName = '';

    protected $services;

    public function __construct(ServiceLocator $services)
    {
        $this->services = $services;
    }

    public function connect()
    {
        $this->db = DbConnector::get_instance()->handler();
    }

    public function get($id = null)
    {
        if (! $id) {
            die('row Id must be setted!');
        }

        $query = $this->db->prepare("SELECT * FROM `$this->tableName` WHERE id = ?");

        $result = $query->execute([$id]);

        if (! empty($result) && $result)
        {
            $data = $query->fetchAll(\PDO::FETCH_ASSOC);

            if (! empty($data[0])) {
                foreach($data[0] as $field => $value) {
                    if (property_exists($this, $field)) {
                        $this->$field = $value;
                    }
                }

                return $data[0];
            }
        } else {
            var_dump($query);
        }

    }

    //TODO: possibility to get data by params.
    public function all($params = null)
    {
        $query = $this->db->prepare("SELECT * FROM `$this->tableName`");

        $result = $query->execute();

        //maybe there is a reason to make only !empty().
        if (!empty($result) && $result)
        {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            var_dump($query);
        }

    }

    // In case highload - must be deleted.
    public function createTable($index = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->tableName` (";
        foreach(static::FIELDS_TYPES as $field => $type) {
            $sql .= "`$field` $type,";
        }
        $sql = rtrim($sql, ',');
        $sql .= ') CHARACTER SET utf8 COLLATE utf8_general_ci';
        if (! empty($index)) {
            $sql .= '; ' . $index;
        }
        $this->db->query($sql);
    }

    public function saveRow()
    {
      $values = '';
      $sql = "INSERT INTO $this->tableName (";
      foreach(static::FIELDS_TYPES as $field => $type) {
          if ($field != 'id' && property_exists($this, $field)) {
              $sql .= "`$field`,";
              $values .= '\'' . $this->$field . '\',';
          }
      }
      $sql = rtrim($sql, ',');
      $values = rtrim($values, ',');
      $sql .= ") VALUES($values)";
      $query = $this->db->prepare($sql);
      $result = $query->execute();

      return $result;
    }


    public function updateRow()
    {
      $sql = "UPDATE $this->tableName SET ";
      foreach(static::FIELDS_TYPES as $field => $type) {
          if ($field != 'id' && property_exists($this, $field)) {
              $sql .= "`$field`='" . $this->$field . "',";
          }
      }

      $sql = rtrim($sql, ',');
      $sql .= " WHERE id = ?";
      $query = $this->db->prepare($sql);
      $result = $query->execute([$this->id]);

      return $result;
    }

    public function deleteRow()
    {
      $values = '';
      $sql = "DELETE FROM $this->tableName WHERE id = ?";
      $query = $this->db->prepare($sql);
      $result = $query->execute([$this->id]);

      return $result;
    }
}
