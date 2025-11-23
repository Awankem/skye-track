<?php

namespace App\Livewire;

use App\Models\Intern;
use Livewire\Component;
use Livewire\Attributes\On;

class AddInternModal extends Component
{
    public $showModal = false;

    public $name;
    public $email;
    public $department;
    public $macAddress;

    #[On('open-add-intern-modal')]
    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'department', 'macAddress']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function saveIntern()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255|min:5',
            'email' => 'required|email|unique:interns,email',
            'department' => 'required',
            'macAddress' => 'required|regex:/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/|unique:interns,mac_address',
        ]);
        
        $validatedData['mac_address'] = $validatedData['macAddress'];
        unset($validatedData['macAddress']);

        Intern::create($validatedData);

        $this->closeModal();

        session()->flash('success', 'Intern created successfully.');
        $this->dispatch('intern-added'); // Dispatch event to refresh intern list if needed
    }

    public function render()
    {
        $departments = getDistinctDepartments();

        return view('livewire.add-intern-modal', compact('departments'));
    }
}