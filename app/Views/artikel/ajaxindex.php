<?= $this->include('templates/header'); ?>

<!-- Container for dynamic content -->
<div id="article-container"></div>

<!-- Loading indicator -->
<div id="loading" style="display: none;">Loading articles...</div>

<!-- Error message -->
<div id="error-message" class="alert alert-danger" style="display: none;"></div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script>
  $(document).ready(function() {
    // Show loading
    $('#loading').show();

    // Fetch articles via AJAX
    $.ajax({
      url: '<?= base_url('api/articles') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.length > 0) {
          let html = '';
          response.forEach(function(item) {
            html += `
                        <div class="article-item" id="hero">
                            <h2>
                                <a href="<?= base_url('artikel/detail/') ?>${item.slug}">
                                    ${item.judul}
                                </a>
                            </h2>
                            <p>${item.isi.substring(0, 200)}...</p>
                            <img src="<?= base_url('gambar/') ?>${item.gambar}" alt="${item.judul}">
                        </div>
                        <hr class="divider" />
                    `;
          });
          $('#article-container').html(html);
        } else {
          $('#article-container').html(`
                    <article class="entry">
                        <h2>Belum ada Data</h2>
                    </article>
                `);
        }
      },
      error: function(xhr) {
        $('#error-message').text('Error loading articles: ' + xhr.statusText).show();
      },
      complete: function() {
        $('#loading').hide();
      }
    });
  });
</script>

<?= $this->include('templates/footer'); ?>
