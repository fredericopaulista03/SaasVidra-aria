<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $paymentSettings = Setting::getGroup('payment');
        $emailSettings = Setting::getGroup('email');

        return view('landlord.settings.index', compact('paymentSettings', 'emailSettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Payment settings
            'asaas_api_key' => 'nullable|string',
            'asaas_environment' => 'required|in:sandbox,production',
            'asaas_webhook_token' => 'nullable|string',
            
            // Email settings
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
        ]);

        // Save payment settings
        if ($request->filled('asaas_api_key')) {
            Setting::set('asaas_api_key', $validated['asaas_api_key'], 'encrypted', 'payment');
        }
        Setting::set('asaas_environment', $validated['asaas_environment'], 'string', 'payment');
        
        if ($request->filled('asaas_webhook_token')) {
            Setting::set('asaas_webhook_token', $validated['asaas_webhook_token'], 'encrypted', 'payment');
        }

        // Save email settings
        if ($request->filled('mail_host')) {
            Setting::set('mail_host', $validated['mail_host'], 'string', 'email');
        }
        if ($request->filled('mail_port')) {
            Setting::set('mail_port', $validated['mail_port'], 'integer', 'email');
        }
        if ($request->filled('mail_username')) {
            Setting::set('mail_username', $validated['mail_username'], 'string', 'email');
        }
        if ($request->filled('mail_password')) {
            Setting::set('mail_password', $validated['mail_password'], 'encrypted', 'email');
        }
        if ($request->filled('mail_encryption')) {
            Setting::set('mail_encryption', $validated['mail_encryption'], 'string', 'email');
        }
        if ($request->filled('mail_from_address')) {
            Setting::set('mail_from_address', $validated['mail_from_address'], 'string', 'email');
        }
        if ($request->filled('mail_from_name')) {
            Setting::set('mail_from_name', $validated['mail_from_name'], 'string', 'email');
        }

        // Update runtime config
        $this->updateRuntimeConfig();

        return redirect()->route('landlord.settings.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Update runtime configuration
     */
    protected function updateRuntimeConfig()
    {
        // Update mail config
        config([
            'mail.mailers.smtp.host' => Setting::get('mail_host', config('mail.mailers.smtp.host')),
            'mail.mailers.smtp.port' => Setting::get('mail_port', config('mail.mailers.smtp.port')),
            'mail.mailers.smtp.username' => Setting::get('mail_username'),
            'mail.mailers.smtp.password' => Setting::get('mail_password'),
            'mail.mailers.smtp.encryption' => Setting::get('mail_encryption', 'tls'),
            'mail.from.address' => Setting::get('mail_from_address', config('mail.from.address')),
            'mail.from.name' => Setting::get('mail_from_name', config('mail.from.name')),
        ]);

        // Update Asaas config
        config([
            'services.asaas.api_key' => Setting::get('asaas_api_key', config('services.asaas.api_key')),
            'services.asaas.environment' => Setting::get('asaas_environment', config('services.asaas.environment')),
            'services.asaas.webhook_token' => Setting::get('asaas_webhook_token', config('services.asaas.webhook_token')),
        ]);
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            \Mail::raw('Este é um email de teste do sistema CRM Vidraçaria.', function ($message) use ($request) {
                $message->to($request->test_email)
                        ->subject('Teste de Configuração de Email');
            });

            return back()->with('success', 'Email de teste enviado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao enviar email: ' . $e->getMessage());
        }
    }
}
