<?php

namespace App\Http\Livewire\Product;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductPresentation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductUpdate extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $product;
    public $name;
    public $code;
    public $description;
    public $photo;
    public $photo_new;
    public $state = 'ACTIVE';
    public $slug;

    public $category_id;
    public $productcategories;

    public $presentation_id;
    public $presentations;



    public function mount($slug)
    {
        //dd($slug);

        $this->product = Product::where('slug', $slug)->firstOrFail();

        if ($this->product) {
            $this->presentation_id = $this->product->presentation_id;
            $this->category_id = $this->product->category_id;
            $this->name = $this->product->name;
            $this->code = $this->product->code;
            $this->photo = $this->product->photo;
            $this->description = $this->product->description;
            $this->slug = $this->product->slug;
        }

        $this->productcategories = ProductCategory::all()->where('state', 'ACTIVE');
        $this->presentations = ProductPresentation::all()->where('state', 'ACTIVE');
    }

    public function render()
    {
        return view('livewire.product.product-update');
    }
    protected $rules = [
        'name' => 'required|max:255|min:3|unique:products,name',
        'code' => 'required|max:255|min:3|unique:products,code',
        'description' => 'nullable|max:255|min:3',
        'state' => 'required',
        'photo_new' => 'nullable|image|max:10240',
        'category_id' => 'required',
        'presentation_id' => 'required',
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
        $this->rules['name'] = 'required|unique:products,name,' . $this->product->id;
        $this->rules['code'] = 'required|unique:products,code,' . $this->product->id;
        $this->validate();

        $this->product->update([
            'name' => $this->name,
            'code' => $this->code,
            'slug' => Str::slug($this->name, '-'),
            'description' => $this->description,
            'state' => $this->state,
            'category_id' => $this->category_id,
            'presentation_id' => $this->presentation_id,
        ]);

        if ($this->photo_new) {
            //Delete File
            Storage::disk('public_uploads')->delete($this->product->photo);
            $filePath = time() . '-product.' . $this->photo_new->getClientOriginalExtension();
            $this->photo_new->storeAs('storage/product-photo', $filePath, 'public_uploads');
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
