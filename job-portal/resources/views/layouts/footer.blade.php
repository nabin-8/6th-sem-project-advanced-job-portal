<footer class="footer mt-auto">
    <div class="container">
        <div class="row py-4 border-bottom border-secondary border-opacity-25">
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="logo-container me-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <img src="{{ asset('uploads/assets/logo.svg') }}" />
                            {{-- <span class="fw-bold text-dark">logo</span> --}}
                        </div>
                    </div>
                    <h5 class="mb-0 text-white">{{ config('app.name', 'Job Portal') }}</h5>
                </div>
                <p class="text-light opacity-75 mb-3">Connecting talent with opportunities</p>
                <p class="text-light opacity-75 mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i> Address
                </p>
                <p class="text-light opacity-75 mb-0">
                    <i class="fas fa-phone me-2 text-primary"></i> 455454554
                </p>
                <p class="text-light opacity-75 mb-0">
                    <i class="fas fa-envelope me-2 text-primary"></i> hjbdhjsd@gmail.com
                </p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-white mb-4">Pages</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}"
                            class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}"
                            class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('jobs.index') }}"
                            class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Job Listings
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('login') }}"
                            class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                            class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Register
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-white mb-4">Important Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Others
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Job Policy
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Terms
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-light opacity-75 text-decoration-none hover-text-primary">
                            <i class="fas fa-chevron-right me-2 text-primary small"></i>Conditions
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-4">Join Our Newsletter</h5>
                <p class="text-light opacity-75 mb-3">Subscribe to get the latest jobs posted, candidates...</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email address"
                            aria-label="Your email address">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-md-12 text-center">
                <p class="text-light opacity-75 mb-0">© {{ date('Y') }} {{ config('app.name', 'Job Portal') }}. All
                    rights reserved to @copyright company</p>
            </div>
        </div>
    </div>
</footer>