<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TherapistController extends Controller
{
    public function index(Request $request)
    {
        $query = Therapist::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $therapists = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.therapists.index', compact('therapists'));
    }

    public function create()
    {
        return view('admin.therapists.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateTherapist($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('therapists', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Therapist::create($validated);

        return redirect()
            ->route('admin.therapists.index')
            ->with('success', 'Therapist profile added successfully.');
    }

    public function edit(Therapist $therapist)
    {
        return view('admin.therapists.edit', compact('therapist'));
    }

    public function update(Request $request, Therapist $therapist)
    {
        $validated = $this->validateTherapist($request);

        if ($request->hasFile('photo')) {
            if ($therapist->photo) {
                Storage::disk('public')->delete($therapist->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('therapists', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $therapist->update($validated);

        return redirect()
            ->route('admin.therapists.index')
            ->with('success', 'Therapist profile updated successfully.');
    }

    public function toggleStatus(Therapist $therapist)
    {
        $therapist->update([
            'is_active' => !$therapist->is_active,
        ]);

        return back()->with('success', 'Therapist status updated.');
    }

    public function destroy(Therapist $therapist)
    {
        if ($therapist->photo) {
            Storage::disk('public')->delete($therapist->photo);
        }

        $therapist->delete();

        return redirect()
            ->route('admin.therapists.index')
            ->with('success', 'Therapist profile deleted successfully.');
    }

    private function validateTherapist(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['nullable', 'string', 'max:150'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:100'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
