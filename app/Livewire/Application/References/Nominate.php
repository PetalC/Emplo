<?php

namespace App\Livewire\Application\References;

use App\Enums\ApplicationReferenceCheckStatuses;
use App\Models\Application;
use App\Models\ReferenceCheck;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Nominate extends Component
{

    public ReferenceCheck $reference;

    #[Locked]
    public Application $application;

    public array $references = [];
//        [
//            'full_name' => '',
//            'email' => '',
//            'phone_number' => '',
//            'position' => '',
//        ]
//    ];

    public $min_references = 1;

    protected $reference_rules = [
        'references' => 'array',
        'references.*.full_name' => 'required|string',
        'references.*.email' => 'required|email',
        'references.*.phone_number' => 'required|string',
        'references.*.position' => 'required|string',
    ];

    public function mount()
    {

        if (isset($this->reference)) {
            $this->name = $this->reference->referee?->name ?? '';
            $this->email = $this->reference->referee?->email ?? '';
            $this->phone_number = $this->reference->referee?->phone ?? '';
            $this->position = $this->reference->referee?->position ?? '';
        }

    }


    public function addReference()
    {
        $this->references[] = [
            'full_name' => '',
            'email' => '',
            'phone_number' => '',
            'position' => '',
        ];
    }

    public function removeReference($index)
    {
        unset($this->references[$index]);
    }

    public function saveReferences()
    {

        $this->validate($this->reference_rules);

        if ($this->application) {

            // Adding additional checks, rather than replacing?
            $this->application->reference_checks()->delete();

            foreach ($this->references as $reference) {

                $referee = $this->application->user->referees()->where('email', $reference['email'])->first();

                if (!$referee) {
                    $referee = $this->application->user->referees()->create([
                        'name' => $reference['full_name'],
                        'email' => $reference['email'],
                        'phone' => $reference['phone_number'],
                        'position' => $reference['position'],
                    ]);
                }

                $reference_check = $this->application->reference_checks()->create([
                    'ulid' => Str::ulid(now()),
                    'referee_id' => $referee->id,
                    'candidate_id' => $this->application->user->id,
                    'status' => ApplicationReferenceCheckStatuses::INTRO,
                    'comment' => '',
                ]);

            }

        }

    }


    public function render()
    {
        return view('livewire.application.references.nominate');
    }

}
