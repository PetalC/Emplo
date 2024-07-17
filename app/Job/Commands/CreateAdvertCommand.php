<?php

namespace App\Job\Commands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Core\SystemCommand;
use App\User;
use App\Job\Models\Advert;
use App\Specialization\Models\Tag;

use Validator;

/**
 * Creates a Job Advertisement
 */
class CreateAdvertCommand extends SystemCommand
{
    /** @var Advert */
    protected $advert;
    
    /** @var array */
    protected $specializations;
    
    /**
     * Initialize the Class
     * 
     * @param Advert $advert
     * @param array $specializations
     */
    public function __construct(Advert $advert, $specializations = [])
    {
        $this->advert = $advert;
        $this->specializations = $specializations;
    }
    
    /**
     * Main Processing to handle the Command
     * 
     * @return boolean
     */
    public function handle()
    {
        if (!$this->validate()) {
            return false;
        }
        
        try {
            $this->advert->save();
            
            if (!empty($this->specializations)) {
                $currentTags = [];
            
                foreach ($this->specializations as $tag) {
                    $label = '';

                    if (isset($tag->text)) {
                        $label = $tag->text;
                    }

                    if (isset($tag->label)) {
                        $label = $tag->label;
                    }

                    if (!empty($label)) {
                        $specialization = Tag::firstOrCreate(
                            ['label' =>  $label]
                        );

                        $currentTags[] = $specialization->id;
                    }
                }
                
                $this->advert->specializations()->sync($currentTags);    
            }
            
            return true;
            
        } catch (\Exception $error) {
            $this->setMessages([$error->getMessage()]);
            return false;
        }
    }
    
    /**
     * Validates the input
     * 
     * @return boolean
     */
    private function validate()
    {
        /*
        $regexp = '/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,4}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/m';

        if (preg_match($regexp, $this->advert->description)) {
            $this->setMessages(['Please remove the links from the description']);
            return false;
        }
        */
        
        /*
        $regexp = '/\+?[0-9][0-9()\-\s+]{6,20}[0-9]/';

        if (preg_match($regexp, $this->advert->description)) {
            $this->setMessages(['Please remove the contact number from the description']);
            return false;
        }
        */

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'time_requirement' => 'required',
            'experience_requirement' => 'required',
        ];

        $attributes = [
            'time_requirement' => 'Job Type',
            'experience_requirement' => 'Years of Experience',
        ];
        
        $validator = Validator::make($this->advert->getAttributes(), $rules);
        $validator->setAttributeNames($attributes);

        if ($validator->fails()) {
            $this->setMessages($validator->messages()->all());
            return false;
        }
        
        return true;
    }

    public function getAdvert()
    {
        return $this->advert;
    }
}
