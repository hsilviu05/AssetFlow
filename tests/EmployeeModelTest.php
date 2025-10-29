<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/EmployeeModel.php';

class EmployeeModelTest extends TestCase
{
    protected $model;
    
    protected function setUp(): void
    {
        $this->model = new EmployeeModel();
    }
    
    public function testFindAllReturnsArray()
    {
        $result = $this->model->findAll();
        $this->assertIsArray($result);
    }
    
    public function testModelInstantiates()
    {
        $this->assertInstanceOf(EmployeeModel::class, $this->model);
    }
}

