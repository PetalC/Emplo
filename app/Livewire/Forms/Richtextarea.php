<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Richtextarea extends Component {

    public string|null $label = null;
    public string $id = 'richtextarea';
    public string $placeholder = 'Please enter some text here...';

    public string $error;

    public array $merge_tags = [];

    #[Modelable]
    public string|null $value = null;

//    public function handleMergeTags( $value ) {
//
////        dd( $this->merge_tags, $value );
//
//        if( ! is_array( $this->merge_tags ) ) {
//            return $value;
//        }
//
//        foreach( $this->merge_tags as $tag => $tag_value ) {
//            $value = str_replace( '[#' . $tag . ']' , $tag_value, $value );
//        }
//
//        return $value;
//
//    }

    public function render() {
        return view('livewire.forms.richtextarea' );
    }

}
