// jQuery code for interactions

$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    // jQuery event handlers
    $('#contact button[type="submit"]').click(function(e) {
        e.preventDefault();
        alert('Message sent!');
    });

    // Show/hide element example
    $('#toggleAlert').click(function() {
        $('.alert').toggle();
    });

    // Trigger modal dynamically
    $('#dynamicModalBtn').click(function() {
        $('#introModal').modal('show');
    });
});
