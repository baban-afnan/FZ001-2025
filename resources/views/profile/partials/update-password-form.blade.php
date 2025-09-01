<!-- Password Update -->
<form method="POST" action="{{ route('password.update') }}">
    @csrf @method('PUT')
    <h5 class="form-section-title">Change Password</h5>
    <!-- Current Password -->
    <div class="mb-3">
        <label class="form-label">Current Password</label>
        <div class="input-group">
            <input type="password" class="form-control" name="current_password" id="current_password" required>
            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#current_password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <!-- New Password -->
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
            <input type="password" class="form-control" name="password" id="new_password" required>
            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#new_password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
            <input type="password" class="form-control" name="password_confirmation" id="confirm_password" required>
            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#confirm_password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">Update Password</button>
</form>
 </div>
  </div>
   </div>

<!-- Password Toggle Script -->
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        });
    });
</script>
