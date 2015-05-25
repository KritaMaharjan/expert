<?php
namespace App\Http\Controllers\Tenant\Settings;

use App\Http\Controllers\Tenant\BaseController;
use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use App\Models\Tenant\Profile;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Support\Facades\Validator;
use Request as Requested;
use Illuminate\Http\Request;
use DB;

class UserController extends BaseController
{


    protected $setting;

    function __construct(Setting $setting)
    {
        \FB::can('Settings');
        parent::__construct();
        $this->setting = $setting;
    }

    public function index($value = '')
    {

        $setting = (array)DB::table('fb_users as u')
            ->leftjoin('fb_profile as p', 'u.id', '=', 'p.user_id')
            ->select('u.id', 'u.fullname As name', 'u.email', 'p.*')
            ->where('u.id', current_user()->id)
            ->first();


        $data = array('page_title' => 'User Controller', 'setting' => $setting);
        return view('tenant.setting.user')->with($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            array(
                'name' => 'required',
                'email' => 'required',
                'postcode' => 'required',
                'social_security_number' => 'required|numeric',
                'phone' => 'required|numeric',
                'address' => 'required',
                'comment' => 'required',
                'tax_card' => 'required',
                'town' => 'required'
            )
        );

        if ($validator->fails())
            return tenant()->route('tenant.edit.profile')->withErrors($validator)->withInput();

        //$all = $request->except('_token', 'group','photo');
        $group = $request->input('group');
        $user = User::find(current_user()->id);
        $user->fullname = $request['name'];
        $user->email = $request['email'];
        $user->save();

        $profile = Profile::find(current_user()->id);
        $profile->social_security_number = $request['social_security_number'];
        $profile->postcode = $request['postcode'];
        $profile->phone = $request['phone'];
        $profile->address = $request['address'];
        $profile->comment = $request['comment'];
        $profile->photo = $request['photo'];
        $profile->tax_card = $request['tax_card'];
        $profile->town = $request['town'];
        $profile->save();

        return tenant()->route('tenant.edit.profile')->with('message', 'Setting Updated successfully');


    }
}