<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperatingHour;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperatingHourController extends Controller
{
    public function index()
    {
        $days = [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday',
            'Friday', 'Saturday', 'Sunday',
        ];

        $hours = OperatingHour::all()->keyBy('day_of_week');

        $holidays = Holiday::orderBy('holiday_date')
            ->paginate(10);

        return view('admin.operating-hours.index', compact(
            'days',
            'hours',
            'holidays'
        ));
    }

    public function updateHours(Request $request)
    {
        $validated = $request->validate([
            'hours' => ['required', 'array'],
            'hours.*.is_closed' => ['nullable', 'boolean'],
            'hours.*.opening_time' => ['nullable', 'date_format:H:i'],
            'hours.*.closing_time' => ['nullable', 'date_format:H:i'],
        ]);

        $days = [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday',
            'Friday', 'Saturday', 'Sunday',
        ];

        foreach ($days as $day) {
            $data = $validated['hours'][$day] ?? [];
            $isClosed = !empty($data['is_closed']);

            if (!$isClosed) {
                validator($data, [
                    'opening_time' => ['required', 'date_format:H:i'],
                    'closing_time' => ['required', 'date_format:H:i', 'after:opening_time'],
                ])->validate();
            }

            OperatingHour::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_closed' => $isClosed,
                    'opening_time' => $isClosed ? null : $data['opening_time'],
                    'closing_time' => $isClosed ? null : $data['closing_time'],
                ]
            );
        }

        return back()->with('success', 'Operating hours updated successfully.');
    }

    public function storeHoliday(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'holiday_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'unique:holidays,holiday_date',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['is_closed'] = true;

        Holiday::create($validated);

        return back()->with('success', 'Holiday added successfully.');
    }

    public function destroyHoliday(Holiday $holiday)
    {
        $holiday->delete();

        return back()->with('success', 'Holiday deleted successfully.');
    }
}