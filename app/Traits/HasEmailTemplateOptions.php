<?php

namespace App\Traits;

use App\Facades\EmailTemplateFacade;
use App\Models\EmailTemplate;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;

/**
 * Load email template options to show in forms
 */
trait HasEmailTemplateOptions
{
    #[Locked]
    /**
     * Email templates - made up of system provided (Employo Templates) and schools custom templates
     * Defined in the Resource Library
     * @var array
     * [<index>: <template_label>]
     */
    public array $email_template_options;

    /**
     * //     * @var Collection<EmailTemplate>
     * @var array
     * [<template_label>: <template_content>]
     */
//    public Collection $email_template_data;
    public array $email_template_data;
    protected function loadEmailTemplates()
    {
        $school = session()->get('current_school');
        $this->email_template_data = EmailTemplateFacade::loadAvailable($school);
//        $this->email_template_data = EmailTemplateFacade::loadAvailable($school);
//        $this->email_template_options = $this->email_template_data->pluck('label')->toArray();
        $this->email_template_options = array_keys($this->email_template_data);
    }

}
