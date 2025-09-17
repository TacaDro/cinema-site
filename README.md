diff --git a/.gitignore b/.gitignore
new file mode 100644
--- /dev/null
+++ b/.gitignore
@@ -0,0 +1,65 @@
+# -------------------------------------
+# PHP/XAMPP project ignores
+# -------------------------------------
+# OS/IDE
+.DS_Store
+Thumbs.db
+.idea/
+.vscode/
+
+# Local env / secrets
+.env
+.env.local
+.env.*.local
+
+# Logs / temp
+*.log
+*.cache
+*.tmp
+tmp/
+cache/
+logs/
+
+# Uploads (если будут локальные постеры/файлы)
+uploads/
+
+# Composer (если вдруг подключишь)
+vendor/
+composer.lock
+
+# Node (если добавишь сборку фронта)
+node_modules/
+package-lock.json
+yarn.lock
+pnpm-lock.yaml
+dist/
+build/
+
+# OS-specific
+ehthumbs.db
+Icon?
+.Spotlight-V100
+.Trashes
+
+# Git patch rejects (на случай конфликтов)
+*.rej
+
+# PHPUnit / coverage (если добавишь тесты)
+coverage/
+.phpunit.result.cache
+
+# Misc
+*.swp
+*.swo
+
diff --git a/README.md b/README.md
new file mode 100644
--- /dev/null
+++ b/README.md
@@ -0,0 +1,126 @@
+# Cinema Site (PHP + MySQL, Apache mod_rewrite)
+
+Минимальный сайт с фильмами для XAMPP: ЧПУ-URL, список/карточка фильма, страницы жанров, простая админка (CRUD), CSRF.  
+Код рассчитан на запуск локально под Windows (XAMPP).
+
+## ⚙️ Запуск локально
+1. Скопируй папку проекта в `C:\\xampp\\htdocs\\cinema-site` (или другое имя).
+2. Включи Apache и MySQL в XAMPP.
+3. Создай БД и таблицы:
+   - Открой `http://localhost/phpmyadmin`
+   - Импортируй `init.sql` (БД: `movies_db`)
+4. Проверь `config.php` → доступ к MySQL (`root` без пароля по умолчанию в XAMPP).
+5. Зайди на сайт:  
+   `http://localhost/cinema-site/`
+
+## 🔗 ЧПУ и .htaccess
+Файл `.htaccess` включает `mod_rewrite`. Если проект в подпапке, обнови `RewriteBase`:
+```apache
+RewriteBase /cinema-site/
+```
+> Если сайт в корне `htdocs`, можно закомментировать `RewriteBase`.
+
+## 🔐 Админка
+- URL: `/admin`
+- Пароль меняется в `config.php` → `admin.password`
+- Доступно: список фильмов, добавление, редактирование, удаление.
+
+## 🧭 Маршруты
+- `/` — главная (список + поиск)
+- `/film/{id}-{slug}` — карточка фильма
+- `/genre/{slug}` — страница жанра
+- `/poisk?q=...` — редирект на главную с параметром
+- `/admin` — панель администратора (CRUD)
+
+## 🧩 Структура
+```
+.
+├─ .htaccess
+├─ index.php          # фронт-контроллер/роутер
+├─ config.php         # настройки (включая пароль админа)
+├─ db.php             # PDO
+├─ csrf.php           # CSRF токены (session-based)
+├─ style.css          # стили
+├─ app.js             # js
+├─ views/
+│  ├─ _layout.php
+│  ├─ home.php
+│  ├─ movie.php
+│  ├─ genre.php
+│  ├─ 404.php
+│  └─ admin/
+│     ├─ login.php
+│     ├─ dashboard.php
+│     └─ form.php
+└─ init.sql
+```
+
+## 🧪 Быстрые проверки
+- **Стили/JS:** открываютcя без 404 (проверь DevTools → Network).
+- **Перепроверка путей:** в `_layout.php` ссылки на `style.css`/`app.js` без лишних префиксов.
+- **Жанры:** меню жанров видно под шапкой; ссылки ведут на `/genre/...`.
+
+---
+
+# Git Workflow (ветка `main`)
+
+## Первичная настройка
+Переход на `main` локально и пуш в GitHub:
+```bash
+git branch -M main
+git push -u origin main
+```
+Если на GitHub уже есть коммиты в `main`, подтяни их перед пушем:
+```bash
+git pull --rebase origin main --allow-unrelated-histories
+git push -u origin main
+```
+
+## Типичный цикл работы
+```bash
+git status
+git add .
+git commit -m "описание изменений"
+git pull --rebase origin main
+git push origin main
+```
+
+## Если появятся конфликты при rebase
+Git покажет конфликтующие файлы:
+```bash
+# правишь файлы вручную
+git add <исправленные файлы>
+git rebase --continue
+```
+Отменить ребейз:
+```bash
+git rebase --abort
+```
+
+---
+
+# Патчи (как мы работаем)
+Мы обмениваемся изменениями через **unified diff patches**.
+
+## Как применить патч
+```bash
+git apply --check my-change.patch   # проверка применимости
+git apply my-change.patch           # применение
+git status                          # проверка изменений
+git add -A
+git commit -m "Apply patch: my-change"
+git push origin main
+```
+
+## Если Git говорит «No valid patches in input»
+Это значит, что:
+1) изменения из патча уже внесены, или  
+2) пути в патче не совпадают с твоей структурой.
+
+Проверь путь файла в репозитории:
+```bash
+git ls-files | findstr views\\_layout.php   # Windows
+```
+
+## Если «patch with only garbage…»
+Убедись, что:
+- файл сохранён **в обычный текст** (UTF-8, без форматирования);
+- блоки начинаются с `diff --git a/... b/...`;
+- в Windows можно применить дополнительные флаги:
+```bash
+git apply --ignore-space-change --ignore-whitespace my-change.patch
+```
+
+---
+
+## Дальше по плану
+- Перенести жанры в справочник (`genres` таблица, `movies.genre_id`).
+- Пагинация и сортировки.
+- Загрузка локальных постеров в `uploads/` + проверка MIME.
+- Роли пользователей (логин/пароль вместо одного admin-пароля).
