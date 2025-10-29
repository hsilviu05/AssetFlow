<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/BaseModel.php';
require_once __DIR__ . '/../model/EquipmentModel.php';

class BaseModelTest extends TestCase
{
    protected $model;
    
    protected function setUp(): void
    {
        $this->model = new EquipmentModel();
    }
    
    public function testModelInheritsFromBaseModel()
    {
        $this->assertInstanceOf(BaseModel::class, $this->model);
    }
    
    public function testModelImplementsCRUDInterface()
    {
        $this->assertInstanceOf(CRUDInterface::class, $this->model);
    }
    
    public function testFindAllMethodExists()
    {
        $this->assertTrue(method_exists($this->model, 'findAll'));
    }
    
    public function testSaveMethodExists()
    {
        $this->assertTrue(method_exists($this->model, 'save'));
    }
    
    public function testFindMethodExists()
    {
        $this->assertTrue(method_exists($this->model, 'find'));
    }
}

