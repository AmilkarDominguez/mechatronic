<?php

namespace App\ImportModels;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductCategoryImportModel implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProductCategory([
            'name' => $row['nombre'],
            'title' => $row['nombre'],
            'slug' => Str::slug($row['nombre']),
            'description' => $row['descripcion'],
            'state' => 'ACTIVE',
        ]);
    }
}
