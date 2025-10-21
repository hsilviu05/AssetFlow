<?php

use Model\Exceptions\StockZeroException;


    class AllocationModel extends BaseModel
    {

        public function allocate(array $data): int
        {
            $equipmentId = $data['equipment_id'];

            $equuipementStatus = $this->getEquipmentStatus($equipmentId);

            if ($equuipementStatus !== 'Available') 
            {
                throw new StockZeroException("Equipment ID {$equipmentId} is not available for allocation. Status: {$equipmentStatus}");            
            }

            $newAllocationId = parent::save($data);

            $updateData = ['status' => 'Allocated'];
            $this->updateEquipmentStatus($equipmentId, $updateData);    

            return $newAllocationId;
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