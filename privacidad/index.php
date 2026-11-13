<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/inc/bootstrap.php';
render('privacy', [
    'id' => 'privacidad',
    'file' => 'privacidad',
    'title' => site()['privacy']['title'] . ' | ' . company()['name'],
    'description' => site()['privacy']['intro'],
    'robots' => 'index, follow',
    'og_title' => site()['privacy']['title'] . ' | ' . company()['name'],
    'og_description' => site()['privacy']['intro'],
    'solid_nav' => true,
    'form_redirect' => '/privacidad/',
]);
