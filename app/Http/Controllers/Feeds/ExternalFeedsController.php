<?php

namespace App\Http\Controllers\Feeds;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\JobBoardTypes;
use App\Models\Campus;
use App\Models\Job;

class SimpleXMLExtended extends \SimpleXMLElement
{

    public function addCData( $cdata_text )
    {
        $node = dom_import_simplexml( $this ); 
        $no   = $node->ownerDocument;
        
        $node->appendChild( $no->createCDATASection( $cdata_text ) ); 
    }
    
}

class ExternalFeedsController extends Controller
{
    public function educationHq()
    {
        // TODO: Get only EducationHQ Jobs
        $ehqJobs = [];

        $jobs = $jobs = Job::whereHas('postings', function($query) {
            $query->where('job_board', JobBoardTypes::COMPLETE_EDUCATIONAL_HQ->value);
        })->get();

        foreach ($jobs as $job) {
            $ehqJobs[] = $job->ehqTransformer();
        }

        return json_encode($ehqJobs);
    }

    public function indeed()
    {
        // TODO: Get only indeed Jobs
        $feed = [];

        $jobs = $jobs = Job::whereHas('postings', function($query) {
            $query->where('job_board', JobBoardTypes::COMPLETE_INDEED->value);
        })->get();

        $feed['publisher'] = 'Employo';
        $feed['publisherurl'] = \URL::To('/');

        foreach ($jobs as $job) {
            $feed[] = $job->indeedTransformer();
        }

        // creating object of SimpleXMLElement
        $xml = new \SimpleXMLElement('<source/>');

        // function call to convert array to xml
        $this->array_to_xml($feed, $xml);

        //saving generated xml file; 
        return response($xml->asXML(), 200, [
                'Content-type' => 'application/xml'
            ]
        );
    }

    private function addCData($name, $value, &$parent)
    {
        $child = $parent->addChild($name);
 
        if ($child !== NULL) {
            $child_node = dom_import_simplexml($child);
            $child_owner = $child_node->ownerDocument;
            $child_node->appendChild($child_owner->createCDATASection($value));
        }
 
        return $child;
    }
 
    private function array_to_xml( $data, &$xml_data )
    {
        foreach( $data as $key => $value ) {

            if( is_array($value) ) {
                if ('job' == key($value)) {
                    $subnode = $xml_data->addChild(key($value));
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $xml_data);
                }

                
            } else {
                $this->addCData("$key", $value, $xml_data);
            }
        }
    }

}
