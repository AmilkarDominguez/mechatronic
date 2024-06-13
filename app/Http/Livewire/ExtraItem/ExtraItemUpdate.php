<?php

namespace App\Http\Livewire\ExtraItem;

use App\Models\ServiceCategory;
use App\Models\ExtraItem;
use App\Models\ServicePresentation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExtraItemUpdate extends Component
{
    use LivewireAlert;
    public $extraItem;
    public $name;
    public $cost;
    public $description;
    public $price;
    public $state = 'ACTIVE';
    public $slug;

    public function mount($slug)
    {
        $this->extraItem = ExtraItem::where('slug', $slug)->firstOrFail();
        if ($this->extraItem) {
            $this->name = $this->extraItem->name;
            $this->cost = $this->extraItem->cost;
            $this->description = $this->extraItem->description;
            $this->price = $this->extraItem->price;
            $this->slug = $this->extraItem->slug;
        }
    }

    public function render()
    {
        return view('livewire.extra-item.extra-item-update');
    }

    protected $rules = [
        'name' => 'required|max:255|min:3|unique:services,name',
        'cost' => 'required',
        'description' => 'nullable',
        'price' => 'required',
        'state' => 'required'
    ];

    public function submit()
    {
        $this->rules['name'] = 'required|unique:services,name,' . $this->extraItem->id;
        $this->validate();

        $this->extraItem->update([
            'name' => $this->name,
            'cost' => $this->cost,
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
        return redirect()->route('extra-item.dashboard');
    }
}
