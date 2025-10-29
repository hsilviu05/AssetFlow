<?php

require_once __DIR__ . '/../model/exceptions/InvalidCredentialsException.php';
require_once __DIR__ . '/../model/AllocationModel.php';

class AllocationController
{
    private $userRole;
    private $allocationModel;

    public function __construct($userRole = null)
    {
        $this->userRole = $userRole;
        $this->allocationModel = new AllocationModel();
    }

    public function allocateAction($data)
    {
        if ($this->userRole == "admin" || $this->userRole == "manager")
        {
            return $this->allocationModel->allocate($data);
        }
        else
        {
            throw new InvalidCredentialsException("Only admins and managers can allocate equipment.");
        }
    }

    public function deallocateAction($allocationId)
    {
        if ($this->userRole == "manager" || $this->userRole == "admin")
        {
            // Get allocation details first
            require_once __DIR__ . '/../model/EquipmentModel.php';
            
            try {
                $allocation = $this->allocationModel->find($allocationId);
                if ($allocation && isset($allocation['equipment_id'])) {
                    $equipmentModel = new EquipmentModel();
                    $updateData = ['status' => 'Available'];
                    $equipmentModel->updateEquipmentStatus($allocation['equipment_id'], $updateData);
                }
                
                $this->allocationModel->delete($allocationId);
                header('Location: index.php?controller=equipment&action=list&success=' . urlencode('Equipment deallocated successfully!'));
                exit;
            } catch (Exception $e) {
                header('Location: index.php?controller=equipment&action=list&error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        else
        {
            throw new InvalidCredentialsException("Only admins and managers can deallocate equipment.");
        }
    }
}

?>