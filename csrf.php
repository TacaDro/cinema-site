<?php
session_start();
if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
function csrf_token(): string { return $_SESSION['csrf'] ?? ''; }
function csrf_check(?string $t): bool { return $t && hash_equals($_SESSION['csrf'] ?? '', $t); }
