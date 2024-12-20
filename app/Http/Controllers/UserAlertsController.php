<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class UserAlertsController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        return Jetstream::inertia()->render($request, 'Alerts/Show', [
            'countries' => Country::orderBy('name')->get(['id','name']),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'creating' => 'required|boolean',
            'updating' => 'required|boolean',
            'uvi' => 'required',
            'precipitation' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        if($request->get('updating') && $request->get('id')) {
            Alert::find($request->get('id'))->update([
                'uvi' => $request->get('uvi'),
                'precipitation' => $request->get('precipitation'),
            ]);
        } else if ($request->get('creating')) {
            $alert = Alert::create([
                'user_id' => $request->user()->id,
                'country_id' => $request->get('country_id'),
                'city_id' => $request->get('city_id'),
                'uvi' => $request->get('uvi'),
                'precipitation' => $request->get('precipitation'),
            ]);
            return response()->json($alert->id);
        }
        return response()->json();
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        Alert::find($request->route('id'))->delete();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCities(Request $request): JsonResponse
    {
        return response()->json([
            'cities' => City::where('country_id', $request->get('country_id'))->orderBy('name')->get(['id','name']),
        ]);
    }
}
