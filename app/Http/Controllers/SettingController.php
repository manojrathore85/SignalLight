<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'a' => 'required|numeric',
            'b' => 'required|numeric',
            'c' => 'required|numeric',
            'd' => 'required|numeric',
            'green_interval' => 'required|numeric',
            'yellow_interval' => 'required|numeric',
        ]);
       
        try {
            $setting = Setting::all()->first();
            if ($setting) {                
                $setting->a = $request->a;
                $setting->b = $request->b;
                $setting->c = $request->c;
                $setting->d = $request->d;
                $setting->green_interval = $request->green_interval;
                $setting->yellow_interval = $request->yellow_interval;
                $setting->save();
            } else {
                $setting = Setting::create([
                    'a' => $request->a,
                    'b' => $request->b,
                    'c' => $request->c,
                    'd' => $request->d,
                    'green_interval' => $request->green_interval,
                    'yellow_interval' => $request->yellow_interval,
                ]);
            }
            return response([
                'status' => true, 
                'message' => 'record updated successfuly', 
        ], 200);
        } catch (\Exception $e) {
            return response([
                 'status' => false,  
                'message' => 'Getting Error: ' . $e
            ], 500);
        }
    }
    public function getSetting(){
        $setting = setting::all()->first();
        return view('welcome',compact('setting'));
    }
}
