<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Person;
use App\Models\DocumentPerson;
use App\Models\User;
use App\Models\Role;
use App\Models\IdentityDocumentType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserCreate extends Component
{
    use LivewireAlert;  
    //person
    public $name;
    public $lastname;
    public $address;
    public $num_address;
    public $date_birth;

    // document_person
    public $document_number;
    public $document_issuance;
    public $document_supplement;

    // user
    public $email;
    public $password;
    public $state = 'ACTIVE';

    //Rol
    public $role_id;
    public $user_id;

    public function mount()
    {
        $this->roles = Role::all()->where('name','!=','admin');
        $this->user_id = Auth()->User()->email;
    }
    public function render()
    {
        return view('livewire.user.user-create');
    }
    protected $rules = [
        //restriccion person
        'name' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion user
        'email' => 'unique:users|email',
        'password' => 'nullable',
        'state' => 'required',

    ];
    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->validate();
        // verificacmos si existe la persona
        $PersonExists = DocumentPerson::where('document_number', $this->document_number)->first();
        if (!$PersonExists) {
            $Person = Person::create([
                'name' => $this->name,
                'lastname' => $this->lastname,
                'address' => $this->address,
                'num_address' => $this->num_address,
                'date_birth' => $this->date_birth,
            ]);
            $DocumentPerson = DocumentPerson::create([
                'person_id' => $Person->id,
                'document_type_id' => 1,
                'document_number' => $this->document_number,
                'document_issuance' => $this->document_issuance,
                'document_supplement' => $this->document_supplement,
            ]);

            //Creando registro customer
            $User = User::create([
                'person_id' => $Person->id,
                'email' => $this->email,
                'email_verified_at' => now(),
                'password' => bcrypt($this->password),
                'remember_token' => Str::random(10),
                //encriptando slug
                        'slug' => Str::uuid(),
                'state' => $this->state,
            ]);
            //Creando registro de asignacion de Rol
            $Rol = Role::find($this->role_id);
            if ($Rol) {
                $User->roles()->attach($Rol);
            }
        }
        else
        {
            //Creando registro customer
            $User = User::create([
                'person_id' => $PersonExists->person_id,
                'email' => $this->email,
                'email_verified_at' => now(),
                'password' => bcrypt($this->password),
                'remember_token' => Str::random(10),
                //encriptando slug
                'slug' => Str::uuid(),
                'state' => $this->state,
            ]);
            //Creando registro de asignacion de Rol
            $Rol = Role::find($this->role_id);
            if ($Rol) {
                $User->roles()->attach($Rol);
            }

        }

        // verificacmos si existe la persona        
        $this->cleanInputs();

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
        $this->document_number = "";
        $this->document_issuance = "";
        $this->document_supplement = "";
        $this->name = "";
        $this->address = "";
        $this->email = "";
        $this->password = "";
    }

    public function onChangeSelectRole()
    {
        $this->roles = Role::all();
    }
    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('user.dashboard');
    }
}
