<?= $this->include('templates/header'); ?>

<h2><?= esc($title); ?></h2>

<div class="row mb-3">
    <div class="col-md-12">
        <form id="search-form" class="form-inline">
            <input type="text" name="q" id="search-box" value="<?= esc($q); ?>" placeholder="Cari judul artikel" class="form-control">
            <select name="kategori_id" id="category-filter" class="form-control">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= esc($k['id_kategori']); ?>" <?= (esc($kategori_id) == esc($k['id_kategori'])) ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="<?= base_url('admin/artikel/add') ?>" class="btn btn-primary">Tambah Artikel Baru</a>
        </form>
    </div>
</div>

<div id="article-container">
    <!-- Artikel akan dimuat di sini melalui AJAX -->
</div>
<div id="pagination-container">
    <!-- Pagination akan dimuat di sini melalui AJAX -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');
    
    const fetchData = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                articleContainer.html('<p class="alert alert-danger">Gagal memuat data artikel. Silakan coba lagi.</p>');
                paginationContainer.empty();
            }
        });
    };

    const renderArticles = (articles) => {
        let html = '<table class="table-data">';
        html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';
        
        if (articles.length > 0) {
            articles.forEach(article => {
                html += `
                    <tr>
                        <td>${article.id}</td>
                        <td>
                            <b>${article.judul}</b>
                            <p><small>${article.isi.substring(0, 50)}...</small></p>
                        </td>
                        <td>${article.nama_kategori}</td>
                        <td>${article.status}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="<?= base_url('admin/artikel/edit/') ?>${article.id}">Ubah</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data ini?');" href="<?= base_url('admin/artikel/delete/') ?>${article.id}">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5">Tidak ada data artikel yang ditemukan.</td></tr>';
        }
        
        html += '</tbody></table>';
        articleContainer.html(html);
    };

    const renderPagination = (pager, q, kategori_id) => {
        let html = '<nav><ul class="pagination">';
        
        if (pager && pager.links) {
            pager.links.forEach(link => {
                let url = link.url ? `${link.url}&q=${encodeURIComponent(q)}&kategori_id=${encodeURIComponent(kategori_id)}` : '#';
                html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}">${link.title}</a></li>`;
            });
        }
        
        html += '</ul></nav>';
        paginationContainer.html(html);
    };

    searchForm.on('submit', function(e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`<?= base_url('admin/artikel') ?>?q=${q}&kategori_id=${kategori_id}`);
    });

    categoryFilter.on('change', function() {
        searchForm.trigger('submit');
    });

    // Handle pagination clicks (delegated event)
    $(document).on('click', '.pagination a.page-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            fetchData(url);
        }
    });

    // Initial load
    fetchData('<?= base_url('admin/artikel') ?>');
});
</script>




<?= $this->include('templates/footer'); ?>
