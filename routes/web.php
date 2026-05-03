<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClusterPageController;
use App\Http\Controllers\EmergencyLogsController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('landing');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Посадочные страницы под кластеры запросов
Route::get('/psiholog-online', [ClusterPageController::class, 'show'])->defaults('slug', 'psiholog-online')->name('cluster.psiholog-online');
Route::get('/geshtalt-terapevt', [ClusterPageController::class, 'show'])->defaults('slug', 'geshtalt-terapevt')->name('cluster.geshtalt-terapevt');
Route::get('/psiholog-vladivostok', [ClusterPageController::class, 'show'])->defaults('slug', 'psiholog-vladivostok')->name('cluster.psiholog-vladivostok');
Route::get('/psiholog-artem', [ClusterPageController::class, 'show'])->defaults('slug', 'psiholog-artem')->name('cluster.psiholog-artem');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

// Аварийный просмотр логов без зависимости от БД. Доступ: /logs?token=YOUR_LOGS_TOKEN
Route::get('/logs', EmergencyLogsController::class)->middleware('logs.auth')->name('logs');
