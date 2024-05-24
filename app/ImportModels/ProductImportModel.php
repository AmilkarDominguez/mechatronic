<?php

namespace App\ImportModels;

use App\Models\Batch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPresentation;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductImportModel implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $product = new Product([
            'name' => $row['producto'],
            'description' => $row['descripcion'],
            'code' => $row['codigo'],
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
            'category_id' => $this->getCategoryId($row['categoria']),
            'presentation_id' => $this->getPresentationId($row['presentacion']),
        ]);

        $this->registerBatch(
            $product->id,
            $row['cantidad'],
            $row['deposito'],
            $row['proveedor'],
            $row['industria'],
            $row['nombre_lote'],
            $row['precio_compra'],
            $row['precio_mayorista'],
            $row['precio_minorista'],
            $row['precio_final'],
        );

        return $product;
    }

    public function registerBatch(
        $product_id,
        $stock,
        $warehouse_name,
        $supplier_name,
        $industry_name,
        $batch_name,
        $purchase_price,
        $wholesale_price,
        $retail_price,
        $final_price,
    )
    {
        $warehouse_id = $this->getWarehouseId($warehouse_name);
        $supplier_id = $this->getSupplierId($supplier_name);
        $industry_id = $this->getIndustryId($industry_name);

        Batch::create([
            'product_id' => $product_id,
            'warehouse_id' => $warehouse_id,
            'supplier_id' => $supplier_id,
            'industry_id' => $industry_id,
            'name' => $batch_name,
            'wholesale_price' => $wholesale_price,
            'retail_price' => $retail_price,
            'final_price' => $final_price,
            'stock' => $stock,
            'description' => null,
            'slug' => Str::uuid()
        ]);
    }

    public function getWarehouseId($name)
    {
        try {
            $warehouse = DB::table('warehouses')->where('name', $name)->first();
            return $warehouse->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $warehouse = Warehouse::create([
                'name' => $name,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE',
            ]);
            return $warehouse->id;
        }
    }

    public function getSupplierId($name)
    {
        try {
            $supplier = DB::table('suppliers')->where('name', $name)->first();
            return $supplier->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $supplier = Supplier::create([
                'name' => $name,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE',
            ]);
            return $supplier->id;
        }
    }

    public function getIndustryId($name)
    {
        try {
            $industry = DB::table('industries')->where('name', $name)->first();
            return $industry->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $industry = Supplier::create([
                'name' => $name,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE',
            ]);
            return $industry->id;
        }
    }

    public function getCategoryId($name)
    {
        try {
            $category = DB::table('product_categories')->where('name', $name)->first();
            return $category->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $category = ProductCategory::create([
                'name' => $name,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE',
            ]);
            return $category->id;
        }
    }

    public function getPresentationId($code)
    {
        try {
            $presentation = DB::table('product_presentations')->where('code', $code)->first();
            //$presentation = ProductPresentation::where('code', $code)->firstOrFail();
            return $presentation->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $presentation = ProductPresentation::create([
                'name' => $code,
                'code' => $code,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE'
            ]);
            return $presentation->id;
        }
    }

}
