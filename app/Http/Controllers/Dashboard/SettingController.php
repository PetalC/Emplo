<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LucasDotVin\Soulbscription\Models\Plan;
use LucasDotVin\Soulbscription\Models\Subscription;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index ()
    {
        $school = session()->get('current_school');

        $settingList = [
            /**[
                'name' => 'Employer Logo',
                'disabled' => true, // Remove key to enable
                'desc' => 'Upload your school\'s Logo'
            ],
            [
                'name' => 'Employer Locations',
                'desc' => 'Upload your school\'s address and add campuses'
            ],[
                'name' => 'Employer Gallery',
                'disabled' => true,// Remove key to enable
                'desc' => 'Manage the image gallery displayed on the Profile'
            ],**/
            [
                'name' => 'My Team',
                'desc' => 'Manage your account with access to your school'
            ],
            [
                'name' => 'Social Media',
                'desc' => 'Social media links and connections'
            ],/**[
                'name' => 'Job Boards',
                'desc' => 'Configure job boards to your own accounts'
            ],**/[
                'name' => 'Update your password',
                'desc' => 'Change your password'
            ],
        ];

        foreach ($settingList as $key => $setting) {
            $settingList[$key]['slug'] = Str::slug($setting['name']);

            if (!auth()->user()->hasPermissionTo('school.manage-users') && $settingList[$key]['slug'] == 'my-team') {
                unset($settingList[$key]);
            }
        }

        usort($settingList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('school.settings.index', [
            'settingList' => $settingList,
//            'plans' => Plan::query()->orderBy( 'order' )->get(),// $planList,
            'school' => $school,
        ]);
    }
}
