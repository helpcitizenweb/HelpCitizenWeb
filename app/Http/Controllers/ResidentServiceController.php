<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ResidentServiceController extends Controller
{
    /**
     * Display a listing of the available services to residents.
     */
    public function index()
    {
        $services = Service::all(); 
        return view('resident.services.index', compact('services'));
    }
}
