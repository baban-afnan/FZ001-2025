<!-- ================= Sidebar Start ================= -->
<aside class="page-sidebar">
  <!-- Left Arrow -->
  <div class="left-arrow" id="left-arrow">
    <i data-feather="arrow-left"></i>
  </div>

  <!-- Main Sidebar -->
  <div class="main-sidebar" id="main-sidebar">
    <ul class="sidebar-menu" id="simple-bar">

      <!-- Pinned Section -->
      <li class="pin-title sidebar-main-title">
        <div>
          <h5 class="sidebar-title f-w-700">Pinned</h5>
        </div>
      </li>

   
      <!-- General Section -->
      <li class="sidebar-main-title">
        <div>
          <h5 class="fw-bold sidebar-title">General</h5>
        </div>
      </li>

       <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('dashboard')}}">
          <i class="bi bi-dashboard text-primary"></i>
          <h6 class="fw-semibold">Dashboard</h6>
        </a>
      </li>

      <!-- Wallets -->
      <li class="sidebar-list">
        <a class="sidebar-link" href="javascript:void(0)">
          <i class="bi bi-wallet text-primary"></i>
          <h6>Wallets</h6>
          <span class="badge bg-primary">3</span>
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{route ('wallet')}}">Fund Wallet</a></li>
          <li><a href="dashboard-02.html">Transfer</a></li>
          <li><a href="dashboard-03.html">Bonus</a></li>
        </ul>
      </li>

      <!-- Services Section -->
      <li class="sidebar-main-title">
        <div>
          <h5 class="fw-bold sidebar-title pt-3">Services</h5>
        </div>
      </li>

      <!-- Utilities -->
      <li class="sidebar-list">
        <a class="sidebar-link" href="javascript:void(0)">
          <i class="bi bi-lightning-fill text-warning"></i>
          <h6 class="fw-semibold">Utilities</h6>
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="#">Airtime</a></li>
          <li><a href="#">Data</a></li>
          <li><a href="#">Cable TV</a></li>
          <li><a href="#">Education Pin</a></li>
          <li><a href="#">Betting</a></li>
        </ul>
      </li>

      <!-- BVN Services -->
      <li class="sidebar-list">
        <a class="sidebar-link" href="javascript:void(0)">
          <i class="bi bi-person-vcard-fill text-success"></i>
          <h6 class="fw-semibold">BVN Services</h6>
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{route ('phone.search.index')}}">Get BVN using P/N</a></li>
          <li><a href="{{route ('bvn-crm')}}">BVN CRM</a></li>
          <li><a href="{{route ('send-vnin')}}">VNIN to NIBSS</a></li>
          <li><a href="{{route ('modification')}}">BVN Modification</a></li>
          <li><a href="{{route ('bvn.index')}}">BVN User</a></li>
          <li><a href="{{route ('enrollments.index')}}">BVN Report</a></li>
        </ul>
      </li>

      <!-- NIN Services -->
      <li class="sidebar-list">
        <a class="sidebar-link" href="javascript:void(0)">
          <i class="bi bi-person-badge-fill text-info"></i>
          <h6 class="fw-semibold">NIN Services</h6>
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{route ('nin-modification')}}">NIN Modification</a></li>
          <li><a href="{{route ('validation')}}">Validation</a></li>
          <li><a href="#">IPE</a></li>
          <li><a href="#">Self Service</a></li>
        </ul>
      </li>

      <!-- Verification -->
      <li class="sidebar-list">
        <a class="sidebar-link" href="javascript:void(0)">
          <i class="bi bi-shield-lock-fill text-danger"></i>
          <h6 class="fw-semibold">Verification</h6>
          <i class="bi bi-chevron-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{route ('nin.verification.index')}}">NIN</a></li>
          <li><a href="#">BVN</a></li>
          <li><a href="#">Personalisation</a></li>
          <li><a href="#">NIN DEMO</a></li>
        </ul>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('enrollments.index')}}">
          <i class="bi bi-bar-chart-fill text-success"></i>
          <h6 class="fw-semibold">BVN Report</h6>
        </a>
      </li>

       <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('vip.services')}}">
          <i class="bi bi-gem text-primary"></i>
          <h6 class="fw-semibold">VIP Services</h6>
        </a>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('support.services')}}">
          <i class="bi bi-person-fill text-primary"></i>
          <h6 class="fw-semibold">Support</h6>
        </a>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('transactions.index')}}">
          <i class="bi bi-credit-card-2-front-fill text-warning"></i>
          <h6 class="fw-semibold">Transactions</h6>
        </a>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="{{route ('settings.services')}}">
          <i class="bi bi-gear-fill text-dark"></i>
          <h6 class="fw-semibold">Settings</h6>
        </a>
      </li>

     <li class="sidebar-list">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-link text-danger border-0 bg-transparent p-0 d-flex align-items-center">
            <i class="bi bi-box-arrow-right text-danger"></i>
            <h6 class="fw-semibold ms-2">Logout</h6>
        </button>
    </form>
</li>


    </ul>
  </div>

  <!-- Right Arrow -->
  <div class="right-arrow" id="right-arrow">
    <i class="bi bi-chevron-right"></i>
  </div>
</aside>
<!-- ================= Sidebar End ================= -->

<!-- ====== ICON SETUP ====== -->
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

      
<style>
    /* ========== Global Service Card Styles ========== */
    .service-card, .vip-service-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .service-card:hover, .vip-service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .service-card:hover {
        border-color: rgba(13, 110, 253, 0.2);
    }
    
    .vip-service-card {
        border: 1px solid rgba(212, 175, 55, 0.3);
    }
    
    .vip-service-card:hover {
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.1);
        border-color: rgba(212, 175, 55, 0.5);
    }

    /* ========== Icon Wrapper Styles ========== */
    .icon-wrapper, .vip-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 auto 1rem;
    }
    
    .service-card:hover .icon-wrapper,
    .vip-service-card:hover .vip-icon-wrapper {
        transform: scale(1.1);
    }

    /* ========== Background Color Variants ========== */
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-info-light { background-color: rgba(23, 162, 184, 0.1); }
    .bg-success-light { background-color: rgba(40, 167, 69, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    .bg-secondary-light { background-color: rgba(108, 117, 125, 0.1); }
    .bg-gold-light { background-color: rgba(212, 175, 55, 0.1); }
    
    .vip-icon-wrapper {
        background-color: rgba(212, 175, 55, 0.1);
    }
    
    .vip-service-card:hover .vip-icon-wrapper {
        background-color: rgba(212, 175, 55, 0.2);
    }

    /* ========== Time-based Greeting Backgrounds ========== */
    .bg-morning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .bg-afternoon { background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); }
    .bg-evening { background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); }

    /* ========== Wallet Display Styles ========== */
    .wallet-display {
        background: rgba(13, 110, 253, 0.05);
        border-radius: 10px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .wallet-display:hover {
        background: rgba(13, 110, 253, 0.1);
    }

    /* ========== Card Header Styles ========== */
    .card-header {
        background: transparent;
        border-bottom: none;
        padding-bottom: 0;
    }
    
    /* ========== Responsive Adjustments ========== */
    @media (max-width: 768px) {
        .icon-wrapper, .vip-icon-wrapper {
            width: 50px;
            height: 50px;
        }
    }
</style>
