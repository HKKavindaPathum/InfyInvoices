<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\City;
use App\Models\State;
use App\Repositories\StateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class StateController extends AppBaseController
{
    /**
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function index(): View
    {
        return view('states.index');
    }

    public function store(CreateStateRequest $request): JsonResponse
    {
        $input = $request->all();
        $state = $this->stateRepository->create($input);

        return $this->sendResponse($state, __('messages.flash.state_create'));
    }

    public function edit(State $state): JsonResponse
    {
        return $this->sendResponse($state, 'State successfully retrieved.');
    }

    public function update(UpdateStateRequest $request, State $state): JsonResponse
    {
        $input = $request->all();
        $this->stateRepository->update($input, $state->id);

        return $this->sendSuccess(__('messages.flash.state_update'));
    }

    public function destroy(State $state): JsonResponse
    {
        $cities = City::where('state_id', $state->id)->count();
        if ($cities > 0) {
            return $this->sendError(__('messages.flash.state_used'));
        }
        $state->delete();

        return $this->sendSuccess('State deleted successfully.');
    }
}
