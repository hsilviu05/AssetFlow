<?php
    require_once __DIR__ . '/BaseModel.php';
    require_once __DIR__ . '/../config/DBConnection.php';
    require_once __DIR__ . '/exceptions/InvalidCredentialsException.php';
    
    class EmployeeModel extends BaseModel
    {
        private $db;

        public function __construct()
        {
            $this->db = DBConnection::getInstance()->getConnection();
        }

        public function find($id)
        {
            $stmt = $this->db->prepare("SELECT * FROM Employees WHERE employee_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function findAll()
        {
            $stmt = $this->db->query("SELECT * FROM Employees");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function save(array $data)
        {
            $stmt = $this->db->prepare("INSERT INTO Employees (full_name, email, department, app_role, password_hash) VALUES (:full_name, :email, :department, :app_role, :password_hash)");
            $stmt->bindValue(':full_name', $data['full_name']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':department', $data['department']);
            $stmt->bindValue(':app_role', $data['app_role']);
            $stmt->bindValue(':password_hash', $data['password_hash']);
            return $stmt->execute();
        }

        public function update($id, array $data)
        {
            $stmt = $this->db->prepare("UPDATE Employees SET name = :name, position = :position, department = :department WHERE employee_id = :id");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':position', $data['position']);
            $stmt->bindParam(':department', $data['department']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function delete($id)
        {
            $stmt = $this->db->prepare("DELETE FROM Employees WHERE employee_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }


        public function register(string $email, string $password)
        {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("INSERT INTO Users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        }

        public function login(string $email, string $password)
        {
            $stmt = $this->db->prepare("SELECT * FROM Employees WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) 
            {
                return $user;
            }
            else
                throw new InvalidCredentialsException();
        }
    }
?>