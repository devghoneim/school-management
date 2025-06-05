<?php

namespace App\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
 public $daysInMonth;
    public $currentMonth;
    public $currentYear;
    public $startDayOfWeek;
    public $events = [];
    public $selectedDate;
    public $title = '';
    public $start_date;
    public $end_date;

    public $editingDate;
    public $newEventTitle = '';
    public $newEventEndDate = '';

    public function mount()
    {
        $now = Carbon::now();
        $this->updateCalendar($now);
    }

    public function goToPreviousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->updateCalendar($date);
    }

    public function goToNextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->updateCalendar($date);
    }

    public function startEditing($date)
    {
        $this->editingDate = $date;
        $this->newEventTitle = '';
        $this->newEventEndDate = $date;
    }

    public function saveQuickEvent()
    {
        $this->validate([
            'newEventTitle' => 'required|string|max:255',
            'editingDate' => 'required|date',
            'newEventEndDate' => 'required|date|after_or_equal:editingDate'
        ]);

        Event::create([
            'title' => $this->newEventTitle,
            'start_date' => $this->editingDate,
            'end_date' => $this->newEventEndDate,
        ]);

        $this->reset(['editingDate', 'newEventTitle', 'newEventEndDate']);
        $this->updateCalendar(Carbon::create($this->currentYear, $this->currentMonth, 1));
    }

    private function updateCalendar($date)
    {
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->daysInMonth = $date->daysInMonth;
        $this->startDayOfWeek = Carbon::create($this->currentYear, $this->currentMonth, 1)->dayOfWeek;

        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth();

        $this->events = Event::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->where('start_date', '<=', $startOfMonth)
                      ->where('end_date', '>=', $endOfMonth);
                });
        })->get();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}


