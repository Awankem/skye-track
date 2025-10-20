<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Intern;
use Livewire\Component;
use Livewire\WithPagination;

class InternAttendance extends Component
{
    use WithPagination;

    public $internId;
    public $date;

    public function mount($internId)
    {
        $this->internId = $internId;
    }

    public function updatedDate()
    {
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->date = null;
        $this->resetPage();
    }

    public function render()
    {
        $intern = Intern::findOrFail($this->internId);
        $query = Attendance::where('intern_id', $this->internId);

        if ($this->date) {
            $query->whereDate('date', $this->date);
        }

        $internAttendance = $query->orderBy('date', 'desc')->paginate(10);

        return view('livewire.intern-attendance', [
            'intern' => $intern,
            'internAttendance' => $internAttendance,
        ]);
    }
}
