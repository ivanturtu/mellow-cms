// Modal Fix for Livewire Components
document.addEventListener('DOMContentLoaded', function() {
    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                // Find the close method for this modal
                const modal = e.target;
                const closeButton = modal.querySelector('[wire\\:click*="cancel"], [wire\\:click*="hide"], [wire\\:click*="close"]');
                if (closeButton) {
                    closeButton.click();
                }
            }
        });

        // Handle ESC key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const closeButton = openModal.querySelector('[wire\\:click*="cancel"], [wire\\:click*="hide"], [wire\\:click*="close"]');
                    if (closeButton) {
                        closeButton.click();
                    }
                }
            }
        });

        // Force close modal when Livewire resets
        Livewire.on('close-modal', () => {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                openModal.classList.remove('show');
                openModal.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        });
    });
});

// Additional modal cleanup
function cleanupModal() {
    // Remove modal backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    
    // Remove modal-open class from body
    document.body.classList.remove('modal-open');
    
    // Hide any visible modals
    const modals = document.querySelectorAll('.modal.show');
    modals.forEach(modal => {
        modal.classList.remove('show');
        modal.style.display = 'none';
    });
}

// Call cleanup on page unload
window.addEventListener('beforeunload', cleanupModal);
