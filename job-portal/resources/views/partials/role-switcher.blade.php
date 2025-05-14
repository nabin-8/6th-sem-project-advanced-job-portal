<div class="btn-group me-2" role="group">
    <div class="btn-group" role="group">
        @php
            $activeRole = session('active_role', 'Candidate');
        @endphp
        
        <form action="{{ route('switch.role') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="role" value="Candidate">
            <button type="submit" class="btn {{ $activeRole === 'Candidate' ? 'btn-primary' : 'btn-outline-light' }} btn-sm">
                <i class="fas fa-user-tie me-1"></i> Candidate
            </button>
        </form>
        
        <form action="{{ route('switch.role') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="role" value="Organization">
            <button type="submit" class="btn {{ $activeRole === 'Organization' ? 'btn-primary' : 'btn-outline-light' }} btn-sm">
                <i class="fas fa-building me-1"></i> Organization
            </button>
        </form>
    </div>
</div>