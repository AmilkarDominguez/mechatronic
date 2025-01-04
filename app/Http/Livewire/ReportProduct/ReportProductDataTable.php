<?php

namespace App\Http\Livewire\ReportProduct;


use App\Models\ServiceOrderBatch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ReportProductDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = ServiceOrderBatch::class;
    public $start_date;
    public $end_date;


    protected $listeners = ['setDatesReportProduct'];

    public function setDatesReportProduct($start, $end)
    {
        $this->start_date = $start;
        $this->end_date = $end;
    }

    public function builder()
    {

//return DB::select('select * from sale_details');
//        return DB::table('sale_details')
//            ->select(DB::raw('count(*) as user_count, status'))
//            ->where('sale_details.state', '!=', 'DELETED')
//            ->groupBy('status')
//            ->get();

//        return Product::select(
//            '*'
//        )
//            ->join('batches', 'products.id', '=', 'batches.product_id')
//            ->join('sale_details', 'sale_details.batch_id', '=', 'batches.id')
//            ->where('sale_details.state', '!=', 'DELETED')
//            ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date])
//            //->groupBy('products.name');


//            (Product::query()
//            ->select('name', 'product_id', 'batch_id', DB::raw('COUNT(*) as total_sales'))
//            ->join('batches', function ($join) {
//                $join->on('products.id', '=', 'batches.product_id');
//            })
//            ->join('sale_details', function ($join) {
//                $join->on('sale_details.batch_id', '=', 'batches.id');
//            })
//            ->where('sale_details.state', '!=', 'DELETED')
//            ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date])
//            ->groupBy('products.id')
//        );


        //this works 2
//        return (Product::query()
//            ->select('name', 'product_id', 'batch_id', DB::raw('COUNT(*) as total_sales'))
//            ->join('batches', function ($join) {
//                $join->on('products.id', '=', 'batches.product_id');
//            })
//            ->join('sale_details', function ($join) {
//                $join->on('sale_details.batch_id', '=', 'batches.id');
//            })
//            ->where('sale_details.state', '!=', 'DELETED')
//            ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date])
//            ->groupBy('products.id')
//        );

        //this works
        return (ServiceOrderBatch::query()
            ->join('batches', function ($join) {
                $join->on('sale_details.batch_id', '=', 'batches.id');
            })
            ->join('products', function ($join) {
                $join->on('batches.product_id', '=', 'products.id');
            })
            ->where('sale_details.state', '!=', 'DELETED')
            ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date])
            ->groupBy('products.id')
        );
    }

    public function columns()
    {
        return [

            Column::name('products.name')
                ->label('name'),


            Column::callback(['id', 'batches.id', 'products.id'], function ($id, $batch_id, $product_id) {
                $details = ServiceOrderBatch::query()
                    ->join('batches', function ($join) {
                        $join->on('sale_details.batch_id', '=', 'batches.id');
                    })
                    ->join('products', function ($join) {
                        $join->on('batches.product_id', '=', 'products.id');
                    })
                    ->where('sale_details.state', '!=', 'DELETED')
                    ->where('products.id', $product_id)
                    ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date]);
                return $details->count();
            })
                ->defaultSort('asc')
                ->label('Cantidad'),


        ];
    }


}
