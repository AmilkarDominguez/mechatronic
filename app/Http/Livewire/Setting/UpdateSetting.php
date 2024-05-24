<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Image;

class UpdateSetting extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $setting;
    public $name;
    public $description;
    public $email;
    public $telephone;
    public $nro_whatsapp;
    public $url_facebook;
    public $url_instagram;
    public $url_website;
    public $address;
    public $logo;
    public $new_logo;
    public $print_logo;
    public function render()
    {
        return view('livewire.setting.update-setting');
    }
    public function mount($slug)
    {
        $this->setting = Setting::where('slug', $slug)->firstOrFail();
        if ($this->setting) {
            $this->name = $this->setting->name;
            $this->logo = $this->setting->logo;
            $this->description = $this->setting->description;
            $this->email = $this->setting->email;
            $this->telephone = $this->setting->telephone;
            $this->nro_whatsapp = $this->setting->nro_whatsapp;
            $this->url_facebook = $this->setting->url_facebook;
            $this->url_instagram = $this->setting->url_instagram;
            $this->url_website = $this->setting->url_website;
            $this->address = $this->setting->address;
            $this->print_logo = $this->setting->print_logo;
        }
    }
    protected $rules = [
        'new_logo' => 'nullable|image|max:1024|mimes:png',
    ];
    public function submit()
    {
        $this->validate();
        $this->setting->update([
            'name' => $this->name,
            'description' => $this->description,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'nro_whatsapp' => $this->nro_whatsapp,
            'url_facebook' => $this->url_facebook,
            'url_instagram' => $this->url_instagram,
            'url_website' => $this->url_website,
            'address' => $this->address,
            'print_logo' => $this->print_logo,

        ]);
        if ($this->new_logo) {
            //Delete File
            if ($this->setting->logo) {
                Storage::disk('public_uploads')->delete($this->setting->logo);
            }

            $filePath = 'logo-setting.' . $this->new_logo->getClientOriginalExtension();
            if (!file_exists('storage/setting-photo/')) {
                mkdir('storage/setting-photo/', 666, true);
            }
            $this->new_logo->storeAs('storage/setting-logo', $filePath, 'public_uploads');
            $this->setting->logo = 'storage/setting-logo/' . $filePath;
            $this->setting->save();
        }
        $this->alert('success', 'Registro actualizado correctamente.', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
