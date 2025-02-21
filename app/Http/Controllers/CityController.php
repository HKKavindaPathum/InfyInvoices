<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CityController extends AppBaseController
{
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('cities.index');
    }

    public function store(CreateCityRequest $request): JsonResponse
    {
        $input = $request->all();
        $state = $this->cityRepository->create($input);

        return $this->sendResponse($state, __('messages.flash.city_create'));
    }

    public function edit(City $city): JsonResponse
    {
        return $this->sendResponse($city, 'City successfully retrieved.');
    }

    public function update(UpdateCityRequest $request, City $city): JsonResponse
    {
        $input = $request->all();
        $this->cityRepository->update($input, $city->id);

        return $this->sendSuccess(__('messages.flash.city_update'));
    }

    public function destroy(City $city): JsonResponse
    {
        $city->delete();

        return $this->sendSuccess('City deleted successfully.');
    }
}
