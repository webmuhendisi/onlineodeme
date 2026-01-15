<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\ActiveDirectoryService;
use App\Services\LogoAccountingService;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit()
    {
        $this->requireAdmin();
        $keys = ['AD_HOST','AD_BASE_DN','AD_USERNAME','AD_PASSWORD','LOGO_API_URL','LOGO_CLIENT_ID','LOGO_CLIENT_SECRET'];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::getValue($key, env($key));
        }
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->requireAdmin();
        $keys = ['AD_HOST','AD_BASE_DN','AD_USERNAME','AD_PASSWORD','LOGO_API_URL','LOGO_CLIENT_ID','LOGO_CLIENT_SECRET'];
        $request->validate(array_fill_keys($keys, 'nullable|string'));
        foreach ($keys as $key) {
            Setting::setValue($key, $request->input($key));
        }
        return redirect()->route('admin.settings.edit')->with('status','Ayarlar kaydedildi');
    }

    public function sync()
    {
        $this->requireAdmin();
        $payments = Payment::with('invoice')->get();
        $logo = new LogoAccountingService();
        foreach ($payments as $payment) {
            $logo->sendPayment($payment);
        }
        return back()->with('status', 'Senkronizasyon tamamlandı');
    }
}
