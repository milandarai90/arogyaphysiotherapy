
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Contact Message</h2>
            <p class="text-muted mb-0">
                Received {{ $contactMessage->created_at->format('d M Y, h:i A') }}
            </p>
        </div>

        <a href="{{ route('admin.contact-messages.index') }}"
           class="btn btn-outline-secondary">
            Back to Messages
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">{{ $contactMessage->subject ?: 'No Subject' }}</h4>

                    <div class="mb-3">
                        <strong>Name</strong>
                        <div>{{ $contactMessage->name }}</div>
                    </div>

                    <div class="mb-3">
                        <strong>Email</strong>
                        <div>
                            @if($contactMessage->email)
                                <a href="mailto:{{ $contactMessage->email }}">
                                    {{ $contactMessage->email }}
                                </a>
                            @else
                                Not provided
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Phone</strong>
                        <div>
                            @if($contactMessage->phone)
                                <a href="tel:{{ $contactMessage->phone }}">
                                    {{ $contactMessage->phone }}
                                </a>
                            @else
                                Not provided
                            @endif
                        </div>
                    </div>

                    <hr>

                    <strong>Message</strong>
                    <div class="mt-2" style="white-space: pre-wrap;">{{ $contactMessage->message }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-3">Manage Message</h5>

                    <form method="POST"
                          action="{{ route('admin.contact-messages.update', $contactMessage) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="new" @selected($contactMessage->status === 'new')>New</option>
                                <option value="read" @selected($contactMessage->status === 'read')>Read</option>
                                <option value="replied" @selected($contactMessage->status === 'replied')>Replied</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Admin Note</label>
                            <textarea name="admin_note" class="form-control" rows="5"
                                      placeholder="Write an internal note...">{{ old('admin_note', $contactMessage->admin_note) }}</textarea>
                            <small class="text-muted">This note is only visible to administrators.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Save Changes
                        </button>
                    </form>

                    <hr>

                    <form method="POST"
                          action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                          onsubmit="return confirm('Are you sure you want to permanently delete this message?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger w-100">
                            Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
