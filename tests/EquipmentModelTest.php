<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/EquipmentModel.php';
require_once __DIR__ . '/../config/DBConnection.php';

class EquipmentModelTest extends TestCase
{
    protected $model;
    protected $typeId = 1;
    
    protected function setUp(): void
    {
        $this->model = new EquipmentModel();
        
        $db = DBConnection::getInstance()->getConnection();
        $stmt = $db->query("SELECT type_id FROM EquipmentTypes LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            $db->exec("INSERT INTO EquipmentTypes (type_name, description) VALUES ('Test Type', 'For testing')");
        }
        
        $stmt = $db->query("SELECT type_id FROM EquipmentTypes LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->typeId = $result['type_id'];
        }
    }
    
    public function testFindAllReturnsArray()
    {
        $result = $this->model->findAll();
        $this->assertIsArray($result);
    }
    
    public function testFindExistingIdReturnsEquipment()
    {
        $result = $this->model->find(1);
        if ($result) {
            $this->assertIsArray($result);
            $this->assertArrayHasKey('equipment_id', $result);
        } else {
            $this->markTestSkipped('No equipment with ID 1 in database');
        }
    }
    
    public function testGetEquipmentStatusReturnsString()
    {
        try {
            $status = $this->model->getEquipmentStatus(1);
            $this->assertIsString($status);
        } catch (Exception $e) {
            $this->markTestSkipped('No equipment in database');
        }
    }
    
    public function testSaveInsertsNewEquipment()
    {
        $data = [
            'inventory_code' => 'TEST' . time(),
            'name' => 'Test Equipment',
            'type_id' => $this->typeId,
            'specifications' => 'Test specs',
            'status' => 'Available',
            'purchase_date' => '2024-01-01',
            'os_version' => 'Windows 11',
            'location' => 'Test Lab'
        ];
        
        $result = $this->model->save($data);
        $this->assertTrue($result);
    }
    
    public function testDeleteRemovesEquipment()
    {
        $data = [
            'inventory_code' => 'DELETE' . time(),
            'name' => 'To Delete',
            'type_id' => $this->typeId,
            'specifications' => '',
            'status' => 'Available',
            'purchase_date' => '2024-01-01',
            'os_version' => 'Linux',
            'location' => 'Test'
        ];
        $this->model->save($data);
        
        $stmt = DBConnection::getInstance()->getConnection()->query("SELECT equipment_id FROM Equipment ORDER BY equipment_id DESC LIMIT 1");
        $lastRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($lastRow && isset($lastRow['equipment_id'])) {
            $lastId = $lastRow['equipment_id'];
            $result = $this->model->delete($lastId);
            $this->assertTrue($result);
        } else {
            $this->markTestSkipped('Could not retrieve last inserted ID');
        }
    }
}

