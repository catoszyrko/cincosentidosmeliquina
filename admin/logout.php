<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/inc/bootstrap.php';

admin_logout();
header('Location: ' . url('admin'));
exit;
