<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/AllocationModel.php';
require_once __DIR__ . '/../model/exceptions/StockZeroException.php';

class AllocationModelTest extends TestCase
{
    protected $model;
    
    protected function setUp(): void
    {
        $this->model = new AllocationModel();
    }
    
    public function testModelInstantiates()
    {
        $this->assertInstanceOf(AllocationModel::class, $this->model);
    }
    
    public function testAllocationThrowsExceptionForUnavailableEquipment()
    {
        // This test expects an exception when equipment is not found or unavailable
        $this->expectException(Exception::class);
        
        $data = [
            'equipment_id' => 99999, // Non-existent equipment
            'employee_id' => 1,
            'admin_id' => 1,
            'allocation_date' => date('Y-m-d')
        ];
        
        $this->model->allocate($data);
    }
}

