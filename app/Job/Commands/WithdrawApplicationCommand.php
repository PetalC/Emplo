<?php

namespace App\Job\Commands;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Core\SystemCommand;
use App\User;
use App\Job\Models\Advert;

use Validator;

/**
 * Creates a Job Advertisement
 */
class WithdrawApplicationCommand extends SystemCommand
{
    /** @var Advert */
    protected $advert;
    
    /** @var User */
    protected $user;
    
    /**
     * Initialize the Class
     * 
     * @param Advert $advert
     * @param User $user
     */
    public function __construct(Advert $advert, $user = [])
    {
        $this->advert = $advert;
        $this->user = $user;
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
            $this->advert->candidates()->updateExistingPivot(
                $this->user->id,
                [
                    'withdrawn_at' => date('Y-m-d H:i:s')
                ]
            );
            
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
        return true;
    }
}
