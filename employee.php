<?php

use inc\classes\Request;

use function inc\helper\auth;
use function inc\helper\redirect;

require_once __DIR__ . '/inc/loader.php';

if(!auth()->check()) redirect('/auth');
if(auth()->user()['role'] !== 1) redirect('/dashboard');

if(!empty(Request::get('action'))) {
  $page = Request::get('action');
  include(__DIR__ . "/partials/page/dashboard/employee/{$page}.php");
} else {
  include(__DIR__ . '/partials/page/dashboard/employee/base.php');
}