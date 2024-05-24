<?php

namespace App\Http\Livewire\ProductPresentation;

use App\ImportModels\ProductPresentationImportModel;
use Livewire\Component;
use App\Models\ProductPresentation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Livewire\WithFileUploads;

class ProductPresentationImport extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public function render()
    {
        return view('livewire.product-presentation.product-presentation-import');
    }

    public $file_ = null;
    public $rows;


    public function import()
    {
        try {
            set_time_limit(0);
            DB::beginTransaction();

            Excel::import(new ProductPresentationImportModel(), $this->file_);
            DB::commit();

            $this->alert('success',  'Datos importados correctamente.', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'confirmButtonText' =>  'Ok',
            ]);

            $this->file_ = null;
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->alert('error',  'No se pudo importar los datos, revise el formato de la plantilla.', [
                'position' =>  'top-end',
                'timer' =>  6000,
                'toast' =>  true,
                'confirmButtonText' =>  'Ok',
            ]);
        }
    }

    public function import_confirm()
    {
        $this->confirm('¿Está seguro que desea importar los registros? ', [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'confirmButtonText' => 'Importar',
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',

        ]);
    }

    protected $listeners = [
        'confirmed',
    ];
    public function confirmed()
    {
        $this->import();
    }


}
