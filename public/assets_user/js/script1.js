$(document).ready(function() {
    $('#filter-form').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        var category = $('#category-select').val(); // Get selected category

        // Send an AJAX request to your server to fetch filtered products
        $.ajax({
            type: 'GET', // Keep the method as GET
            url: '/filter-products', // Replace with your route for filtering products
            data: { category: category }, // Pass selected category as data
            success: function(response) {
                $('#product-list').html(response); // Update product list with filtered products
            },
            error: function(xhr, status, error) {
                console.error(error); // Log any errors to the console
            }
        });
    });
});
