<?php

namespace App\Http\Livewire\Vehicle;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Vehicle;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VehicleUpdate extends Component
{
    use LivewireAlert;
    public $vehicle;
    public $slug;
    public $license_plate;
    public $brand;
    public $model;
    public $displacement;
    public $state;
    public $customers;
    public $customer_id;


    public function mount($slug)
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
        $this->vehicle = Vehicle::where('slug', $slug)->firstOrFail();
        if ($this->vehicle) {
            $this->license_plate = $this->vehicle->license_plate;
            $this->brand = $this->vehicle->brand;
            $this->model = $this->vehicle->model;
            $this->displacement = $this->vehicle->displacement;
            $this->state = $this->vehicle->state;
            $this->customer_id = $this->vehicle->customer_id;
        }
    }
    public function render()
    {
        return view('livewire.vehicle.vehicle-update');
    }
    protected $rules = [
        'license_plate' => 'required|max:255|min:2|unique:vehicles,license_plate',
        'brand' => 'nullable',
        'model' => 'nullable',
        'displacement' => 'nullable',
    ];
    public function submit()
    {
        $this->rules['license_plate'] = 'required|unique:vehicles,license_plate,' . $this->vehicle->id;
        $this->validate();

        $this->vehicle->update([
            'license_plate' => $this->license_plate,
            'brand' => $this->brand,
            'model' => $this->model,
            'displacement' => $this->displacement,
            'state' => $this->state,
            'customer_id' => $this->customer_id,
        ]);
        
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',

        ]);
    }
}
