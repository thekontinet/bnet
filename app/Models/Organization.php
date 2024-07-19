<?php

namespace App\Models;

use App\Models\Contracts\Customer as CustomerContract;
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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

/**
 * @property ?Subscription $subscription
 * @property Wallet $wallet
 * @property Collection $config
 */
class Organization extends BaseTenant implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    \Illuminate\Contracts\Auth\MustVerifyEmail,
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
        HasTenantSettings,
        SoftDeletes;

    protected $guarded = [];

    protected $table = 'organizations';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data' => 'array',
        'config' => 'collection'
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
            'deleted_at',
            'remember_token',
            'password',
            'config'
        ];
    }

    public function getForeignKey(): string
    {
        return 'organization_id';
    }

    public function getLogoUrl()
    {
        return $this->logo ? Storage::url($this->logo) : 'https://via.placeholder.com/150';
    }

    public function brandName(): Attribute
    {
        return new Attribute(
            get: fn() => $this->name
        );
    }

    public function brandDescription(): Attribute
    {
        return new Attribute(
            get: fn() => $this->description
        );
    }

    public function domain(): HasOne
    {
        return $this->domains()->one()->ofMany();
    }

    public function domains(): HasMany
    {
        return $this->hasMany(config('tenancy.domain_model'));
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
        return $this->belongsToMany(Package::class, 'organization_package')
            ->withPivot(['price', 'discount']);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
