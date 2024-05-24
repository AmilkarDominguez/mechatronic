<?php


namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use App\Models\Country;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepartmentCreate extends Component
{
    use LivewireAlert; 
    //varibles para propiedades
    public $name;
    public $state = "ACTIVE";
    public $slug;
    
    //public countrie
    public $country_id;

    public function mount()
    {
        $this->countries = Country::all();
    }

    public function render()
    {
        return view('livewire.department.department-create');
    }
    //reglas para validacion
    protected $rules = [
        'country_id' => 'required',
        'name' => 'required|max:100|min:2|unique:departments,name',
        'state' => 'required',
    ];

    //Metodo que llama el formulario
    public function submit()
    {

        //Funcion para validar mediante las reglas
        $this->validate();
        
        
        //Creando registro
        Department::create([
            'country_id' => $this->country_id,
            'name' => $this->name,
            //generar slug
            'state' => $this->state,
            'slug' => Str::uuid(),
        ]);
 
        
        //Llamando a funcion para limpiar inputs
        $this->cleanInputs();

        //Mostrar alerta de registro
        $this->confirm('Registro creado correctamente', [
            'icon' => 'success',
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' => false,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Aceptar',
            'onConfirmed' => 'confirmed',
        ]);
    }

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->name = "";
        $this->country_id="";
    }

    public function onChangeSelectCountrie()
    {
        $this->countries = Country::all();
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboard
    public function confirmed()
    {
        return redirect()->route('department.dashboard');
    }
}
