<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/generar-pdf', [PDFController::class, 'generarPDF'])->name('generar.pdf');
Route::get('/reporte-tabla', [PDFController::class, 'reporteTabla'])->name('reporte.tabla');
Route::get('/reporte-con-imagen', [PDFController::class, 'reporteConImagen'])->name('reporte.con_imagen');
