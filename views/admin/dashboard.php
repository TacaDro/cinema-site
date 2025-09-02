<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
  <h2>Фильмы (<?= (int)$count ?>)</h2>
  <div>
    <a href="<?= $base ?>/admin/movie/new" class="btn">Добавить</a>
    <a href="<?= $base ?>/admin/logout" class="btn" style="background:#444;">Выйти</a>
  </div>
</div>

<?php if (empty($movies)): ?>
  <p class="muted">Пока пусто.</p>
<?php else: ?>
  <table class="table">
    <thead><tr>
      <th>ID</th><th>Название</th><th>Год</th><th>Жанр</th><th>Постер</th><th></th>
    </tr></thead>
    <tbody>
    <?php foreach ($movies as $m): ?>
      <tr>
        <td><?= (int)$m['id'] ?></td>
        <td><a href="<?= url_movie($m['id'], $m['title']) ?>" target="_blank"><?= h($m['title']) ?></a></td>
        <td><?= h($m['year']) ?></td>
        <td><?= h($m['genre']) ?></td>
        <td style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">&nbsp;<?= h($m['poster_url']) ?></td>
        <td style="white-space:nowrap;">
          <a href="<?= $base ?>/admin/movie/<?= (int)$m['id'] ?>/edit" class="btn">Редактировать</a>
          <form method="post" action="<?= $base ?>/admin/movie/<?= (int)$m['id'] ?>/delete" style="display:inline" onsubmit="return confirm('Удалить?')">
            <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
            <button class="btn danger" type="submit">Удалить</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
