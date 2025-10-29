<?php

require_once __DIR__ . '/../model/exceptions/InvalidCredentialsException.php';

class EquipmentController
{
    private $userRole;
    private $equipmentModel;

    public function __construct($userRole = null)
    {
        $this->userRole = $userRole;
        require_once __DIR__ . '/../model/EquipmentModel.php';
        $this->equipmentModel = new EquipmentModel();
    }

    public function addAction($data)
    {
        if ($this->userRole == "admin" || $this->userRole == "it_manager")
        {
            try {
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../public/uploads/';
                    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
                    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                    
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($imageFileType, $allowedTypes)) {
                        throw new Exception('Invalid image type. Allowed: JPG, PNG, GIF, WEBP');
                    }
                    
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                        $data['photo_path'] = 'uploads/' . basename($_FILES['photo']['name']);
                    } else {
                        throw new Exception('Failed to upload photo');
                    }
                }
                
                return $this->equipmentModel->save($data);
            } catch (Exception $e) {
                header('Location: index.php?controller=equipment&action=list&error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        else
        {
            header('Location: index.php?controller=equipment&action=list&error=' . urlencode("Only admins and managers can add equipment."));
            exit;
        }
    }

    public function removeAction($id)
    {
        if ($this->userRole == "admin")
        {
            try {
                $result = $this->equipmentModel->delete($id);
                header('Location: index.php?controller=equipment&action=list&success=' . urlencode('Equipment deleted successfully!'));
                exit;
            } catch (Exception $e) {
                header('Location: index.php?controller=equipment&action=list&error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        else
        {
            header('Location: index.php?controller=equipment&action=list&error=' . urlencode("Only admins can remove equipment."));
            exit;
        }
    }

    public function updateAction($id, $data)
    {
        if($this->userRole == "admin")
        {
            try {
                $result = $this->equipmentModel->update($id, $data);
                header('Location: index.php?controller=equipment&action=list&success=' . urlencode('Equipment updated successfully!'));
                exit;
            } catch (Exception $e) {
                header('Location: index.php?controller=equipment&action=list&error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        else
        {
            header('Location: index.php?controller=equipment&action=list&error=' . urlencode("Only admins can update equipment."));
            exit;
        }
    }
}

?>