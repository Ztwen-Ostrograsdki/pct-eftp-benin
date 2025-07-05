<?php

use App\Livewire\AboutUs;
use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Chat\ForumChatBox;
use App\Livewire\HomePage;
use App\Livewire\Libraries\EpreuveProfil;
use App\Livewire\Libraries\EpreuvesExamensPage;
use App\Livewire\Libraries\EpreuvesPage;
use App\Livewire\Libraries\EpreuvesUploader;
use App\Livewire\Libraries\LibraryHomePage;
use App\Livewire\Libraries\PdfReader;
use App\Livewire\Libraries\SupportFilesPage;
use App\Livewire\Libraries\SupportFilesUploader;
use App\Livewire\Master\CommuniqueComponent;
use App\Livewire\Master\CommuniquesDispatchedToAll;
use App\Livewire\Master\LawChapterProfilPage;
use App\Livewire\Master\LawProfilPage;
use App\Livewire\Master\LyceesListingPage;
use App\Livewire\Master\MembersHomePage;
use App\Livewire\Master\MembersListPage;
use App\Livewire\Master\RoleProfil;
use App\Livewire\Master\UsersListPage;
use App\Livewire\User\CardMemberComponent;
use App\Livewire\User\MemberProfil;
use App\Livewire\User\MyAdminRoles;
use App\Livewire\User\MyMonthlyPayments;
use App\Livewire\User\MyNotificationsPage;
use App\Livewire\User\MyQuotes;
use App\Livewire\User\UserEditionPage;
use App\Livewire\User\UserProfil;
use App\Models\Epreuve;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

Route::get('/', HomePage::class)->name('home');

Route::get('communiques/page', CommuniquesDispatchedToAll::class)->name('communique.dispatched');

Route::get('communiques/communique/id={id}/s={slug}', CommuniqueComponent::class)->name('communique.profil');

Route::get('/les-lycees-et-centre-de-formations-du-benin', LyceesListingPage::class)->name('lycee.listing');


Route::middleware(['auth', 'user.not.blocked'])->group(function(){

    Route::get('gestion/utilisateurs', UsersListPage::class)->name('master.users.list');
    
    Route::get('gestion/role-administrateurs/ID={role_id}', RoleProfil::class)->name('master.admin.role.profil');

    Route::get('administration/aesp-eftp/acceuil', MembersHomePage::class)->name('master.members.home');

    Route::get('administration/aesp-eftp/les-membres', MembersListPage::class)->name('master.members.list');

    Route::get('administration/aesp-eftp/carte-de-membre/membre={identifiant}', CardMemberComponent::class)->name('master.card.member');


});

Route::middleware(['auth', 'user.confirmed.by.admin', 'user.not.blocked'])->group(function(){

    
    Route::get('association/details-loi/Loi={slug}', LawProfilPage::class)->name('law.profil');

    Route::get('association/details-loi/Loi={slug}/chapitre={chapter_slug}', LawChapterProfilPage::class)->name('law.profil.chapter');

    Route::get('chat/forum/', ForumChatBox::class)->name('forum.chat');

    Route::get('bibliotheque/publication/tag=les-epreuves/type={type}', EpreuvesUploader::class)->name('library.epreuves.uplaoder');

    Route::get('bibliotheque/publication/tag=les-fiches-de-cours', SupportFilesUploader::class)->name('library.fiches.uplaoder');
    
    Route::get('profil/mes-notifications/IDX={identifiant?}', MyNotificationsPage::class)->name('user.notifications')->middleware(['user.self']);
    
    Route::get('profil/IDX={identifiant}/edition-profil/{auth_token}', UserEditionPage::class)->name('user.profil.edition')->middleware(['user.self']);

    Route::get('profil/IDX={identifiant}', UserProfil::class)->name('user.profil')->middleware(['self.or.admins']);
    
    Route::get('profil/statut=membre/IDX={identifiant}', MemberProfil::class)->name('member.profil')->middleware(['self.or.admins']);
    
    Route::get('profil/statut=membre/cotisations/IDX={identifiant}/mes-cotisations', MyMonthlyPayments::class)->name('member.payments')->middleware(['self.or.admins']);
    
    Route::get('profil/statut=membre/IDX={identifiant}/mes-citations', MyQuotes::class)->name('member.quotes')->middleware(['self.or.admins']);

    Route::get('profil/statut=membre/IDX={identifiant}/mes-roles-administrateurs', MyAdminRoles::class)->name('member.admins.roles')->middleware(['self.or.admins']);

});

Route::get('/a-propos/de-aesp-eftp-benin/', AboutUs::class)->name('about.us');

Route::get('bibliotheque/', LibraryHomePage::class)->name('library.home');

Route::get('bibliotheque/tag=les-epreuves', EpreuvesPage::class)->name('library.epreuves');

Route::get('bibliotheque/details-epreuves/epreuve={uuid}', EpreuveProfil::class)->name('library.epreuve.profil');

Route::get('bibliotheque/examens/tag=les-epreuves', EpreuvesExamensPage::class)->name('library.epreuves.examens');

Route::get('bibliotheque/tag=les-fiches-de-cours', SupportFilesPage::class)->name('library.fiches');

Route::get('/lecture/secure-pdf/{uuid}', function ($uuid) {

    $epreuve = Epreuve::where('uuid', $uuid)->firstOrFail();

    $path = storage_path('app/' . $epreuve->path);

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $epreuve->path . '"'
    ]);

})->name('epreuve.secure');

Route::get('/epreuve/lecture/{uuid}', PdfReader::class)->name('epreuve.viewer');

Route::get('/403', function () {
    abort(403, "Vous n'êtes pas authorisé à acceder à une telle page ou effectuer une telle action!");
})->name('error.403');


Route::middleware(['guest'])->group(function(){
    Route::get('/connexion/{email?}', LoginPage::class)->name('login');
    Route::get('/inscription', RegisterPage::class)->name('register');
    Route::get('/verification-email/email={email}/{key?}', EmailVerificationPage::class)->name('email.verification');
    Route::get('/reinitialisation-mot-de-passe/token={token?}/email={email?}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/reinitialisation-mot-de-passe/par-email/email={email?}/{key?}', ResetPasswordPage::class)->name('password.reset.by.email');
    Route::get('/mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
});
