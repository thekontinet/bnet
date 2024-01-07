<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    TenantWithDatabase
{
    use HasFactory,
        HasDomains,
        HasDatabase,
        Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        Notifiable;

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
            'username',
            'email',
            'email_verified_at',
            'password',
        ];
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'tenant_package')
            ->withPivot(['price', 'discount']);
    }
}
