<?php

namespace App\Http\Controllers;

use App\Models\UtmTransition;
use Illuminate\Http\Request;

class UtmController extends Controller
{
    public function trackUtm(Request $request)
    {
        $utmSource = $request->query('utm_source');
        $utmMedium = $request->query('utm_medium');
        $utmCampaign = $request->query('utm_campaign');

        UtmTransition::create([
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
        ]);

        return redirect('/home');
    }
}
