// js/delete_products.js
$(document).ready(function() {
    $('#massDeleteButton').on('click', function() {
        let selectedIds = [];
        $('.delete-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            fetch('delete_products.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids: selectedIds })
            }).then(response => response.text())
            .then(data => {
                window.location.reload(); // Refresh page after delete
            });
        }
    });
});
