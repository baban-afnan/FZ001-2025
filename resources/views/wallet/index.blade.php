<x-app-layout>

  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12">
            <h2>Wallet funding</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">

        <!-- Automatic Funding Card -->
        <div class="col-xl-6 mb-lg-3">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <h3>Automatic wallet funding</h3>
              <p class="mt-1 mb-0">
                Fund your wallet using a virtual account. It will be credited instantly after payment confirmation.
              </p>
            </div>

            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif

            <div class="card-body custom-input form-validation">
              @if($virtualAccount)
              <form class="row g-3">
                <div class="col-12">
                  <label class="form-label">Account Name</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->accountName }}">
                </div>
                <div class="col-12">
                  <label class="form-label">Account Number</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->accountNo }}">
                </div>
                <div class="col-12">
                  <label class="form-label">Bank Name</label>
                  <input class="form-control" type="text" readonly value="{{ $virtualAccount->bankName }}">
                </div>
              </form>
              @else
              <div class="col-12 mt-2">
                <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#virtualAccountModal">
                  <i class="fas fa-user"></i> No virtual account? Create
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Account Bonus Container -->
        <div class="col-xl-6">
          <div class="card shadow-lg border-0 rounded-3">
            
            <!-- Header -->
            <div class="card-header bg-gradient-primary text-white rounded-top d-flex align-items-center justify-content-between">
              <h4 class="mb-0 text-primary">
                <i class="bi bi-wallet2 me-2"></i>Account Bonus
              </h4>
              <span class="badge bg-primary text-primary fw-bold">Active</span>
            </div>

            <!-- Body -->
            <div class="card-body">
              <p class="text-muted mb-3">
                Invite your friends and earn extra rewards! <br>
                Use your referral code:
              </p>

              <!-- Referral Code with Copy -->
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="referralCode" readonly 
                  value="https://biyanow.com/login/{{ auth()->user()->referral_code }}">
                <button class="btn btn-outline-primary" type="button" onclick="copyReferral()">
                  <i class="bi bi-clipboard-check"></i> Copy
                </button>
              </div>
              <small id="copyMsg" class="text-success d-none"><i class="bi bi-check2-circle"></i> Copied!</small>

              <!-- Share Buttons -->
              <div class="d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-success" onclick="shareWhatsApp()">
                  <i class="bi bi-whatsapp"></i> WhatsApp
                </button>
                <button class="btn btn-primary" onclick="shareFacebook()">
                  <i class="bi bi-facebook"></i> Facebook
                </button>
                <button class="btn btn-info text-white" onclick="shareTwitter()">
                  <i class="bi bi-twitter-x"></i> Twitter
                </button>
                <button class="btn btn-dark" onclick="nativeShare()">
                  <i class="bi bi-share-fill"></i> More...
                </button>
              </div>

              <!-- Bonus Card -->
              <div class="row g-4 mt-4">
                <div class="col-md-6">
                  <div class="card bg-light border-0 shadow-sm h-100 hover-shadow transition">
                    <div class="card-body text-center">
                      <span class="badge bg-success px-3 py-2 mb-2">
                        <i class="bi bi-gift-fill"></i> Bonus
                      </span>
                      <h3 class="fw-bold text-primary mb-1">{{ $walletData['bonus'] }}</h3>
                      <p class="text-muted small mb-3">Extra rewards earned</p>
                     @if($walletData['bonus'] > 0)
                     <form action="{{ route('wallet.claimBonus') }}" method="POST" class="d-inline">
                        @csrf
                      <button type="submit" class="btn btn-primary">
                         Claim Bonus
                       </button>
                      </form>
                      @endif
                    </div>
                  </div>
                </div>
              </div> <!-- row -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

    <!-- Modal for Virtual Account Creation -->
  <div class="modal fade" id="virtualAccountModal" tabindex="-1" aria-labelledby="virtualAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content shadow rounded-4">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Create Virtual Account</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body px-4 py-4">
          <form method="POST" action="{{ route('virtual.account.create') }}" class="row g-4">
            @csrf
            <div class="col-md-6">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="name" required value="{{ auth()->user()->first_name." ".auth()->user()->last_name}}" readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="phone" required value="{{ auth()->user()->phone_no }}">
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                <label class="form-check-label" for="confirmCheck">
                  I confirm that the above details are accurate and consent to create a virtual account.
                </label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-send-fill me-2"></i> Submit Request
              </button>
            </div>
          </form>
        </div>
           <div class="modal-footer bg-light rounded-bottom-4 py-3">
          <small class="text-muted">Account will be generated instantly and linked to your wallet.</small>
        </div>
      </div>
    </div>
  </div>



  <!-- JS for Copy & Share -->
  <script>
    function copyReferral() {
      let copyText = document.getElementById("referralCode");
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile
      navigator.clipboard.writeText(copyText.value);
      document.getElementById("copyMsg").classList.remove("d-none");
      setTimeout(() => {
        document.getElementById("copyMsg").classList.add("d-none");
      }, 2000);
    }

    function shareWhatsApp() {
      let text = encodeURIComponent("Discover a world of seamless transactions and exclusive bonuses! Join now with my referral link: " + document.getElementById("referralCode").value + " and unlock a special welcome bonus tailored just for you.");
      window.open("https://api.whatsapp.com/send?text=" + text, "_blank");
    }

    function shareFacebook() {
      let url = encodeURIComponent(document.getElementById("referralCode").value);
      window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank");
    }

    function shareTwitter() {
      let text = encodeURIComponent("Discover a world of seamless transactions and exclusive bonuses! Join now with my referral link: " + document.getElementById("referralCode").value);
      window.open("https://twitter.com/intent/tweet?text=" + text, "_blank");
    }

    function nativeShare() {
      if (navigator.share) {
        navigator.share({
          title: 'Join me on Biyanow!',
          text: 'Use my referral link to sign up:',
          url: document.getElementById("referralCode").value
        });
      } else {
        alert("Sharing not supported on this browser. Please use copy or social buttons.");
      }
    }
  </script>

  <!-- Optional CSS Enhancements -->
  <style>
    .hover-shadow:hover {
      box-shadow: 0 0.8rem 1.5rem rgba(0, 0, 0, 0.15) !important;
      transform: translateY(-3px);
      transition: all 0.3s ease-in-out;
    }
    .transition {
      transition: all 0.3s ease-in-out;
    }
  </style>

</x-app-layout>
