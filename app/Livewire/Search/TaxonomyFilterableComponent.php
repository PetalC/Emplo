<?php

namespace App\Livewire\Search;

use App\Enums\EmptySearchTypes;
use App\Mail\EmptyJobSearchMail;
use App\Mail\EmptySchoolSearchMail;
use App\Mail\EmptyTaxonomyFilterSearchMail;
use App\Models\Curriculum;
use App\Models\JobLength;
use App\Models\PositionTitle;
use App\Models\PositionType;
use App\Models\Subject;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TaxonomyFilterableComponent extends Component
{

    /**
     * Determines how many taxonomy filter results can load
     */
    const TAXONOMY_FILTER_RESULT_LIMIT = 8;
    public string $noTaxonomyResultsText;

    /**
     * Human readable label for the given taxonomy model
     * @var string[]
     */
    private $taxonomyLabelModelMap = [
        PositionTitle::class => 'Position Title',
        PositionType::class => 'Position Type',
        Subject::class => 'Subject',
        Curriculum::class => 'Curriculum',
    ];

    public function mount(){
        $this->noTaxonomyResultsText = 'No Results';
    }

    /**
     * Generalised lookup taxonomy model by name
     *
     * @param string $taxonomyModel
     * @param $value
     * @return mixed
     */
    protected function search_taxonomies_by_name(string $taxonomyModel, $value)
    {
        $model = new $taxonomyModel();
        $query = $model->query();
        $results = $query
            ->where( 'name', 'LIKE', '%' . $value . '%')
            ->limit(self::TAXONOMY_FILTER_RESULT_LIMIT)
            ->get();
        if ($results->isEmpty()) {
            $this->report_empty_result(EmptySearchTypes::TAXONOMY_FILTER_SEARCH, ['type' => $this->labeliseTaxonomyClass($taxonomyModel), 'value' => $value]);
        }
        return $results;
    }


    protected function get_search_taxonomy_filters() {
        $search_filters = [];
        foreach ($this->filters as $type => $filter) {
            if (!is_array($filter) || empty($filter)) {
                continue;
            }
            foreach ($filter as $value) {
                $search_filters[$type][] = $value;
            }
        }
        return $search_filters;
    }

    protected function report_empty_result(EmptySearchTypes $searchType, array $data = [])
    {
        if (env('APP_ENV' ) !== 'local'){
            // disable reporting empty results for now @Ben - nice to give once they request it
            return;
        }
        // Diagnosing
        switch ($searchType) {
            case EmptySearchTypes::JOB_SEARCH:
                // TODO: probably want to have a search results stats table or something to handle at scale
                $search_filters = $this->get_search_taxonomy_filters();
                // Notify employo when job searches are empty (to improve taxonomies)
                if($search_filters) {
                    Mail::to(env('MAIL_EMPLOYO_SUPPORT', 'ben.casey@humanpixel.com.au'))->send(
                        new EmptyJobSearchMail($search_filters)
                    );
                }
                break;
            case EmptySearchTypes::SCHOOL_SEARCH:
                // TODO: probably want to have a search results stats table or something to handle at scale
                $search_filters = $this->get_search_taxonomy_filters();
                // Notify employo when school searches are empty (to improve taxonomies)
                if($search_filters) {
                    Mail::to(env('MAIL_EMPLOYO_SUPPORT', 'ben.casey@humanpixel.com.au'))->send(
                        new EmptySchoolSearchMail($this->get_search_taxonomy_filters())
                    );
                }
                break;
            case EmptySearchTypes::TAXONOMY_FILTER_SEARCH:
                // TODO: probably want to have a search results stats table or something to handle at scale
                // Notify employo when filter searches are empty (to improve taxonomies)
                Mail::to(env( 'MAIL_EMPLOYO_SUPPORT', 'ben.casey@humanpixel.com.au' ) )->send(
                    new EmptyTaxonomyFilterSearchMail($data['type'], $data['value'])
                );
            default:
        }

    }

    private function labeliseTaxonomyClass(string $taxonomyModel)
    {
        $parts = explode('\\', $taxonomyModel);
        $taxonomyName = $parts[count($parts)-1];
        // Add a space before all capital letters
        return ltrim(preg_replace('/[A-Z]/', ' $0', $taxonomyName));
    }


}
