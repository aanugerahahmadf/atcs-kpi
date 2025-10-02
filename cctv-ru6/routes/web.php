<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Ui\Dashboard as UiDashboard;
use App\Livewire\Ui\Maps as UiMaps;
use App\Livewire\Ui\Location as UiLocation;
use App\Livewire\Ui\Contact as UiContact;
use App\Livewire\Ui\Notifications as UiNotifications;
use App\Livewire\Ui\Messages as UiMessages;
use App\Livewire\Ui\Stream as UiStream;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/ui/dashboard', UiDashboard::class)->name('ui.dashboard');
    Route::get('/ui/maps', UiMaps::class)->name('ui.maps');
    Route::get('/ui/location', UiLocation::class)->name('ui.location');
    Route::get('/ui/contact', UiContact::class)->name('ui.contact');
    Route::get('/ui/notifications', UiNotifications::class)->name('ui.notifications');
    Route::get('/ui/messages', UiMessages::class)->name('ui.messages');
    Route::get('/ui/stream/{cctv}', UiStream::class)->name('ui.stream');
});

require __DIR__.'/auth.php';
