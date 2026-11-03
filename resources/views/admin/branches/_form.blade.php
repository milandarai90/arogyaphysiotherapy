@php
    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    $schedule = old('working_days', $branch->working_days ?? []);

    if (!is_array($schedule)) {
        $schedule = [];
    }
@endphp

<div class="card table-card mb-4">
    <div class="card-header bg-white border-0 p-3">
        <h5 class="fw-bold mb-1">Weekly Operating Hours</h5>
        <p class="text-muted small mb-0">
            Configure opening and closing times separately for each day.
        </p>
    </div>

    <div class="card-body">

        @foreach($days as $day)
            @php
                $daySchedule = $schedule[$day] ?? [];
                $isClosed = (bool) ($daySchedule['is_closed'] ?? false);
            @endphp

            <div class="border rounded p-3 mb-3 branch-day-row">

                <div class="row align-items-center g-3">

                    <div class="col-md-3">
                        <strong>{{ $day }}</strong>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small mb-1">Opening Time</label>

                        <input
                            type="time"
                            name="working_days[{{ $day }}][open]"
                            class="form-control branch-time-input"
                            value="{{ $daySchedule['open'] ?? '' }}"
                            {{ $isClosed ? 'disabled' : '' }}
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small mb-1">Closing Time</label>

                        <input
                            type="time"
                            name="working_days[{{ $day }}][close]"
                            class="form-control branch-time-input"
                            value="{{ $daySchedule['close'] ?? '' }}"
                            {{ $isClosed ? 'disabled' : '' }}
                        >
                    </div>

                    <div class="col-md-3">
                        <div class="form-check mt-3 mt-md-0">
                            <input
                                type="checkbox"
                                class="form-check-input branch-closed-checkbox"
                                name="working_days[{{ $day }}][is_closed]"
                                value="1"
                                id="closed_{{ strtolower($day) }}"
                                {{ $isClosed ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="closed_{{ strtolower($day) }}"
                            >
                                Closed
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.branch-closed-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const row = this.closest('.branch-day-row');

            row.querySelectorAll('.branch-time-input').forEach(function (input) {
                input.disabled = checkbox.checked;

                if (checkbox.checked) {
                    input.value = '';
                }
            });
        });
    });
});
</script>