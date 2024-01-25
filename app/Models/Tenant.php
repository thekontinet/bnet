<?php

namespace App\Models;

use App\Enums\Config;
use App\Models\Contracts\Customer as CustomerContract;
use App\Models\Contracts\HasSubscription;
use App\Models\Contracts\HasTenantSettings;
use App\Models\Contracts\Payable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Rawilk\Settings\Models\HasSettings;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    TenantWithDatabase,
    CustomerContract
{
    use HasFactory,
        HasDomains,
        HasDatabase,
        Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        Notifiable,
        Payable,
        HasSubscription,
        HasTenantSettings;

    protected $guarded = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data' => 'json'
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'email_verified_at',
            'password',
        ];
    }

    public function getLogoUrl()
    {
        return $this->logo ? Storage::url($this->logo) : 'https://via.placeholder.com/150';
    }

    public function domain(): Attribute
    {
        return new Attribute(
            get: fn()=> $this->domains->last()
        );
    }

    public function websiteUrl(): Attribute
    {
        $domain = str($this->domain?->domain);
        return new Attribute(function () use($domain){
            if (str($domain)->isUrl()) {
                $domainWithProtocol = $domain->toString();
            } else {
                $domainWithProtocol = $domain->prepend('https://');

            }

            echo $domainWithProtocol;
        });
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'tenant_package')
            ->withPivot(['price', 'discount']);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
