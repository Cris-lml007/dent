<?php

namespace App\Livewire;

use App\Models\Specialty;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SpecialtyComponent extends Component
{

    #[Validate('required')]
    public $title;
    // #[Validate('required')]
    public $description;
    public Specialty $specialty;

    public function mount(){
        $this->specialty = new Specialty();
    }

    public function updateOrCreate(){
        $this->validate();
        if($this->specialty->id == null){
            Specialty::create([
                'name' => $this->title,
                'description' => $this->description
            ]);
        }else{
            $this->specialty->name = $this->title;
            $this->specialty->description = $this->description;
            $this->specialty->save();

            $this->specialty = new Specialty();
        }

        $this->reset(['title', 'description']);
        $this->dispatch('modalClose');
    }

    public function load($id){
        $this->specialty = Specialty::find($id);
        $this->title = $this->specialty->name;
        $this->description = $this->specialty->description;
    }

    public function delete($id){
        Specialty::destroy($id);
    }

    public function render()
    {
        $list = Specialty::all();
        $headSpecialty = ['ID', 'Nombre', 'Descripción', 'Opciones'];
        return view('livewire.specialty-component', compact(['headSpecialty', 'list']));
    }
}

