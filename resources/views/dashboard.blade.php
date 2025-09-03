<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="container-fluid">

        <!-- Greeting and Wallet Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @php
                            $hour = now()->format('H');
                            $greeting = $hour < 12 ? 'Good Morning 🌅' : ($hour < 17 ? 'Good Afternoon ☀️' : 'Good Evening 🌙');
                        @endphp

                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
                            <div>
                                <p class="fw-bold text-primary mb-2">
                                    {{ $greeting }}, {{ Auth::user()->first_name ?? 'User' }}!
                                </p>
                                <p class="mb-0 text-muted">Welcome back to your dashboard. Here's what's happening today.</p>
                            </div>

                            <!-- Wallet Balance -->
                            <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 shadow-sm">
                                <a href="{{route ('wallet')}}" class="text-decoration-none" title="Go to Wallet">
                                    <i class="fas fa-wallet fs-2 text-primary"></i>
                                </a>
                                @if($wallets->isNotEmpty())
                                    @php
                                        $wallet = $wallets->firstWhere('currency', 'NGN') ?? $wallets->first();
                                        $currencySymbol = $wallet->currency === 'NGN' ? '₦' : '$';
                                    @endphp
                                    <div class="text-center">
                                        <span class="fw-bold text-primary fs-4">
                                            {{ $currencySymbol }}{{ number_format($wallet->wallet_balance ?? 0, 2) }}
                                        </span>
                                        <span class="badge bg-{{ $wallet->status === 'active' ? 'success' : 'warning' }} ms-2">
                                            {{ ucfirst($wallet->status) }}
                                            @if($wallets->count() > 1)
                                                ({{ $wallets->count() }} wallets)
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="fw-bold fs-4">₦0.00</span>
                                        <span class="badge bg-danger ms-2">No Wallet</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @foreach (['success' => 'check-circle', 'error' => 'exclamation-triangle'] as $type => $icon)
            @if(session($type))
                <div class="alert alert-{{ $type === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                    <i class="fas fa-{{ $icon }} me-2"></i> {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i> Please fix the following:
                <ul class="mb-0">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

      <!-- Services Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h4 class="fw-bold text-primary">
                            <i class="fas fa-cubes me-2"></i> Our Services
                        </h4>
                        <p class="text-muted mb-0">Access all available services with one click</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Trasfer Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/transfer.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Transfer</h5>
                                        <small class="text-muted">Local fund transfer</small>
                                    </div>
                                </a>
                            </div>


                              <!-- BVN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/airtime.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Buy Airtime</h5>
                                        <small class="text-muted">All network in nigeria</small>
                                    </div>
                                </a>
                            </div>


                              <!-- DATA Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/data.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Buy Data</h5>
                                        <small class="text-muted">All networks In nigeria</small>
                                    </div>
                                </a>
                            </div>
                          
                          

                              <!-- BVN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('bvn.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">BVN Services</h5>
                                        <small class="text-muted">Bank Verification</small>
                                    </div>
                                </a>
                            </div>
                          
                            
                            <!-- NIN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('nin.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/nimc1.png" alt="NIN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">NIN Services</h5>
                                        <small class="text-muted">National ID</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Verifications -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{ route('verification.services') }}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/identity.png" alt="Verifications" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Verifications</h5>
                                        <small class="text-muted">Identity Checks</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- VIP Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{route ('vip.services')}}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-warning-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="VIP Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">VIP Services</h5>
                                        <small class="text-muted">Premium Features</small>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- BVN Report -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{route ('enrollments.index')}}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-danger-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/bvnlogo.png" alt="BVN Report" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">BVN Report</h5>
                                        <small class="text-muted">Agent Records</small>
                                    </div>
                                </a>
                            </div>

                              <!-- EDUCATION Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/education.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Educational Pin</h5>
                                        <small class="text-muted">all education pin</small>
                                    </div>
                                </a>
                            </div>
                          

                              <!-- LOAN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{route ('vip.services')}}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/fund.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Agent Loan</h5>
                                        <small class="text-muted">Business loan</small>
                                    </div>
                                </a>
                            </div>

                              <!-- BVN Services -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/modify.png" alt="BVN Services" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Pay Bet</h5>
                                        <small class="text-muted">Betting wallet funding</small>
                                    </div>
                                </a>
                            </div>
                          
                          
                            
                            <!-- Support -->
                            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                                <a href="{{route ('support.services')}}" class="card service-card h-100 text-decoration-none">
                                    <div class="card-body text-center p-3">
                                        <div class="icon-wrapper bg-secondary-light mb-3 mx-auto">
                                            <img src="../assets/images/apps/support.png" alt="Support" class="img-fluid" style="width: 40px; height: 40px;">
                                        </div>
                                        <h5 class="mb-0 fw-bold">Support</h5>
                                        <small class="text-muted">Help Center</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="row">
            <div class="col-12"><!-- Future notification cards --></div>
        </div>
    </div>

    <!-- Force Profile Update Modal -->
    <div class="modal fade" id="forceProfileModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-check me-2"></i> Welcome, {{ Auth::user()->first_name ?? 'User' }}!</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h6 class="fw-bold text-dark">Let’s Complete Your Registration 🎉</h6>
                        <p class="text-muted mb-0">We’re excited to have you onboard! Please update your details to enjoy the full features of your dashboard.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.updateRequired') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="bvn" class="form-label fw-semibold">BVN</label>
                            <input type="text" name="bvn" id="bvn" class="form-control"
                                   value="{{ old('bvn', Auth::user()->bvn) }}" required maxlength="11" minlength="11" placeholder="Enter your 11-digit BVN">
                        </div>
                        <div class="mb-3">
                            <label for="phone_no" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone_no" id="phone_no" class="form-control"
                                   value="{{ old('phone_no', Auth::user()->phone_no) }}" required maxlength="11" minlength="11" required placeholder="Enter your active phone number">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @if(!Auth::user()->bvn || !Auth::user()->phone_no)
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                new bootstrap.Modal(document.getElementById('forceProfileModal')).show();
                setTimeout(() => {
                    document.querySelectorAll('.alert').forEach(alert => new bootstrap.Alert(alert).close());
                }, 4000);
            });
        </script>
    @endif

</x-app-layout>
