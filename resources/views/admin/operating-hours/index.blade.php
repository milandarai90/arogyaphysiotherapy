
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operating Hours | Arogya Physiotherapy Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #173f78;
            color: white;
            padding: 25px 18px;
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #dce8fa;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: rgba(255,255,255,.15);
            color: white;
        }

        .main-content {
            padding: 30px;
        }

        .content-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .table th {
            font-size: 13px;
            color: #667085;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        @media(max-width: 767px) {
            .sidebar { min-height: auto; }
            .main-content { padding: 18px; }
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <aside class="col-md-3 col-lg-2 sidebar">
            <h4><i class="fa-solid fa-heart-pulse me-2"></i>AROGYA</h4>

            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.appointments.index') }}">
                <i class="fa-solid fa-calendar-check me-2"></i>Appointments
            </a>
            <a href="{{ route('admin.services.index') }}">
                <i class="fa-solid fa-stethoscope me-2"></i>Services
            </a>
            <a href="{{ route('admin.gallery.index') }}">
                <i class="fa-solid fa-images me-2"></i>Gallery
            </a>
            <a href="{{ route('admin.blog.index') }}">
                <i class="fas fa-newspaper me-2"></i>Blog Management
            </a>
            <a href="{{ route('admin.contact-messages.index') }}">
                <i class="fas fa-envelope me-2"></i>Contact Messages
            </a>
            <a href="{{ route('admin.therapists.index') }}">
                <i class="fas fa-user-md me-2"></i>Therapists & Staff
            </a>
            <a href="{{ route('admin.testimonials.index') }}">
                <i class="fas fa-star me-2"></i>Patient Testimonials
            </a>
            <a href="{{ route('admin.operating-hours.index') }}" class="active">
                <i class="fas fa-clock me-2"></i>Operating Hours
            </a>
            <a href="{{ route('admin.settings.index') }}">
                <i class="fas fa-cog me-2"></i>Website Settings
            </a>

            <hr class="border-light">

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                </button>
            </form>
        </aside>

        <main class="col-md-9 col-lg-10 main-content">

            <div class="mb-4">
                <h3 class="fw-bold mb-1">Operating Hours & Holidays</h3>
                <p class="text-muted mb-0">
                    Manage clinic opening times and upcoming closures.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card content-card mb-4">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Weekly Operating Hours
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.operating-hours.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Opening Time</th>
                                        <th>Closing Time</th>
                                        <th>Closed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $day)
                                        @php
                                            $hour = $hours->get($day);
                                            $closed = old("hours.$day.is_closed", $hour?->is_closed ?? false);
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ $day }}</td>
                                            <td>
                                                <input type="time"
                                                    name="hours[{{ $day }}][opening_time]"
                                                    class="form-control"
                                                    value="{{ old("hours.$day.opening_time", $hour?->opening_time ? substr($hour->opening_time, 0, 5) : '09:00') }}"
                                                    {{ $closed ? 'disabled' : '' }}>
                                            </td>
                                            <td>
                                                <input type="time"
                                                    name="hours[{{ $day }}][closing_time]"
                                                    class="form-control"
                                                    value="{{ old("hours.$day.closing_time", $hour?->closing_time ? substr($hour->closing_time, 0, 5) : '17:00') }}"
                                                    {{ $closed ? 'disabled' : '' }}>
                                            </td>
                                            <td>
                                                <input type="hidden"
                                                    name="hours[{{ $day }}][is_closed]"
                                                    value="0">

                                                <div class="form-check">
                                                    <input type="checkbox"
                                                        name="hours[{{ $day }}][is_closed]"
                                                        value="1"
                                                        class="form-check-input closed-checkbox"
                                                        {{ $closed ? 'checked' : '' }}>
                                                    <label class="form-check-label">Closed</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Operating Hours
                        </button>
                    </form>
                </div>
            </div>

            <div class="card content-card mb-4">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-calendar-plus text-success me-2"></i>
                        Add Holiday / Closure
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.holidays.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Holiday Name *</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title') }}" required
                                    placeholder="e.g. Dashain Holiday">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Holiday Date *</label>
                                <input type="date" name="holiday_date" class="form-control"
                                    value="{{ old('holiday_date') }}"
                                    min="{{ now()->toDateString() }}" required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control"
                                    value="{{ old('description') }}"
                                    placeholder="Optional information">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-plus me-2"></i>Add Holiday
                        </button>
                    </form>
                </div>
            </div>

            <div class="card content-card">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Upcoming Holidays</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Holiday</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($holidays as $holiday)
                                    <tr>
                                        <td class="fw-semibold">{{ $holiday->title }}</td>
                                        <td>{{ $holiday->holiday_date->format('d M Y') }}</td>
                                        <td>{{ $holiday->description ?: '—' }}</td>
                                        <td class="text-end">
                                            <form method="POST"
                                                action="{{ route('admin.holidays.destroy', $holiday) }}"
                                                onsubmit="return confirm('Delete this holiday?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No holidays added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $holidays->links() }}
                </div>
            </div>

            <p class="text-center text-muted small mt-4">
                © {{ date('Y') }} Arogya Physiotherapy Center. All rights reserved.
            </p>

        </main>
    </div>
</div>

<script>
document.querySelectorAll('.closed-checkbox').forEach(function (checkbox) {
    function updateTimeFields() {
        const row = checkbox.closest('tr');

        row.querySelectorAll('input[type="time"]').forEach(function (input) {
            input.disabled = checkbox.checked;
        });
    }

    checkbox.addEventListener('change', updateTimeFields);
    updateTimeFields();
});
</script>
</body>
</html>
