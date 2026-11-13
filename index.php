<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';

render('home', [
    'id' => 'home',
    'file' => 'index.php',
    'title' => site()['seo']['title'],
    'description' => site()['seo']['description'],
    'keywords' => site()['seo']['keywords'] ?? '',
    'og_title' => site()['seo']['og_title'] ?? site()['seo']['title'],
    'og_description' => site()['seo']['og_description'] ?? site()['seo']['description'],
    'form_redirect' => '/',
]);
