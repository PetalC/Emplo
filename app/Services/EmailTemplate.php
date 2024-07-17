<?php

namespace App\Services;

use App\Enums\MediaCollections;
use App\Models\School;
use Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Handle email templates loading, merge tag replacement, rendering for preview etc
 */
class EmailTemplate
{
    /**
     * Load available email templates for the given school
     * @param School $school
     * @return array - label: template content
     */
//    public function loadAvailable(School $school, string $templatePath = null): \Illuminate\Support\Collection
    public function loadAvailable(School $school, string $templatePath = null): array
    {

        if (!$templatePath) {
            $templatePath = resource_path('views/email_templates');
        }

        $templates = [];

        $files = File::files($templatePath);
        foreach ($files as $templateFile) {
            $title = explode('.',basename($templateFile))[0];
//            $template = new \App\Models\EmailTemplate();
//            $template->setLabel(Str::headline($title))
//                ->setSubject('Email subject prefilled - defined in file?')
//                ->setContent(trim(File::get($templateFile)));
//            $templates[] = $template;
            $templates[Str::headline($title)] = trim(File::get($templateFile));
        }
//        return collect($templates);
        return $templates;
    }
}
