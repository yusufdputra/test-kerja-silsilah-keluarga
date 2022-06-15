<?php

namespace App\Http\Controllers;

use App\Models\Silsilah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $data['title'] = 'Kelola Silsilah keluarga';
    $data['silsilah'] = Silsilah::where('level', '!=', 3)->get();
    // silsilah level 1
    $data['level_1']  = Silsilah::where('level', 1)->get();
    // silsilah level 2
    $data['level_2']  = Silsilah::where('level', 2)->get();
    // silsilah level 3
    $data['level_3']  = Silsilah::where('level', 3)->get();
    return view('home', compact('data'));
  }
}
