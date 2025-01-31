<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Statistic;
use App\Models\Contact;
use App\Models\TextContent;
use Illuminate\Support\Facades\Mail;

class Contacto extends Component
{
    public $name;
    public $email;
    public $message;
    
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10'
    ];

    public function render()
    {
        $stats = Statistic::all();
        $contactDescription = TextContent::where('key', 'contact-description')->first()?->content;
        return view('livewire.contacto', [
            'stats' => $stats,
            'contactDescription' => $contactDescription
        ]);
    }

    public function submit()
    {
        $this->validate();

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message
        ]);

        // Opcional: Enviar email
        // Mail::to('tucorreo@example.com')->send(new ContactFormMail($this->all()));

        $this->resetForm();
        session()->flash('message', '¡Mensaje enviado correctamente!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->message = '';
    }
}