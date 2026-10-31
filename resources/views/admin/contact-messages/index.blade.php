 @extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('page-title', 'Contact Messages')

@section('page-description', 'Manage enquiries submitted through your website.')

@section('content')

<form method="GET"
      action="{{ route('admin.contact-messages.index') }}"
      class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-5">
                <label class="form-label fw-semibold">Search</label>
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Name, email, phone or subject"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="new" @selected(request('status') === 'new')>New</option>
                    <option value="read" @selected(request('status') === 'read')>Read</option>
                    <option value="replied" @selected(request('status') === 'replied')>Replied</option>
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>

                <a href="{{ route('admin.contact-messages.index') }}"
                   class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>

        </div>
    </div>
</form>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-0 p-3">
        <h5 class="mb-0 fw-bold">Enquiries</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">Sender</th>
                    <th>Contact</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($messages as $message)

                    <tr>
                        <td class="ps-3">
                            <strong>{{ $message->name }}</strong>
                        </td>

                        <td>
                            <div>{{ $message->email ?: 'No email' }}</div>
                            <small class="text-muted">
                                {{ $message->phone ?: 'No phone' }}
                            </small>
                        </td>

                        <td>{{ $message->subject ?: 'No subject' }}</td>

                        <td>
                            <span class="text-nowrap">
                                {{ $message->created_at->format('d M Y') }}
                            </span>
                            <br>
                            <small class="text-muted">
                                {{ $message->created_at->format('h:i A') }}
                            </small>
                        </td>

                        <td>
                            @if($message->status === 'new')
                                <span class="badge bg-danger">New</span>
                            @elseif($message->status === 'read')
                                <span class="badge bg-primary">Read</span>
                            @else
                                <span class="badge bg-success">Replied</span>
                            @endif
                        </td>

                        <td class="text-end pe-3">
                            <a href="{{ route('admin.contact-messages.show', $message) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-envelope-open-text fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No contact messages found.</p>
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    @if($messages->hasPages())
        <div class="card-footer bg-white border-0 p-3">
            {{ $messages->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>

@endsection