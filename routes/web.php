<?php

use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Chat\ForumChatBox;
use App\Livewire\HomePage;
use App\Livewire\Libraries\EpreuvesPage;
use App\Livewire\Libraries\EpreuvesUploader;
use App\Livewire\Libraries\LibraryHomePage;
use App\Livewire\Libraries\SupportFilesPage;
use App\Livewire\Libraries\SupportFilesUploader;
use App\Livewire\Master\LawChapterProfilPage;
use App\Livewire\Master\LawProfilPage;
use App\Livewire\Master\MembersHomePage;
use App\Livewire\Master\MembersListPage;
use App\Livewire\Master\UsersListPage;
use App\Livewire\User\CardMemberComponent;
use App\Livewire\User\MemberProfil;
use App\Livewire\User\MyNotificationsPage;
use App\Livewire\User\UserEditionPage;
use App\Livewire\User\UserProfil;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');


Route::middleware(['auth', 'master', 'user.not.blocked'])->group(function(){

    Route::get('gestion/utilisateurs', UsersListPage::class)->name('master.users.list');

    Route::get('administration/aesp-eftp/acceuil', MembersHomePage::class)->name('master.members.home');

    Route::get('administration/aesp-eftp/les-membres', MembersListPage::class)->name('master.members.list');

    Route::get('administration/aesp-eftp/carte-de-membre/membre={identifiant}', CardMemberComponent::class)->name('master.card.member');


});

Route::middleware(['auth', 'user.confirmed.by.admin', 'user.not.blocked'])->group(function(){

    
    Route::get('association/details-loi/Loi={slug}', LawProfilPage::class)->name('law.profil');

    Route::get('association/details-loi/Loi={slug}/chapitre={chapter_slug}', LawChapterProfilPage::class)->name('law.profil.chapter');

    Route::get('chat/forum/', ForumChatBox::class)->name('forum.chat');

    Route::get('bibliotheque/', LibraryHomePage::class)->name('library.home');

    Route::get('bibliotheque/tag=les-epreuves', EpreuvesPage::class)->name('library.epreuves');
    
    Route::get('bibliotheque/tag=les-fiches-de-cours', SupportFilesPage::class)->name('library.fiches');

    Route::get('bibliotheque/publication/tag=les-epreuves', EpreuvesUploader::class)->name('library.epreuves.uplaoder');

    Route::get('bibliotheque/publication/tag=les-fiches-de-cours', SupportFilesUploader::class)->name('library.fiches.uplaoder');
    
    Route::get('profil/mes-notifications', MyNotificationsPage::class)->name('user.notifications')->middleware(['user.self']);
    
    Route::get('profil/IDX={identifiant}/edition-profil/{auth_token}', UserEditionPage::class)->name('user.profil.edition')->middleware(['user.self']);

    Route::get('profil/IDX={identifiant}', UserProfil::class)->name('user.profil')->middleware(['user.self']);
    
    Route::get('profil/statut=membre/IDX={identifiant}', MemberProfil::class)->name('member.profil')->middleware(['user.self']);


});




Route::middleware(['guest'])->group(function(){
    Route::get('/connexion/{email?}', LoginPage::class)->name('login');
    Route::get('/inscription', RegisterPage::class)->name('register');
    Route::get('/verification-email/email={email}/{key?}', EmailVerificationPage::class)->name('email.verification');
    Route::get('/reinitialisation-mot-de-passe/token={token?}/email={email?}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/reinitialisation-mot-de-passe/par-email/email={email?}/{key?}', ResetPasswordPage::class)->name('password.reset.by.email');
    Route::get('/mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
});
