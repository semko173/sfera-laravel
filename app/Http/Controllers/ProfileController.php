<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('profile.orders');
    }

    public function orders(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }

    public function prescriptions(): View
    {
        $prescriptions = auth()->user()
            ->prescriptions()
            ->latest('created_at')
            ->get();

        return view('profile.prescriptions', compact('prescriptions'));
    }

    public function settings(): View
    {
        return view('profile.settings', ['user' => auth()->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.settings')->with('status', 'Профиль обновлён');
    }

    public function storePrescription(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'od_sph'  => ['nullable', 'string', 'max:20'],
            'od_cyl'  => ['nullable', 'string', 'max:20'],
            'od_axis' => ['nullable', 'string', 'max:10'],
            'os_sph'  => ['nullable', 'string', 'max:20'],
            'os_cyl'  => ['nullable', 'string', 'max:20'],
            'os_axis' => ['nullable', 'string', 'max:10'],
            'pd'      => ['nullable', 'string', 'max:10'],
        ]);

        $request->user()->prescriptions()->create($data);

        return redirect()->route('profile.prescriptions')->with('status', 'Рецепт добавлен');
    }

    public function destroyPrescription(Prescription $prescription): RedirectResponse
    {
        abort_unless($prescription->user_id === auth()->id(), 403);

        $prescription->delete();

        return redirect()->route('profile.prescriptions')->with('status', 'Рецепт удалён');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}