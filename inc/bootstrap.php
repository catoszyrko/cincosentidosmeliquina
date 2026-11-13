<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('TPL_ROOT', dirname(__DIR__));

require_once TPL_ROOT . '/inc/helpers.php';
require_once TPL_ROOT . '/inc/db.php';
require_once TPL_ROOT . '/inc/forms.php';
require_once TPL_ROOT . '/inc/admin.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
enforce_canonical_host();
