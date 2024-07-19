<?php

namespace App\Http\Livewire\Product;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductPresentation;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductCreate extends Component
{

    use LivewireAlert;
    //product
    use WithFileUploads;
    public $product;
    public $name;
    public $code;
    public $description;
    public $photo;
    public $state = 'ACTIVE';
    public $view;
    public $slug;

    public $category_id;
    public $productcategories;

    public $presentation_id;
    public $presentations;



    public function mount()
    {
        $this->productcategories = ProductCategory::all()->where('state', 'ACTIVE');
        $this->presentations = ProductPresentation::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.product.product-create');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:products,name',
        'code' => 'required|max:255|min:3|unique:products,code',
        'description' => 'nullable|max:255|min:3',
        'state' => 'required',
        'photo' => 'nullable|image|max:1024',
        'presentation_id' => 'required',
        'category_id' => 'required',
    ];
    public function onChangeSelectCategory()
    {
        $this->productcategories = ProductCategory::all()->where('state', 'ACTIVE');
    }
    public function onChangeSelectPresentation()
    {
        $this->presentations = ProductPresentation::all()->where('state', 'ACTIVE');
    }

    public function submit()
    {
        $this->validate();
        $this->product = Product::create([
            'name' => $this->name,
            'code' => $this->code,
            'slug' => Str::slug($this->name, '-'),
            'description' => $this->description,
            'state' => $this->state,
            'category_id' => $this->category_id,
            'presentation_id' => $this->presentation_id,
        ]);

        if ($this->photo) {
            $filePath = time() . '-product.' . $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('storage/product-photo', $filePath, 'public_uploads');
            $this->product->photo = 'storage/product-photo/' . $filePath;
            $this->product->save();
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
        return redirect()->route('product.dashboard');
    }
}
