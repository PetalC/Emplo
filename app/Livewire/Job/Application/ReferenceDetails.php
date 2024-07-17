<?php

namespace App\Livewire\Job\Application;

use App\Models\Application;
use App\Models\ReferenceCheck;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Reference\Reference;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReferenceDetails extends Component
{
    public ReferenceCheck $reference;

    public Application $application;

    #[Validate('required')]
    #[Validate('string')]
    #[Validate('max:255')]
    public string $name;

    #[Validate('required')]
    #[Validate('email')]
    #[Validate('max:255')]
    public string $email;

    #[Validate('required')]
    #[Validate('string')]
    #[Validate('max:255')]
    public string $phone_number;

    #[Validate('required')]
    #[Validate('string')]
    #[Validate('max:255')]
    public string $position;

    public function mount(){

        if( isset( $this->reference ) ){
            $this->name = $this->reference->referee?->name ?? '';
            $this->email = $this->reference->referee?->email ?? '';
            $this->phone_number = $this->reference->referee?->phone ?? '';
            $this->position = $this->reference->referee?->position ?? '';
        }

    }

    public function updated( $parameter, $value ){

        $this->validateOnly( $parameter );

        if( ! $this->reference->referee()->exists() && Validator::make( [ 'email' => $this->email ], [ 'email' => [ 'required', 'email', 'max:255' ] ] )->passes() ){

            $referee = $this->application->user->referees()->where( 'email', $this->email )->first();

            if( ! $referee ){
                $referee = $this->application->user->referees()->create([
                    'name' => $this->name ?? '',
                    'email' => $this->email,
                    'phone' => $this->phone_number ?? '',
                    'position' => $this->position ?? ''
                ]);
            }

            $this->reference->referee_id = $referee->id;

            $this->reference->save();

        }

        if( $this->reference->referee()->exists() ){

            switch( $parameter ){
                case 'name':
                    $this->reference->referee->name = $value;
                    break;
                case 'email':
                    $this->reference->referee->email = $value;
                    break;
                case 'phone_number':
                    $this->reference->referee->phone = $value;
                    break;
                case 'position':
                    $this->reference->referee->position = $value;
                    break;
            }

            $this->reference->referee->save();

        }

    }

//    public function deleteReference(){
//        $this->reference->delete();
//        $this->dispatch( 'references_updated' )->to( Documents::class );
//    }

    public function render() {
        return view('livewire.job.application.reference-details');
    }

}
