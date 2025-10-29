<?php
    $dbFile = __DIR__ . '/database.sqlite';

    try 
    {
         $db = new PDO('sqlite:' . $dbFile);
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to SQLite database at: $dbFile\n";

    $db->exec("PRAGMA foreign_keys = ON;");

    $db->exec("
        CREATE TABLE IF NOT EXISTS EquipmentTypes (
            type_id INTEGER PRIMARY KEY AUTOINCREMENT,
            type_name VARCHAR(50) UNIQUE NOT NULL,
            description TEXT
        );
    ");


    $db->exec("
        CREATE TABLE IF NOT EXISTS Employees (
            employee_id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            department VARCHAR(50),
            app_role VARCHAR(20) NOT NULL,
            password_hash VARCHAR(255) NOT NULL
        );
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS Equipment (
            equipment_id INTEGER PRIMARY KEY AUTOINCREMENT,
            inventory_code VARCHAR(50) UNIQUE NOT NULL,
            name VARCHAR(100) NOT NULL,
            type_id INTEGER,
            specifications TEXT,
            status TEXT NOT NULL CHECK(status IN ('Available', 'Allocated', 'Service', 'Decommissioned')),
            purchase_date TEXT,
            os_version VARCHAR(50) NOT NULL,
            location VARCHAR(100) NOT NULL,
            photo_path VARCHAR(255),
            FOREIGN KEY (type_id) REFERENCES EquipmentTypes(type_id) ON DELETE SET NULL
            
        );
    ");


    $db->exec("
        CREATE TABLE IF NOT EXISTS Allocations (
            allocation_id INTEGER PRIMARY KEY AUTOINCREMENT,
            equipment_id INTEGER NOT NULL,
            employee_id INTEGER NOT NULL,
            admin_id INTEGER NOT NULL,
            allocation_date TEXT NOT NULL,
            estimated_return_date TEXT,
            notes TEXT,
            FOREIGN KEY (equipment_id) REFERENCES Equipment(equipment_id) ON DELETE CASCADE,
            FOREIGN KEY (employee_id) REFERENCES Employees(employee_id) ON DELETE CASCADE,
            FOREIGN KEY (admin_id) REFERENCES Employees(employee_id) ON DELETE CASCADE
        );
    ");

    echo "Database tables created successfully!\n";
    }
    catch (PDOException $e) 
    {
        echo "Database connection failed: " . $e->getMessage();
        exit();
    }
?>