 @extends('admin.layouts.app')

@section('title', 'Contact Message')

@section('page-title', 'Contact Message')

@section('page-description')
    Received {{ $contactMessage->created_at->format('d M Y, h:i A') }}
@endsection

@section('page-actions')
    <a href="{{ route('admin.contact-messages.index') }}"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Messages
    </a>
@endsection

@section('content')

<div class="row g-4">

    {{-- Message Details --}}
    <div class="col-lg-7">

        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">

                <h4 class="fw-bold mb-4">
                    {{ $contactMessage->subject ?: 'No Subject' }}
                </h4>

                <div class="mb-4">
                    <div class="text-muted small mb-1">Name</div>
                    <div class="fw-semibold">{{ $contactMessage->name }}</div>
                </div>

                <div class="mb-4">
                    <div class="text-muted small mb-1">Email</div>

                    @if($contactMessage->email)
                        <a href="mailto:{{ $contactMessage->email }}">
                            {{ $contactMessage->email }}
                        </a>
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

                <div class="mb-4">
                    <div class="text-muted small mb-1">Phone</div>

                    @if($contactMessage->phone)
                        <a href="tel:{{ $contactMessage->phone }}">
                            {{ $contactMessage->phone }}
                        </a>
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

                <hr>

                <div class="mb-2 fw-semibold">Message</div>

                <div class="bg-light rounded-3 p-3"
                     style="white-space: pre-wrap; overflow-wrap: anywhere;">{{ $contactMessage->message }}</div>

                <div class="mt-4">
                    <span class="text-muted small">Current status:</span>

                    @if($contactMessage->status === 'new')
                        <span class="badge bg-danger ms-1">New</span>
                    @elseif($contactMessage->status === 'read')
                        <span class="badge bg-primary ms-1">Read</span>
                    @else
                        <span class="badge bg-success ms-1">Replied</span>
                    @endif
                </div>

            </div>
        </div>

    </div>

    {{-- Manage Message --}}
    <div class="col-lg-5">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">Manage Message</h5>

                <form method="POST"
                      action="{{ route('admin.contact-messages.update', $contactMessage) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>

                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                            <option value="new"
                                @selected(old('status', $contactMessage->status) === 'new')>
                                New
                            </option>

                            <option value="read"
                                @selected(old('status', $contactMessage->status) === 'read')>
                                Read
                            </option>

                            <option value="replied"
                                @selected(old('status', $contactMessage->status) === 'replied')>
                                Replied
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Admin Note</label>

                        <textarea name="admin_note"
                                  class="form-control @error('admin_note') is-invalid @enderror"
                                  rows="5"
                                  placeholder="Write an internal note...">{{ old('admin_note', $contactMessage->admin_note) }}</textarea>

                        <small class="text-muted">
                            This note is only visible to administrators.
                        </small>

                        @error('admin_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>

                </form>

                <hr class="my-4">

                <form method="POST"
                      action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                      onsubmit="return confirm('Are you sure you want to permanently delete this message?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-1"></i> Delete Message
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection