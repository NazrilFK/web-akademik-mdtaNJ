<script>
    window.timetableApp = function(schedulesData, timeSlotsData) {
        return {
            selectedKelas: 'Semua',
            selectedGuru: 'Semua',
            days: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            timeSlots: timeSlotsData,
            allSchedules: schedulesData,
            filteredSchedules: schedulesData,

            init() {
                this.filterData();
            },

            filterData() {
                this.filteredSchedules = this.allSchedules.filter(item => {
                    let matchKelas = this.selectedKelas === 'Semua' || item.kelas === this.selectedKelas;
                    let matchGuru = this.selectedGuru === 'Semua' || item.guru === this.selectedGuru;
                    return matchKelas && matchGuru;
                });
            },

            getCellItems(day, slot) {
                return this.filteredSchedules.filter(item => item.hari === day && item.time_slot === slot);
            }
        };
    };
</script>

<div x-data="window.timetableApp(@js($schedules), @js($timeSlots))" style="width: 100%;">
    
    <div style="display: flex; flex-wrap: wrap; gap: 24px; margin-bottom: 24px; padding: 20px; background-color: var(--card-bg, #fff); border-radius: 12px; border: 1px solid var(--border-color, #e5e7eb);">
        
        <div style="display: flex; flex-direction: column; gap: 8px; flex-grow: 1; min-width: 200px;">
            <label style="font-size: 14px; font-weight: 600; color: var(--text-main, #111827);">Filter Kelas</label>
            <select x-model="selectedKelas" @change="filterData()" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color, #d1d5db); background: var(--select-bg, #fff); color: var(--text-main, #111827); font-size: 14px;">
                <option value="Semua">Semua Kelas</option>
                <template x-for="kls in @js($listKelas)" :key="kls">
                    <option :value="kls" x-text="kls"></option>
                </template>
            </select>
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px; flex-grow: 1; min-width: 200px;">
            <label style="font-size: 14px; font-weight: 600; color: var(--text-main, #111827);">Filter Guru</label>
            <select x-model="selectedGuru" @change="filterData()" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color, #d1d5db); background: var(--select-bg, #fff); color: var(--text-main, #111827); font-size: 14px;">
                <option value="Semua">Semua Guru</option>
                <template x-for="gru in @js($listGuru)" :key="gru">
                    <option :value="gru" x-text="gru"></option>
                </template>
            </select>
        </div>
    </div>

    <div style="width: 100%; overflow-x: auto; background: var(--card-bg, #fff); border-radius: 12px; border: 1px solid var(--border-color, #e5e7eb); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="min-width: 900px; display: grid; grid-template-columns: 160px repeat(5, 1fr);">
            
            <div style="background-color: #059669; color: #ffffff; padding: 16px; font-weight: 700; display: flex; align-items: center;">Waktu</div>
            <template x-for="day in days" :key="day">
                <div style="background-color: #059669; color: #ffffff; padding: 16px; font-weight: 700; text-align: center; display: flex; align-items: center; justify-content: center; border-left: 1px solid rgba(255,255,255,0.1);" x-text="day"></div>
            </template>

            <template x-for="slot in timeSlots" :key="slot">
                <div style="display: contents;">
                    
                    <div style="padding: 16px; font-weight: 600; color: var(--text-main, #374151); background-color: var(--time-col-bg, #f9fafb); display: flex; align-items: center; gap: 8px; border-top: 1px solid var(--border-color, #e5e7eb); font-size: 13px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span x-text="slot"></span>
                    </div>

                    <template x-for="day in days" :key="day">
                        <div style="padding: 14px; border-top: 1px solid var(--border-color, #e5e7eb); border-left: 1px solid var(--border-color, #e5e7eb); min-height: 135px; display: flex; flex-direction: column; justify-content: center; gap: 8px; position: relative;">
                            
                            <template x-for="item in getCellItems(day, slot)" :key="item.id">
                                <div :style="'background-color: ' + item.bg_color + ';'" style="padding: 14px 16px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); display: flex; flex-direction: column; gap: 6px; color: #111827; transition: transform 0.2s;">
                                    
                                    <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 15px; color: #111827;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span x-text="item.mapel"></span>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; color: #1f2937;">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span x-text="item.guru"></span>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 500; color: #374151;">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span x-text="item.kelas + ' • ' + item.ruangan"></span>
                                    </div>
                                </div>
                            </template>

                            <template x-if="getCellItems(day, slot).length === 0">
                                <div style="display: flex; justify-content: center; align-items: center; color: #d1d5db; font-size: 18px; font-weight: 300; height: 100%;">+</div>
                            </template>
                        </div>
                    </template>

                </div>
            </template>
        </div>
    </div>

    <div style="margin-top: 24px; padding: 16px; background: var(--card-bg, #fff); border-radius: 12px; border: 1px solid var(--border-color, #e5e7eb);">
        <h4 style="font-size: 14px; font-weight: 700; color: var(--text-main, #111827); margin-top: 0; margin-bottom: 12px;">Legenda Mata Pelajaran</h4>
        <div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center;">
            @foreach($legends as $legend)
                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-main, #374151);">
                    <div style="width: 14px; height: 14px; border-radius: 4px; background-color: {{ $legend['bg_color'] }}; flex-shrink: 0;"></div>
                    <span>{{ $legend['mapel'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    :root { --card-bg: #ffffff; --border-color: #e5e7eb; --text-main: #111827; --time-col-bg: #f9fafb; --select-bg: #ffffff; }
    .dark { --card-bg: #18181b; --border-color: #27272a; --text-main: #f4f4f5; --time-col-bg: #202023; --select-bg: #27272a; }
</style>