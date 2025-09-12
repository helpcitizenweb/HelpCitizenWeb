<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  

class AdminServiceController extends Controller
{

    // Display a listing of the services
    public function index()
    {
        $services = Service::all(); 
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        // Validate only name and description fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create a new service
        Service::create($validatedData);

        // Redirect to services index with a success message
        return redirect()->route('admin.services.index')
                        ->with('success', 'Service created successfully!');
    }


    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    // Update the specified service in the database
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect with success message
        return redirect()->route('admin.services.index')
                 ->with('success', 'Service successfully updated.');
    }


    // Remove the specified service from the database
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service deleted successfully!');
    }
}
