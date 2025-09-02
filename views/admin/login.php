<h2>Вход в админку</h2>
<form method="post" action="<?= $base ?>/admin/login">
  <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
  <input type="password" name="password" placeholder="Пароль" required>
  <button type="submit">Войти</button>
</form>
<?= $error ?? '' ?>
