 <!-- Right Column -->
<div class="col-xl-8">
  <form method="POST" action="{{ route('profile.update') }}" class="card" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <div class="card-header">
      <h3 class="card-title mb-0">Edit Profile</h3>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <!-- NIN Field -->
        <div class="col-md-4">
          <label class="form-label">NIN</label>
          <input 
            class="form-control" 
            type="text" 
            name="nin"
            value="{{ old('nin', Auth::user()->nin ?? '') }}"
            pattern="\d{11}"
            minlength="11" maxlength="11"
            title="NIN must be exactly 11 digits"
            @if(Auth::user()->nin) readonly @endif
            required
          >
        </div>

        <!-- Email Field -->
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input class="form-control" type="email" name="email"
                 value="{{ old('email', Auth::user()->email) }}" readonly>
        </div>

        <!-- Address Field -->
        <div class="col-md-12">
          <label class="form-label">Home Address</label>
          <textarea 
            class="form-control" 
            name="address" 
            rows="3"
            placeholder="Enter your complete residential address (Street, City, State)"
            required>{{ old('address', Auth::user()->address ?? '') }}</textarea>
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
      <button 
        type="submit" 
        class="btn btn-primary px-4"
        @if(Auth::user()->nin) disabled @endif
      >
        <i class="fas fa-save"></i> Save Changes
      </button>
    </div>
  </form>
</div>
