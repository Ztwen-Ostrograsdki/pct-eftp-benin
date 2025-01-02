<?php

use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\BookDetailsPage;
use App\Livewire\FedapayCheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\Libraries\EpreuvesPage;
use App\Livewire\Libraries\EpreuvesUploader;
use App\Livewire\Libraries\LibraryHomePage;
use App\Livewire\Master\MembersHomePage;
use App\Livewire\Master\MembersListPage;
use App\Livewire\Master\OrdersList;
use App\Livewire\Master\UsersListPage;
use App\Livewire\Shop\ShoppingHome;
use App\Livewire\User\CartPage;
use App\Livewire\User\CheckoutPage;
use App\Livewire\User\CheckoutSuccessPage;
use App\Livewire\User\MemberProfil;
use App\Livewire\User\MyNotificationsPage;
use App\Livewire\User\Orders;
use App\Livewire\User\UserEditionPage;
use App\Livewire\User\UserProfil;
use App\Livewire\User\UserProfilPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);


Route::middleware(['auth', 'master', 'user.not.blocked'])->group(function(){

    Route::get('gestion/utilisateurs', UsersListPage::class)->name('master.users.list');

    Route::get('gestion/les-commandes', OrdersList::class)->name('master.orders.list');

    Route::get('association/acceuil', MembersHomePage::class)->name('master.members.home');

    Route::get('association/les-membres', MembersListPage::class)->name('master.members.list');


});

Route::middleware(['auth', 'user.confirmed.by.admin', 'user.not.blocked'])->group(function(){

    Route::get('bibliotheque/', LibraryHomePage::class)->name('library.home');

    Route::get('bibliotheque/tag=les-epreuves', EpreuvesPage::class)->name('library.epreuves');

    Route::get('bibliotheque/publication/tag=les-epreuves', EpreuvesUploader::class)->name('library.epreuves.uplaoder');
    
    Route::get('profil/mes-notifications', MyNotificationsPage::class)->name('user.notifications')->middleware(['user.self']);
    
    Route::get('profil/IDX={identifiant}/edition-profil/{auth_token}', UserEditionPage::class)->name('user.profil.edition')->middleware(['user.self']);

    Route::get('profil/IDX={identifiant}', UserProfil::class)->name('user.profil')->middleware(['user.self']);
    
    Route::get('profil/statut=membre/IDX={identifiant}', MemberProfil::class)->name('member.profil')->middleware(['user.self']);

    Route::get('profil/achats/mes-commandes/IDX={identifiant}', Orders::class)->name('user.orders')->middleware(['user.self']);

    Route::get('profil/boutique/mon-panier/IDX={identifiant}', CartPage::class)->name('user.cart')->middleware(['user.self']);

    Route::get('profil/boutique/validation-payement/IDX={identifiant}/FADAPAYTRANSACTION={transactionID}/token={token}', FedapayCheckoutPage::class)->name('feda.checkout.proccess');
    
    Route::get('profil/boutique/validation-panier-et-addresse-reception/IDX={identifiant}', CheckoutPage::class)->name('user.checkout.address')->middleware(['user.self']);
    
    Route::get('profil/boutique/commande/ID={identifiant}', CheckoutSuccessPage::class)->name('user.checkout.success');

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
