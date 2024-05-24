<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceCreate extends Component
{

    use LivewireAlert;
    public $service;
    public $name;
    public $code;
    public $description;
    public $price;
    public $state = 'ACTIVE';
    public $view;
    public $slug;

    //Aux
    public $showModal = false;

    public function mount()
    {
    }
    public function render()
    {
        return view('livewire.service.service-create');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:services,name',
        'code' => 'required|max:255|min:3|unique:services,code',
        'description' => 'nullable',
        'price' => 'required',
        'state' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        $this->service = Service::create([
            'name' => $this->name,
            'code' => $this->code,
            'slug' => Str::uuid(),
            'description' => $this->description,
            'price' => $this->price,
            'state' => $this->state,
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

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('service.dashboard');
    }
}
