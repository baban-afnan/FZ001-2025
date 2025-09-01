
    <x-slot name="title">Transaction PIN Setup</x-slot>

    <div class="container py-4">

        {{-- Global toasts (success / error) --}}
        @if(session('status') || session('success') || session('error'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
                <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            @if(session('status')) <i class="fas fa-check-circle me-2"></i>{{ session('status') }} @endif
                            @if(session('success')) <i class="fas fa-check-circle me-2"></i>{{ session('success') }} @endif
                            @if(session('error')) <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }} @endif
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

       <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <h4 class="mb-3 d-flex align-items-center">
            <i class="fas fa-key text-primary me-2"></i> Transaction PIN
        </h4>

        @php
            // ✅ Assuming you have a "securities" relationship or model connected to the user
            $security = \App\Models\Security::where('user_id', Auth::id())->first();
        @endphp

        @if($security && $security->transaction_pin)
            <!-- PIN Already Set -->
            <p class="text-success">
                <i class="fas fa-check-circle me-1"></i> PIN is already set.
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Change PIN -->
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createPinModal">
                    <i class="fas fa-lock me-1"></i> Change PIN
                </button>
                <!-- Reset PIN -->
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#resetPinModal">
                    <i class="fas fa-redo me-1"></i> Reset PIN
                </button>
            </div>
        @else
            <!-- No PIN Set -->
            <p class="text-danger">
                <i class="fas fa-exclamation-circle me-1"></i> No PIN set.
            </p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPinModal">
                <i class="fas fa-plus-circle me-1"></i> Create PIN
            </button>
        @endif
    </div>
</div>

    </div>

    {{-- =============== CREATE PIN MODAL (Email → OTP → New PIN) =============== --}}
    <div class="modal fade" id="createPinModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-primary"><i class="fas fa-key me-2"></i>Create PIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- stepper --}}
                <div class="px-3 pb-2">
                    <div class="d-flex align-items-center small text-muted">
                        <span class="badge rounded-pill bg-primary me-2" id="c-step-b1">1</span><span class="me-3">Send OTP</span>
                        <span class="badge rounded-pill bg-secondary me-2" id="c-step-b2">2</span><span class="me-3">Verify OTP</span>
                        <span class="badge rounded-pill bg-secondary me-2" id="c-step-b3">3</span><span>Set PIN</span>
                    </div>
                </div>

                <div class="modal-body">
                    {{-- Inline errors for this modal --}}
                    @if ($errors->any() && (session('current_modal') === 'create'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success hints --}}
                    @if(session('otp_sent') && session('current_modal') === 'create')
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>OTP sent to {{ Auth::user()->email }}. It expires in 2 minutes.</div>
                    @endif
                    @if(session('otp_verified') && session('current_modal') === 'create')
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>OTP verified. Set your new PIN.</div>
                    @endif

                    {{-- Step 1: Request OTP --}}
                    <div id="c-step1">
                        <form method="POST" action="{{ route('pin.requestOtp') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-1"></i> Send OTP
                            </button>
                        </form>
                    </div>

                    {{-- Step 2: Verify OTP --}}
                    <div id="c-step2" class="d-none">
                        <form method="POST" action="{{ route('pin.verifyOtp') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="mb-3">
                                <label class="form-label">Enter 8-digit OTP</label>
                                <input type="text" name="otp" inputmode="numeric" pattern="\d{8}" maxlength="8" class="form-control" placeholder="********" required>
                                <small class="text-muted">OTP expires in 2 minutes.</small>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-1"></i> Verify OTP
                            </button>
                        </form>
                    </div>

                    {{-- Step 3: Create PIN --}}
                    <div id="c-step3" class="d-none">
                        <form method="POST" action="{{ route('pin.create') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">New PIN</label>
                                <div class="input-group">
                                    <input type="password" name="pin" inputmode="numeric" pattern="\d{4}" maxlength="4" class="form-control" placeholder="••••" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-pin"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm PIN</label>
                                <div class="input-group">
                                    <input type="password" name="pin_confirmation" inputmode="numeric" pattern="\d{4}" maxlength="4" class="form-control" placeholder="••••" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-pin"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i> Save PIN
                            </button>
                        </form>
                    </div>
                </div> {{-- /modal-body --}}
            </div>
        </div>
    </div>

    {{-- =============== RESET PIN MODAL (Old PIN → OTP → New PIN) =============== --}}
    <div class="modal fade" id="resetPinModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-danger"><i class="fas fa-redo me-2"></i>Reset / Change PIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- stepper --}}
                <div class="px-3 pb-2">
                    <div class="d-flex align-items-center small text-muted">
                        <span class="badge rounded-pill bg-primary me-2" id="r-step-b1">1</span><span class="me-3">Verify Old PIN</span>
                        <span class="badge rounded-pill bg-secondary me-2" id="r-step-b2">2</span><span class="me-3">Verify OTP</span>
                        <span class="badge rounded-pill bg-secondary me-2" id="r-step-b3">3</span><span>Set New PIN</span>
                    </div>
                </div>

                <div class="modal-body">
                    {{-- Inline errors for this modal --}}
                    @if ($errors->any() && (session('current_modal') === 'reset'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success hints --}}
                    @if(session('reset_otp_sent') && session('current_modal') === 'reset')
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>OTP sent to {{ Auth::user()->email }}. It expires in 2 minutes.</div>
                    @endif
                    @if(session('otp_verified') && session('current_modal') === 'reset')
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>OTP verified. Set your new PIN.</div>
                    @endif

                    {{-- Step 1: Old PIN → request OTP --}}
                    <div id="r-step1">
                        <form method="POST" action="{{ route('pin.reset') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Old PIN</label>
                                <div class="input-group">
                                    <input type="password" name="old_pin" inputmode="numeric" pattern="\d{4}" maxlength="4" class="form-control" placeholder="••••" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-pin"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-paper-plane me-1"></i> Send Reset OTP
                            </button>
                        </form>
                    </div>

                    {{-- Step 2: Verify OTP --}}
                    <div id="r-step2" class="d-none">
                        <form method="POST" action="{{ route('pin.verifyOtp') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="mb-3">
                                <label class="form-label">Enter 8-digit OTP</label>
                                <input type="text" name="otp" inputmode="numeric" pattern="\d{8}" maxlength="8" class="form-control" placeholder="********" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-1"></i> Verify OTP
                            </button>
                        </form>
                    </div>

                    {{-- Step 3: New PIN --}}
                    <div id="r-step3" class="d-none">
                        <form method="POST" action="{{ route('pin.create') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">New PIN</label>
                                <div class="input-group">
                                    <input type="password" name="pin" inputmode="numeric" pattern="\d{4}" maxlength="4" class="form-control" placeholder="••••" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-pin"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm PIN</label>
                                <div class="input-group">
                                    <input type="password" name="pin_confirmation" inputmode="numeric" pattern="\d{4}" maxlength="4" class="form-control" placeholder="••••" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-pin"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-save me-1"></i> Save New PIN
                            </button>
                        </form>
                    </div>
                </div> {{-- /modal-body --}}
            </div>
        </div>
    </div>

    {{-- =============== JS: step control & auto-open =============== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Eye toggle for PIN inputs
            document.querySelectorAll('.toggle-pin').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.previousElementSibling;
                    const icon = btn.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });

            // Helpers
            const show = el => el.classList.remove('d-none');
            const hide = el => el.classList.add('d-none');

            // Create modal elements
            const cModalEl  = document.getElementById('createPinModal');
            const cModal    = new bootstrap.Modal(cModalEl);
            const c1 = document.getElementById('c-step1');
            const c2 = document.getElementById('c-step2');
            const c3 = document.getElementById('c-step3');
            const cb1 = document.getElementById('c-step-b1');
            const cb2 = document.getElementById('c-step-b2');
            const cb3 = document.getElementById('c-step-b3');

            // Reset modal elements
            const rModalEl  = document.getElementById('resetPinModal');
            const rModal    = new bootstrap.Modal(rModalEl);
            const r1 = document.getElementById('r-step1');
            const r2 = document.getElementById('r-step2');
            const r3 = document.getElementById('r-step3');
            const rb1 = document.getElementById('r-step-b1');
            const rb2 = document.getElementById('r-step-b2');
            const rb3 = document.getElementById('r-step-b3');

            function setCreateStep(step) {
                [c1,c2,c3].forEach(hide); [cb1,cb2,cb3].forEach(b=>b.classList.replace('bg-primary','bg-secondary'));
                if (step === 1) { show(c1); cb1.classList.replace('bg-secondary','bg-primary'); }
                if (step === 2) { show(c2); cb2.classList.replace('bg-secondary','bg-primary'); }
                if (step === 3) { show(c3); cb3.classList.replace('bg-secondary','bg-primary'); }
            }

            function setResetStep(step) {
                [r1,r2,r3].forEach(hide); [rb1,rb2,rb3].forEach(b=>b.classList.replace('bg-primary','bg-secondary'));
                if (step === 1) { show(r1); rb1.classList.replace('bg-secondary','bg-primary'); }
                if (step === 2) { show(r2); rb2.classList.replace('bg-secondary','bg-primary'); }
                if (step === 3) { show(r3); rb3.classList.replace('bg-secondary','bg-primary'); }
            }

            // Flags from server
            const flags = {
                otpSent:      @json(session('otp_sent')),
                resetOtpSent: @json(session('reset_otp_sent')),
                otpVerified:  @json(session('otp_verified')),
                statusMsg:    @json(session('status')),
                currentModal: @json(session('current_modal')) // optional if you add it
            };

            // Decide which modal/step to open automatically.
            // 1) If OTP sent for Create → open Create step 2
            if (flags.otpSent && (!flags.currentModal || flags.currentModal === 'create')) {
                setCreateStep(2);
                cModal.show();
            }

            // 2) If OTP sent for Reset → open Reset step 2
            if (flags.resetOtpSent && (!flags.currentModal || flags.currentModal === 'reset')) {
                setResetStep(2);
                rModal.show();
            }

            // 3) After OTP verified:
            //    If user already has a PIN, assume Reset flow → open Reset step 3
            //    Else assume Create flow → open Create step 3
            const userHasPin = @json((bool) Auth::user()->transaction_pin);
            if (flags.otpVerified) {
                if (userHasPin && (!flags.currentModal || flags.currentModal === 'reset')) {
                    setResetStep(3);
                    rModal.show();
                } else {
                    setCreateStep(3);
                    cModal.show();
                }
            }

            // 4) After final success (status), close modals if open
            if (flags.statusMsg) {
                cModal.hide();
                rModal.hide();
            }

            // Default initial steps
            if (!flags.otpSent && !flags.otpVerified && !flags.statusMsg) {
                setCreateStep(1);
                setResetStep(1);
            }
        });
    </script>

