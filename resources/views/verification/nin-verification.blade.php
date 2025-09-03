<x-app-layout>
    <x-slot name="title">Verify NIN</x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- NIN Verification Form -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>NIN Verification Form</h3>
                        <p class="mt-1 mb-0">NIN verification is instant. No charges for invalid searches.</p>

                        {{-- ✅ Global success/error messages from controller --}}
                        @if (session('status') && session('message'))
                            <div class="alert alert-{{ session('status') === 'success' ? 'success' : 'danger' }} alert-dismissible fade show mt-3"
                                role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- ✅ Validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <div class="card-body custom-input form-validation">
                        <form class="row g-3" method="POST" action="{{ route('nin.verification.store') }}">
                            @csrf

                            <div class="col-12">
                                <label class="form-label">NIN Number <span class="text-danger">*</span></label>
                                <input class="form-control" name="number_nin" type="text"
                                    placeholder="Enter 11 Digit NIN" maxlength="11" minlength="11" pattern="[0-9]{11}"
                                    required value="{{ old('number_nin') }}">
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info d-flex justify-content-between align-items-center">
                                    <span>Service Fee:</span>
                                    <strong>₦{{ number_format($standard_nin_fee->amount ?? 0, 2) }}</strong>
                                </div>
                            </div>

                            <div class="col-12 mt-3 text-center">
                                <button class="btn btn-primary w-80" type="submit">
                                    <i class="bi bi-send-fill me-2"></i> Verify Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Verification Info -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>Verification Information</h3>
                    </div>

                    @if (session('verification'))
                        <div class="card-body">
                            <div class="alert alert-success text-center">
                                <strong>Verification Successful!</strong>
                            </div>

                            {{-- Centered Photo if available --}}
                            @if (!empty(session('verification')->photo_path))
                                <div class="text-center mb-3">
                                    <div class="id-photo-container d-inline-block p-2 border rounded bg-white">
                                        <img src="data:image/jpeg;base64, {{ session('verification')['data']['photo'] }}"
                                            alt="ID Photo" class="img-fluid rounded shadow-sm"
                                            style="max-height:200px;">
                                        <div class="mt-1" style="font-size: 0.8rem;">PHOTO</div>
                                    </div>
                                </div>
                            @endif

                            <table class="table table-bordered mb-3">
                                <tbody>
                                    <tr>
                                        <th>NIN Number</th>
                                        <td>{{ session('verification')['data']['nin'] }}
                                            <span id="nin_no"
                                                hidden>{{ session('verification')['data']['nin'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ session('verification')['data']['firstName'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ session('verification')['data']['surname'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Middle Name</th>
                                        <td>{{ session('verification')['data']['middleName'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>
                                            {{ !empty(session('verification')['data']['birthDate'])
                                                ? \Carbon\Carbon::parse(session('verification')['data']['birthDate'])->format('d M, Y')
                                                : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ ucfirst(session('verification')['data']['gender'] ?? 'N/A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ session('verification')['data']['telephoneNo'] ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="text-center">
                                <a href="#" id="standardSlip" class="btn btn-primary btn-wave me-2">
                                    <i class="bi bi-download"></i> Standard NIN Slip
                                </a>

                                <a href="#" id="premiumSlip" class="btn btn-secondary btn-wave">
                                    <i class="bi bi-download"></i> Premium NIN Slip
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/apps/search.png') }}" width="20%" alt="Search Icon">
                            <p class="mt-3">Results will appear here after verification.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</x-app-layout>
