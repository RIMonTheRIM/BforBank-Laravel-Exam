<?php


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
Route::redirect('/', '/login');
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/send-verification-test', function () {
    $user = Auth::user();

    if ($user) {
        $user->sendEmailVerificationNotification();
        return 'Verification email sent to ' . $user->email;
    }

    return 'No user logged in.';
});

Route::get('/home',                 [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');
Route::get('/accountchoice',        [App\Http\Controllers\HomeController::class, 'choice'])->middleware('auth', 'verified');
Route::get('/demande/{type}',       [App\Http\Controllers\HomeController::class, 'createDemande'])->middleware('auth', 'verified');
Route::get('/cloture/{id}',       [App\Http\Controllers\HomeController::class, 'demandeCloture'])->middleware('auth', 'verified');

//Route::get('/transaction/{id}',   [App\Http\Controllers\CompteController::class, 'showTransaction'])->middleware('auth');
Route::post('/transaction/depot',   [App\Http\Controllers\CompteController::class, 'depot'])->middleware('auth', 'verified');
Route::post('/transaction/retrait', [App\Http\Controllers\CompteController::class, 'retrait'])->middleware('auth', 'verified');
Route::post('/transaction/virement',[App\Http\Controllers\CompteController::class, 'virement'])->middleware('auth', 'verified');
Route::get('/dashboard/compte/{id}',[App\Http\Controllers\CompteController::class, 'returnDashboard'])->middleware('auth', 'verified');
Route::get('/createcarte/{id}',[App\Http\Controllers\CompteController::class, 'createCarte'])->middleware('auth', 'verified');

Route::get('/gesDemandes', [App\Http\Controllers\GestionController::class, 'demandesDashboard'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/searchDemandeAttente', [App\Http\Controllers\GestionController::class, 'searchDemandeAttente'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/searchDemande', [App\Http\Controllers\GestionController::class, 'searchDemande'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/searchTransaction', [App\Http\Controllers\GestionController::class, 'searchTransaction'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/searchCompte', [App\Http\Controllers\GestionController::class, 'searchCompte'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/gesTransactions', [App\Http\Controllers\GestionController::class, 'transactionsDashboard'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/gesComptes', [App\Http\Controllers\GestionController::class, 'comptesDashboard'])->middleware(['auth', 'isAdmin', 'verified']);

Route::get('/valider/{demandeId}',  [App\Http\Controllers\GestionController::class, 'validerDemande'])->middleware(['auth', 'isAdmin', 'verified']);
Route::post('/rejeter/{demandeId}', [App\Http\Controllers\GestionController::class, 'rejetDemande'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/revoke/{idTransaction}', [App\Http\Controllers\GestionController::class, 'revokeTransaction'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/compteinfo/{idCompte}', [App\Http\Controllers\GestionController::class, 'showCompteInfo'])->middleware(['auth', 'isAdmin', 'verified']);
Route::get('/suspendre/{idCompte}', [App\Http\Controllers\GestionController::class, 'suspendreCompte'])->middleware(['auth', 'isAdmin', 'verified']);

Route::get('/download/carte/{id}', [App\Http\Controllers\CompteController::class, 'pdfCarte']);
Route::get('/download/histo/{id}', [App\Http\Controllers\CompteController::class, 'pdfHisto']);
