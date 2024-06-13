<?php

namespace App\Http\Livewire\ProductCategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class ProductCategoryCreate extends Component
{
    use LivewireAlert; 
    use WithFileUploads;
    //person
    public $category;
    public $name;
    public $title;
    public $slug;
    public $description;
    public $photo;
    public $icon;
    public $view;
    public $state = 'ACTIVE';

    public function render()
    {
        return view('livewire.product-category.product-category-create');
    }

    protected $rules = [
        'name' => 'required|max:255|min:3',
        'title' => 'required|max:255|min:3',
        'description' => 'nullable|max:255|min:3',
        'state' => 'required',
        'photo' => 'required|image|max:1024',
        'icon' => 'required|image|max:1024',
    ];
    public function submit()
    {
        $this->validate();
        $this->category = ProductCategory::create([
            'name' => $this->name,
            'title' => $this->title,
            'slug' => Str::uuid(),
            'description' => $this->description,
            'state' => $this->state,
        ]);

        if ($this->photo) {
            $filePath = time() . '-product-category.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('storage/product-category-photo', $filePath, 'public_uploads');
            $this->category->photo = 'storage/product-category-photo/' . $filePath;
            $this->category->save();
        }

        if ($this->icon) {
            $filePath = time() . '-product-category.' . $this->icon->getClientOriginalExtension();
            $this->icon->storeAs('storage/product-category-icon', $filePath, 'public_uploads');
            $this->category->icon = 'storage/product-category-icon/' . $filePath;
            $this->category->save();
        }

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
        return redirect()->route('product-category.dashboard');
    }
}
