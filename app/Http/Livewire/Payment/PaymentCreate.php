<?php

namespace App\Http\Livewire\Payment;

use Livewire\Component;
use App\Models\Payment;
use App\Models\ServiceOrder;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentCreate extends Component
{
    use LivewireAlert;
    public $amount;
    public $slug;
    public $state = "ACTIVE";

    public $service_order;
    public function mount($slug)
    {
        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.payment.payment-create');
    }

    protected $rules = [
        'amount' => 'required',
        'state' => 'required',
    ];
    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        
        if ($this->checkMust($this->amount)) {
            $this->validate();
            //Creando registro
            Payment::create([
                'amount' => $this->amount,
                //encriptando slug
                'slug' => Str::uuid(),
                'service_order_id' =>  $this->service_order->id,
                'state' => $this->state,
            ]);
            $this->service_order->update([
                'have' => $this->service_order->have + $this->amount,
                'must' => $this->service_order->must - $this->amount,
            ]);
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
        else {
            $this->alert('error', 'El pago <span class=" text-red-500 font-bold text-xl">'.$this->amount. '</span> es superior al a la deuda.', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
            ]);
        }
    }

    //Funcion para limpiar imputs
    public function checkMust($amount)
    {
        if ($this->service_order->must < $amount) {
            return false;
        }
        else {
            return true;
        }
    }

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->amount = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('payment.dashboard', [$this->service_order->slug]);
    }
}
