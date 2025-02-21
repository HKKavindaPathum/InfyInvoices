<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    public $userRepository;

    /**
     * UserController constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        try {
            $this->userRepository->store($input);
            Flash::success(__('messages.flash.admin_created_successfully'));
        } catch (Exception $exception) {
            Flash::error($exception->getMessage());

            return redirect()->route('users.create')->withInput();
        }

        return redirect(route('users.index'));
    }

    /**
     * @return Application|Factory|View
     */
    public function show(User $user): \Illuminate\View\View
    {
        $user->load('media');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('media');

        if ($user->is_default_admin) {
            Flash::error(__('messages.flash.default_admin_can_not_editable'));

            return redirect(route('users.index'));
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified User in storage.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $this->userRepository->updateUser($request->all(), $user->id);
            Flash::success(__('messages.flash.admin_updated_successfully'));
        } catch (Exception $exception) {
            Flash::error($exception->getMessage());

            return redirect(route('users.edit', ['user' => $user->id]))->withInput();
        }

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->is_default_admin) {
            return $this->sendError(__("messages.flash.Admin_cant_be_deleted"));
        }

        $user->delete();

        return $this->sendSuccess(__("messages.flash.Admin_deleted_successfully"));
    }

    /**
     * @return Application|Factory|View
     */
    public function editProfile(): \Illuminate\View\View
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function updateProfile(UpdateUserProfileRequest $request): RedirectResponse
    {
        $this->userRepository->updateProfile($request->all());
        Flash::success(__("messages.flash.admin_profile_updated_successfully"));

        return redirect(route('profile.setting'));
    }

    public function changePassword(UpdateChangePasswordRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            /** @var User $user */
            $user = Auth::user();
            if (! Hash::check($input['current_password'], $user->password)) {
                return $this->sendError(__("messages.flash.current_password_is_invalid"));
            }
            $input['password'] = Hash::make($input['new_password']);
            $user->update($input);

            return $this->sendSuccess(__("messages.flash.password_updated_successfully"));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function changeUserStatus(User $user): JsonResponse
    {
        $status = ! $user->status;
        $user->update(['status' => $status]);

        return $this->sendSuccess(__("messages.flash.status_updated_successfully"));
    }

    public function updateLanguage(Request $request): JsonResponse
    {
        $language = $request->get('language');

        $user = getLogInUser();
        $user->update(['language' => $language]);

        return $this->sendSuccess(__("messages.flash.language_updated_successfully"));
    }

    public function updateDarkMode(): RedirectResponse
    {
        $user = Auth::user();
        $darkEnabled = $user->dark_mode == true;
        $user->update([
            'dark_mode' => ! $darkEnabled,
        ]);

        return redirect()->back();
    }
}
