<?php

namespace App\Http\Livewire\Service;

use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServicePresentation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceUpdate extends Component
{
    use LivewireAlert;
    public $service;
    public $name;
    public $code;
    public $description;
    public $price;
    public $state = 'ACTIVE';
    public $slug;

    //Aux
    public $showModal = false;

    public function mount($slug)
    {
        $this->service = Service::where('slug', $slug)->firstOrFail();
        if ($this->service) {
            $this->name = $this->service->name;
            $this->code = $this->service->code;
            $this->description = $this->service->description;
            $this->price = $this->service->price;
            $this->slug = $this->service->slug;
        }
    }

    public function render()
    {
        return view('livewire.service.service-update');
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
        $this->rules['name'] = 'required|unique:services,name,' . $this->service->id;
        $this->rules['code'] = 'required|unique:services,code,' . $this->service->id;
        $this->validate();

        $this->service->update([
            'name' => $this->name,
            'code' => $this->code,
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
