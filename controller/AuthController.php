<?php
require_once __DIR__ . '/../model/EmployeeModel.php';
require_once __DIR__ . '/../model/exceptions/InvalidCredentialsException.php';

class AuthController
{
    private $employeeModel;
    
    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }
    
    public function loginAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->employeeModel->login($_POST['email'], $_POST['password']);
                
                $_SESSION['user_id'] = $user['employee_id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['app_role'];
                
                header('Location: index.php?controller=equipment&action=list');
                exit;
            } catch (InvalidCredentialsException $e) {
                header('Location: index.php?controller=auth&action=login&error=' . urlencode($e->getMessage()));
                exit;
            } catch (Exception $e) {
                header('Location: index.php?controller=auth&action=login&error=' . urlencode('An error occurred: ' . $e->getMessage()));
                exit;
            }
        } else {
            include __DIR__ . '/../view/auth/login.php';
        }
    }
    
    public function logoutAction()
    {
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?>