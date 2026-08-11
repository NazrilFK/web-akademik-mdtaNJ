<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    // Daftarkan fungsi ke window scope di awal pemuatan halaman
    window.setupKalenderAkademikMDTA = function(eventsData) {
        return {
            activeFilter: 'Semua',
            isDateSelected: false,
            selectedDate: '',
            formattedDate: '',
            allEvents: eventsData,
            upcomingEvents: [],
            selectedDateEvents: [],
            calendarInstance: null,

            init() {
                let today = new Date();
                let todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                this.selectedDate = todayStr;

                this.updateUpcoming();
                
                // Berikan jeda super singkat agar HTML di bawahnya selesai dimuat
                setTimeout(() => {
                    this.initCalendar();
                }, 50);
            },

            getFilteredEvents() {
                if (this.activeFilter === 'Semua') return this.allEvents;
                
                const colorMap = {
                    'Libur Sekolah': '#ef4444',
                    'Ujian': '#a855f7',
                    'Kegiatan': '#3b82f6',
                    'Rapat': '#f97316',
                    'Pembagian Rapor': '#10b981'
                };
                
                return this.allEvents.filter(e => e.color === colorMap[this.activeFilter]);
            },

            setFilter(kategori) {
                this.activeFilter = kategori;
                this.updateUpcoming();
                this.updateSelectedDateEvents();

                if (this.calendarInstance) {
                    document.querySelectorAll('.fc-daygrid-day-frame.ada-background-agenda').forEach(el => {
                        el.classList.remove('ada-background-agenda');
                        el.style.removeProperty('--warna-lembut-agenda');
                        el.style.backgroundColor = '';
                    });

                    this.calendarInstance.removeAllEventSources();
                    this.calendarInstance.addEventSource(this.getFilteredEvents());
                }
            },

            updateUpcoming() {
                let filtered = this.getFilteredEvents().filter(e => e.start >= this.selectedDate);
                filtered.sort((a, b) => new Date(a.start) - new Date(b.start));
                this.upcomingEvents = filtered.slice(0, 5);
            },

            updateSelectedDateEvents() {
                if(!this.isDateSelected) return;
                this.selectedDateEvents = this.getFilteredEvents().filter(e => {
                    return this.selectedDate >= e.start && this.selectedDate <= e.raw_end;
                });
            },

            formatDisplayDate(start, end) {
                const opt1 = { day: 'numeric', month: 'short' };
                const opt2 = { day: 'numeric', month: 'short', year: 'numeric' };
                let d1 = new Date(start).toLocaleDateString('id-ID', opt1);
                
                if (start !== end) {
                    let d2 = new Date(end).toLocaleDateString('id-ID', opt2);
                    return `${d1} - ${d2}`;
                }
                return new Date(start).toLocaleDateString('id-ID', opt2);
            },

            initCalendar() {
                const calendarEl = document.getElementById('calendar-app');
                if(!calendarEl) return;
                
                this.calendarInstance = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    firstDay: 1,
                    showNonCurrentDates: false, 
                    fixedWeekCount: false,      
                    events: this.getFilteredEvents(),
                    headerToolbar: { left: 'title', center: '', right: 'prev,next' },
                    editable: false,
                    selectable: true,
                    height: 'auto', 
                    
                    eventContent: function(arg) {
                        let dotColor = arg.event.backgroundColor || '#6b7280';
                        return {
                            html: `<div style="width: 8px; height: 8px; background-color: ${dotColor}; border-radius: 50%; margin: 2px auto;"></div>`
                        };
                    },

                    eventDidMount: function(arg) {
                        let cellFrame = arg.el.closest('.fc-daygrid-day-frame');
                        
                        if (cellFrame && !cellFrame.classList.contains('ada-background-agenda')) {
                            let color = arg.event.backgroundColor;
                            let lightBg = '#f3f4f6'; 
                            
                            if(color === '#ef4444') lightBg = '#fee2e2'; 
                            else if(color === '#a855f7') lightBg = '#f3e8ff'; 
                            else if(color === '#3b82f6') lightBg = '#dbeafe'; 
                            else if(color === '#f97316') lightBg = '#ffedd5'; 
                            else if(color === '#10b981') lightBg = '#d1fae5'; 

                            cellFrame.classList.add('ada-background-agenda');
                            cellFrame.style.setProperty('--warna-lembut-agenda', lightBg);
                        }
                    },
                    
                    dateClick: (info) => {
                        this.isDateSelected = true;
                        this.selectedDate = info.dateStr;
                        const d = new Date(info.dateStr);
                        this.formattedDate = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                        
                        this.updateSelectedDateEvents();
                        this.updateUpcoming();
                    }
                });
                
                this.calendarInstance.render();
            }
        };
    };
</script>

<div x-data="window.setupKalenderAkademikMDTA(@js($events))">
    
    <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; padding: 16px; background-color: var(--bg-color, #fff); border-radius: 12px; border: 1px solid #e5e7eb;">
        <button type="button" @click="setFilter('Semua')" :class="activeFilter === 'Semua' ? 'filter-semua active' : 'inactive'" class="filter-btn" style="background: #10b981; color: white;">Semua</button>
        <button type="button" @click="setFilter('Libur Sekolah')" :class="activeFilter === 'Libur Sekolah' ? 'filter-libur active' : 'inactive'" class="filter-btn" style="background: #fee2e2; color: #dc2626;">Libur Sekolah</button>
        <button type="button" @click="setFilter('Ujian')" :class="activeFilter === 'Ujian' ? 'filter-ujian active' : 'inactive'" class="filter-btn" style="background: #f3e8ff; color: #9333ea;">Ujian</button>
        <button type="button" @click="setFilter('Kegiatan')" :class="activeFilter === 'Kegiatan' ? 'filter-kegiatan active' : 'inactive'" class="filter-btn" style="background: #dbeafe; color: #2563eb;">Kegiatan</button>
        <button type="button" @click="setFilter('Rapat')" :class="activeFilter === 'Rapat' ? 'filter-rapat active' : 'inactive'" class="filter-btn" style="background: #ffedd5; color: #ea580c;">Rapat</button>
        <button type="button" @click="setFilter('Pembagian Rapor')" :class="activeFilter === 'Pembagian Rapor' ? 'filter-rapor active' : 'inactive'" class="filter-btn" style="background: #d1fae5; color: #059669;">Pembagian Rapor</button>
    </div>

    <div class="kunci-layout-kalender">
        
        <div style="height: 100%; background: var(--bg-color, #fff); padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <div id="calendar-app" wire:ignore></div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px; height: 100%;">
            
            <div style="background: var(--bg-color, #fff); padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; min-height: 180px; display: flex; flex-direction: column; justify-content: center;">
                <template x-if="!isDateSelected">
                    <div style="text-align: center;">
                        <div style="color: #d1d5db; margin-bottom: 16px; display: flex; justify-content: center;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p style="font-size: 14px; color: #6b7280; margin: 0;">Pilih tanggal untuk melihat event</p>
                    </div>
                </template>

                <template x-if="isDateSelected">
                    <div style="width: 100%;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; color: #059669; font-weight: 600;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Agenda Terpilih</span>
                        </div>
                        <p x-text="formattedDate" style="font-size: 18px; font-weight: bold; color: var(--text-color, #111827); border-bottom: 1px solid #e5e7eb; padding-bottom: 12px; margin-bottom: 16px; margin-top: 0;"></p>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <template x-for="ev in selectedDateEvents" :key="ev.id">
                                <div style="display: flex; gap: 10px; align-items: start;">
                                    <div :style="'background-color: ' + (ev.color || ev.backgroundColor || '#6b7280') + '; width: 10px; height: 10px; border-radius: 50%; margin-top: 5px; flex-shrink: 0;'"></div>
                                    <div>
                                        <h4 x-text="ev.title" style="font-size: 14px; font-weight: 600; color: var(--text-color, #111827); margin: 0; line-height: 1.4;"></h4>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="selectedDateEvents.length === 0">
                                <p style="font-size: 13px; color: #6b7280; font-style: italic; margin: 0;">Tidak ada agenda pada tanggal ini.</p>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div style="background: var(--bg-color, #fff); padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; flex-grow: 1; display: flex; flex-direction: column;">
                <h3 style="font-weight: bold; font-size: 16px; color: var(--text-color, #111827); margin-top: 0; margin-bottom: 24px;">Event Mendatang</h3>
                
                <div style="display: flex; flex-direction: column; gap: 20px; flex-grow: 1;">
                    <template x-for="event in upcomingEvents" :key="event.id">
                        <div style="display: flex; gap: 12px; align-items: start;">
                            <div :style="'background-color: ' + (event.color || event.backgroundColor || '#6b7280') + '; width: 10px; height: 10px; border-radius: 50%; margin-top: 6px; flex-shrink: 0;'"></div>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <h4 x-text="event.title" style="font-size: 14px; font-weight: 600; color: var(--text-color, #111827); margin: 0; line-height: 1.4;"></h4>
                                <p x-text="formatDisplayDate(event.start, event.raw_end)" style="font-size: 12px; color: #6b7280; margin: 0;"></p>
                            </div>
                        </div>
                    </template>

                    <template x-if="upcomingEvents.length === 0">
                        <p style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 20px;">Tidak ada event mendatang.</p>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-btn {
        padding: 6px 16px; border-radius: 6px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease; display: inline-block;
    }
    .filter-btn.inactive { opacity: 0.4; filter: grayscale(20%); }
    .filter-btn.inactive:hover { opacity: 0.7; }
    
    .filter-semua.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #10b981; opacity: 1; transform: scale(1.02); }
    .filter-libur.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #ef4444; opacity: 1; transform: scale(1.02); }
    .filter-ujian.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #a855f7; opacity: 1; transform: scale(1.02); }
    .filter-kegiatan.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #3b82f6; opacity: 1; transform: scale(1.02); }
    .filter-rapat.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #f97316; opacity: 1; transform: scale(1.02); }
    .filter-rapor.active { box-shadow: 0 0 0 2px var(--bg-color, #fff), 0 0 0 4px #10b981; opacity: 1; transform: scale(1.02); }

    .kunci-layout-kalender { display: grid; grid-template-columns: 1fr; gap: 24px; align-items: stretch; margin-top: 10px; }
    @media (min-width: 1024px) { .kunci-layout-kalender { grid-template-columns: 2fr 1fr; } }
    
    .fc .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 700; text-transform: capitalize; color: var(--text-color, #111827); }
    .fc .fc-button-primary { background: transparent !important; border: none !important; color: #6b7280 !important; }
    .fc .fc-button-primary:hover { background: #f3f4f6 !important; color: #111827 !important; }
    .fc-theme-standard td, .fc-theme-standard th { border: 1px solid #f3f4f6 !important; }
    .fc .fc-col-header-cell-cushion { padding: 12px 4px; font-weight: 600; color: #6b7280; font-size: 0.875rem; }
    
    .fc .fc-daygrid-day-frame { display: flex; flex-direction: column; align-items: center; padding-top: 8px; min-height: 85px; }
    .fc .fc-daygrid-day-top { display: flex; justify-content: center; width: 100%; }
    .fc .fc-daygrid-day-number { color: var(--text-color, #374151); font-size: 0.875rem; padding: 4px; font-weight: 500; text-decoration: none; z-index: 2; }
    
    .fc .fc-daygrid-day-events {
        display: flex !important; justify-content: center !important; align-items: center !important; flex-wrap: wrap; width: 100%; margin-top: 2px !important; position: static !important; min-height: unset !important;
    }
    .fc .fc-daygrid-event-harness { margin: 0 3px !important; position: static !important; }
    .fc .fc-daygrid-event { background: transparent !important; border: none !important; box-shadow: none !important; }
    .fc .fc-scrollgrid { border: none !important; }

    .fc-daygrid-day-frame.ada-background-agenda {
        background-color: var(--warna-lembut-agenda);
        border-radius: 8px;
        margin: 4px;
        height: calc(100% - 8px);
    }
    .dark .fc-daygrid-day-frame.ada-background-agenda { background-color: transparent !important; }
    
    :root { --bg-color: #ffffff; --text-color: #111827; }
    .dark { --bg-color: #18181b; --text-color: #f9fafb; } 
    .dark .fc-theme-standard td, .dark .fc-theme-standard th { border: 1px solid #374151 !important; }
    .dark .fc .fc-button-primary:hover { background: #374151 !important; color: #f9fafb !important; }
</style>