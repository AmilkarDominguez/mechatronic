<?php

namespace App\Http\Livewire\ExtraItem;

use App\Models\ExtraItem;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExtraItemCreateSmall extends Component
{

    use LivewireAlert;
    public $extraItem;
    public $name;
    public $cost;
    public $price;

    public function render()
    {
        return view('livewire.extra-item.extra-item-create-small')->layout('layouts.guest');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:services,name',
        'cost' => 'required',
        'price' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        $this->extraItem = ExtraItem::create([
            'name' => $this->name,
            'cost' => $this->cost,
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
        $this->cost = '';
        $this->price = '';
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        $this->clearInputs();
        $this->emit('extraItemAdded', $this->extraItem->id);
    }
}
