<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant
{
    use HasDomains;

    protected $fillable = ['id', 'data', 'website', 'owner_phone', 'document'];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'data',
        ];
    }

    /**
     * Get the subscriptions for the tenant.
     */
    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class);
    }

    /**
     * Get the company name from data column.
     */
    public function getCompanyNameAttribute()
    {
        return $this->data['company_name'] ?? $this->id;
    }

    /**
     * Get formatted phone number.
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->owner_phone) {
            return '';
        }

        $phone = preg_replace('/[^0-9]/', '', $this->owner_phone);
        
        if (strlen($phone) == 11) {
            // (00) 00000-0000
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7);
        } elseif (strlen($phone) == 10) {
            // (00) 0000-0000
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6);
        }
        
        return $this->owner_phone;
    }

    /**
     * Get formatted document (CPF or CNPJ).
     */
    public function getFormattedDocumentAttribute()
    {
        if (!$this->document) {
            return '';
        }

        $document = preg_replace('/[^0-9]/', '', $this->document);
        
        if (strlen($document) == 11) {
            // CPF: 000.000.000-00
            return substr($document, 0, 3) . '.' . substr($document, 3, 3) . '.' . substr($document, 6, 3) . '-' . substr($document, 9, 2);
        } elseif (strlen($document) == 14) {
            // CNPJ: 00.000.000/0000-00
            return substr($document, 0, 2) . '.' . substr($document, 2, 3) . '.' . substr($document, 5, 3) . '/' . substr($document, 8, 4) . '-' . substr($document, 12, 2);
        }
        
        return $this->document;
    }
}
