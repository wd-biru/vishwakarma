<?php

namespace App\Imports\Models;

use App\Models\EmployeeProfile;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EmployeeProfile([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => \Hash::make('123456'),
        ]);
    }
}
