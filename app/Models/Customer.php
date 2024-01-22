<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Contracts\HasWallet;
use App\Models\Contracts\Payable;
use App\Models\Contracts\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Customer extends Authenticatable implements Contracts\Customer
{
    use HasApiTokens, HasFactory, Notifiable, BelongsToTenant, Payable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->getAttribute('firstname') . ' ' . $this->getAttribute('lastname'),
            set: function(string $value){
                $names = explode($value, ' ');
                $this->setAttribute('firstname', $names[0] ?? '');
                $this->setAttribute('lastname', $names[1] ?? '');
            }
        );
    }
}
