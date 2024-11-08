$(document).ready(function () {
    $('#delete-product-btn').on('click', function () {
        let selectedIds = [];
        $('.delete-checkbox:checked').each(function () {
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            fetch('/scandiwebtask/public/delete_product', { // Adjust to match your public URL structure
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids: selectedIds })
            }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload(); // Refresh page after delete
                    } else {
                        alert(data.message); // Display error message
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});