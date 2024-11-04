<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/administration', Dashboard::class);
