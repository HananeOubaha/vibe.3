<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function toggleAutoDelete()
    {
        $setting = Setting::first();

        if ($setting) {
            $setting->auto_delete_messages = !$setting->auto_delete_messages;
            $setting->save();
        }

        return response()->json([
            'status' => 'success',
            'auto_delete' => $setting->auto_delete_messages,
        ]);
    }

    public function getAutoDeleteStatus()
    {
        $setting = Setting::first();
        return response()->json(['status' => $setting ? $setting->auto_delete_messages : false]);
    }
}
