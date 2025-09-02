<article class="movie">
  <div class="poster">
    <img src="<?= h($movie['poster_url']) ?>" alt="<?= h($movie['title']) ?>" onerror="this.style.display='none'">
  </div>
  <div class="info">
    <h2><?= h($movie['title']) ?> (<?= h($movie['year']) ?>)</h2>
    <p class="muted">Жанр: <?= h($movie['genre']) ?></p>
    <p><?= nl2br(h($movie['description'])) ?></p>
  </div>
</article>
