<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
    }

    public function view(User $user, Employee $employee)
    {
        if ($user->role === 'superadmin') {
            return true; // can view all employees
        }

        if ($user->role === 'admin') {
            return $user->employee &&
                $user->employee->department &&
                $employee->department &&
                $user->employee->department->instansi_id === $employee->department->instansi_id;
        }

        if ($user->role === 'user') {
            return $user->employee_id === $employee->id;
        }

        return false;
    }

    public function create(User $user)
  {
      // Izinkan subadmin untuk mengakses form pembuatan karyawan
      return in_array($user->role, ['superadmin', 'admin', 'subadmin']);
  }

    public function update(User $user, Employee $employee)
    {
        if ($user->role === 'superadmin') {
            return true;
        }
        if ($user->role === 'admin') {
            return $user->employee &&
                $user->employee->institution &&
                $employee->institution &&
                $user->employee->institution->id === $employee->institution->id;
        }

        if ($user->role === 'subadmin') {
            return $user->employee &&
                $user->employee->department &&
                $employee->department &&
                $user->employee->department_id === $employee->department_id;
        }

        return $this->view($user, $employee);
    }

    public function delete(User $user, Employee $employee)
    {
        if ($user->role === 'superadmin') {
            return true;
        }
        if ($user->role === 'admin') {
            return $user->employee &&
                $user->employee &&
                $employee &&
                $user->employee->institution_id === $employee->institution_id;
        }
        if ($user->role === 'subadmin') {
            return $user->employee &&
                $user->employee->department &&
                $employee->department &&
                $user->employee->department_id === $employee->department_id;
        }

        return $this->update($user, $employee);
    }
}
