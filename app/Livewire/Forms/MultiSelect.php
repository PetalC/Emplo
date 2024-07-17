<?php

namespace App\Livewire\Forms;

use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class MultiSelect extends Component {

    const EVENT_ACTIONED_OPTION = 'multiselect-actioned-option';
    const EVENT_REMOVED_OPTION = 'multiselect-removed-option';
    const EVENT_ADDED_OPTION = 'multiselect-added-option';
    const EVENT_SEARCH = 'multiselect-search';

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

    /**
     * Array of selected elements
     *
     * @var Collection
     */
    #[Modelable]
    public array|null $selected = [];

    /**
     * Boolean flag to enable or disable the create new field.
     *
     * @var bool
     */
    public $create_new = false;

    /**
     * Boolean flag to enable or disable the search field.
     *
     * @var bool
     */
    public bool $withSearch = false;

    /**
     * Boolean flag to enable or disable removing selections.
     *
     * @var bool
     */
    public bool $withRemove = true;

    /**
     * Boolean flag to enable or disable the dropdown (false when wanting uneditable multi select items)
     *
     * @var bool
     */
    public bool $withDropdown = true;

    /**
     * Boolean flag to show the border underneath the selected chips
     *
     * @var bool
     */
    public bool $withBorder = true;

    /**
     * Boolean flag to add a clickable element to run an action for the selected chip
     *
     * @var bool
     */
    public bool $withSelectedAction = false;

    public string|bool $variant = false;

    public string $badge_style = 'pill';

    /**
     * Holder for the value of the create new input.
     *
     * @var string|null
     */
    //    public string|null $create_new_value;

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

    public function handleCreateNew() {

        //Disabled for EMPLO If this functionality is required we can re-enable it.
        return false;

        /**
         * If we are using a model, we can attempt to create one here.
         */
        if ($this->model) {

            try {

                $item = new ($this->model);
                $item->{$this->value_key} = $this->search_value;
                $item->save();

                $this->selected[$item->id] = $item->{$this->value_key};

                $this->search_value = '';

                $this->show_dropdown = false;

            } catch (\Throwable $e) {}

        }

        /**
         * Otherwise the parent needs to implement a listener.
         */
        $this->dispatch('multiselect-add-new', $this->search_value);

    }

    public function handleSearch() {

        if ( $this->search_value && $this->model ) {
            /**
             * @var Builder $query
             */
            $query = call_user_func([$this->model, 'query']);

            $this->options = $query->where($this->value_key, 'LIKE', '%'.$this->search_value.'%')->pluck($this->value_key, $this->id_key)->toArray();

        } else {
            $this->dispatch(self::EVENT_SEARCH, $this->search_value);
        }

    }

    public function updatedSearchValue() {
        $this->handleSearch();
    }

    public function handleRemoveOption($option_key) {

        if (isset($this->selected[$option_key])) {
            unset($this->selected[$option_key]);
        }

        $this->dispatch( self::EVENT_REMOVED_OPTION, $option_key );

    }

    public function handleSelectOption($option_key) {

        $option = isset($this->options[$option_key]) ? $this->options[$option_key] : false;

        if ($option) {
            if ( ! $this->selected ) {
                $this->selected = [];
            }
            $this->selected[$option_key] = $option;
        }

        $this->dispatch( self::EVENT_ADDED_OPTION, $option_key );

    }

    public function handleSelectedAction($key) {
        $this->dispatch(self::EVENT_ACTIONED_OPTION, $key);
    }

    public function render() {
        return view('livewire.forms.multi-select');
    }

}
