<?php

namespace App\Http\Livewire\Vehicle;

use App\Models\Customer;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VehicleCreate extends Component
{
    use LivewireAlert;
    public $license_plate;
    public $brand;
    public $model;
    public $displacement;
    public $customers;
    public $customer_id;
    public $state = "ACTIVE";

    public function mount()
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.vehicle.vehicle-create');
    }
    protected $rules = [
        'license_plate' => 'required|max:255|min:2|unique:vehicles,license_plate',
        'brand' => 'nullable',
        'model' => 'nullable',
        'displacement' => 'nullable',
        'customer_id' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        Vehicle::create([
            'license_plate' => $this->license_plate,
            'brand' => $this->brand,
            'model' => $this->model,
            'displacement' => $this->displacement,
            'slug' => Str::uuid(),
            'state' => $this->state,
            'customer_id' => $this->customer_id,
        ]);

        $this->cleanInputs();

        $this->confirm('Registro creado correctamente', [
            'icon' => 'success',
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' => false,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Aceptar',
            'onConfirmed' => 'confirmed',
        ]);
    }

    public function cleanInputs()
    {
        $this->brand = "";
        $this->model = "";
        $this->displacement = "";
        $this->license_plate = "";
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('vehicle.dashboard');
    }
}
