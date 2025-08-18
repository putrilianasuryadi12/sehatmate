<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display the superadmin dashboard.
     */
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    public function verification()
    {
        $users = User::where('status', 'pending')->get();
        return view('superadmin.verification.index', compact('users'));
    }

    public function foods()
    {
        $foods = \App\Models\Food::with('createdBy')->get();
        return view('superadmin.foods.index', compact('foods'));
    }

    /**
     * Display the specified food for superadmin.
     */
    public function showFood(Food $food)
    {
        return view('superadmin.foods.show', compact('food'));
    }

    /**
     * Display a listing of users for super admin.
     */
    public function index()
    {
        $users = User::all();
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Approve the specified user.
     */
    public function approve(Request $request, User $user)
    {
        $user->update(['status' => 'approved', 'approved_at' => now()]);
        return back()->with('success', 'User approved successfully.');
    }

    /**
     * Reject and delete the specified user.
     */
    public function reject(Request $request, User $user)
    {
        $user->delete();
        return back()->with('success', 'User rejected and deleted successfully.');
    }

    /**
     * Show the form for creating a new food.
     */
    public function createFood()
    {
        return view('superadmin.foods.create');
    }

    /**
     * Store a newly created food in storage.
     */
    public function storeFood(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbohydrates' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'vitamin_c_mg' => 'required|numeric|min:0',
            'besi_mg' => 'required|numeric|min:0',
            'seng_mg' => 'required|numeric|min:0',
            'urlimage' => 'nullable|url',
        ]);

        // Set default values untuk field yang tidak diinput
        $validated['air_g'] = 0;
        $validated['serat_g'] = 0;
        $validated['abu_g'] = 0;
        $validated['kalsium_mg'] = 0;
        $validated['fosfor_mg'] = 0;
        $validated['natrium_mg'] = 0;
        $validated['kalium_mg'] = 0;
        $validated['tembaga_mg'] = 0;
        $validated['seng_mg'] = 0;
        $validated['retinol_mcg'] = 0;
        $validated['b_kar_mcg'] = 0;
        $validated['kar_total_mcg'] = 0;
        $validated['thiamin_mg'] = 0;
        $validated['riboflavin_mg'] = 0;
        $validated['niasin_mg'] = 0;
        $validated['bdd_persen'] = 0;

        // Add default status as unpublished and author information
        $validated['status'] = 'unpublished';
        $validated['created_by'] = auth()->id();

        Food::create($validated);

        return redirect()->route('superadmin.foods.index')
            ->with('success', 'Makanan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified food.
     */
    public function editFood(Food $food)
    {
        // Only superadmin or owner can edit
        if (auth()->user()->role !== 'superadmin' && $food->created_by !== auth()->id()) {
            return redirect()->route('not.allowed');
        }
        return view('superadmin.foods.edit', compact('food'));
    }

    /**
     * Update the specified food in storage.
     */
    public function updateFood(Request $request, Food $food)
    {
        // Check permission
        if (auth()->user()->role !== 'superadmin' && $food->created_by !== auth()->id()) {
            return redirect()->route('not.allowed');
        }
        // Validate input fields except status (handled by buttons)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbohydrates' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'vitamin_c_mg' => 'required|numeric|min:0',
            'besi_mg' => 'required|numeric|min:0',
            'seng_mg' => 'required|numeric|min:0',
            'urlimage' => 'nullable|url',
        ]);
        // Determine action: save or publish
        if ($request->input('action') === 'publish') {
            // Set status to published when publishing
            $food->update(array_merge($validated, ['status' => 'published']));
        } else {
            // Save or update action without 'publish' should keep or set unpublished
            $food->update(array_merge($validated, ['status' => 'unpublished']));
        }

        return redirect()->route('superadmin.foods.index')
            ->with('success', 'Makanan berhasil diperbarui!');
    }

    /**
     * Toggle the status of the specified food.
     */
    public function toggleStatus(Food $food)
    {
        $newStatus = ($food->status === 'published') ? 'unpublished' : 'published';
        $food->update(['status' => $newStatus]);

        return redirect()->route('superadmin.foods.index')
            ->with('success', 'Status makanan berhasil diperbarui!');
    }

    /**
     * Remove the specified food from storage.
     */
    public function destroyFood(Food $food)
    {
        // Only superadmin or owner can delete
        if (auth()->user()->role !== 'superadmin' && $food->created_by !== auth()->id()) {
            return redirect()->route('not.allowed');
        }
        $food->delete();
        return back()->with('success', 'Makanan berhasil dihapus!');
    }
}
