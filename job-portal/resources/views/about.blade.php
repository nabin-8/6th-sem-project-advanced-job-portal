@extends('layouts.master')

@section('title', 'About Us')

@section('page-header')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary">About Our Job Portal</h1>
            <p class="lead text-muted">Connecting talented candidates with outstanding organizations</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="container py-4">
        <!-- Our Mission Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="img-fluid rounded shadow" alt="Our mission">
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="p-4 bg-white rounded shadow-sm">
                    <h2 class="fw-bold mb-3">Our Mission</h2>
                    <p class="lead">To create a seamless connection between job seekers and employers.</p>
                    <p>We believe that the right job can transform a person's life, and the right talent can transform a company. Our mission is to make this connection as efficient and effective as possible.</p>
                    <p>Our platform is designed to help candidates find opportunities that match their skills, experience, and career goals, while enabling organizations to identify and recruit top talent that aligns with their needs and culture.</p>
                </div>
            </div>
        </div>

        <!-- Who We Are Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="img-fluid rounded shadow" alt="Our team">
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded shadow-sm">
                    <h2 class="fw-bold mb-3">Who We Are</h2>
                    <p>Founded in 2023, our job portal has quickly grown to become one of the leading platforms connecting talented individuals with forward-thinking organizations.</p>
                    <p>Our team consists of passionate professionals with backgrounds in HR, technology, and recruitment who understand the challenges faced by both job seekers and employers in today's competitive market.</p>
                    <p>We're committed to continuous improvement and innovation, constantly enhancing our platform to provide the best possible experience for all users.</p>
                </div>
            </div>
        </div>

        <!-- Our Values Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="p-4 bg-white rounded shadow-sm">
                    <h2 class="fw-bold mb-4 text-center">Our Core Values</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="display-6 text-primary mb-3">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h4>Integrity</h4>
                                <p class="text-muted">We believe in transparency and honesty in all our interactions with candidates, organizations, and stakeholders.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="display-6 text-primary mb-3">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h4>Excellence</h4>
                                <p class="text-muted">We strive for excellence in our platform, services, and support, constantly seeking ways to improve.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="display-6 text-primary mb-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>Inclusivity</h4>
                                <p class="text-muted">We're committed to creating equal opportunities for all, regardless of background or circumstance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="p-4 bg-white rounded shadow-sm">
                    <h2 class="fw-bold mb-4 text-center">How It Works</h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0"><i class="fas fa-user-tie me-2"></i>For Candidates</h4>
                                </div>
                                <div class="card-body">
                                    <ol class="ps-3">
                                        <li class="mb-3">Create your profile with your skills, experience, education, and career preferences.</li>
                                        <li class="mb-3">Browse available job listings that match your skills and interests.</li>
                                        <li class="mb-3">Apply for positions with just a few clicks.</li>
                                        <li>Track your application status and receive updates from employers.</li>
                                    </ol>
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Register as a Candidate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h4 class="mb-0"><i class="fas fa-building me-2"></i>For Organizations</h4>
                                </div>
                                <div class="card-body">
                                    <ol class="ps-3">
                                        <li class="mb-3">Create your company profile to showcase your organization to potential candidates.</li>
                                        <li class="mb-3">Post job vacancies with detailed descriptions, requirements, and benefits.</li>
                                        <li class="mb-3">Review applications and manage your candidate pipeline efficiently.</li>
                                        <li>Communicate with candidates and schedule interviews through our platform.</li>
                                    </ol>
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register as an Organization</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="row">
            <div class="col-12 text-center">
                <div class="p-5 bg-light rounded shadow-sm">
                    <h2 class="fw-bold mb-3">Get in Touch</h2>
                    <p class="lead mb-4">Have questions or feedback? We'd love to hear from you!</p>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="btn btn-primary px-4"><i class="fas fa-envelope me-2"></i>Contact Us</a>
                                <a href="#" class="btn btn-outline-primary px-4"><i class="fas fa-question-circle me-2"></i>FAQs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection