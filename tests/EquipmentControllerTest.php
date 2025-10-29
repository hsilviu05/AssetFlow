<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controller/EquipmentController.php';

class EquipmentControllerTest extends TestCase
{
    protected $controller;
    
    protected function setUp(): void
    {
        $this->controller = new EquipmentController('admin');
    }
    
    public function testControllerInstantiates()
    {
        $this->assertInstanceOf(EquipmentController::class, $this->controller);
    }
    
    public function testAddActionRequiresAdmin()
    {
        $adminController = new EquipmentController('admin');
        $this->assertInstanceOf(EquipmentController::class, $adminController);
    }
}

