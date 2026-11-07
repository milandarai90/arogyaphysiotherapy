<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderByDesc('is_main')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBranch($request);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $validated['is_main'] = $request->boolean('is_main');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $validated['working_days'] = $this->normalizeWorkingDays(
            $validated['working_days'] ?? []
        );

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('branches', 'public');
        }

        DB::transaction(function () use ($validated) {
            if ($validated['is_main']) {
                Branch::where('is_main', true)
                    ->update(['is_main' => false]);
            }

            Branch::create($validated);
        });

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch added successfully.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $this->validateBranch($request);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name'],
            $branch->id
        );

        $validated['is_main'] = $request->boolean('is_main');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $validated['working_days'] = $this->normalizeWorkingDays(
            $validated['working_days'] ?? []
        );

        $oldImage = $branch->image;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('branches', 'public');

            $validated['image'] = $newImage;
        } else {
            unset($validated['image']);
        }

        try {
            DB::transaction(function () use ($validated, $branch) {
                if ($validated['is_main']) {
                    Branch::where('id', '!=', $branch->id)
                        ->where('is_main', true)
                        ->update(['is_main' => false]);
                }

                $branch->update($validated);
            });
        } catch (\Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $exception;
        }

        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function toggleStatus(Branch $branch)
    {
        $branch->update([
            'is_active' => !$branch->is_active,
        ]);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch status updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $image = $branch->image;

        $branch->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    private function validateBranch(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],

            'google_maps_url' => ['nullable', 'url', 'max:2000'],
            'google_maps_embed_url' => ['nullable', 'url', 'max:2000'],

            'working_days' => ['nullable', 'array:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'working_days.*.is_closed' => ['nullable', 'boolean'],
            'working_days.*.open' => ['nullable', 'date_format:H:i'],
            'working_days.*.close' => ['nullable', 'date_format:H:i'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_main' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $submittedDays = $validated['working_days'] ?? [];

        foreach ($submittedDays as $day => $hours) {
            if (!is_array($hours)) {
                continue;
            }

            $isClosed = filter_var(
                $hours['is_closed'] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );

            if ($isClosed) {
                continue;
            }

            $open = $hours['open'] ?? null;
            $close = $hours['close'] ?? null;

            if (empty($open) || empty($close)) {
                throw ValidationException::withMessages([
                    "working_days.$day.open" =>
                        "$day requires both opening and closing times, or must be marked Closed.",
                ]);
            }

            if ($close <= $open) {
                throw ValidationException::withMessages([
                    "working_days.$day.close" =>
                        "$day closing time must be later than opening time.",
                ]);
            }
        }

        return $validated;
    }

    private function normalizeWorkingDays(array $submittedDays): array
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $schedule = [];

        foreach ($days as $day) {
            $dayData = $submittedDays[$day] ?? [];

            $isClosed = filter_var(
                $dayData['is_closed'] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );

            $schedule[$day] = [
                'is_closed' => $isClosed,
                'open' => $isClosed ? null : ($dayData['open'] ?? null),
                'close' => $isClosed ? null : ($dayData['close'] ?? null),
            ];
        }

        return $schedule;
    }

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Branch::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
