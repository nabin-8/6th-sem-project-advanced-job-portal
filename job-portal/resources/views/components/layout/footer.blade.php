<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h3 class="h5 mb-3">Job Portal</h3>
                <p class="mb-3">Find your dream job or the perfect candidate for your company.</p>
                <p class="mb-0 small text-white-50">© {{ date('Y') }} Job Portal. All rights reserved.</p>
            </div>
            <div class="col-lg-2 col-md-4 col-6 mb-4 mb-md-0">
                <h4 class="h6 mb-3">Quick Links</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('public.home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('public.jobs.index') }}" class="text-white-50 text-decoration-none">Browse Jobs</a></li>
                    <li class="mb-2"><a href="{{ route('public.organizations.index') }}" class="text-white-50 text-decoration-none">Organizations</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-6 mb-4 mb-md-0">
                <h4 class="h6 mb-3">For Job Seekers</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('register') }}" class="text-white-50 text-decoration-none">Create Account</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">Login</a></li>
                    <li class="mb-2"><a href="{{ route('public.jobs.index') }}" class="text-white-50 text-decoration-none">Search Jobs</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-6 mb-4 mb-md-0">                <h4 class="h6 mb-3">For Organizations</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('register') }}" class="text-white-50 text-decoration-none">Create Account</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}?type=organization" class="text-white-50 text-decoration-none">Post a Job</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-12">
                <h4 class="h6 mb-3">FAQs</h4>
                @if(isset($faqs) && $faqs->count() > 0)
                    <div class="accordion accordion-flush" id="footerFaqs">
                        @foreach($faqs as $faq)
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header" id="flush-heading{{ $faq->id }}">
                                    <button class="accordion-button collapsed bg-transparent text-white-50 p-0 mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $faq->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $faq->id }}" data-bs-parent="#footerFaqs">
                                    <div class="accordion-body text-white-50 p-0 mb-2 small">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-white-50">No FAQs available</p>
                @endif
            </div>
        </div>
    </div>
</footer>

<button id="backToTop" class="btn btn-primary btn-sm rounded-circle position-fixed bottom-0 end-0 m-4" style="display: none; z-index: 1000;">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    // Back to Top Button
    document.addEventListener('DOMContentLoaded', function() {
        var backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
