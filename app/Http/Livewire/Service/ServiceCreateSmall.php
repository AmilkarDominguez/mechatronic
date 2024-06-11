<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceCreateSmall extends Component
{

    use LivewireAlert;
    public $service;
    public $name;
    public $code;
    public $price;

    public function render()
    {
        return view('livewire.service.service-create-small')->layout('layouts.guest');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:services,name',
        'code' => 'required|max:255|min:3|unique:services,code',
        'price' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        $this->service = Service::create([
            'name' => $this->name,
            'code' => $this->code,
            'slug' => Str::uuid(),
            'description' => '',
            'price' => $this->price
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

    function clearInputs() {
        $this->name = '';
        $this->code = '';
        $this->price = '';
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        $this->clearInputs();
        $this->emit('serviceAdded', $this->service->id);
    }
}
