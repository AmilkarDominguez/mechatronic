<?php

namespace App\Http\Livewire\Vehicle;

use App\Models\Customer;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class VehicleCreateSmall extends Component
{

    use LivewireAlert;
    public $license_plate;
    public $vehicle;
    public $brand;
    public $model;
    public $displacement;
    public $customer_id;
    public $customers;

    public function loadCustomers()
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
    }

    public function refreshCustomers()
    {
        $this->customers = DB::table('customers')
            ->join('people', 'customers.person_id', '=', 'people.id')
            ->where('customers.state', '=', 'ACTIVE')
            // ->orderBy('people.name', 'ASC')
            ->select('customers.*', 'people.name', 'people.ci')
            ->get();
        $this->emit('refreshCustomers', $this->customers);
    }

    public function render()
    {
        $this->loadCustomers();
        return view('livewire.vehicle.vehicle-create-small', ['customers' => $this->customers])->layout('layouts.guest');
    }
    protected $rules = [
        'license_plate' => 'required|max:255|min:2|unique:vehicles,license_plate',
        'brand' => 'nullable',
        'model' => 'nullable',
        'displacement' => 'nullable',
        'customer_id' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        $this->vehicle = Vehicle::create([
            'license_plate' => $this->license_plate,
            'brand' => $this->brand,
            'model' => $this->model,
            'displacement' => $this->displacement,
            'slug' => Str::uuid(),
            'customer_id' => $this->customer_id,
        ]);

        $this->confirm(__('alert.registerSuccesss'), [
            'icon' => 'success',
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ok',
            'showConfirmButton' => true,
            'showCancelButton' => false,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',
        ]);
    }

    function clearInputs()
    {
        $this->license_plate = '';
        $this->brand = '';
        $this->model = '';
        $this->displacement = '';
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        $this->clearInputs();
        $this->emit('vehicleAdded', $this->vehicle->id);
    }
}
