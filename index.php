<?php
spl_autoload_register(function ($className) {
    $directories = [
        __DIR__ . '/model',
        __DIR__ . '/controller',
        __DIR__ . '/config',
        __DIR__ . '/model/exceptions'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . '/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/config/DBConnection.php';

session_start();

// Redirect to login if not authenticated (except for login page)
$action = $_GET['action'] ?? 'index';
$controller = $_GET['controller'] ?? 'auth';

// Public routes that don't require authentication
$publicRoutes = ['auth'];

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// If logged in and on default page, redirect to equipment list
if ($controller == 'auth' && $isLoggedIn && $action == 'index') {
    header('Location: index.php?controller=equipment&action=list');
    exit;
}

// Redirect to login if not logged in and trying to access protected routes
if (!in_array($controller, $publicRoutes) && !$isLoggedIn) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

switch ($controller) {
    case 'equipment':
        require_once __DIR__ . '/controller/EquipmentController.php';
        $ctrl = new EquipmentController($_SESSION['user_role'] ?? null);
        
        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $ctrl->addAction($_POST);
                    header('Location: ?controller=equipment&action=list');
                } else {
                    require_once __DIR__ . '/model/EquipmentModel.php';
                    $model = new EquipmentModel();
                    $equipmentTypes = []; // You can add equipment types if needed
                    include __DIR__ . '/view/equipment/add.php';
                }
                break;
            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $ctrl->updateAction($_POST['id'], $_POST);
                    header('Location: ?controller=equipment&action=list');
                }
                break;
            case 'delete':
                $ctrl->removeAction($_GET['id']);
                header('Location: ?controller=equipment&action=list');
                break;
            case 'list':
            default:
                require_once __DIR__ . '/model/EquipmentModel.php';
                $model = new EquipmentModel();
                $equipment = $model->findAll();
                include __DIR__ . '/view/equipment/list.php';
                break;
        }
        break;
        
    case 'allocation':
        require_once __DIR__ . '/controller/AllocationController.php';
        $ctrl = new AllocationController($_SESSION['user_role'] ?? null);
        
        switch ($action) {
            case 'allocate':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        $result = $ctrl->allocateAction($_POST);
                        header('Location: ?controller=equipment&action=list&success=' . urlencode('Equipment allocated successfully!'));
                    } catch (Exception $e) {
                        header('Location: ?controller=equipment&action=list&error=' . urlencode($e->getMessage()));
                    }
                } else {
                    require_once __DIR__ . '/model/EquipmentModel.php';
                    require_once __DIR__ . '/model/EmployeeModel.php';
                    $equipmentModel = new EquipmentModel();
                    $employeeModel = new EmployeeModel();
                    $equipment = $equipmentModel->findAll();
                    $employees = $employeeModel->findAll();
                    include __DIR__ . '/view/equipment/allocate.php';
                }
                break;
            default:
                echo "Allocation management";
                break;
        }
        break;
    
    case 'employee':
        require_once __DIR__ . '/controller/EmployeeController.php';
        $ctrl = new EmployeeController($_SESSION['user_role'] ?? null);
        
        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $ctrl->addAction($_POST);
                    header('Location: ?controller=employee&action=list');
                } else {
                    include __DIR__ . '/view/employee/add.php';
                }
                break;
            case 'list':
                $employees = $ctrl->listAction();
                include __DIR__ . '/view/employee/list.php';
                break;
            case 'delete':
                $ctrl->removeAction($_GET['id']);
                header('Location: ?controller=employee&action=list');
                break;
            default:
                include __DIR__ . '/view/employee/list.php';
                break;
        }
        break;
    
    case 'auth':
        require_once __DIR__ . '/controller/AuthController.php';
        $authCtrl = new AuthController();
        
        switch ($action) {
            case 'login':
                $authCtrl->loginAction();
                break;
            case 'logout':
                $authCtrl->logoutAction();
                break;
            default:
                include __DIR__ . '/view/auth/login.php';
                break;
        }
        break;
        
    case 'deallocate':
        require_once __DIR__ . '/controller/AllocationController.php';
        $ctrl = new AllocationController($_SESSION['user_role'] ?? null);
        $ctrl->deallocateAction($_GET['id']);
        header('Location: ?controller=equipment&action=list');
        break;
        
    default:
        echo "<h1>Asset Management System</h1>";
        echo "<p><a href='?controller=equipment&action=list'>View Equipment</a></p>";
        break;
}
?>

