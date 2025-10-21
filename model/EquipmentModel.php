<?php
    class Equipment extends CRUDInterface
    {
        private $db;

        public function __construct()
        {
            $this->db = DBConnection::getInstance()->getConnection();
        }

        public function find($id)
        {
            $stmt = $this->db->prepare("SELECT * FROM Equipment WHERE equipment_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findAll()
        {
            $stmt = $this->db->query("SELECT * FROM Equipment");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function save(array $data)
        {
            $stmt = $this->db->prepare("INSERT INTO Equipment (name, type_id, purchase_date) VALUES (:name, :type_id, :purchase_date)");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':type_id', $data['type_id'], PDO::PARAM_INT);
            $stmt->bindParam(':purchase_date', $data['purchase_date']);
            return $stmt->execute();
        }

        public function update($id, array $data)
        {
            $stmt = $this->db->prepare("UPDATE Equipment SET name = :name, type_id = :type_id, purchase_date = :purchase_date WHERE equipment_id = :id");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':type_id', $data['type_id'], PDO::PARAM_INT);
            $stmt->bindParam(':purchase_date', $data['purchase_date']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function delete($id)
        {
            $stmt = $this->db->prepare("DELETE FROM Equipment WHERE equipment_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function getEquipmentTypeIdByName($typeName)
    {
        $stmt = $this->db->prepare("SELECT type_id FROM EquipmentType WHERE type_name = :type_name");
        $stmt->bindParam(':type_name', $typeName);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['type_id'] : null;
    }


        private function getEquipmentStatus($equipmentId): string
        {
            $stmt = $this->connection->prepare("SELECT status FROM Equipment WHERE equipment_id = :equipment_id");
            $stmt->bindParam(':equipment_id', $equipmentId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['status'];
            } else {
                throw new Exception("Equipment with ID {$equipmentId} not found.");
            }
        }

        private function updateEquipmentStatus($equipmentId, array $data): bool
        {
            $setClause = "";
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            $setClause = rtrim($setClause, ", ");
            $stmt = $this->connection->prepare("UPDATE Equipment SET $setClause WHERE equipment_id = :equipment_id");
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(":equipment_id", $equipmentId, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

?>