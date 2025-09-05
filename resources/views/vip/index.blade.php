<x-app-layout>
  <x-slot name="title">VIP Services</x-slot>
   <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12">
          </div>
        </div>
      </div>
   </div>
  <div class="container-fluid">
    <!-- VIP Services Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0 pb-0">
            <h4 class="fw-bold text-primary">
              <i class="fas fa-crown me-2"></i> Our VIP Services
            </h4>
            <p class="text-muted mb-0">Exclusive premium services for valued clients</p>
          </div>
          
          <div class="card-body">
            <div class="row g-4">
              <!-- CRM Service -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('bvn-crm') }}" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="CRM" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">CRM</h5>
                    <small class="text-muted">10% discount</small>
                  </div>
                </a>
              </div>
              
              <!-- BVN User -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{ route('bvn.index') }}" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="BVN User" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">BVN User</h5>
                    <small class="text-muted">10% discount</small>
                  </div>
                </a>
              </div>
              
              <!-- VNIN to NIBSS -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{route ('send-vnin')}}" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="VNIN to NIBSS" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">VNIN to NIBSS</h5>
                    <small class="text-muted">10% discount</small>
                  </div>
                </a>
              </div>
              
              <!-- VIP Modification -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{route ('vip-modification')}}" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/bvnlogo.png" alt="Modification" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Modification</h5>
                    <small class="text-muted">Other Banks in nigeria</small>
                  </div>
                </a>
              </div>
              
              <!-- Get BVN Link -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="#" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/court.png" alt="Get BVN Link" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Affidavit</h5>
                    <small class="text-muted">Affidavit for all your need</small>
                  </div>
                </a>
              </div>
               <!-- Nin verification Link -->
              <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <a href="{{route ('nin.verification.index')}}" class="card vip-service-card h-100 text-decoration-none">
                  <div class="card-body text-center p-3">
                    <div class="vip-icon-wrapper bg-gold-light mb-3 mx-auto">
                      <img src="../assets/images/apps/nimc1.png" alt="Get BVN Link" class="img-fluid" style="width: 40px; height: 40px;">
                    </div>
                    <h5 class="mb-0 fw-bold">Identity Verification</h5>
                    <small class="text-muted">10% discount</small>
                  </div>
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>