<x-filament-panels::page>
    
    <div style="background-color: #059669; color: #ffffff; padding: 24px 32px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); width: 100%; box-sizing: border-box; margin-bottom: 8px;">
        <h1 style="font-size: 26px; font-weight: 700; margin: 0; line-height: 1.3; font-family: inherit; letter-spacing: -0.5px;">
            Assalamu'alaikum, {{ auth()->user()->name ?? 'Admin' }}
        </h1>
        <p style="font-size: 15px; margin: 8px 0 0 0; opacity: 0.90; font-weight: 500; letter-spacing: 0.2px;">
            Selamat datang di Sistem Penjadwalan Akademik MDTA Nurul Jihad
        </p>
    </div>

    <div style="width: 100%; margin-bottom: 8px;">
        @livewire(\App\Filament\Widgets\StatsOverview::class)
    </div>

    <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 24px; width: 100%; box-sizing: border-box; align-items: stretch; margin-top: 8px;">
        
        <div style="flex: 1.2; min-width: 340px; background-color: var(--dash-card-bg); border: 1px solid var(--dash-card-border); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 20px; box-sizing: border-box;">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--dash-text-main); margin: 0;">Event Mendatang</h3>
                <svg style="width: 20px; height: 20px; color: var(--dash-text-muted);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div style="display: flex; flex-direction: column; gap: 14px; width: 100%; flex-grow: 1;">
                @forelse($upcomingEvents as $event)
                    <div style="background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 16px; box-sizing: border-box;">
                        <div style="background-color: var(--{{ $event['type'] }}-bg); color: var(--{{ $event['type'] }}-icon); width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                            <span style="font-size: 15px; font-weight: 600; color: var(--dash-text-main); line-height: 1.2;">{{ $event['title'] }}</span>
                            <span style="font-size: 12px; color: var(--dash-text-muted);">{{ $event['date'] }}</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px 20px; color: var(--dash-text-muted); font-size: 14px; font-style: italic; display: flex; align-items: center; justify-content: center; height: 100%;">
                        Tidak ada kegiatan akademik mendatang.
                    </div>
                @endforelse
            </div>
        </div>

        <div style="flex: 0.8; min-width: 300px; background-color: var(--dash-card-bg); border: 1px solid var(--dash-card-border); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; width: 100%;">
                    <div style="font-size: 18px; font-weight: 700; color: var(--dash-cal-title); text-transform: capitalize;">
                        {{ $currentMonthName }}
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button wire:click="prevMonth" type="button" style="background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); color: var(--dash-text-muted); width: 32px; height: 32px; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">&larr;</button>
                        <button wire:click="nextMonth" type="button" style="background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); color: var(--dash-text-muted); width: 32px; height: 32px; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">&rarr;</button>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-size: 13px; font-weight: 600; color: var(--dash-text-muted); margin-bottom: 16px; width: 100%;">
                    <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); row-gap: 10px; column-gap: 6px; text-align: center; width: 100%;">
                    @foreach($calendarDays as $dayItem)
                        @if(is_null($dayItem))
                            <div></div>
                        @else
                            <div style="aspect-ratio: 1 / 1; display: flex; align-items: center; justify-content: center; font-size: 14px; border-radius: 8px; box-sizing: border-box;
                                @if($dayItem['is_today'])
                                    background-color: #059669; color: #ffffff; font-weight: 700; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                @elseif($dayItem['has_event'])
                                    background-color: var(--{{ $dayItem['event_type'] }}-bg); color: var(--{{ $dayItem['event_type'] }}-icon); font-weight: 700;
                                @else
                                    color: var(--dash-cal-day-text);
                                @endif
                            ">
                                {{ $dayItem['day'] }}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--dash-item-border); display: flex; flex-wrap: wrap; gap: 12px; font-size: 11px; color: var(--dash-text-muted);">
                <div style="display: flex; align-items: center; gap: 4px;"><div style="width: 8px; height: 8px; border-radius: 50%; background-color: #059669;"></div> Hari Ini</div>
                <div style="display: flex; align-items: center; gap: 4px;"><div style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--ujian-icon);"></div> Ujian</div>
                <div style="display: flex; align-items: center; gap: 4px;"><div style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--rapat-icon);"></div> Rapat</div>
                <div style="display: flex; align-items: center; gap: 4px;"><div style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--libur-icon);"></div> Libur</div>
                <div style="display: flex; align-items: center; gap: 4px;"><div style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--kegiatan-icon);"></div> Kegiatan</div>
            </div>
        </div>
    </div>

    <div style="width: 100%; background-color: var(--dash-card-bg); border: 1px solid var(--dash-card-border); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 20px; box-sizing: border-box; margin-top: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; width: 100%;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--dash-text-main); margin: 0;">Jadwal Hari Ini ({{ $namaHariIni }})</h3>
                <svg style="width: 20px; height: 20px; color: var(--dash-text-muted);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <select wire:model.live="selectedKelas" style="background-color: var(--dash-card-bg); color: var(--dash-text-main); border: 1px solid var(--dash-card-border); padding: 8px 36px 8px 12px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; outline: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23a1a1aa%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px top 50%; background-size: 10px auto;">
                    <option value="Semua">Semua Kelas</option>
                    @foreach($classList as $classOption)
                        <option value="{{ $classOption }}">{{ $classOption }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
            @forelse($todaySchedules as $schedule)
                <div style="background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 24px; box-sizing: border-box; width: 100%;">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dash-text-muted); min-width: 110px; flex-shrink: 0; text-align: left; font-family: monospace;">{{ $schedule['waktu'] }}</div>
                    <div style="width: 1px; height: 32px; background-color: var(--dash-item-border); flex-shrink: 0;"></div>
                    <div style="display: flex; flex-direction: column; gap: 3px; text-align: left;">
                        <span style="font-size: 16px; font-weight: 700; color: var(--dash-text-main); line-height: 1.2;">{{ $schedule['mapel'] }}</span>
                        <span style="font-size: 13px; color: var(--dash-text-muted); font-weight: 500;">{{ $schedule['kelas'] }} &bull; {{ $schedule['guru'] }}</span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--dash-text-muted); font-size: 14px; font-style: italic; background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); border-radius: 12px; width: 100%; box-sizing: border-box;">Jadwal hari ini kosong.</div>
            @endforelse
        </div>
    </div>

    <div style="width: 100%; background-color: var(--dash-card-bg); border: 1px solid var(--dash-card-border); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 20px; box-sizing: border-box; margin-top: 24px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--dash-text-main); margin: 0;">Pengumuman Terbaru</h3>
                <svg style="width: 20px; height: 20px; color: var(--dash-text-muted);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
            @forelse($latestAnnouncements as $announcement)
                <div style="background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); border-radius: 12px; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box; width: 100%; gap: 16px;">
                    
                    <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                        <span style="font-size: 16px; font-weight: 700; color: var(--dash-text-main); line-height: 1.3;">
                            {{ $announcement['title'] }}
                        </span>
                        <span style="font-size: 12px; color: var(--dash-text-muted); font-weight: 500;">
                            {{ $announcement['time'] }}
                        </span>
                    </div>

                    <div style="background-color: {{ $announcement['badge_bg'] }}; color: {{ $announcement['badge_text'] }}; padding: 4px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-transform: capitalize; flex-shrink: 0;">
                        {{ $announcement['badge_label'] }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--dash-text-muted); font-size: 14px; font-style: italic; background-color: var(--dash-item-bg); border: 1px solid var(--dash-item-border); border-radius: 12px; width: 100%; box-sizing: border-box;">
                    Belum ada pengumuman terbaru yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>

    <style>
        :root {
            --dash-card-bg: #ffffff; --dash-card-border: #e5e7eb; --dash-item-bg: #f9fafb; --dash-item-border: #f1f5f9; --dash-text-main: #111827; --dash-text-muted: #6b7280; --dash-cal-title: #1e3a8a; --dash-cal-day-text: #374151;
            --ujian-bg: #fef2f2; --ujian-icon: #ef4444; --rapat-bg: #eff6ff; --rapat-icon: #3b82f6; --libur-bg: #fff7ed; --libur-icon: #f97316; --kegiatan-bg: #ecfdf5; --kegiatan-icon: #10b981;
        }

        .dark, [data-theme="dark"] {
            --dash-card-bg: #18181b; --dash-card-border: #27272a; --dash-item-bg: #202023; --dash-item-border: #27272a; --dash-text-main: #ffffff; --dash-text-muted: #a1a1aa; --dash-cal-title: #60a5fa; --dash-cal-day-text: #f4f4f5;
            --ujian-bg: #451a1a; --ujian-icon: #f87171; --rapat-bg: #1e293b; --rapat-icon: #60a5fa; --libur-bg: #432515; --libur-icon: #fb923c; --kegiatan-bg: #064e3b; --kegiatan-icon: #34d399;
        }

        /* Formula Kotak Badge Ikon Statistik Atas */
        .fi-wi-stats-overview div:nth-child(1) .fi-wi-stats-overview-stat-icon-box svg, .fi-wi-stats-overview > *:nth-child(1) svg {
            background-color: #dcfce7 !important; color: #15803d !important; padding: 8px !important; border-radius: 10px !important; width: 24px !important; height: 24px !important; box-sizing: content-box !important;
        }
        .fi-wi-stats-overview div:nth-child(2) .fi-wi-stats-overview-stat-icon-box svg, .fi-wi-stats-overview > *:nth-child(2) svg {
            background-color: #dbeafe !important; color: #1d4ed8 !important; padding: 8px !important; border-radius: 10px !important; width: 24px !important; height: 24px !important; box-sizing: content-box !important;
        }
        .fi-wi-stats-overview div:nth-child(3) .fi-wi-stats-overview-stat-icon-box svg, .fi-wi-stats-overview > *:nth-child(3) svg {
            background-color: #f3e8ff !important; color: #7c3aed !important; padding: 8px !important; border-radius: 10px !important; width: 24px !important; height: 24px !important; box-sizing: content-box !important;
        }
        .fi-wi-stats-overview div:nth-child(4) .fi-wi-stats-overview-stat-icon-box svg, .fi-wi-stats-overview > *:nth-child(4) svg {
            background-color: #fef3c7 !important; color: #d97706 !important; padding: 8px !important; border-radius: 10px !important; width: 24px !important; height: 24px !important; box-sizing: content-box !important;
        }

        .dark .fi-wi-stats-overview div:nth-child(1) .fi-wi-stats-overview-stat-icon-box svg, .dark .fi-wi-stats-overview > *:nth-child(1) svg { background-color: rgba(22, 163, 74, 0.15) !important; color: #4ade80 !important; width: 24px !important; height: 24px !important; }
        .dark .fi-wi-stats-overview div:nth-child(2) .fi-wi-stats-overview-stat-icon-box svg, .dark .fi-wi-stats-overview > *:nth-child(2) svg { background-color: rgba(37, 99, 235, 0.15) !important; color: #60a5fa !important; width: 24px !important; height: 24px !important; }
        .dark .fi-wi-stats-overview div:nth-child(3) .fi-wi-stats-overview-stat-icon-box svg, .dark .fi-wi-stats-overview > *:nth-child(3) svg { background-color: rgba(147, 51, 234, 0.15) !important; color: #c084fc !important; width: 24px !important; height: 24px !important; }
        .dark .fi-wi-stats-overview div:nth-child(4) .fi-wi-stats-overview-stat-icon-box svg, .dark .fi-wi-stats-overview > *:nth-child(4) svg { background-color: rgba(234, 88, 12, 0.15) !important; color: #fcd34d !important; width: 24px !important; height: 24px !important; }
    </style>
</x-filament-panels::page>