<?php

namespace App\Models;

class Domain extends \Stancl\Tenancy\Database\Models\Domain
{
    public function tenant()
    {
        return $this->belongsTo(config('tenancy.tenant_model'), 'organization_id');
    }
}
