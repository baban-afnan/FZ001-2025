<x-app-layout>
     <x-slot name="title">Support - Service</x-slot>
    <head>
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        <!-- Quill Editor -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

        <style>
            .card {
                border: none;
                border-radius: 12px;
                margin-bottom: 24px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }
            .card-header {
                border-radius: 12px 12px 0 0 !important;
                padding: 16px 24px;
            }
            .support-action-btn {
                border-radius: 8px;
                padding: 10px 20px;
                transition: all 0.3s ease;
                font-weight: 500;
            }
            .support-action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .form-control, .form-select {
                border-radius: 8px;
                padding: 12px 16px;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .form-control:focus, .form-select:focus {
                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
                border-color: #4299e1;
            }
            .alert {
                border-radius: 10px;
                border: none;
                padding: 16px 20px;
            }
            .btn-primary {
                background: var(--primary-gradient);
                border: none;
                padding: 10px 24px;
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(75, 108, 183, 0.25);
            }
            .nav-tabs .nav-link {
                border: none;
                color: #6c757d;
                font-weight: 500;
                padding: 12px 20px;
                border-radius: 8px;
            }
            .nav-tabs .nav-link.active {
                color: #4b6cb7;
                background-color: rgba(75, 108, 183, 0.1);
            }
            #editor {
                height: 200px;
                border-radius: 8px;
                margin-bottom: 16px;
            }
            .stats-card {
                text-align: center;
                padding: 20px;
            }
            .stats-number {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0;
            }
            .recent-activity {
                list-style: none;
                padding: 0;
            }
            .recent-activity li {
                padding: 10px 0;
                border-bottom: 1px solid #eee;
            }
            .recent-activity li:last-child {
                border-bottom: none;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-xxl-10 col-xl-11 col-lg-12">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h2 fw-bold text-primary">Support Center</h1>
                            <p class="text-muted">We're here to help you with any issues or questions</p>
                        </div>
                        <div class="d-none d-md-flex align-items-center">
                            <div class="me-3">
                                <span class="fw-bold text-dark">Welcome Back,</span>
                                <span class="fw-bold text-dark">{{ Auth::user()->first_name ?? 'User' }}</span>
                            </div>
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                MFB
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card stats-card text-center p-3">
                                <p class="stats-number text-warning mb-0">{{ $pendingCount ?? 0 }}</p>
                                <p class="text-muted">Pending Tickets</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stats-card text-center p-3">
                                <p class="stats-number text-info mb-0">{{ $processingCount ?? 0 }}</p>
                                <p class="text-muted">Processing Tickets</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stats-card text-center p-3">
                                <p class="stats-number text-success mb-0">{{ $resolvedCount ?? 0 }}</p>
                                <p class="text-muted">Resolved Tickets</p>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    <div class="container mt-3">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-x-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <!-- Tickets -->
                            <div class="card">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Your Support Tickets</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-4" id="ticketTabs">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#active">Active</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#resolved">Resolved</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#new">New Ticket</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- Active -->
                                        <div class="tab-pane fade show active" id="active">
                                            @forelse(($pendingTickets ?? collect())->merge($processingTickets ?? collect()) as $ticket)
                                                <div class="card mb-3">
                                                    <div class="card-body d-flex justify-content-between">
                                                        <div>
                                                            <h6>{{ $ticket->category }}</h6>
                                                            <p class="text-muted mb-0">Ref: {{ $ticket->transaction_ref }}</p>
                                                            <small class="text-muted">Created {{ $ticket->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <span class="badge 
                                                            @if($ticket->status == 'pending') bg-warning 
                                                            @elseif($ticket->status == 'processing') bg-info 
                                                            @else bg-secondary @endif">
                                                            {{ ucfirst($ticket->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No active tickets.</p>
                                            @endforelse
                                        </div>

                                        <!-- Resolved -->
                                        <div class="tab-pane fade" id="resolved">
                                            @forelse($resolvedTickets ?? [] as $ticket)
                                                <div class="card mb-3">
                                                    <div class="card-body d-flex justify-content-between">
                                                        <div>
                                                            <h6>{{ $ticket->category }}</h6>
                                                            <p class="text-muted mb-0">Ref: {{ $ticket->transaction_ref }}</p>
                                                            <small class="text-muted">Created {{ $ticket->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <span class="badge bg-success">{{ ucfirst($ticket->status) }}</span>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No resolved tickets.</p>
                                            @endforelse
                                        </div>

                                        <!-- New Ticket -->
                                        <div class="tab-pane fade" id="new">
                                            <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Transaction Reference</label>
                                                    <input type="text" name="transaction_ref" class="form-control @error('transaction_ref') is-invalid @enderror" required>
                                                    @error('transaction_ref') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                                        <option value="">Select</option>
                                                        <option value="transaction">Transaction Issue</option>
                                                        <option value="technical">Technical Problem</option>
                                                        <option value="billing">Billing Dispute</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Complaint Details</label>
                                                    <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" required></textarea>
                                                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Attachment (optional)</label>
                                                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                                                    @error('attachment') <div class="text-danger small">{{ $message }}</div> @enderror
                                                </div>
                                                <button class="btn btn-primary"><i class="bi bi-send me-1"></i> Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Quick Support</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Get help quickly through these channels</p>
                                    <div class="d-grid gap-2">
                                        <a href="mailto:support@yourcompany.com" class="btn support-action-btn btn-outline-primary text-start">
                                            <i class="bi bi-envelope me-2"></i> Email Support
                                        </a>
                                        <a href="{{route ('support')}}" target="_blank" class="btn support-action-btn btn-outline-success text-start">
                                            <i class="bi bi-whatsapp me-2"></i> WhatsApp Chat
                                        </a>
                                        <a href="tel:+2348012345678" class="btn support-action-btn btn-outline-danger text-start">
                                            <i class="bi bi-telephone me-2"></i> Call Support
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="recent-activity">
                                        <li>
                                            <div class="d-flex justify-content-between">
                                                <span>Ticket #45612 created</span>
                                                <small class="text-muted">2h ago</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between">
                                                <span>Ticket #78945 updated to Processing</span>
                                                <small class="text-muted">1d ago</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex justify-content-between">
                                                <span>Ticket #32165 created</span>
                                                <small class="text-muted">3d ago</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap & Quill JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            // Initialize Quill
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Please describe your issue in detail...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                    ]
                }
            });

            // Sync Quill content
            document.querySelector('form').onsubmit = function() {
                var contentInput = document.querySelector('textarea[name=content]');
                contentInput.value = quill.root.innerHTML;
            };

            // Auto dismiss flash messages after 5s
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        </script>
    </body>
</x-app-layout>
