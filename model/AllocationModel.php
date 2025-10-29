<?php

    require_once __DIR__ . '/exceptions/StockZeroException.php';
    require_once __DIR__ . '/EquipmentModel.php';

    class AllocationModel extends BaseModel
    {
        protected $tableName = 'Allocations';
        private $equipmentModel;
        private $db;

        public function __construct()
        {
            parent::__construct();
            $this->equipmentModel = new EquipmentModel();
            $this->db = DBConnection::getInstance()->getConnection();
        }

        public function findAll()
        {
            $stmt = $this->db->query("SELECT * FROM Allocations");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function find($id)
        {
            $stmt = $this->db->prepare("SELECT * FROM Allocations WHERE allocation_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function delete($id)
        {
            $stmt = $this->db->prepare("DELETE FROM Allocations WHERE allocation_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function allocate(array $data): int
        {
            $equipmentId = $data['equipment_id'];

            $equipementStatus = $this->equipmentModel->getEquipmentStatus($equipmentId);

            if ($equipementStatus !== 'Available') 
            {
                throw new StockZeroException("Equipment ID {$equipmentId} is not available for allocation. Status: {$equipementStatus}");            
            }

            $newAllocationId = parent::save($data);

            $updateData = ['status' => 'Allocated'];
            $this->equipmentModel->updateEquipmentStatus($equipmentId, $updateData);    

            return $newAllocationId;
        }
    }
?>