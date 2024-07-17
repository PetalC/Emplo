<?php

use App\Facades\EmailTemplateFacade;
use App\Models\School;

test('Email Templates loads something', function () {
    $school = $this->createMock(School::class);
    // Default path has to have template files
    expect(EmailTemplateFacade::loadAvailable($school))->not()->toBeEmpty();
});
