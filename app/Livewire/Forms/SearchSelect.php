<?php

namespace App\Livewire\Forms;

use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SearchSelect extends Component {


    #[Locked]
    public $id;

    /**
     * Collection of options for this select
     */
    public array $options;

    /**
     * If no $options are present, this component can be passed in a model class to search. If not defined, the search event will fire
     */
    #[Locked]
    public ?string $model = null;

    /**
     * ID Key to use when searching either the model of the options.
     */
    #[Locked]
    public string $id_key = 'id';

    /**
     * Value key to use when searching either the model of the options.
     */
    #[Locked]
    public string $value_key = 'name';

    #[Modelable]
    public mixed $selected;

    public string $selected_text = '';

    /**
     * Holder for the value of the search input.
     *
     * @var string|null
     */
    public string $search_value = '';

    /**
     * Label for the input
     *
     * @var string
     */
    public string $label = '';

    public bool $show_dropdown = false;

    #[Reactive]
    public string|bool|null $error_message;

    public string $placeholder = 'Search...';

    public string|bool $variant = false;

    public function handleSearch() {

        if ( $this->search_value && $this->model ) {
            /**
             * @var Builder $query
             */
            $query = call_user_func([$this->model, 'query']);

            $this->options = $query->where($this->value_key, 'LIKE', '%'.$this->search_value.'%')->take( 20 )->pluck($this->value_key, $this->id_key)->toArray();

        } else {
            $this->options = [];
        }

    }

    public function updatedSearchValue() {
        $this->handleSearch();
    }

    public function handleSelectOption($option_key) {

        $option = isset($this->options[$option_key]) ? $this->options[$option_key] : false;

        $this->selected = $option_key;
        $this->selected_text = $option;

        $this->show_dropdown = false;

    }

    public function render() {
        return view('livewire.forms.search-select');
    }

}
