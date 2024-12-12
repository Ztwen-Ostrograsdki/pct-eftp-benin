<?php

use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\BookDetailsPage;
use App\Livewire\HomePage;
use App\Livewire\Master\UsersListPage;
use App\Livewire\Shop\ShoppingHome;
use App\Livewire\User\CartPage;
use App\Livewire\User\CheckoutPage;
use App\Livewire\User\CheckoutSuccessPage;
use App\Livewire\User\MyNotificationsPage;
use App\Livewire\User\Orders;
use App\Livewire\User\UserProfilPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);

Route::get('gestion/utilisateurs', UsersListPage::class)->name('master.users.list')->middleware(['auth', 'master', 'user.not.blocked']);

Route::middleware(['auth', 'user.self', 'user.confirmed.by.admin', 'user.not.blocked'])->group(function(){

    Route::get('profil/mes-notifications', MyNotificationsPage::class)->name('user.notifications');
    
    Route::get('profil/IDX={identifiant}', UserProfilPage::class)->name('user.profil');

    Route::get('profil/achats/mes-commandes/IDX={identifiant}', Orders::class)->name('user.orders');

    Route::get('profil/boutique/mon-panier/IDX={identifiant}', CartPage::class)->name('user.cart');

    Route::get('profil/boutique/Validation-payement/IDX={identifiant}', CheckoutPage::class)->name('user.checkout');
    
    Route::get('profil/boutique/panier-valide/succes-payement/ID={identifiant}', CheckoutSuccessPage::class)->name('user.checkout.success');

});


Route::get('boutique/', ShoppingHome::class)->name('shopping.home');
Route::get('boutique/details-documents/ID={identifiant}/IDX={slug}', BookDetailsPage::class)->name('book.details');


Route::middleware(['guest'])->group(function(){
    Route::get('/connexion', LoginPage::class)->name('login');
    Route::get('/inscription', RegisterPage::class)->name('register');
    Route::get('/verification-email/email={email}/{key?}', EmailVerificationPage::class)->name('email.verification');
    Route::get('/reinitialisation-mot-de-passe/token={token?}/email={email?}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/reinitialisation-mot-de-passe/par-email/email={email?}/{key?}', ResetPasswordPage::class)->name('password.reset.by.email');
    Route::get('/mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
});
