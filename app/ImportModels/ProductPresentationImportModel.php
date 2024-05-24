<?php

namespace App\ImportModels;

use App\Models\ProductPresentation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductPresentationImportModel implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProductPresentation([
            'name' => $row['nombre'],
            'code' => $row['codigo'],
            'description' => $row['descripcion'],
            'state' => 'ACTIVE',
            'slug' => Str::uuid(),
        ]);
    }
}
