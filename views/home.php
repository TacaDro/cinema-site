<?php if (empty($movies)): ?>
  <p class="muted">Ничего не найдено.</p>
<?php else: ?>
  <ul class="grid">
    <?php foreach ($movies as $m): ?>
      <li class="card">
        <a href="<?= url_movie($m['id'], $m['title']) ?>">
          <img src="<?= h($m['poster_url']) ?>" alt="<?= h($m['title']) ?>" onerror="this.style.display='none'">
          <div class="meta">
            <strong><?= h($m['title']) ?></strong>
            <span><?= h($m['year']) ?> · <?= h($m['genre']) ?></span>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
