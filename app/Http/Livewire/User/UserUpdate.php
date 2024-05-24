<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Person;
use App\Models\IdentityDocumentType;
use App\Models\DocumentPerson;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class UserUpdate extends Component
{
    use LivewireAlert;

    //person
    public $person;

    public $name;
    public $lastname;
    public $address;
    public $num_address;
    public $date_birth;

    //TypeDocument
    public $identitydocumenttype;

    //Document Person
    public $documentperson;
    public $document_number;
    public $document_issuance;
    public $document_supplement;
    //user
    public $user;
    public $email;
    public $password;
    public $state;
    public $slug;
    //Rol
    public $role;
    public $role_id;

    public function mount($slug)
    {

        $this->user = User::where('slug', $slug)->firstOrFail();
        $this->person = Person::where('id', $this->user->person_id)->firstOrFail();

        $this->documentperson = DocumentPerson::where('person_id', $this->person->id)->first();

        $this->roles = Role::all();
        if ($this->user) {
            //cargando datos del usuario
            $this->person_id = $this->user->person_id;
            $this->email = $this->user->email;
            $this->state = $this->user->state;

            //Verificando rol
            $this->role_id = $this->user->roles->first()->id;
            $this->role = $this->user->roles->first()->id;

        }
        if ($this->person) {

            $this->name = $this->person->name;
            $this->lastname = $this->person->lastname;
            $this->address = $this->person->address;
            $this->num_address = $this->person->num_address;
            $this->date_birth = $this->person->date_birth;
        }
        if ($this->documentperson) {
            $this->document_number = $this->documentperson->document_number;
            $this->document_issuance = $this->documentperson->document_issuance;
            $this->document_supplement = $this->documentperson->document_supplement;
        }


    }

    public function render()
    {
        return view('livewire.user.user-update');
    }

    protected $rules = [
        //restriccion person
        'name' => 'required|max:255|min:2',
        'lastname' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion user
        'email' => 'unique:users|email',
        'password' => 'nullable',
        'state' => 'required',

    ];

    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['slug'] = 'required|unique:users,slug,' . $this->user->id;
        $this->rules['email'] = 'required|unique:users,email,' . $this->user->id;
        $this->validate();
        if ((int)$this->role_id <> $this->role) {
            //Editando rol
            $this->user->roles()->detach($this->role);
            $this->user->roles()->attach($this->role_id);
        }
        if ($this->password) {
            //Actualizando registro
            $this->user->update([
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'state' => $this->state,
            ]);
        } else {
            //Actualizando registro
            $this->user->update([
                'email' => $this->email,
                'state' => $this->state,
            ]);
        }
        $this->person->update([

            'name' => $this->name,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'num_address' => $this->num_address,
            'date_birth' => $this->date_birth,
        ]);


        if ($this->documentperson) {
            $this->documentperson->update([
                'document_number' => $this->document_number,
                'document_issuance' => $this->document_issuance,
                'document_supplement' => $this->document_supplement,
            ]);
        } else {
            DocumentPerson::create([
                'person_id' => $this->person->id,
                'document_type_id' => 1,
                'document_number' => $this->document_number,
                'document_issuance' => $this->document_issuance,
                'document_supplement' => $this->document_supplement,
            ]);
        }


        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',

        ]);
    }

    public function onChangeSelectRole()
    {
        $this->roles = Role::all();
    }
}
