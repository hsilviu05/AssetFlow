<?php

use model\exceptions\InvalidCredentialsException;


class AllocationController
{
    public function allocateAction()
    {
        if ($data[$app_role] == "admin" || $data[$app_role] == "manager")
        {
            alocate();
        }
        else
        {
            throw new InvalidCredentialsException("Only admins and managers can allocate equipment.");
        }
    }

    public function deallocateAction()
    {
        if ($data[$app_role] == "manager" || $data[$app_role] == "admin")
        {
            // proceed with deallocating equipment
        }
        else
        {
            throw new InvalidCredentialsException("Only admins and managers can deallocate equipment.");
        }
    }
}

?>