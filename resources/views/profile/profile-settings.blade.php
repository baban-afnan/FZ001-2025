<x-app-layout>
    <x-slot name="title">Profile Settings</x-slot>

    <div class="container-fluid py-4">
        <div class="edit-profile">
            <div class="row">

                <!-- ✅ Success Message -->
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show m-3 shadow-sm rounded" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Profile updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ❌ Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3 shadow-sm rounded" role="alert">
                        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ⚠️ Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3 shadow-sm rounded" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ================= LEFT COLUMN ================= -->
                <div class="col-xl-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header pb-0 bg-white border-0">
                            <h3 class="card-title fw-bold mb-0">My Profile</h3>
                        </div>
                        <div class="card-body">

                            <!-- Profile Section -->
                            <div class="row mb-4">
                                <div class="profile-title">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded shadow-sm">

                                        <!-- Profile Image -->
                                        <div class="position-relative profile-img-container" data-bs-toggle="modal" data-bs-target="#profileImageModal">
                                            <img class="img-70 rounded-circle border border-2 shadow-sm"
                                                 src="{{ Auth::user()->photo 
                                                        ? (Str::startsWith(Auth::user()->photo, 'http') 
                                                            ? Auth::user()->photo 
                                                            : asset('storage/profile_photos/' . Auth::user()->photo)) 
                                                        : asset('assets/images/profile.png') }}"
                                                 alt="User Photo"
                                                 style="object-fit: cover; width: 70px; height: 70px;" />

                                            <!-- Edit Icon Overlay -->
                                            <div class="profile-img-edit d-flex justify-content-center align-items-center">
                                                <i class="fas fa-pen fa-xs text-white"></i>
                                            </div>
                                        </div>

                                        <!-- User Info -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 fw-bold text-primary">
                                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                            </h4>
                                            <p class="text-muted mb-0">
                                                Account Role: 
                                                <span class="fw-semibold text-primary">
                                                    {{ ucfirst(Auth::user()->role) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction PIN -->
                            @include('profile.partials.transactionpin')

                            <!-- Update Password -->
                            @include('profile.partials.update-password-form')

                              <!-- SQA-->
                            @include('profile.partials.sqa')


                            <!-- Update Profile Info -->
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
                <!-- ================= END LEFT COLUMN ================= -->

            </div>
        </div>
    </div>

    <!-- ================= Profile Image Update Modal ================= -->
    <div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold " id="profileImageModalLabel">Update Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data">
                   @csrf

                    <div class="modal-body text-center">
                        <!-- Current Image Preview -->
                        <img id="currentImagePreview" 
                             src="{{ Auth::user()->photo 
                                    ? (Str::startsWith(Auth::user()->photo, 'http') 
                                        ? Auth::user()->photo 
                                        : asset('storage/profile_photos/' . Auth::user()->photo)) 
                                    : asset('assets/images/profile.png') }}" 
                             alt="Preview" 
                             class="rounded-circle border shadow-sm mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">

                        <!-- Upload New Image -->
                        <div class="mb-3">
                            <input class="form-control" type="file" name="photo" accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= Custom Styles ================= -->
    <style>
        .profile-img-container {
            position: relative;
            cursor: pointer;
            display: inline-block;
        }
        .profile-img-container img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .profile-img-container:hover img {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
        }
        .profile-img-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 26px;
            height: 26px;
            background: rgba(0,0,0,0.6);
            border-radius: 50%;
            display: none;
        }
        .profile-img-container:hover .profile-img-edit {
            display: flex;
        }
    </style>

    <!-- ================= JavaScript Preview ================= -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('currentImagePreview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
