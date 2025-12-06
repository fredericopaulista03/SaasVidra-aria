<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only load settings if database is ready
        if (Schema::hasTable('settings')) {
            $this->loadMailConfig();
            $this->loadPaymentConfig();
        }
    }

    /**
     * Load mail configuration from database
     */
    protected function loadMailConfig(): void
    {
        $mailHost = Setting::get('mail_host');
        $mailPort = Setting::get('mail_port');
        $mailUsername = Setting::get('mail_username');
        $mailPassword = Setting::get('mail_password');
        $mailEncryption = Setting::get('mail_encryption');
        $mailFromAddress = Setting::get('mail_from_address');
        $mailFromName = Setting::get('mail_from_name');

        if ($mailHost) {
            config(['mail.mailers.smtp.host' => $mailHost]);
        }
        if ($mailPort) {
            config(['mail.mailers.smtp.port' => $mailPort]);
        }
        if ($mailUsername) {
            config(['mail.mailers.smtp.username' => $mailUsername]);
        }
        if ($mailPassword) {
            config(['mail.mailers.smtp.password' => $mailPassword]);
        }
        if ($mailEncryption) {
            config(['mail.mailers.smtp.encryption' => $mailEncryption]);
        }
        if ($mailFromAddress) {
            config(['mail.from.address' => $mailFromAddress]);
        }
        if ($mailFromName) {
            config(['mail.from.name' => $mailFromName]);
        }
    }

    /**
     * Load payment configuration from database
     */
    protected function loadPaymentConfig(): void
    {
        $asaasApiKey = Setting::get('asaas_api_key');
        $asaasEnvironment = Setting::get('asaas_environment');
        $asaasWebhookToken = Setting::get('asaas_webhook_token');

        if ($asaasApiKey) {
            config(['services.asaas.api_key' => $asaasApiKey]);
        }
        if ($asaasEnvironment) {
            config(['services.asaas.environment' => $asaasEnvironment]);
        }
        if ($asaasWebhookToken) {
            config(['services.asaas.webhook_token' => $asaasWebhookToken]);
        }
    }
}
