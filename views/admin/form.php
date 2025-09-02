<h2><?= isset($movie) ? 'Редактировать фильм' : 'Добавить фильм' ?></h2>
<form method="post" action="<?= $action ?>">
  <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
  <label>Название
    <input type="text" name="title" value="<?= h($movie['title'] ?? '') ?>" required>
  </label>
  <label>Год
    <input type="number" name="year" min="1880" max="2100" value="<?= h($movie['year'] ?? '') ?>" required>
  </label>
  <label>Жанр
    <input type="text" name="genre" value="<?= h($movie['genre'] ?? '') ?>" required>
  </label>
  <label>Постер (URL)
    <input type="url" name="poster_url" value="<?= h($movie['poster_url'] ?? '') ?>">
  </label>
  <label>Описание
    <textarea name="description" rows="6" required><?= h($movie['description'] ?? '') ?></textarea>
  </label>
  <button type="submit" class="btn">Сохранить</button>
  <a class="btn" href="<?= $base ?>/admin">Отмена</a>
</form>
