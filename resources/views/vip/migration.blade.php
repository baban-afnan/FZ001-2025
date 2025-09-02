<x-app-layout>
    <x-slot name="title">migration - Service</x-slot>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Main Content -->
        <div class="comingsoon bg-light min-vh-100 d-flex align-items-center">
            <div class="comingsoon-inner text-center w-100 py-3 py-md-4 py-lg-5">

                <!-- Logo -->
                <div class="logo-container mb-4">
                    <img class="for-light img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" style="max-width: 40px;" />
                    <img class="for-dark img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" style="max-width: 40px;" />
                </div>

                <!-- Heading -->
                <div class="container">
                    <p class="lead text-muted mb-4">
                        Exciting upgrades and new features are on their way!
                    </p>
                </div>

                <!-- Upgrade CTA -->
                <div class="upgrade-cta bg-white p-4 rounded shadow-lg mb-5 mx-auto">
                    <h3 class="mb-3">
                        <i class="bi bi-rocket-takeoff text-primary me-2"></i> Upgrade to Agent Status
                    </h3>
                    <p class="text-muted mb-4">
                        Unlock powerful features and grow your business exponentially.
                    </p>

                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <button type="button" class="btn btn-primary shadow-sm px-4 py-2" 
                                data-bs-toggle="modal" data-bs-target="#migrationBenefitsModal">
                            <i class="bi bi-stars me-2"></i> See Benefits
                        </button>
                        <button type="button" class="btn btn-success shadow-sm px-4 py-2" 
                                data-bs-toggle="modal" data-bs-target="#migrationFormModal">
                            <i class="bi bi-pencil-square me-2"></i> Apply Now
                        </button>
                    </div>
                </div>

                <!-- Quick Benefits Preview -->
                <div class="quick-benefits row justify-content-center g-3 mx-auto" style="max-width: 1200px;">
                    @php
                        $benefits = [
                            ['icon' => 'bi-cash-stack', 'color' => 'primary', 'title' => 'Higher Commissions', 'text' => 'Earn significantly more with agent-level rates'],
                            ['icon' => 'bi-people-fill', 'color' => 'success', 'title' => 'Team Building', 'text' => 'Build your own team and earn from their performance'],
                            ['icon' => 'bi-shield-lock', 'color' => 'info', 'title' => 'Priority Support', 'text' => 'Dedicated support team for all your needs'],
                            ['icon' => 'bi-award-fill', 'color' => 'warning', 'title' => 'Exclusive Tools', 'text' => 'Access to premium analytics and marketing tools'],
                        ];
                    @endphp

                    @foreach ($benefits as $benefit)
                        <div class="col-6 col-md-3">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <div class="icon-circle bg-{{ $benefit['color'] }} bg-opacity-10 text-{{ $benefit['color'] }} mb-3 mx-auto">
                                        <i class="bi {{ $benefit['icon'] }} fs-3"></i>
                                    </div>
                                    <h5 class="card-title">{{ $benefit['title'] }}</h5>
                                    <p class="card-text text-muted small">{{ $benefit['text'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        @include('forms.upgradebenefits')
        @include('forms.migrationform')

    </div>

    <style>
        .text-gradient-primary {
            background: linear-gradient(90deg, #4e73df, #224abe);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upgrade-cta {
            border-top: 4px solid #4e73df;
            max-width: 650px;
        }

        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }

        .btn {
            min-height: 44px;
        }

        @media (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
        }
    </style>
</x-app-layout>
