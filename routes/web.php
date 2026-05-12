<?php
use App\Models\Pet;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/quienes-somos', 'quienes-somos')->name('quienes.somos');
    Route::view('/contacto', 'contacto')->name('contacto');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/especies', 'especies')->name('especies.index');
    Route::view('/mascotas', 'mascotas')->name('mascotas.index');
});

Route::get('/pets-pdf', function () {
    $pets = Pet::with('species')->get();
    $pdf = Pdf::loadView('pdf.pets', compact('pets'));
    return $pdf->download('reporte-mascotas.pdf');
})->name('pets.pdf');

require __DIR__.'/auth.php';
