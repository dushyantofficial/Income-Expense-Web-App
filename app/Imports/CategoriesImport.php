<?php

namespace App\Imports;

use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        Validator::make($row, [
            'name' => 'required',
            'icon' => 'required',
        ])->validate();


        return new Categories([
            'name' => $row['name'],
            'icon' => $row['icon'],
            'status' => 'active',
        ]);


    }


}
