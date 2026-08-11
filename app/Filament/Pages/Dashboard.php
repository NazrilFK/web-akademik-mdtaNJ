<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\KalenderAkademik;
use App\Models\JadwalPelajaran;
use App\Models\Pengumuman; // Pastikan model di-import aman
use Carbon\Carbon;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        return '';
    }

    protected string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [];
    }

    // Properti Livewire untuk navigasi Kalender & Filter Kelas
    public ?int $month = null;
    public ?int $year = null;
    public ?string $selectedKelas = 'Semua';

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function prevMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function nextMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    protected function getViewData(): array
    {
        $today = now()->startOfDay();
        $hariIni = now()->locale('id')->dayName;

        // 1. DATA EVENT MENDATANG
        $upcomingEvents = KalenderAkademik::where('tanggal_mulai', '>=', $today)
            ->orderBy('tanggal_mulai', 'asc')
            ->take(4)
            ->get()
            ->map(function ($item) {
                $style = match ($item->jenis_kegiatan) {
                    'Ujian' => ['bg' => 'ujian', 'icon' => 'ujian'],
                    'Rapat', 'Rapat Guru' => ['bg' => 'rapat', 'icon' => 'rapat'],
                    'Libur Sekolah' => ['bg' => 'libur', 'icon' => 'libur'],
                    default => ['bg' => 'kegiatan', 'icon' => 'kegiatan'],
                };

                return [
                    'title' => $item->judul,
                    'date' => Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('d F Y') . ' • All Day',
                    'type' => $style['bg'],
                ];
            })->toArray();

        // 2. DATA MINI KALENDER INTERAKTIF
        $startOfMonth = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        $calendarDays = [];
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $calendarDays[] = null;
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateStr = sprintf('%04d-%02d-%02d', $this->year, $this->month, $day);
            $eventOnDay = KalenderAkademik::where('tanggal_mulai', '<=', $dateStr)->where('tanggal_selesai', '>=', $dateStr)->first();
            $isToday = (now()->format('Y-m-d') === $dateStr);
            
            $eventType = null;
            if ($eventOnDay) {
                $eventType = match ($eventOnDay->jenis_kegiatan) {
                    'Ujian' => 'ujian',
                    'Rapat', 'Rapat Guru' => 'rapat',
                    'Libur Sekolah' => 'libur',
                    default => 'kegiatan',
                };
            }

            $calendarDays[] = [
                'day' => $day,
                'has_event' => !is_null($eventOnDay),
                'event_type' => $eventType,
                'is_today' => $isToday
            ];
        }

        // 3. DATA JADWAL HARI INI & DAFTAR FILTER KELAS (SUPER RELASI AMAN)
        $todaySchedulesRaw = JadwalPelajaran::where('hari', $hariIni)->orderBy('jam_mulai', 'asc')->get();

        $classList = [];
        foreach ($todaySchedulesRaw as $jadwal) {
            $namaKelas = is_object($jadwal->kelas) ? ($jadwal->kelas->nama_kelas ?? $jadwal->kelas->nama ?? $jadwal->kelas->name) : ($jadwal->nama_kelas ?? $jadwal->kelas);
            if ($namaKelas && !in_array($namaKelas, $classList)) { $classList[] = $namaKelas; }
        }
        sort($classList);

        $todaySchedules = $todaySchedulesRaw->map(function ($item) {
            $kelasName = is_object($item->kelas) ? ($item->kelas->nama_kelas ?? $item->kelas->nama ?? $item->kelas->name ?? 'Kelas') : ($item->nama_kelas ?? ($item->kelas && !is_numeric($item->kelas) ? $item->kelas : 'Kelas'));
            if (is_object($item->mataPelajaran)) { $mapelName = $item->mataPelajaran->nama_mapel ?? $item->mataPelajaran->nama_mata_pelajaran ?? $item->mataPelajaran->nama ?? $item->mataPelajaran->name; } elseif (is_object($item->mapel)) { $mapelName = $item->mapel->nama_mapel ?? $item->mapel->nama ?? $item->mapel->name; } else { $mapelName = $item->nama_mapel ?? $item->nama_mata_pelajaran ?? ($item->mapel && !is_numeric($item->mapel) ? $item->mapel : 'Mata Pelajaran'); }
            $guruName = is_object($item->guru) ? ($item->guru->nama ?? $item->guru->name ?? 'Guru') : ($item->nama_guru ?? $item->guru ?? 'Guru');
            $waktu = !empty($item->jam_mulai) && !empty($item->jam_selesai) ? date('H:i', strtotime($item->jam_mulai)) . ' - ' . date('H:i', strtotime($item->jam_selesai)) : ($item->waktu ?? '08:00 - 09:30');

            return ['kelas' => $kelasName, 'mapel' => $mapelName, 'guru' => $guruName, 'waktu' => $waktu];
        });

        if ($this->selectedKelas && $this->selectedKelas !== 'Semua') {
            $todaySchedules = $todaySchedules->where('kelas', $this->selectedKelas);
        }

        // 4. BARU: AMBIL DATA PENGUMUMAN TERBARU (Sesuai Gambar 8)
        $latestAnnouncements = Pengumuman::latest()
            ->take(3) // Batasi maksimal 3 data teratas agar estetika pas
            ->get()
            ->map(function ($item) {
                // Deteksi string status untuk pewarnaan pill badge kapsul kustom
                $statusStr = strtolower($item->status ?? 'published');
                $badgeStyle = match($statusStr) {
                    'scheduled' => ['bg' => 'rgba(59, 130, 246, 0.12)', 'text' => '#3b82f6', 'label' => 'Scheduled'],
                    'draft' => ['bg' => 'rgba(156, 163, 175, 0.12)', 'text' => '#9ca3af', 'label' => 'Draft'],
                    default => ['bg' => 'rgba(16, 185, 129, 0.12)', 'text' => '#10b981', 'label' => 'Published'],
                };

                return [
                    'title' => $item->judul ?? $item->title ?? 'Tanpa Judul Pengumuman',
                    'time' => $item->created_at ? $item->created_at->locale('id')->diffForHumans() : 'Baru saja',
                    'badge_bg' => $badgeStyle['bg'],
                    'badge_text' => $badgeStyle['text'],
                    'badge_label' => $badgeStyle['label']
                ];
            })->toArray();

        return [
            'upcomingEvents' => $upcomingEvents,
            'calendarDays' => $calendarDays,
            'currentMonthName' => $startOfMonth->locale('id')->translatedFormat('F Y'),
            'classList' => $classList,
            'todaySchedules' => $todaySchedules,
            'namaHariIni' => $hariIni,
            'latestAnnouncements' => $latestAnnouncements, // Terkirim aman ke Blade
        ];
    }
}