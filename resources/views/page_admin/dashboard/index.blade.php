@extends('template_admin.layout')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Home</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ asset('admin') }}/dashboard/index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Home</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Kalender Dashboard - Full Width -->
                <div class="col-12">
                    <div class="card dashboard-calendar-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="color: #ffffff;">
                                <i class="ti ti-calendar me-2" style="color: #ffffff;"></i>Kalender Dashboard
                            </h5>
                            <div class="calendar-actions">
                                <button class="btn btn-sm btn-outline-primary" id="today-btn">
                                    <i class="ti ti-calendar-event me-1"></i>Hari Ini
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <!-- Panel Schedules -->
                                <div class="col-lg-4 col-md-5">
                                    <div class="schedule-panel h-100">
                                        <div class="schedule-header">
                                            <h6 class="schedule-title">
                                                <i class="ti ti-calendar-event me-2"></i>Jadwal Hari Ini
                                            </h6>
                                        </div>
                                        <div id="selected-date-info" class="selected-date">
                                            <div class="date-day" id="selected-day">Pilih Tanggal</div>
                                            <div class="date-date" id="selected-date"></div>
                                        </div>
                                        <div id="events-list" class="articles-list">
                                            <div class="no-articles">
                                                <i class="ti ti-calendar"></i>
                                                <p>Pilih tanggal untuk melihat jadwal</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel Calendar -->
                                <div class="col-lg-8 col-md-7">
                                    <div class="calendar-panel h-100">
                                        <div class="calendar-header">
                                            <div class="month-year-selector">
                                                <button class="btn btn-sm btn-outline-secondary" id="prev-month">
                                                    <i class="ti ti-chevron-left"></i>
                                                </button>
                                                <h6 class="month-year" id="month-year"></h6>
                                                <button class="btn btn-sm btn-outline-secondary" id="next-month">
                                                    <i class="ti ti-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="calendar-grid" id="calendar-grid">
                                            <div class="loading-overlay hidden" id="calendar-loading">
                                                <div class="loading-spinner">
                                                    <div class="spinner"></div>
                                                    <p class="loading-text">Memuat data...</p>
                                                </div>
                                            </div>

                                            <div class="calendar-header-row">
                                                <div class="day-header">Min</div>
                                                <div class="day-header">Sen</div>
                                                <div class="day-header">Sel</div>
                                                <div class="day-header">Rab</div>
                                                <div class="day-header">Kam</div>
                                                <div class="day-header">Jum</div>
                                                <div class="day-header">Sab</div>
                                            </div>

                                            <div class="calendar-body" id="calendar-body">
                                                <!-- Calendar days will be generated here by JavaScript -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard Calendar Card */
        .dashboard-calendar-card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            overflow: hidden;
        }

        .dashboard-calendar-card .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1.25rem 1.5rem;
        }

        .calendar-actions .btn {
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .calendar-actions .btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }

        /* Schedule Panel */
        .schedule-panel {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .schedule-header {
            margin-bottom: 1rem;
        }

        .schedule-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .selected-date {
            margin-bottom: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .date-day {
            font-size: 1.2rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.25rem;
        }

        .date-date {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .articles-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .articles-list::-webkit-scrollbar {
            width: 4px;
        }

        .articles-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .articles-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }

        .no-articles {
            text-align: center;
            color: #6c757d;
            padding: 2rem 1rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .no-articles i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.5;
        }

        .no-articles p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Calendar Panel */
        .calendar-panel {
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            margin-bottom: 1rem;
        }

        .month-year-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .month-year {
            font-size: 1.25rem;
            font-weight: 700;
            color: #495057;
            margin: 0;
            min-width: 180px;
            text-align: center;
        }

        .calendar-grid {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            flex: 1;
            position: relative;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 12px;
        }

        .loading-overlay.hidden {
            display: none;
        }

        .loading-spinner {
            text-align: center;
        }

        .loading-spinner .spinner {
            width: 50px;
            height: 50px;
            margin: 0 auto 1rem;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            color: #667eea;
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .calendar-header-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #dee2e6;
        }

        .day-header {
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-weight: 700;
            color: #495057;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .calendar-day {
            padding: 0.75rem 0.5rem;
            text-align: center;
            border-right: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .calendar-day:hover {
            background: #f8f9fa;
            transform: scale(1.05);
        }

        .calendar-day.other-month {
            color: #adb5bd;
            background: #f8f9fa;
        }

        .calendar-day.today {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1976d2;
            font-weight: 700;
            box-shadow: inset 0 0 0 2px #1976d2;
        }

        .calendar-day.active {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%) !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4);
        }

        .calendar-day.has-bookings {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            font-weight: 600;
        }

        .calendar-day.has-bookings:hover {
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
            transform: scale(1.05);
        }

        /* Status-based calendar colors */
        .calendar-day.status-pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
            color: #856404 !important;
            border-left: 3px solid #ffc107 !important;
        }

        .calendar-day.status-diterima {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
            color: #0c5460 !important;
            border-left: 3px solid #17a2b8 !important;
        }

        .calendar-day.status-diproses {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
            color: #155724 !important;
            border-left: 3px solid #28a745 !important;
        }

        .calendar-day.status-selesai {
            background: linear-gradient(135deg, #d1f2eb 0%, #abe5cc 100%) !important;
            color: #0e6655 !important;
            border-left: 3px solid #1abc9c !important;
        }

        .calendar-day.status-ditolak {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
            color: #721c24 !important;
            border-left: 3px solid #dc3545 !important;
        }

        .calendar-day.status-dibatalkan {
            background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%) !important;
            color: #383d41 !important;
            border-left: 3px solid #6c757d !important;
        }

        .booking-indicator {
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 0.7rem;
            color: #4caf50;
        }

        .day-number {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .booking-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .booking-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
            border-color: #007bff;
        }

        .booking-time {
            display: flex;
            align-items: center;
            margin-right: 0.75rem;
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .booking-time i {
            margin-right: 0.25rem;
        }

        .booking-content {
            flex: 1;
        }

        .booking-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .booking-meta {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .booking-status {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-diterima {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-diproses {
            background: #d4edda;
            color: #155724;
        }

        .status-selesai {
            background: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        .status-dibatalkan {
            background: #e2e3e5;
            color: #383d41;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .calendar-day {
                min-height: 45px;
                padding: 0.5rem 0.25rem;
            }

            .day-number {
                font-size: 0.8rem;
            }

            .month-year {
                font-size: 1rem;
                min-width: 140px;
            }
        }

        @media (max-width: 576px) {
            .schedule-panel {
                padding: 1rem;
            }

            .calendar-panel {
                padding: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentDate = new Date();
            let currentYear = currentDate.getFullYear();
            let currentMonth = currentDate.getMonth();
            let bookingsMap = {}; // Store bookings by date
            let statusMap = {}; // Store status by date

            const monthYearElement = document.getElementById('month-year');
            const calendarBodyElement = document.getElementById('calendar-body');
            const selectedDayElement = document.getElementById('selected-day');
            const selectedDateElement = document.getElementById('selected-date');
            const eventsListElement = document.getElementById('events-list');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            const todayBtn = document.getElementById('today-btn');
            const calendarLoadingElement = document.getElementById('calendar-loading');

            function showLoading() {
                if (calendarLoadingElement) {
                    calendarLoadingElement.classList.remove('hidden');
                }
            }

            function hideLoading() {
                if (calendarLoadingElement) {
                    calendarLoadingElement.classList.add('hidden');
                }
            }

            function renderCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDayOfWeek = firstDay.getDay();

                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                monthYearElement.textContent = monthNames[currentMonth] + ' ' + currentYear;

                calendarBodyElement.innerHTML = '';

                // Show loading
                showLoading();

                // Load bookings for current month first, then render calendar
                loadBookingsForMonth().then(() => {
                    // Days from previous month
                    for (let i = startDayOfWeek - 1; i >= 0; i--) {
                        const date = new Date(currentYear, currentMonth, -i);
                        const dayElement = createDayElement(date, true);
                        calendarBodyElement.appendChild(dayElement);
                    }

                    // Days in current month
                    for (let day = 1; day <= daysInMonth; day++) {
                        const date = new Date(currentYear, currentMonth, day);
                        const dayElement = createDayElement(date, false);
                        calendarBodyElement.appendChild(dayElement);
                    }

                    // Days from next month
                    const totalCells = 42;
                    const remainingCells = totalCells - (startDayOfWeek + daysInMonth);
                    for (let day = 1; day <= remainingCells; day++) {
                        const date = new Date(currentYear, currentMonth + 1, day);
                        const dayElement = createDayElement(date, true);
                        calendarBodyElement.appendChild(dayElement);
                    }

                    // Hide loading after calendar is rendered
                    hideLoading();

                    // Highlight today on load after calendar is rendered
                    setTimeout(function() {
                        const todayElement = document.querySelector('.calendar-day.today');
                        if (todayElement) {
                            todayElement.click();
                        }
                    }, 100);
                });
            }

            function loadBookingsForMonth() {
                const monthNumber = currentMonth + 1;
                return fetch(`{{ route('dashboard.get-calendar-data') }}?year=${currentYear}&month=${monthNumber}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            data.calendar_data.forEach(day => {
                                bookingsMap[day.full_date] = day.has_bookings;
                                statusMap[day.full_date] = day.status;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading bookings:', error);
                    });
            }

            function createDayElement(date, isOtherMonth) {
                const day = date.getDate();
                const isToday = date.toDateString() === new Date().toDateString();
                const dateString = formatDate(date);
                const hasBookings = bookingsMap[dateString] || false;
                const status = statusMap[dateString] || null;

                const dayDiv = document.createElement('div');
                let classNames = 'calendar-day' +
                    (isOtherMonth ? ' other-month' : '');

                // Today class has priority, don't add status to today
                if (isToday) {
                    classNames += ' today';
                } else {
                    // Add status class if there's a booking status (only for non-today dates)
                    if (status) {
                        const statusClass = 'status-' + status.toLowerCase();
                        classNames += ' ' + statusClass;
                    } else if (hasBookings) {
                        classNames += ' has-bookings';
                    }
                }

                dayDiv.className = classNames;

                let html = `<span class="day-number">${day}</span>`;
                if (hasBookings || status) {
                    html += '<i class="ti ti-calendar-event booking-indicator"></i>';
                }
                dayDiv.innerHTML = html;

                dayDiv.dataset.date = dateString;

                dayDiv.addEventListener('click', function() {
                    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
                    this.classList.add('active');
                    loadEventsForDate(dateString);
                });

                return dayDiv;
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function getStatusClass(status) {
                const statusMap = {
                    'Pending': 'status-pending',
                    'Diterima': 'status-diterima',
                    'Diproses': 'status-diproses',
                    'Selesai': 'status-selesai',
                    'Ditolak': 'status-ditolak',
                    'Dibatalkan': 'status-dibatalkan'
                };
                return statusMap[status] || 'status-pending';
            }

            function loadEventsForDate(date) {
                const dateObj = new Date(date);
                const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const dayName = dayNames[dateObj.getDay()];

                selectedDayElement.textContent = dayName;
                selectedDateElement.textContent = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Load bookings from backend
                fetch(`{{ route('dashboard.get-bookings-by-date') }}?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.bookings.length > 0) {
                            eventsListElement.innerHTML = data.bookings.map(booking => `
                                <div class="booking-item" onclick="window.location.href='{{ url('super-admin/booking') }}/${booking.id}'">
                                    <div class="booking-time">
                                        <i class="ti ti-clock"></i>
                                        ${booking.booking_time}
                                    </div>
                                        <div class="booking-content">
                                        <div class="booking-title">${booking.nama}</div>
                                        <div class="booking-meta">
                                            ${booking.layanan ? booking.layanan.judul : 'Tidak ada layanan'} •
                                            <span class="booking-status ${getStatusClass(booking.status)}">${booking.status}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="ti ti-arrow-right"></i>
                                    </div>
                                </div>
                            `).join('');
                        } else {
                            eventsListElement.innerHTML = `
                                <div class="no-articles">
                                    <i class="ti ti-calendar-event"></i>
                                    <p>Tidak ada booking pada tanggal ini</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading bookings:', error);
                        eventsListElement.innerHTML = `
                            <div class="no-articles">
                                <i class="ti ti-exclamation-triangle"></i>
                                <p>Gagal memuat data booking</p>
                        </div>
                        `;
                    });
            }

            prevMonthBtn.addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            });

            todayBtn.addEventListener('click', function() {
                currentDate = new Date();
                currentYear = currentDate.getFullYear();
                currentMonth = currentDate.getMonth();
                renderCalendar(); // Will auto-highlight today after render
            });

            // Initialize calendar
            renderCalendar();
        });
    </script>
@endsection
