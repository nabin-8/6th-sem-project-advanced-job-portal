<x-layout.html>
    <x-slot:styles>
        @stack('styles')
    </x-slot:styles>

    <x-slot:header>
        <x-layout.header />
    </x-slot:header>    {{ $slot }}

    <x-slot:footer>
        <x-layout.footer />
    </x-slot:footer>
    
    <x-slot:scripts>
        @stack('scripts')
    </x-slot:scripts>
                </div>
                <hr class="mt-4 mb-3 opacity-25">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0 small text-white-50">&copy; {{ date('Y') }} Job Portal. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="/terms" class="text-white-50 small">Terms of Service</a></li>
                            <li class="list-inline-item ms-3"><a href="/privacy" class="text-white-50 small">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </x-slot:footer>
</x-layout.html>
