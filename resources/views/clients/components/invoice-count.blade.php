<span class="badge badge-circle bg-success me-2 text-3xl p-3">
    <a href="{{ route('clients.show', $row->id . '?Active=invoices') }}"
        class="text-decoration-none text-white">{{ $row->invoices_count }}</a>
</span>
