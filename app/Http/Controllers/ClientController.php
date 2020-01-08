<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClient;
use App\QueryFilters\{Email, Name, Id};
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Redirector;
use App\Http\Requests\StoreClient;
use Exception;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = app(Pipeline::class)
            ->send(Client::query())
            ->through([
                Name::class,
                Email::class,
                Id::class,
            ])
            ->thenReturn();

        $clients = $clients->latest()->paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.modify');
    }

    public function edit(Client $client)
    {
        return view('clients.modify', compact('client'));
    }

    /**
     * @param StoreClient $request
     * @return RedirectResponse|Redirector
     */
    public function store(StoreClient $request)
    {
        $validated = $request->validated();

        Client::create($validated);

        return redirectSuccess('clients.index', 'Add client successful');
    }

    public function update(Client $client, UpdateClient $request)
    {
        $validated = $request->validated();

        $client->update($validated);

        return redirectSuccess('clients.index', 'Client update successful');
    }

    public function remove(Client $client)
    {
        try {
            $client->delete();
        } catch (Exception $e) {
            return redirectFail('clients.index', 'Client deleted successful!');
        }

        return redirectSuccess('clients.index', 'Client deleted successful!');
    }
}
