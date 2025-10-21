<?php

class ServerModel extends EquipmentModel
{
    private const SERVER_TYPE_NAME = 'Server';


    public function __construct()
    {
        parent::__construct();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT e.* FROM Equipment e
            JOIN EquipmentTypes t ON e.type_id = t.type_id
            WHERE e.equipment_id = :id AND t.type_name = :type_name
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':type_name', self::SERVER_TYPE_NAME);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByOperatingSystem($osVersion)
    {
        $stmt = $this->db->prepare("
            SELECT e.*, t.type_name 
            FROM Equipment e
            JOIN EquipmentType t ON e.type_id = t.type_id
            WHERE t.type_name = :type_name AND e.os_version = :os_version
        ");
        $stmt->bindParam(':type_name', self::SERVER_TYPE_NAME);
        $stmt->bindParam(':os_version', $osVersion);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByLocation($location)
    {
        $stmt = $this->db->prepare("
            SELECT e.*, t.type_name 
            FROM Equipment e
            JOIN EquipmentType t ON e.type_id = t.type_id
            WHERE t.type_name = :type_name AND e.location = :location
        ");
        $stmt->bindParam(':type_name', self::SERVER_TYPE_NAME);
        $stmt->bindParam(':location', $location);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(array $data)
    {
        $ServerID = $this->getEquipmentTypeIdByName(self::SERVER_TYPE_NAME);
        if ($ServerID === null) {
            throw new Exception("Equipment type 'Server' not found in the database.");
        }

        $data['type_id'] = $serverId;
    
        return parent::save($data);
    }
}


?>