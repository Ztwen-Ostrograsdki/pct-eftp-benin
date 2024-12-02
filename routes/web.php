<?php

use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\HomePage;
use App\Livewire\Master\UsersListPage;
use App\Livewire\Shop\ShoppingHome;
use App\Livewire\User\MyNotificationsPage;
use App\Livewire\User\UserProfilPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);

Route::get('gestion/utilisateurs', UsersListPage::class)->name('master.users.list')->middleware(['auth', 'master', 'user.not.blocked']);

Route::middleware(['auth', 'user.self', 'user.confirmed.by.admin', 'user.not.blocked'])->group(function(){

    Route::get('mon-compte/mes-notifications', MyNotificationsPage::class)->name('user.notifications');
    
    Route::get('mon-compte/{id}', UserProfilPage::class)->name('user.profil');

});


Route::get('boutique/', ShoppingHome::class)->name('shopping.home');


Route::middleware(['guest'])->group(function(){
    Route::get('/connexion', LoginPage::class)->name('login');
    Route::get('/inscription', RegisterPage::class)->name('register');
    Route::get('/verification-email/email={email}/{key?}', EmailVerificationPage::class)->name('email.verification');
    Route::get('/reinitialisation-mot-de-passe/token={token?}/email={email?}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/reinitialisation-mot-de-passe/par-email/email={email?}/{key?}', ResetPasswordPage::class)->name('password.reset.by.email');
    Route::get('/mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
});
