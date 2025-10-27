<?php

    use Model\Exceptions\StockZeroException;


    class AllocationModel extends BaseModel
    {
        protected $tableName = 'Allocations';
        private $equipmentModel;

        public function __construct()
        {
            parent::__construct();
            $this->equipmentModel = new EquipmentModel(); 
        }

        public function allocate(array $data): int
        {
            $equipmentId = $data['equipment_id'];

            $equipementStatus = $this->equipmentModel->getEquipmentStatus($equipmentId);

            if ($equipementStatus !== 'Available') 
            {
                throw new StockZeroException("Equipment ID {$equipmentId} is not available for allocation. Status: {$equipmentStatus}");            
            }

            $newAllocationId = parent::save($data);

            $updateData = ['status' => 'Allocated'];
            $this->updateEquipmentStatus($equipmentId, $updateData);    

            return $newAllocationId;
        }
    }
?>