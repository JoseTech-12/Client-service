<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ClientController extends Controller
{


    protected $auth;

    public function __construct(AuthService $auth)
    {

        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        $clients = Client::all();
        return response()->json([
            'message' => 'estos son los clientes',
            'clientes' => $clients
        ], 200);
    }

    public function store(ClientRequest $request)
    {
        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        if ($user['rol'] == 'Contador') {
            return response()->json([
                'message' => 'Solo los Administradores y cajeros pueden agregar cajeros'
            ], 401);
        }

        $client = Client::create(
            [
                'id' => $request->id,
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono
            ]
        );

        return response()->json([
            'message' => 'Cliente agregado satisfactoriamente',
            'client' => $client
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacionn'
            ], 401);
        }

        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json(
            $client,
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        if ($user['rol'] == 'Contador') {
            return response()->json([
                'message' => 'Solo los Administradores y cajeros pueden editar cajeros'
            ], 401);
        }

        $client = Client::where('id', $id)->firstOrFail();
        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        $client->update($request->all());

        return response()->json([
            'message' => 'Cliente actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $token = $request->bearerToken();
        $user = $this->auth->getUserFromToken($token);

        if (!$user) {
            return response()->json([
                'message' => 'No tienes autorizacion'
            ], 401);
        }

        if ($user['rol'] == 'Contador') {
            return response()->json([
                'message' => 'Solo los Administradores y cajeros pueden eliminar cajeros'
            ], 401);
        }

        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        $client->delete();

        return response()->json([
            'message' => 'Cliente elimando correctamente'
        ], 200);
    }
}
