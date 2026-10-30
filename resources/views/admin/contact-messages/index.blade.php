
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Contact Messages</h2>
            <p class="text-muted mb-0">Manage enquiries submitted through your website.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.contact-messages.index') }}"
          class="card card-body mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                       placeholder="Search name, email, phone or subject"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="new" @selected(request('status') === 'new')>New</option>
                    <option value="read" @selected(request('status') === 'read')>Read</option>
                    <option value="replied" @selected(request('status') === 'replied')>Replied</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('admin.contact-messages.index') }}"
                   class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sender</th>
                        <th>Contact</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>
                                <strong>{{ $message->name }}</strong>
                            </td>
                            <td>
                                <div>{{ $message->email ?: 'No email' }}</div>
                                <small class="text-muted">{{ $message->phone ?: 'No phone' }}</small>
                            </td>
                            <td>{{ $message->subject ?: 'No subject' }}</td>
                            <td>{{ $message->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                @if($message->status === 'new')
                                    <span class="badge bg-danger">New</span>
                                @elseif($message->status === 'read')
                                    <span class="badge bg-primary">Read</span>
                                @else
                                    <span class="badge bg-success">Replied</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.contact-messages.show', $message) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
