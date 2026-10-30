
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Details | Arogya Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; font-family: Arial, sans-serif; }
        .page-card { border: 0; border-radius: 12px; }
        .detail-label { color: #667085; font-size: 13px; margin-bottom: 5px; }
        .detail-value { font-weight: 600; overflow-wrap: anywhere; }
    </style>
</head>
<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Appointment Details</h3>
            <p class="text-muted mb-0">{{ $appointment->booking_reference }}</p>
        </div>

        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-primary">
            Back to Appointments
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card page-card shadow-sm mb-4">
        <div class="card-header bg-white p-3">
            <h5 class="mb-0">Patient Information</h5>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="detail-label">Patient Name</div>
                    <div class="detail-value">{{ $appointment->patient_name }}</div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">{{ $appointment->phone }}</div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Age</div>
                    <div class="detail-value">{{ $appointment->age }} years</div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Service</div>
                    <div class="detail-value">{{ $appointment->service->name ?? 'N/A' }}</div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Requested Date</div>
                    <div class="detail-value">{{ $appointment->appointment_date->format('d M Y') }}</div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Requested Time</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-label">Symptoms</div>
                    <div class="detail-value">{{ $appointment->symptoms ?: 'Not provided' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="detail-label">Patient Message</div>
                    <div class="detail-value">{{ $appointment->patient_message ?: 'Not provided' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="detail-label">Current Status</div>
                    <div class="detail-value">{{ ucfirst($appointment->status) }}</div>
                </div>

                <div class="col-md-6">
                    <div class="detail-label">Admin Note</div>
                    <div class="detail-value">{{ $appointment->admin_note ?: 'No note' }}</div>
                </div>

                @if($appointment->status === 'rescheduled')
                    <div class="col-md-6">
                        <div class="detail-label">New Appointment Date</div>
                        <div class="detail-value">
                            {{ $appointment->rescheduled_date?->format('d M Y') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-label">New Appointment Time</div>
                        <div class="detail-value">
                            {{ $appointment->rescheduled_time
                                ? \Carbon\Carbon::parse($appointment->rescheduled_time)->format('h:i A')
                                : 'Not provided' }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(!in_array($appointment->status, ['completed', 'cancelled'], true))
        <div class="row g-4">

            <div class="col-lg-6">
                <div class="card page-card shadow-sm h-100">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0">Update Appointment Status</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.appointments.status', $appointment) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">Choose Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                    <option value="completed">Mark as Completed</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Note</label>
                                <textarea name="admin_note" class="form-control" rows="3"
                                    placeholder="Optional note for this appointment">{{ old('admin_note', $appointment->admin_note) }}</textarea>
                            </div>

                            <button class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card page-card shadow-sm h-100">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0">Reschedule Appointment</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.appointments.reschedule', $appointment) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">New Date</label>
                                <input
                                    type="date"
                                    name="rescheduled_date"
                                    class="form-control"
                                    min="{{ now()->toDateString() }}"
                                    value="{{ old('rescheduled_date', $appointment->rescheduled_date?->format('Y-m-d')) }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Time</label>
                                <input
                                    type="time"
                                    name="rescheduled_time"
                                    class="form-control"
                                    value="{{ old('rescheduled_time') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Admin Note</label>
                                <textarea name="admin_note" class="form-control" rows="3"
                                    placeholder="Reason for rescheduling">{{ old('admin_note', $appointment->admin_note) }}</textarea>
                            </div>

                            <button class="btn btn-warning">Reschedule Appointment</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="alert alert-secondary">
            This appointment is {{ $appointment->status }} and cannot be changed.
        </div>
    @endif

</div>
</body>
</html>
