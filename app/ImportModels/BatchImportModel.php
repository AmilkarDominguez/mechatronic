<?php

namespace App\ImportModels;

use App\Models\Batch;
use App\Models\Expense;
use App\Models\Industry;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPresentation;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BatchImportModel implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $name = '-';
        if ($row['nombre_lote'] !== null) {
            $name = $row['nombre_lote'];
        }
        $slug = Str::uuid();
        $batch = new Batch([
            'product_id' => $this->getProductId($row['producto'], $row['descripcion'], $row['codigo'], $row['categoria'], $row['presentacion']),
            'warehouse_id' => $this->getWarehouseId($row['deposito']),
            'supplier_id' => $this->getSupplierId($row['proveedor']),
            'industry_id' => $this->getIndustryId($row['industria']),
            'name' => $name,
            'wholesale_price' => $row['precio_mayorista'],
            'retail_price' => $row['precio_minorista'],
            'final_price' => $row['precio_final'],
            'stock' => $row['cantidad'],
            //'description' => null,
            'expiration_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['vencimiento']),
            'slug' => $slug
        ]);
        $this->registerExpense($row['producto'], $row['precio_compra'], $slug);
        return $batch;
    }

    public function registerExpense($name, $purchase, $slug)
    {
        Expense::create([
            'expense_type_id' => 1,
            'purchase' => $purchase,
            'description' => 'Compra de lote de producto ' . $name,
            'slug' => $slug,
            'state' => 'ACTIVE',
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
            $industry = Industry::create([
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

    public function getProductId($name, $description, $code, $category, $presentation)
    {
        try {
            $product = DB::table('products')->where('name', $name)->first();
            return $product->id;
        } catch (\Exception $exception) {
            //dd($exception);
            $product = Product::create([
                'name' => $name,
                'code' => $code,
                'slug' => Str::uuid(),
                'state' => 'ACTIVE',
                'description' => $description,
                'category_id' => $this->getCategoryId($category),
                'presentation_id' => $this->getPresentationId($presentation),
            ]);
            return $product->id;
        }
    }

}
