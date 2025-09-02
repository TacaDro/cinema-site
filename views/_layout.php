<?php /* Базовый шаблон */ ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= isset($movie) ? h($movie['title']).' — Фильмы' : 'Фильмы' ?></title>
  <link rel="stylesheet" href="<?= $base ?>/style.css?v=2" />
</head>
<body>
<header class="container">
  <h1><a href="<?= $base ?>/">Фильмы</a></h1>
  <form class="search" action="<?= $base ?>/poisk" method="get">
    <input type="text" name="q" placeholder="Название" value="<?= h($q ?? '') ?>" />
    <button>Найти</button>
  </form>
</header>

<nav class="genres-nav container">
  <?php if (!empty($genres)): ?>
    <ul>
      <?php foreach ($genres as $g): ?>
        <li><a href="<?= $base ?>/genre/<?= h($g['slug']) ?>"><?= h($g['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</nav>

<main class="container">
  <?php include __DIR__ . '/' . $view . '.php'; ?>
</main>
<script>window.APP_BASE=<?= json_encode($base) ?>;</script>
<script src="<?= $base ?>/app.js?v=1"></script>
</body>
</html>
