<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/tambah-tugas', function () {
    return view('tambah-tugas');
})->name('tambah-tugas');

Route::get('/tugas', function () {
    return view('tugas');
})->name('tugas');
