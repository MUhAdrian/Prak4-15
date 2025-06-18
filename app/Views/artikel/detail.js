// Add event listeners to all titles
document.querySelectorAll('.clickable-title').forEach(title => {
  title.addEventListener('click', function() {
    const slug = this.dataset.slug;
    loadArticleDetail(slug);
  });
});

// AJAX function to fetch details
async function loadArticleDetail(slug) {
  try {
    const response = await fetch(`/artikel/detail/${slug}`);
    const data = await response.json();

    // Update the DOM with fetched data
    document.getElementById('detail-container').innerHTML = `
      <h2>${data.judul}</h2>
      <p>${data.isi}</p>
    `;

    // Optional: Update URL without reloading
    history.pushState(null, null, `/artikel/detail/${slug}`);
  } catch (error) {
    console.error('Error:', error);
  }
}
