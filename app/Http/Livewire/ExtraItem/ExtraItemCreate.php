<?php

namespace App\Http\Livewire\ExtraItem;

use App\Models\ExtraItem;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExtraItemCreate extends Component
{

    use LivewireAlert;
    public $extraItem;
    public $name;
    public $cost;
    public $description;
    public $price;
    public $state = 'ACTIVE';
    public $view;
    public $slug;


    public function mount()
    {
    }
    public function render()
    {
        return view('livewire.extra-item.extra-item-create');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:services,name',
        'description' => 'nullable',
        'cost' => 'required',
        'price' => 'required',
        'state' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        $this->extraItem = ExtraItem::create([
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'price' => $this->price,
            'slug' => Str::uuid(),
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
        return redirect()->route('extra-item.dashboard');
    }
}
