<?php

class EquipmenentController
{
    public function addAction()
    {
        if ($data[$app_role] == "admin")
        {
            // proceed with adding equipment
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can add equipment.");
        }
    }

    public function removeAction()
    {
        if ($data[$app_role] == "admin")
        {
            // proceed with adding equipment
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can remove equipment.");
        }
    }

    public function updateAction()
    {
        if($data[$app_role] == "admin")
        {
            // proceed with adding equipment
        }
        else
        {
            throw new InvalidCredentialsException("Only admins can update equipment.");
        }
    }
}

?>