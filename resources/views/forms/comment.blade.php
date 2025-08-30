   <!-- Enhanced Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg">
            
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-chat-left-text me-2"></i> Submission Comment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body" id="commentModalBody" style="font-size: 1rem; white-space: pre-wrap;">
                Loading comment...
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{route ('enrollments.index')}}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-file-earmark-text"></i> Check BVN Report
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-star"></i> VIP Access
                    </a>
                     <a href="{{route ('support.services')}}" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-star"></i> Complain ?
                    </a>
                </div>
                <div id="encouragement" class="text-muted small fst-italic"></div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Encouragement Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messages = [
            "Keep pushing forward — success is near!",
            "Believe in yourself, you’ve got this!",
            "Every step counts, no matter how small.",
            "Great things take time, stay patient.",
            "Your effort today is your victory tomorrow!",
            "Stay focused — progress is happening.",
            "Never give up, your breakthrough is close!"
        ];

        // Random encouragement when modal opens
        const encouragement = document.getElementById("encouragement");
        const modal = document.getElementById("commentModal");

        modal.addEventListener("show.bs.modal", function () {
            const randomMessage = messages[Math.floor(Math.random() * messages.length)];
            encouragement.innerText = randomMessage;
        });
    });
</script>
