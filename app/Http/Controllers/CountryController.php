<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use App\Models\State;
use App\Repositories\CountryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CountryController extends AppBaseController
{
    private CountryRepository $countryRepository;

    public $sendResponse;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(): View
    {
        return view('countries.index');
    }

    public function store(CreateCountryRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['short_code'] = strtoupper($input['short_code']);
        $country = $this->countryRepository->create($input);

        return $this->sendResponse($country, __('messages.flash.country_create'));
    }

    public function edit(Country $country): JsonResponse
    {
        return $this->sendResponse($country, 'Country successfully retrieved.');
    }

    public function update(UpdateCountryRequest $request, Country $country): JsonResponse
    {
        $input = $request->all();
        $input['short_code'] = strtoupper($input['short_code']);

        $this->countryRepository->update($input, $country->id);

        return $this->sendSuccess(__('messages.flash.country_update'));
    }
    public function destroy(Country $country): JsonResponse
    {
        $states = State::whereCountryId($country->id)->count();
        if ($states > 0) {
            return $this->sendError(__('messages.flash.country_used'));
        }
        $country->delete();

        return $this->sendSuccess('Country deleted successfully.');
    }
}
