<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Donation;
use App\Models\ExtraSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::find(1);
        $es = ExtraSetting::find(1);
        $donation = Donation::find(1);

        return view('pages.settings.form', compact('settings', 'es', 'donation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {

        // dd($request->all());
        //
       $validated = $request->validate([
            // General Tab
            'site_name'    => 'required|string|max:255',
            'site_address' => 'nullable|string|max:255',
            'site_email'   => 'email',
            'phone'        => 'nullable|string|max:20',
            'logo'         => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048', // 2MB Max
            'icon'         => 'nullable|image|mimes:ico,png|max:512',      // 512KB Max

            // Socials & Media Tab
            'social_facebook'  => 'nullable|url',
            'social_twitter'   => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_youtube'  => 'nullable|url',
            'intro_video_url'  => 'nullable|url',

            // Footer Tab (Using corrected names)
            'cp_title' => 'nullable|string|max:255',
            'cp_text'  => 'nullable|string',

            // Donations Tab
            'donation_bkash'  => 'nullable|string|max:20',
            'donation_nagad'  => 'nullable|string|max:20',
            'donation_rocket' => 'nullable|string|max:20',
            'bank_account_name'   => 'nullable|string|max:255', // Account Name
            'bank_account_number'   => 'nullable|string|max:255', // Account Number
            'bank_name'   => 'nullable|string|max:255', // Bank Name
            'branch'   => 'nullable|string|max:255', // Branch
            'routing'   => 'nullable|string|max:255', // Routing
        ]);
        // 2. DATA PROCESSING
        // ====================

        // --- Handle General Settings (Setting Model) ---
        $settings = Setting::firstOrFail(); // Assuming there's only one row for settings
        $settings->update([
            'site_name' => $validated['site_name'],
            'address'   => $validated['site_address'],
            'email'     => $validated['site_email'],
            'phone'     => $validated['phone'],
        ]);

        if ($request->hasFile('logo')) {
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            $settings->update(['logo' => $logoPath]);
        }

        if ($request->hasFile('icon')) {
            if ($settings->icon && Storage::disk('public')->exists($settings->icon)) {
                Storage::disk('public')->delete($settings->icon);
            }
            $iconPath = $request->file('icon')->store('settings', 'public');
            $settings->update(['icon' => $iconPath]);
        }


        $es = ExtraSetting::firstOrFail();
        $es->update([
            'facebook'  => $validated['social_facebook'],
            'twitter'   => $validated['social_twitter'],
            'instagram' => $validated['social_instagram'],
            'youtube'  => $validated['social_youtube'],
            'embedded_url'   => $validated['intro_video_url'],
            'cp_title'  => $validated['cp_title'],
            'cp_text'   => $validated['cp_text'],
        ]);

        // --- Handle Donations (Donation Model) ---
        $donation = Donation::firstOrFail();
        $donation->update([
            'bkash'         => $validated['donation_bkash'],
            'nagad'         => $validated['donation_nagad'],
            'rocket'        => $validated['donation_rocket'],
            'account_name'  => $request->input('bank_account_name'),
            'account_number'=> $request->input('bank_account_number'),
            'bank'          => $request->input('bank_name'),
            'branch'        => $request->input('branch'),
            'routing'       => $request->input('routing'),
        ]);


        // 3. REDIRECT
        // =============
        return back()->with('success', 'Settings have been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
