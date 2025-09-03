<?php

namespace App\Livewire;

use App\Models\Intern;
use Livewire\Component;
use Livewire\WithPagination;

class SearchIntern extends Component
{
    use WithPagination;

    public $search = '';
    public $department = '';

    // Delete modal
    public $confirmingInternDeletion = false;
    public $internToDelete;

    // Edit modal
    public $showEditModal = false;
    public $editingIntern;
    public $name, $email, $mac_address, $departmentEdit;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartment()
    {
        $this->resetPage();
    }

    // === DELETE ===
    public function confirmDelete($id)
    {
        $this->internToDelete = $id;
        $this->confirmingInternDeletion = true;
    }

    public function deleteIntern()
    {
        if ($this->internToDelete) {
            Intern::find($this->internToDelete)?->delete();
            return redirect()->route('intern.index')->with('success', 'Intern deleted successfully!');
        }

        $this->confirmingInternDeletion = false;
        $this->internToDelete = null;
    }

    // === EDIT ===
    public function editIntern($id)
    {
        $intern = Intern::findOrFail($id);
        $this->editingIntern = $intern;

        // Prefill form
        $this->name = $intern->name;
        $this->email = $intern->email;
        $this->mac_address = $intern->mac_address;
        $this->departmentEdit = $intern->department;

        $this->showEditModal = true;
    }

    public function updateIntern()
    {
        $this->validate([
            'name' => 'required|max:255|min:5',
            'email' => 'required|email',
            'mac_address' => 'required|max:20',
            'departmentEdit' => 'required|max:255',
        ]);

        $this->editingIntern->update([
            'name' => $this->name,
            'email' => $this->email,
            'mac_address' => $this->mac_address,
            'department' => $this->departmentEdit,
        ]);
        $this->showEditModal = false;
        return redirect()->route('intern.index')->with('success', 'Intern updated successfully!');
    }

    public function render()
    {
        $query = Intern::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('department', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->department) {
            $query->where('department', $this->department);
        }

        return view('livewire.search-intern', [
            'interns' => $query->paginate(10),
        ]);
    }
}
