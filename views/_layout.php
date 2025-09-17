<?php /* Базовый шаблон */ ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= isset($movie) ? h($movie['title']).' — Фильмы' : 'Фильмы' ?></title>
  <link rel="stylesheet" href="<?= $base ?>/style.css?v=4" />
</head>
<body>
<header class="container">
  <h1><a href="<?= $base ?>/">Фильмы</a></h1>
  <form class="search" action="<?= $base ?>/poisk" method="get">
    <input type="text" name="q" placeholder="Название" value="<?= h($q ?? '') ?>" />
    <button>Найти</button>
  </form>
</header>

<?php $active = $active_genre_slug ?? null; ?>
<?php if (!empty($genres)): ?>
  <nav class="genres-nav container">
    <ul>
      <?php foreach ($genres as $g):
        $isActive = ($active && $g['slug'] === $active);
      ?>
        <li>
          <a href="<?= $base ?>/genre/<?= h($g['slug']) ?>" class="<?= $isActive ? 'active' : '' ?>">
            <?= h($g['name']) ?>
            <span class="count">(<?= (int)($g['count'] ?? 0) ?>)</span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
<?php endif; ?>

<main class="container">
  <?php include __DIR__ . '/' . $view . '.php'; ?>
</main>

<script>window.APP_BASE=<?= json_encode($base) ?>;</script>
<script src="<?= $base ?>/app.js?v=1"></script>
</body>
</html>
