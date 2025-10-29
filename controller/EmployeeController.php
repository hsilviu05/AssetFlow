<?php

require_once __DIR__ . '/../model/exceptions/InvalidCredentialsException.php';
require_once __DIR__ . '/../model/EmployeeModel.php';

class EmployeeController
{
    private $userRole;
    private $employeeModel;

    public function __construct($userRole = null)
    {
        $this->userRole = $userRole;
        $this->employeeModel = new EmployeeModel();
    }

    public function listAction()
    {
        if ($this->userRole == "admin" || $this->userRole == "manager")
        {
            return $this->employeeModel->findAll();
        }
        else
        {
            throw new InvalidCredentialsException("Only admins and managers can view employees.");
        }
    }

    public function addAction($data)
    {
        if ($this->userRole == "admin")
        {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $employeeData = [
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'department' => $data['department'],
                'app_role' => $data['app_role'] ?? 'employee',
                'password_hash' => $hashedPassword
            ];
            
            return $this->employeeModel->save($employeeData);
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can add employees.");
        }
    }

    public function removeAction($id)
    {
        if ($this->userRole == "admin")
        {
            return $this->employeeModel->delete($id);
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can remove employees.");
        }
    }

    public function updateAction($id, $data)
    {
        if($this->userRole == "admin")
        {
            return $this->employeeModel->update($id, $data);
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can update employees.");
        }
    }
}

?>

