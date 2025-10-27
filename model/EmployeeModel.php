<?php
    class EmployeeModel extends CRUDInterface
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
            $stmt = $this->db->prepare("INSERT INTO Employees (name, position, department) VALUES (:name, :position, :department)");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':position', $data['position']);
            $stmt->bindParam(':department', $data['department']);
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
            $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) 
            {
                return $user;
            }
            else
                throw new InvalidCredentialsException();
        }
    }
?>