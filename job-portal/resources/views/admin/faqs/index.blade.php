@extends('admin.layout')

@section('title', 'Manage FAQs')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<style>
    .sortable-item {
        cursor: move;
    }
    .ui-sortable-helper {
        background: #f8f9fc;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .published-badge {
        min-width: 100px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Frequently Asked Questions</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New FAQ
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All FAQs</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Drag and drop FAQs to rearrange their order on the frontend.
            </div>
            
            @if($faqs->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">Order</th>
                            <th width="30%">Question</th>
                            <th width="40%">Answer</th>
                            <th width="10%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="faq-sortable">
                        @foreach($faqs as $faq)
                        <tr class="sortable-item" data-id="{{ $faq->id }}">
                            <td class="text-center">
                                <span class="order-handle">
                                    <i class="fas fa-grip-vertical text-gray-500"></i>
                                </span>
                                <span class="d-block">{{ $faq->order }}</span>
                            </td>
                            <td>{{ $faq->question }}</td>
                            <td>{{ Str::limit($faq->answer, 100) }}</td>                            <td class="text-center">
                                <form action="{{ route('admin.faqs.toggle-published', $faq) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm published-badge btn-{{ $faq->is_published ? 'success' : 'secondary' }}">
                                        {{ $faq->is_published ? 'Published' : 'Unpublished' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <p>No FAQs found. Click the button above to add your first FAQ.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Enable sorting
        $("#faq-sortable").sortable({
            items: '.sortable-item',
            handle: '.order-handle',
            axis: 'y',
            cursor: 'move',
            opacity: 0.8,
            update: function(event, ui) {
                const ids = [];
                
                // Get all FAQ IDs in their new order
                $('#faq-sortable tr').each(function() {
                    ids.push($(this).data('id'));
                });
                
                // Send the new order to the server
                $.ajax({
                    url: '{{ route('admin.faqs.reorder') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            if (typeof toastr !== 'undefined') {
                                toastr.success('FAQ order updated successfully.');
                            } else {
                                alert('FAQ order updated successfully.');
                            }
                            
                            // Update the visible order numbers
                            $('#faq-sortable tr').each(function(index) {
                                $(this).find('td:first span.d-block').text(index + 1);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating FAQ order:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('There was a problem updating the FAQ order.');
                        } else {
                            alert('There was a problem updating the FAQ order.');
                        }
                    }
                });
            }
        });
        
        // Make the drag handle more visible
        $('.order-handle').css('cursor', 'move');
    });
</script>
@endsection
