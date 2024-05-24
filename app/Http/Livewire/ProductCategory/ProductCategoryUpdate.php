<?php

namespace App\Http\Livewire\ProductCategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class ProductCategoryUpdate extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $category;
    public $name;
    public $title;
    public $slug;
    public $description;
    public $photo;
    public $icon;
    public $photo_new;
    public $icon_new;
    public $view;
    public $state;
    //Aux
    //public $showModal = false;

    public function mount($slug)
    {
        $this->category = ProductCategory::where('slug', $slug)->firstOrFail();
        if ($this->category) {
            $this->name = $this->category->name;
            $this->title = $this->category->title;
            $this->description = $this->category->description;
            $this->photo = $this->category->photo;
            $this->icon = $this->category->icon;
            $this->view = $this->category->view;
            $this->state = $this->category->state;
        }
    }
    //Constructor
    public function render()
    {
        return view('livewire.product-category.product-category-update');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3',
        'title' => 'required|max:255|min:3',
        'description' => 'nullable|max:255|min:3',
        'state' => 'required',
        'photo_new' => 'nullable|image|max:1024',
        'icon_new' => 'nullable|image|max:1024',
    ];
    public function submit()
    {
        //Modificando regla para actualizar
        $this->rules['slug'] = 'required|unique:product_categories,slug,' . $this->category->id;
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'state' => $this->state,
        ]);

        if ($this->photo_new) {

            //Delete File
            Storage::disk('public_uploads')->delete($this->category->photo);

            $filePath = time() . '-product-category.' . $this->photo_new->getClientOriginalExtension();
            $this->photo_new->storeAs('storage/product-category-photo', $filePath, 'public_uploads');
            $this->category->photo = 'storage/product-category-photo/' . $filePath;
            $this->category->save();
        }

        if ($this->icon_new) {

            //Delete File
            Storage::disk('public_uploads')->delete($this->category->icon);

            $filePath = time() . '-category.' . $this->icon_new->getClientOriginalExtension();
            $this->icon_new->storeAs('storage/category-icon', $filePath, 'public_uploads');
            $this->category->icon = 'storage/category-icon/' . $filePath;
            $this->category->save();
        }

        $this->confirm(__('alert.editedSuccesss'), [
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
