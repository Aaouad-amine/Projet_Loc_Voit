<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\{AuthController, VoitureController, ReservationController, FactureController, AdminController};
use Illuminate\Support\Facades\Route;

// ─── PAGE D'ACCUEIL ─────────────────────────────────────────────
Route::get('/', function () {
    $voitures = \App\Models\Voiture::where('disponibilite', true)->with('assurance')->take(6)->get();
    return view('home', compact('voitures'));
})->name('home');

// ─── AUTHENTIFICATION ───────────────────────────────────────────
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ─── VOITURES (publiques) ───────────────────────────────────────
Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');

// ─── ROUTES AUTHENTIFIÉES ───────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ⚠️ /voitures/create AVANT /voitures/{voiture}
    Route::get('/voitures/create',  [VoitureController::class, 'create'])->name('voitures.create');
    Route::post('/voitures',        [VoitureController::class, 'store'])->name('voitures.store');

    // ─── VOITURES (admin seulement) ─────────────────────────────
    Route::middleware('is.admin')->group(function () {
        Route::get('/voitures/{voiture}/edit',    [VoitureController::class, 'edit'])->name('voitures.edit');
        Route::put('/voitures/{voiture}',         [VoitureController::class, 'update'])->name('voitures.update');
        Route::delete('/voitures/{voiture}',      [VoitureController::class, 'destroy'])->name('voitures.destroy');
        Route::post('/voitures/{voiture}/toggle', [VoitureController::class, 'toggleDisponibilite'])->name('voitures.toggle');
    });

    // ─── RÉSERVATIONS ────────────────────────────────────────────
    Route::get('/voitures/{voiture}/reserver',   [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/voitures/{voiture}/reserver',  [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/reservations',                  [ReservationController::class, 'index'])->name('reservations.index');

    // ─── FACTURES ────────────────────────────────────────────────
    Route::get('/factures/{facture}',          [FactureController::class, 'show'])->name('factures.show');
    Route::get('/factures/{facture}/download', [FactureController::class, 'download'])->name('factures.download');
});

// ⚠️ /voitures/{voiture} APRÈS toutes les routes statiques
Route::get('/voitures/{voiture}', [VoitureController::class, 'show'])->name('voitures.show');

// ─── ADMIN ──────────────────────────────────────────────────────
Route::middleware(['auth', 'is.admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.index', [
            'totalUsers'        => \App\Models\User::count(),
            'totalVoitures'     => \App\Models\Voiture::count(),
            'totalReservations' => \App\Models\Reservation::count(),
            'totalRevenus'      => \App\Models\Facture::sum('montant_total'),
            'reservations'      => \App\Models\Reservation::with(['user', 'voiture'])->latest()->get(),
            'voitures'          => \App\Models\Voiture::with('user')->latest()->get(),
            'users'             => \App\Models\User::latest()->get(),
            'factures'          => \App\Models\Facture::with([
                'reservation.user',
                'reservation.voiture'
            ])->latest()->get(),
        ]);
    })->name('admin.index');

    // ✅ Alias pour admin.dashboard
    Route::get('/admin/dashboard', function () {
        return redirect()->route('admin.index');
    })->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::delete('/users/{user}',               [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::delete('/voitures/{voiture}',         [VoitureController::class, 'destroy'])->name('voitures.delete');
        Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    });
});

    Route::prefix('admin')->name('admin.')->group(function () {
        // Supprimer utilisateur
        Route::delete('/users/{user}',           [AdminController::class, 'deleteUser'])->name('users.delete');
        // Supprimer voiture ✅
        Route::delete('/voitures/{voiture}',     [VoitureController::class, 'destroy'])->name('voitures.delete');
        // Annuler réservation ✅
        Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    });
    
