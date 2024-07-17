<?php

namespace App\Livewire\JobCenter;

use App\Enums\JobBoardTypes;
use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\LicencingAuthorityTypes;
use App\Enums\SalaryTypes;
use App\Enums\VacancyReasons;
use App\Models\Campus;
use App\Models\Job;
use App\Models\JobBoardPostings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Enums\MediaCollections;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class EditJob extends Component {

    use WithFileUploads;

    #[Locked]
    public Job|null $job = null;

    public string|null $status;

    public array $fields = [
        'title' => '',
        'description' => '',
        'responsibilities' => '',
        'required_licence_certs' => '',
        'salary_min' => '',
        'salary_max' => '',
        'salary_type' => '',
        'offers_relocation' => '',
        'offers_housing' => '',
//        'position_title_id' => '',
        'location_type_id' => '',
        'job_length_id' => '',
        'job_type' => JobType::FULLTIME,
        'position_type_id' => '',
        'start_date' => '',
        'licencing_authority' => '',
        'campus_id' => 0,
        'subjects' => [],
        'vacancy_reason' => '',
        'job_boards' => [],
        'terms_conditions' => false,
        'billing_policy' => false,
        'applicant_routing_preference' => 'Employo',
        'external_application_url' => '',
    ];

    public MediaCollection $supporting_documents;

    public string|TemporaryUploadedFile $uploadFile = '';

    public array $salary_options = [];

    public array $panel_member_options = [];

    public array $panel_members = [];

    public bool $form_submitted = true;

    public bool $has_errors = false;
    public bool $display_share = false;

    public $available_campuses = [];

    public function rules(){
        return [
            'uploadFile' => 'sometimes|nullable|file|max:2048',
            'fields.title' => 'required|string|max:255',
            'fields.description' => 'required|string|max:3000',
            'fields.selling_points' => 'required|string|max:3000',
            'fields.responsibilities' => 'required|string|max:3000',
            'fields.campus_id' => 'required|exists:campuses,id',
            'fields.job_type' => [ 'required', ( new Enum( JobType::class ) ) ],
            'fields.salary_min' => 'required|numeric',
            'fields.salary_max' => 'required|numeric',
            'fields.salary_type' => [ 'required', ( new Enum( SalaryTypes::class ) ) ],
            'fields.offers_relocation' => 'sometimes|nullable|boolean',
            'fields.offers_housing' => 'sometimes|nullable|boolean',
            'fields.job_length_id' => 'required|numeric',
            'fields.position_type_id' => 'required|numeric',
            'fields.start_date' => 'required|date_format:j/n/Y',
            'fields.licencing_authority' => [ 'required', ( new Enum( LicencingAuthorityTypes::class ) ) ],
            'fields.subjects' => 'required|array',
            'fields.subjects.*' => 'required|min:1|exists:subjects,name',
            'fields.terms_conditions' => 'accepted|boolean',
            'fields.billing_policy' => 'accepted|boolean',
            'fields.vacancy_reason' => [ 'required', ( new Enum( VacancyReasons::class ) ) ],
            'panel_members' => 'array',
//            'panel_members.*' => '',
            'fields.job_boards' => 'required|array|min:1',
            'fields.job_boards.*' => [ 'sometimes', 'nullable', ( new Enum( JobBoardTypes::class ) ) ],
            'fields.routing_preference' => 'required|string',
            'fields.external_application_url' => 'sometimes|nullable|url|required_if:fields.applicant_routing_preference,External Application',
        ];
    }

    public function messages(){

        return [
            'uploadFile.max' => 'The file must be less than 2MB',
            'uploadFile.file' => 'Please upload a file',
            'fields.title.required' => 'Please enter a job title',
            'fields.title.max' => 'Please enter a shorter job title',
            'fields.description.required' => 'Please enter a job description',
            'fields.description.max' => 'Please enter a shorter job description',
            'fields.responsibilities.required' => 'Please enter a job responsibilities description',
            'fields.responsibilities.max' => 'Please enter a shorter job responsibilities description',
            'fields.campus_id.required' => 'Please select a campus',
            'fields.job_type.required' => 'Please select a job type',
            'fields.salary_min.required' => 'Please enter a minimum salary',
            'fields.salary_min.numeric' => 'Minimum salary must be a number',
            'fields.salary_max.required' => 'Please enter a maximum salary',
            'fields.salary_max.numeric' => 'Maximum salary must be a number',
            'fields.salary_type.required' => 'Please select a salary type',
            'fields.start_date.required' => 'Please enter a start date',
            'fields.license_authority.required' => 'Please select a licensing authority',
            'fields.subjects.required' => 'Please select at least one subject',
            'fields.subjects.*.min' => 'Please select at least one subject',
            'fields.terms_conditions.accepted' => 'Please accept the terms and conditions',
            'fields.billing_policy.accepted' => 'Please accept the billing policy',
            'fields.panel_members.required' => 'Please select at least one panel member',
            'fields.panel_members.*.min' => 'Please select at least one panel member',
            'fields.job_boards.required' => 'Please select at least one job board',
            'fields.job_boards.min' => 'Please select at least one job board',
            'fields.routing_preference.required' => 'Please select a routing preference',
            'fields.external_application_url.required_if' => 'Please enter the URL to route applicants to',
            'fields.external_application_url.url' => 'Please enter a valid URL',
        ];

    }

    public function mount(){

        // Grab the selected school & campus from the session
        if( is_null( $this->job ) ){
            $this->redirect( route('school.jobcenter.create' ) );
        }

//        $this->authorize('update', $this->job );

        $this->fields['campus_id'] = $this->job->campus_id;
        $this->fields['status'] = $this->job->status ?? JobStatus::DRAFT;
        $this->fields['title'] = $this->job->title ?? '';
        $this->fields['description'] = $this->job->description ?? '';
        $this->fields['selling_points'] = $this->job->selling_points ?? '';
        $this->fields['responsibilities'] = $this->job->responsibilities ?? '';
        $this->fields['salary_min'] = $this->job->salary_min ?? 0;
        $this->fields['salary_max'] = $this->job->salary_max ?? 0;
        $this->fields['salary_type'] = $this->job->salary_type ?? SalaryTypes::SALARY;
        $this->fields['offers_relocation'] = $this->job->offers_relocation ?? false;
        $this->fields['offers_housing'] = $this->job->offers_housing ?? false;
        $this->fields['job_length_id'] = $this->job->job_length_id ?? null;
        $this->fields['position_type_id'] = $this->job->position_type_id ?? null;
        $this->fields['start_date'] = $this->job->start_date?->format( 'd/m/Y' ) ?? Carbon::now()->format( 'j/n/Y' );
        $this->fields['licencing_authority'] = $this->job->licencing_authority ?? LicencingAuthorityTypes::OTHER;
        $this->fields['subjects'] = $this->job->subjects?->pluck( 'name', 'id' )->toArray();
        $this->fields['vacancy_reason'] = $this->job->vacancy_reason ?? VacancyReasons::OTHER;
        $this->fields['licencing_authority'] = $this->job->licencing_authority ?? '';
        $this->fields['job_boards'] = $this->job->postings->pluck( 'job_board' )->toArray();
        $this->fields['routing_preference'] = $this->job->routing_preference ?? 'Employo';
        $this->fields['external_application_url'] = $this->job->external_application_url ?? '';


        //Set form submitted to false so the success notification does not display if the user refreshes.
        $this->form_submitted = false;

        $campuses = Campus::with( 'primary_profile' )->where('school_id', $this->job->school_id )->get();

        foreach( $campuses as $campus ){
            $this->available_campuses[$campus->id] = $campus->primary_profile?->name ?? $campus->school->name;
        }

    }

    public function removeDocument( $document_id ): void
    {

        if (!auth()->user()->can('school.manage-jobs')) {
            session()->flash('error', 'You do not have permission to perform this action.');
            return;
        }

        try {
            $this->job->media()->where( 'id', '=', $document_id )->first()->delete();
            session()->flash('message', 'Document deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting document.');
        }
    }

     public function updated( $field, $value ) {
         $this->validateOnly( $field );

         switch( $field ) {
            case 'uploadFile':
                $collectionName = MediaCollections::JOBCENTRE_JOB_DOCUMENTS->value;

                $this->job->addMedia( $this->uploadFile )->toMediaCollection( $collectionName );

                $this->uploadFile = '';

                break;

            case 'fields.title':
            case 'fields.campus_id':
            case 'fields.position_type_id':
            case 'fields.job_type':
            case 'fields.job_length_id':
            case 'fields.vacancy_reason':
            case 'fields.salary_min':
            case 'fields.salary_max':
            case 'fields.salary_type':
            case 'fields.start_date':
            case 'fields.licencing_authority':
            case 'fields.description':
            case 'fields.responsibilities':
            case 'fields.offers_relocation':
            case 'fields.offers_housing':
            case 'fields.routing_preference':
            case 'fields.external_application_url':
            case 'fields.selling_points':

                $_field = Str::after( $field, '.' );

                $this->job->update( [
                    $_field => $value,
                ] );

                break;

             default:
                 break;
         }

         if( Str::contains( $field, 'fields.subjects' ) ){
             $this->job->subjects()->sync( array_keys( $this->fields['subjects'] ) );
         }

         if( Str::contains( $field, 'panel_members' ) ){
             $this->job->panel_members()->sync( array_keys( $this->panel_members ) );
         }

         if( Str::contains( $field, 'job_boards' ) ){
             $this->job->postings()->delete();

             foreach( $this->fields['job_boards'] as $job_board ){

                 $posting = $this->job->postings()->create( [
                     'job_board' => $job_board,
                     'credit_cost' => 0,//@TODO
                 ] );

                 $posting->save();
             }

         }

     }

     public function save_open(){
        $this->job->status = JobStatus::OPEN;
        $this->job->save();
        $this->display_share = true;
        $this->render();
     }

    public function save_closed(){
        $this->job->status = JobStatus::CLOSED;
        $this->job->save();
        $this->render();
    }

    public function submitForm() {
        try {
            $wat = $this->validate();
        } catch ( \Illuminate\Validation\ValidationException $e ) {
            $this->has_errors = true;
            throw $e;
        }

        Cache::forget( 'candidate_statistics_' . $this->job->id );

        $this->job->update( [
            'title' => $this->fields['title'],
            'campus_id' => $this->fields['campus_id'],
            'position_type_id' => $this->fields['position_type_id'],
            'employment_type' => $this->fields['job_type'],
            'job_length_id' => $this->fields['job_length_id'],
            'vacancy_reason' => $this->fields['vacancy_reason'],
            'salary_min' => $this->fields['salary_min'],
            'salary_max' => $this->fields['salary_max'],
            'salary_type' => $this->fields['salary_type'],
            'start_date' => $this->fields['start_date'],
            'description' => $this->fields['description'],
            'responsibilities' => $this->fields['responsibilities'],
            'offers_relocation' => $this->fields['offers_relocation'],
            'offers_housing' => $this->fields['offers_housing'],
            'licencing_authority' => $this->fields['licencing_authority'],
        ] );

        $this->job->subjects()->sync( array_keys( $this->fields['subjects'] ) );

        $this->job->panel_members()->sync( array_keys( $this->panel_members ) );

        $this->job->save();

        // TODO - Nuking the postings will remove any posted_at / posted_response data, should we persist this instead?
        $this->job->postings()->delete();

        foreach( $this->fields['job_boards'] as $job_board ){
            $posting = $this->job->postings()->create( [
                'job_board' => $job_board,
                'credit_cost' => 0,//@TODO
            ] );

            $posting->save();
        }

        $this->form_submitted = true;

    }

    public function render() {

        $this->supporting_documents = $this->job->getMedia(MediaCollections::JOBCENTRE_JOB_DOCUMENTS->value);

        $this->panel_members = $this->job->panel_members->pluck( 'name', 'id' )->toArray();

        //@TODO Is this the correct way to get the panel members?
        $this->panel_member_options = $this->job->school->users->pluck('name', 'id')->toArray();

        return view('livewire.job-center.edit-job');
    }
}
