<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\City;
use App\Models\Client;
use App\Models\Invoice;
use App\Repositories\ClientRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ClientController extends AppBaseController
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\View\View
    {
        return view('clients.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $data = $this->clientRepository->getData();
        $countries = $data['countries'];
        $vatNoLabel = getVatNoLabel();

        return view('clients.create', compact('countries', 'vatNoLabel'));
    }

    public function store(CreateClientRequest $request): RedirectResponse
    {
        $input = $request->all();

        if (!empty($input['city_name'])) {
            $city = City::where('name', $input['city_name'])->where('state_id', $input['state_id'])->first();
            if (!$city) {
                $city = City::create([
                    'name' => $input['city_name'],
                    'state_id' => $input['state_id'],
                ]);
            }
            $input['city_id'] = $city->id;
        }

        try {
            $this->clientRepository->store($input);
            Flash::success(__('messages.flash.client_created_successfully'));
        } catch (Exception $exception) {
            Flash::error($exception->getMessage());

            return redirect()->route('clients.create')->withInput();
        }

        return redirect()->route('clients.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function show(Client $client, Request $request): \Illuminate\View\View
    {
        $client->load('user.media', 'invoices.payments');
        $activeTab = $request->get('Active', 'overview');
        $data = $this->clientRepository->getData();
        $vatNoLabel = getVatNoLabel();

        return view('clients.show', compact('client', 'activeTab', 'vatNoLabel'));
    }

    /**
     * @return Application|Factory|View
     */
    public function edit(Client $client)
    {
        $data = $this->clientRepository->getData();
        $countries = $data['countries'];
        $vatNoLabel = getVatNoLabel();
        $client->load('user.media');

        return view('clients.edit', compact('client', 'countries', 'vatNoLabel'));
    }

    public function update(Client $client, UpdateClientRequest $request)
    {
        $input = $request->all();
        $client->load('user');

        if (!empty($input['city_name'])) {
            $city = City::where('name', $input['city_name'])->where('state_id', $input['state_id'])->first();
            if (!$city) {
                $city = City::create([
                    'name' => $input['city_name'],
                    'state_id' => $input['state_id'],
                ]);
            }
            $input['city_id'] = $city->id;
        }

        try {
            $this->clientRepository->updateClient($input, $client);
            Flash::success(__('messages.flash.client_updated_successfully'));
        } catch (Exception $exception) {
            Flash::error($exception->getMessage());

            return redirect()->back()->withInput();
        }

        return redirect()->route('clients.index');
    }

    public function destroy(Client $client, Request $request): JsonResponse
    {
        $check = $request->get('clientWithInvoices');
        $invoiceModels = [
            Invoice::class,
        ];
        $result = canDelete($invoiceModels, 'client_id', $client->id);
        if ($check && $result) {
            return $this->sendError(__('messages.flash.client_cant_deleted'));
        }
        $client->user()->delete();
        $client->invoices()->delete();
        $client->delete();

        return $this->sendSuccess(__('messages.flash.client_deleted_successfully'));
    }

    public function getStates(Request $request): mixed
    {
        $countryId = $request->get('countryId');
        $states = getStates($countryId);

        return $this->sendResponse($states, __('messages.flash.status_retrieved_successfully'));
    }

    /**
     * @return mixed
     */
    public function getCities(Request $request)
    {
        $stateId = $request->get('stateId');
        $cities = getCities($stateId);

        return $this->sendResponse($cities, __('messages.flash.cities_retrieved_successfully'));
    }

}
