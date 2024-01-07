<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        // En vez de 'pintar' una vista (view), lo que necesitamos es que retorne información en formato json
        // return response()->json($clients);
        $array = [];
        foreach ($clients as $client){
            $array[] = [
                'id'        => $client->id,
                'name'      => $client->name,
                'email'     => $client->email,
                'phone'     => $client->phone,
                'address'   => $client->address,
                'services'  => $client->services
            ];
        }
        return response()->json($array);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name   = $request->name;
        $client->email  = $request->email;
        $client->phone  = $request->phone;
        $client->address= $request->address;
        $client->save();
        // Devolvemos una data 
        $data = [
            'message'   => 'Client created successfully',
            'client'    => $client,
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $data = [
            'message'   => 'Client details',
            'client'    => $client,
            'services'  => $client->services
        ];
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $client->name   = $request->name;
        $client->email  = $request->email;
        $client->phone  = $request->phone;
        $client->address= $request->address;
        $client->save();
        // Devolvemos una data 
        $data = [
            'message'   => 'Client updated successfully',
            'client'    => $client,
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        $data = [
            'message'   => 'Client deleted',
            'client'    => $client,
        ];
        return response()->json($data);
    }


    // Campo de relación de Clientes/Servicio
    public function attach(Request $request, Client $client)
    {
        $client = Client::find($request->client_id);
        $client->services()->attach($request->service_id);
        $data = [
            'message'   => 'Service attached successfully',
        ];
        return response()->json($data);
    }

    public function detach(Request $request){
        $client = Client::find($request->client_id);
        $client->services()->detach($request->service_id);
        $data = [
            'message'   => 'Service detached',
        ];
        return response()->json($data);
    }
}
