<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'published') {
                    $query->where('is_published', true);
                } elseif ($request->status === 'draft') {
                    $query->where('is_published', false);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        $isPublished = $request->boolean('is_published');

        $validated['slug'] = $this->uniqueSlug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        $validated['is_published'] = $isPublished;
        $validated['published_at'] = $isPublished ? now() : null;

        Blog::create($validated);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog article created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        $wasPublished = $blog->is_published;
        $isPublished = $request->boolean('is_published');

        $validated['slug'] = $this->uniqueSlug(
            $validated['title'],
            $blog->id
        );

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs', 'public');
        }

        $validated['is_published'] = $isPublished;

        if ($isPublished) {
            $validated['published_at'] = $wasPublished && $blog->published_at
                ? $blog->published_at
                : now();
        } else {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog article updated successfully.');
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->is_published = ! $blog->is_published;
        $blog->published_at = $blog->is_published
            ? ($blog->published_at ?? now())
            : null;

        $blog->save();

        return back()->with('success', 'Blog publication status updated.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Blog article deleted successfully.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'blog-article';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}