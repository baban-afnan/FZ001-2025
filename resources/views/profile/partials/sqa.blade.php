
<!-- Security Questions Modal -->
<div class="modal fade" id="securityQuestionsModal" tabindex="-1" aria-labelledby="securityQuestionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">
      
      <!-- Header -->
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="securityQuestionsModalLabel">
          <i class="fas fa-lock me-2 text-primary"></i> Manage Security Questions
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('profile.updateSecurityQuestions') }}">
         @csrf
         @method('PUT')

        <div class="modal-body">
          <p class="text-muted small">Please set your security questions and answers. These will help us verify your identity if you forget your password.</p>

          <!-- Question 1 -->
          <div class="mb-3">
            <label class="form-label">Security Question 1</label>
            <select name="security_question_1" class="form-select" required>
              <option value="">-- Select a Question --</option>
              <option value="mother_maiden" {{ Auth::user()->security_question_1 == 'mother_maiden' ? 'selected' : '' }}>What is your mother’s maiden name?</option>
              <option value="first_pet" {{ Auth::user()->security_question_1 == 'first_pet' ? 'selected' : '' }}>What was the name of your first pet?</option>
              <option value="birth_city" {{ Auth::user()->security_question_1 == 'birth_city' ? 'selected' : '' }}>What city were you born in?</option>
            </select>
            <input type="text" name="security_answer_1" class="form-control mt-2" placeholder="Enter your answer" required>
          </div>

          <!-- Question 2 -->
          <div class="mb-3">
            <label class="form-label">Security Question 2</label>
            <select name="security_question_2" class="form-select" required>
              <option value="">-- Select a Question --</option>
              <option value="favourite_teacher" {{ Auth::user()->security_question_2 == 'favourite_teacher' ? 'selected' : '' }}>What is the name of your favorite teacher?</option>
              <option value="first_school" {{ Auth::user()->security_question_2 == 'first_school' ? 'selected' : '' }}>What was the name of your first school?</option>
              <option value="favourite_food" {{ Auth::user()->security_question_2 == 'favourite_food' ? 'selected' : '' }}>What is your favorite food?</option>
            </select>
            <input type="text" name="security_answer_2" class="form-control mt-2" placeholder="Enter your answer" required>
          </div>

          <!-- Question 3 -->
          <div class="mb-3">
            <label class="form-label">Security Question 3</label>
            <select name="security_question_3" class="form-select" required>
              <option value="">-- Select a Question --</option>
              <option value="favourite_movie" {{ Auth::user()->security_question_3 == 'favourite_movie' ? 'selected' : '' }}>What is your favorite movie?</option>
              <option value="dream_job" {{ Auth::user()->security_question_3 == 'dream_job' ? 'selected' : '' }}>What was your childhood dream job?</option>
              <option value="favourite_color" {{ Auth::user()->security_question_3 == 'favourite_color' ? 'selected' : '' }}>What is your favorite color?</option>
            </select>
            <input type="text" name="security_answer_3" class="form-control mt-2" placeholder="Enter your answer" required>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Save Questions
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
