<?php

namespace App\Policies\Nova;

use App\Traits\HasDeveloperPermissions;

/**
 * Override nova permissions policy
 */
class PermissionPolicy extends \Vyuldashev\NovaPermission\PermissionPolicy
{
    use HasDeveloperPermissions;
    public function viewAny(): bool
    {
        return $this->isDeveloperUser();
    }

    public function view(): bool
    {
        return $this->isDeveloperUser();
    }

    public function create(): bool
    {
        return $this->isDeveloperUser();
    }

    public function update(): bool
    {
        return $this->isDeveloperUser();
    }

    public function delete(): bool
    {
        return $this->isDeveloperUser();
    }

    public function restore(): bool
    {
        return $this->isDeveloperUser();
    }

    public function forceDelete(): bool
    {
        return $this->isDeveloperUser();
    }

}
