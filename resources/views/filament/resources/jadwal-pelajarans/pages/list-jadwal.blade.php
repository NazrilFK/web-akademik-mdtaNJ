<x-filament-panels::page>
    @include('filament.resources.jadwal-pelajarans.timetable-matrix')

    <div style="margin-top: 40px;">
        {{ $this->table }}
    </div>
</x-filament-panels::page>