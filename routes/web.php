<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EbisManualInputController;
use App\Http\Controllers\EbisPlanningController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\MasterInputController;
use App\Http\Controllers\AdminController;





Route::get('/', function () {
    return view('beranda');
})->name('beranda');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'role:optima,admin,tif,telkom_akses'])
->name('dashboard');

Route::get('/waiting', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->role !== 'waiting') {
        return redirect()->route('dashboard');
    }

    return view('waiting');

})->middleware('auth')->name('waiting');


Route::middleware('auth')->group(function () {

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', 'role:optima,admin,tif,telkom_akses'])->group(function () {

    
    Route::get('/deployment/b2b', function () {
        return view('deployment.b2b');
    })->name('deployment.b2b');

    
    Route::get('/deployment/olo', function () {
        return view('deployment.olo');
    })->name('deployment.olo');

    
    Route::get('/deployment/input', [EbisManualInputController::class, 'index'])
        ->name('deployment.input');

    Route::post('/deployment/input', [EbisManualInputController::class, 'store'])
        ->name('deployment.input.store');

    Route::get('/deployment/api/search-starclick', [EbisManualInputController::class, 'searchStarclick'])
        ->name('deployment.api.search-starclick');

    Route::get('/deployment/api/check-starclick', [EbisManualInputController::class, 'checkStarclickExists'])
        ->name('deployment.api.check-starclick');

    
    Route::get('/deployment/lihat-data', [EbisPlanningController::class, 'lihatData'])
        ->name('deployment.lihat-data');

    Route::get('/deployment/lihat-data/{id}/detail', [EbisPlanningController::class, 'detailLihatData'])
        ->name('deployment.lihat-data.detail');

    Route::get('/deployment/lihat-data/export', [EbisPlanningController::class, 'exportLihatData'])
        ->name('deployment.lihat-data.export');

    
    Route::get('/deployment/rekap', function () {
        return redirect()->route('deployment.lihat-data');
    });

    
    Route::get('/deployment/update', [EbisManualInputController::class, 'updateList'])
        ->name('deployment.update');

    
    Route::get('/deployment/{id}/edit', [EbisManualInputController::class, 'edit'])
        ->name('deployment.edit');

    Route::put('/deployment/{id}', [EbisManualInputController::class, 'update'])
        ->name('deployment.update.process');

    
    Route::get('/deployment/upload', [EbisPlanningController::class, 'index'])
        ->name('deployment.upload');

    Route::post('/ebis/import', [EbisPlanningController::class, 'import'])
        ->name('ebis.import');

    Route::get('/ebis/export', [EbisPlanningController::class, 'export'])
        ->name('ebis.export');


    
    Route::post('/ebis/manual/store', [EbisManualInputController::class, 'store'])
        ->name('ebis.manual.store');
    
    Route::get('/deployment/update/list', [EbisManualInputController::class, 'updateList'])
        ->name('deployment.update.list');

    
    Route::get('/deployment/progress-overview', [AdminController::class, 'progressOverview'])
        ->name('deployment.progress-overview');

    
    Route::get('/admin/workload', [AdminController::class, 'workloadDetailsPage'])
        ->name('admin.workload');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/role', [UserController::class, 'updateRole']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/telegram/daily-report', [AdminController::class, 'sendDailyTelegramReport'])->name('admin.telegram.daily-report');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/master-input', [MasterInputController::class, 'index'])
        ->name('admin.master-input');

    Route::post('/admin/master-input/datel', [MasterInputController::class, 'storeDatel'])
        ->name('admin.master-input.datel');

    Route::post('/admin/master-input/sto', [MasterInputController::class, 'storeSto'])
        ->name('admin.master-input.sto');

    Route::post('/admin/master-input/mitra', [MasterInputController::class, 'storeMitra'])
        ->name('admin.master-input.mitra');

    
    Route::put('/admin/master-input/datel/{id}', [MasterInputController::class, 'updateDatel'])
        ->name('admin.master-input.datel.update');

    Route::put('/admin/master-input/sto/{id}', [MasterInputController::class, 'updateSto'])
        ->name('admin.master-input.sto.update');

    Route::put('/admin/master-input/mitra/{id}', [MasterInputController::class, 'updateMitra'])
        ->name('admin.master-input.mitra.update');

    
    Route::delete('/admin/master-input/datel/{id}', [MasterInputController::class, 'destroyDatel'])
        ->name('admin.master-input.datel.destroy');

    Route::delete('/admin/master-input/sto/{id}', [MasterInputController::class, 'destroySto'])
        ->name('admin.master-input.sto.destroy');

    Route::delete('/admin/master-input/mitra/{id}', [MasterInputController::class, 'destroyMitra'])
        ->name('admin.master-input.mitra.destroy');

    Route::get('/admin/api/dashboard-stats', [AdminController::class, 'getEnterpriseStats'])
        ->name('admin.api.dashboard-stats');

    Route::get('/admin/api/trend-data', [AdminController::class, 'getTrendData'])
        ->name('admin.api.trend-data');

    Route::get('/admin/api/live-tracking', [AdminController::class, 'getLiveTracking'])
        ->name('admin.api.live-tracking');

    Route::get('/admin/api/workload-day', [AdminController::class, 'getWorkloadDay'])
        ->name('admin.api.workload-day');

    Route::get('/admin/api/top-mitras', [AdminController::class, 'getTopMitras'])
        ->name('admin.api.top-mitras');
});



require __DIR__ . '/auth.php';
