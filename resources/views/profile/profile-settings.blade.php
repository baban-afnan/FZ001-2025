<x-app-layout>
    <x-slot name="title">Profile Settings</x-slot>

<div class="container-fluid py-4">
  <div class="edit-profile">
    <div class="row">
      

        <!-- Show success message -->
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                ✅ Profile updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Show error message -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Show validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

      <!-- Left Column -->
      <div class="col-xl-4">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h3 class="card-title mb-0">My Profile</h3>
          </div>
          <div class="card-body">
            <!-- Profile Image + Name -->
           <div class="d-flex align-items-center gap-3 p-3 bg-white rounded shadow-sm mb-3">
    <div class="profile-img-container" data-bs-toggle="modal" data-bs-target="#profileImageModal">
        <img class="img-70 rounded-circle border border-2 shadow-sm"
             src="{{ Auth::user()->photo 
                        ? asset('storage/profile_photos/' . Auth::user()->photo) 
                        : asset('assets/images/user/6.png') }}"
             alt="User Photo"
             style="object-fit: cover; width: 70px; height: 70px;" />
        <div class="profile-img-edit">
            <i class="fas fa-pen fa-xs"></i>
                </div>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                <p class="text-muted mb-0">Role: {{ Auth::user()->role }}</p>
              </div>
            </div>

            <!-- Transaction PIN -->
            <div class="mb-4">
              <h5 class="form-section-title">Transaction PIN</h5>
              @if(Auth::user()->transaction_pin)
                <p class="text-success mb-2"><i class="fas fa-check-circle"></i> PIN is set</p>
                <div class="transaction-pin-actions">
                  <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePinModal">
                    <i class="fas fa-lock"></i> Change
                  </button>
                  <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#resetPinModal">
                    <i class="fas fa-key"></i> Reset
                  </button>
                </div>
              @else
                <p class="text-danger mb-2"><i class="fas fa-exclamation-circle"></i> No PIN set</p>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPinModal">
                  <i class="fas fa-plus-circle"></i> Create PIN
                </button>
              @endif
            </div>

            <!-- Password Update -->
            <form method="POST" action="{{ route('password.update') }}">
              @csrf @method('PUT')
              <h5 class="form-section-title">Change Password</h5>
              <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control" name="current_password" required>
              </div>
              <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-xl-8">
        <form method="POST" action="{{ route('profile.update') }}" class="card" enctype="multipart/form-data">
          @csrf @method('PATCH')
          <div class="card-header">
            <h3 class="card-title mb-0">Edit Profile</h3>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">NIN</label>
                <input class="form-control" type="text" name="nin"
                       value="{{ old('nin', Auth::user()->nin ?? '') }}" required>
              </div>

               <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email"
                       value="{{ old('email', Auth::user()->email) }}" readonly>
              </div>

              <div class="col-md-12">
                <label class="form-label">Home Address</label>
                <input class="form-control" type="text" name="address"
                       value="{{ old('address', Auth::user()->address ?? '') }}" required>
              </div>
            </div>

            <hr class="my-4">

            <!-- Security Questions Trigger -->
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="form-section-title">Security Questions</h5>
              <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#securityQuestionsModal">
                <i class="fas fa-shield-alt"></i> Manage
              </button>
            </div>
          </div>
          <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save"></i> Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ===================== MODALS ===================== -->

<!-- Profile Image Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="modal-content p-3">
      @csrf @method('PATCH')
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title text-primary"><i class="fas fa-image me-2"></i>Update Profile Photo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Select New Photo</label>
          <input type="file" name="photo" class="form-control" accept="image/*" required>
        </div>
        <div class="alert alert-info small"><i class="fas fa-info-circle"></i> Allowed: JPG/PNG, max 2MB. cropping will apply.</div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload"></i> Upload</button>
      </div>
    </form>
  </div>
</div>

<!-- Create PIN Modal (Email/OTP) -->
<div class="modal fade" id="createPinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('profile.update') }}" class="modal-content p-3">
      @csrf
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title text-primary"><i class="fas fa-key me-2"></i>Create PIN with Verification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check-circle"></i> Create PIN</button>
      </div>
    </form>
  </div>
</div>

<!-- Change PIN Modal (old/new/confirm) -->
<div class="modal fade" id="changePinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="#" class="modal-content p-3">
      @csrf @method('PUT')
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title text-primary"><i class="fas fa-lock me-2"></i>Update Transaction PIN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Old PIN <span class="text-danger">*</span></label>
          <input type="password" name="old_pin" class="form-control" maxlength="4" placeholder="Enter old PIN" required>
        </div>
        <div class="mb-3">
          <label class="form-label">New PIN <span class="text-danger">*</span></label>
          <input type="password" name="new_pin" class="form-control" maxlength="4" placeholder="Enter new PIN" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm New PIN <span class="text-danger">*</span></label>
          <input type="password" name="new_pin_confirmation" class="form-control" maxlength="4" placeholder="Confirm new PIN" required>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Update PIN</button>
      </div>
    </form>
  </div>
</div>

<!-- Reset PIN Modal -->
<div class="modal fade" id="resetPinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="#" class="modal-content">
      @csrf @method('PATCH')
      <div class="modal-header">
        <h5 class="modal-title">Reset Transaction PIN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted">Resetting will allow you to create a new PIN.</p>
        <label class="form-label">New PIN</label>
        <input type="password" name="new_pin" class="form-control mb-3" maxlength="4" required>
        <label class="form-label">Confirm PIN</label>
        <input type="password" name="new_pin_confirmation" class="form-control" maxlength="4" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Reset PIN</button>
      </div>
    </form>
  </div>
</div>

<!-- Security Questions Modal -->
<div class="modal fade" id="securityQuestionsModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" action="#" class="modal-content">
      @csrf @method('PATCH')
      <div class="modal-header">
        <h5 class="modal-title">Manage Security Questions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Security Question 1</label>
            <select class="form-select" name="security_question_1" required>
              <option value="">Select a question</option>
              <option>What is your mother’s maiden name?</option>
              <option>What was the name of your first pet?</option>
              <option>What city were you born in?</option>
            </select>
            <input type="text" class="form-control mt-2" name="security_answer_1" placeholder="Answer" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Security Question 2</label>
            <select class="form-select" name="security_question_2" required>
              <option value="">Select a question</option>
              <option>What is your favorite teacher’s name?</option>
              <option>What was your childhood nickname?</option>
              <option>What is your favorite book?</option>
            </select>
            <input type="text" class="form-control mt-2" name="security_answer_2" placeholder="Answer" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Security Question 3</label>
            <select class="form-select" name="security_question_3" required>
              <option value="">Select a question</option>
              <option>What is your dream job?</option>
              <option>What is your favorite food?</option>
              <option>What is the name of your first school?</option>
            </select>
            <input type="text" class="form-control mt-2" name="security_answer_3" placeholder="Answer" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Questions</button>
      </div>
    </form>
  </div>
</div>

</x-app-layout>
