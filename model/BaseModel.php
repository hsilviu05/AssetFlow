<?php
    require_once __DIR__ . '/CRUDInterface.php';
    require_once __DIR__ . '/../config/DBConnection.php';
    
    class BaseModel implements CRUDInterface
    {
        protected $tableName;
        protected $connection;

        public function __construct ()
        {
            $this->connection = DBConnection::getInstance()->getConnection();
        }

        public function find($id)
        {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findAll()
        {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->tableName}");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function save(array $data)
        {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $stmt = $this->connection->prepare("INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)");
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            return $stmt->execute();
        }

        public function update($id, array $data)
        {
            $setClause = "";
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            $setClause = rtrim($setClause, ", ");
            $stmt = $this->connection->prepare("UPDATE {$this->tableName} SET $setClause WHERE id = :id");
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        }

        public function delete($id)
        {
            $stmt = $this->connection->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
?>
