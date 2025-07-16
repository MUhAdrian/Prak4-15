<?= $this->include('template/header'); ?>

<h1>Data Artikel</h1>

<table class="table-data" id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>

<script>
$(document).ready(function() {
    // Function to display a loading message while data is fetched
    function showLoadingMessage() {
        $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
    }

    // Function to load data
    function loadData() {
        showLoadingMessage(); // Display loading message initially

        // Make AJAX request to get data
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                // Populate table with the data received from the server
                var tableBody = "";
                for (var i = 0; i < data.length; i++) {
                    var row = data[i];
                    tableBody += '<tr>';
                    tableBody += '<td>' + row.id + '</td>';
                    tableBody += '<td>' + row.judul + '</td>';

                    // Add a placeholder for the "Status" column (modify as needed)
                    tableBody += '<td><span class="status">---</span></td>';

                    tableBody += '<td>';
                    // Replace with your desired actions (e.g., edit, delete)
                    tableBody += '<a href="<?= base_url('artikel/edit/') ?>' + row.id + '" class="btn btn-primary">Edit</a>';
                    tableBody += ' <a href="#" class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
                    tableBody += '</td>';
                    tableBody += '</tr>';
                }

                // Update the table body with the new rows
                $('#artikelTable tbody').html(tableBody);
            }
        });
    }

    loadData(); // Load data on page load

    // Implement actions for buttons (e.g., delete confirmation)
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        // Add confirmation dialog or handle deletion logic here
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('artikel/delete/') ?>" + id,
                method: "DELETE",
                success: function(data) {
                    loadData(); // Reload data to reflect changes
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting article: ' + textStatus + errorThrown);
                }
            });
        }

        console.log('Delete button clicked for ID:', id);
    });
});
</script>

<?= $this->include('template/footer'); ?>
