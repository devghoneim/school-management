<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button wire:click="goToPreviousMonth" class="btn btn-outline-secondary">&larr; السابق</button>
        <h2 class="h4 m-0">
            {{ \Carbon\Carbon::create($currentYear, $currentMonth)->translatedFormat('F Y') }}
        </h2>
        <button wire:click="goToNextMonth" class="btn btn-outline-secondary">التالي &rarr;</button>
    </div>

    <div class="row bg-light text-center fw-bold py-2 border rounded">
        <div class="col">الأحد</div>
        <div class="col">الإثنين</div>
        <div class="col">الثلاثاء</div>
        <div class="col">الأربعاء</div>
        <div class="col">الخميس</div>
        <div class="col">الجمعة</div>
        <div class="col">السبت</div>
    </div>

    @php
        $totalBoxes = $startDayOfWeek + $daysInMonth;
        $rows = ceil($totalBoxes / 7);
        $dayCounter = 1;
    @endphp

    @for ($row = 0; $row < $rows; $row++)
        <div class="row border border-top-0">
            @for ($col = 0; $col < 7; $col++)
                @php $boxIndex = $row * 7 + $col; @endphp

                @if ($boxIndex < $startDayOfWeek || $dayCounter > $daysInMonth)
                    <div class="col border p-3 bg-light" style="min-height: 100px;"></div>
                @else
                    @php
                        $currentDate = \Carbon\Carbon::create($currentYear, $currentMonth, $dayCounter)->toDateString();
                        $isToday = $currentDate === now()->toDateString();
                        $hasEvent = collect($events)->filter(function ($event) use ($currentDate) {
                            return $currentDate >= $event->start_date && $currentDate <= $event->end_date;
                        });
                    @endphp

                    <div class="col border p-2 bg-white position-relative {{ $isToday ? 'bg-warning-subtle' : '' }}" style="min-height: 100px;">
                        <div>
                            <div class="fw-bold" wire:click="startEditing('{{ $currentDate }}')">{{ $dayCounter }}</div>

                            @if ($editingDate === $currentDate)
                                <form wire:submit.prevent="saveQuickEvent" class="mt-1">
                                    <input type="text" wire:model.defer="newEventTitle" class="form-control form-control-sm mb-1" placeholder="عنوان الفعالية">
                                    <input type="date" wire:model.defer="newEventEndDate" class="form-control form-control-sm mb-1">
                                    <button type="submit" class="btn btn-sm btn-success w-100">+</button>
                                </form>
                            @else
                                @foreach ($hasEvent as $event)
                                    <div class="badge bg-info text-dark mt-1 text-wrap w-100">
                                        {{ $event->title }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    @php $dayCounter++; @endphp
                @endif
            @endfor
        </div>
    @endfor
</div>
