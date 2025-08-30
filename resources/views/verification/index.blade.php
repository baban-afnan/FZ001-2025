<x-app-layout>
  <x-slot name="title">Verification Services</x-slot>

  <div class="container-fluid">
    <!-- Verification Services Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0 pb-0">
            <h4 class="fw-bold text-primary">
              <i class="fas fa-id-card-alt me-2"></i> Our Verification Services
            </h4>
            <p class="text-muted mb-0">Comprehensive Verification solutions</p>
          </div>
          
          <div class="card-body">
            <div class="row g-4">
              <!-- NIN Verification Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('nin.verification.index') }}" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-primary-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Modification" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">NIN Verification</h5>
                    <small class="mb-0 fw-bold">V1</small>
                  </div>
                </a>
              </div>
              
              <!-- NIN Verification DEMO Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Validation" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify NIN DEMO</h5>
                    <small class="mb-0 fw-bold">V1</small>
                  </div>
                </a>
              </div>

               <!-- NIN Verification Phone Number Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-info-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Validation" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify Phone NO</h5>
                    <small class="mb-0 fw-bold">V1</small>
                  </div>
                </a>
              </div>
              
              <!-- BVN VERIFICATION -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="IPE" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify BVN</h5>
                    <small class="mb-0 fw-bold">V1</small>
                  </div>
                </a>
              </div>
               <!-- BVN Verification v1 -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="IPE" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify BVN</h5>
                  </div>
                </a>
              </div>
               <!-- Account Verification services-->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="icon-wrapper bg-success-light mb-3 mx-auto">
                      <img src="../assets/images/apps/agent.jpg" alt="IPE" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Verify Bank Account</h5>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>