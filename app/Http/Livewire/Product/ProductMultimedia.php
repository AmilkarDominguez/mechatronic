<?php

namespace App\Http\Livewire\Product;

use App\Models\Multimedia;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Image;

class ProductMultimedia extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $product;
    public $multimedia;
    public function mount($slug)
    {
        $this->listMultimedias($slug);
    }
    public function render()
    {
        return view('livewire.product.product-multimedia');
    }
    protected $rules = [
        'multimedia' => 'required|image|max:1024',
    ];

    public function submit()
    {
        $this->validate();

        $regiter_multimedia = Multimedia::create([
            'product_id' => $this->product->id,
        ]);

        if ($this->multimedia) {
            $filePath = time() . '-multimedia.' . $this->multimedia->getClientOriginalExtension();

            $img = Image::make($this->multimedia)
                ->resize(720, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $img->save('storage/multimedia/products/' . $filePath);
            $regiter_multimedia->path = 'storage/multimedia/products/' . $filePath;
            $regiter_multimedia->save();
        }

        $this->alert('success', __('alert.registerSuccesss'), [
            'position' =>  'top-end',
            'timer' =>  3000,
            'toast' =>  true,
        ]);

        //Clean var
        $this->multimedia = null;
        //Update table
        $this->listMultimedias($this->product->slug);
    }

    public $idDelet;

    public function toastConfirmDelet($id)
    {
        $this->idDelet =  $id;
        $this->confirm(__('labeltables.alertDelet'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'confirmButtonText' =>  __('labeltables.delete'),
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',

        ]);
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        $Multimedia = Multimedia::find($this->idDelet);

        //Delete File
        Storage::disk('public_uploads')->delete($Multimedia->path);

        $Multimedia->delete();

        //Update table
        $this->listMultimedias($this->product->slug);
    }
    private function listMultimedias($slug){
        $this->product = Product::with('multimedias')->where('slug', $slug)->firstOrFail();
    }
}
