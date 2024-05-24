<?php

namespace App\Http\Livewire\ProductPresentation;

use App\Models\ProductPresentation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductPresentationUpdate extends Component
{
    use LivewireAlert;
    public $name;
    public $code;
    public $description;
    public $slug;
    public $state;

    public function mount($slug)
    {
        $this->presentation_type = ProductPresentation::where('slug', $slug)->firstOrFail();
        if ($this->presentation_type) {
            $this->name = $this->presentation_type->name;
            $this->code = $this->presentation_type->code;
            $this->description = $this->presentation_type->description;
            $this->state = $this->presentation_type->state;
        }
    }
    public function render()
    {
        return view('livewire.product-presentation.product-presentation-update');
    }
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:product_presentations,name',
        'code' => 'required',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];
    public function submit()
    {
        $this->rules['name'] = 'required|unique:product_presentations,name,' .$this->presentation_type->id;
        $this->validate();
        $this->presentation_type->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'state' => $this->state,
        ]);
        $this->alert('success', 'Registro actualizado correctamente.', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
