<?php

namespace App\Policies\Nova;

use App\Traits\HasDeveloperPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

/**
 * Override nova permissions policy
 */
class GeneralResourcePolicy
{
    public function viewAny(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true
        );
    }

    public function view(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    public function create(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    public function update(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    public function delete(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    public function restore(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    public function forceDelete(): bool
    {
        return Nova::whenServing(
            fn(NovaRequest $request) => $this->canNovaManageGeneral(),
            fn(Request $request) => true);
    }

    private function canNovaManageGeneral() {
        return Auth::user()->can('nova.manage.general');
    }

}
