<?php
namespace App\Models\System\User;

use App\Models\System\Profile\Addresses;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\System\User\UserAddress;
use App\Models\System\Profile\Phone;
use App\Models\System\User\UserPhone;

class User extends Model
{

    protected $table = 'ex_users';
    protected $fillable = ['username', 'given_name', 'surname', 'email', 'address_id', 'title', 'added_by_users_id'];

    /* DEFINE RELATIONSHIPS */
    // each user has many addresses
    public function user_addresses()
    {
        return $this->hasMany('App\Models\System\User\UserAddress', 'ex_users_id');
    }

    // each user has many phones
    public function user_phones()
    {
        return $this->hasMany('App\Models\System\User\UserPhone', 'ex_users_id');
    }

    // each user has many assigned lead (for sales)
    public function assignedTo()
    {
        return $this->hasMany('App\Models\System\Lead\ClientLeadAssign', 'assign_to');
    }

    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request['username'],
                'given_name' => $request['given_name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'title' => $request['title'],
                'added_by_users_id' => \Auth::user()->id
            ]);

            $address = Addresses::create([
                'line1' => $request['line1'],
                'line2' => $request['line2'],
                'suburb' => $request['suburb'],
                'state' => $request['state'],
                'postcode' => $request['postcode'],
                'country' => $request['country']
            ]);

            $user_address = UserAddress::create([
                'ex_users_id' => $user->id,
                'address_type_id' => 1, //$request['type'], change this later
                'is_current' => 1,
                'address_id' => $address->id
            ]);

            /* Add Phone numbers*/
            $phone_numbers = $request['phone'];
            foreach ($phone_numbers as $key => $phone_num) {
                if ($phone_num != '') {
                    $phone = Phone::create([
                        'number' => $phone_num,
                        'type' => $request['phonetype'][$key]
                    ]);

                    UserPhone::create([
                        'phones_id' => $phone->id,
                        'ex_users_id' => $user->id
                    ]);
                }
            }

            DB::commit();
            return $user->id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($user) return true;
        else return false;
    }

    /*
     * Update user info
     * Output boolean
     */
    function edit(array $request, $user_id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($user_id);

            $user->username = $request['username'];
            $user->given_name = $request['given_name'];
            $user->surname = $request['surname'];
            $user->email = $request['email'];
            $user->title = $request['title'];
            $user->save();

            /* Delete associated addresses and phone numbers... change this later for code optimization */
            User::find($user_id)->user_addresses()->with('address')->delete();
            User::find($user_id)->user_phones()->with('phone')->delete();
            //change this later for multiple addresses

            $address = Addresses::create([
                'line1' => $request['line1'],
                'line2' => $request['line2'],
                'suburb' => $request['suburb'],
                'state' => $request['state'],
                'postcode' => $request['postcode'],
                'country' => $request['country']
            ]);

            UserAddress::create([
                'ex_users_id' => $user->id,
                'address_type_id' => 1, //$request['type'], change this later
                'is_current' => 1,
                'address_id' => $address->id
            ]);

            /* Add Phone numbers*/
            $phone_numbers = $request['phone'];
            foreach ($phone_numbers as $key => $phone_num) {
                if ($phone_num != '') {
                    $phone = Phone::create([
                        'number' => $phone_num,
                        'type' => $request['phonetype'][$key]
                    ]);

                    UserPhone::create([
                        'phones_id' => $phone->id,
                        'ex_users_id' => $user->id
                    ]);
                }
            }

            DB::commit();
            return $user->id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($user) return true;
        else return false;

    }

    /*
     * Delete user
     * parameter user id int
    */
    function remove($user_id)
    {
        DB::beginTransaction();

        try {
            //get details
            $user = User::find($user_id);

            //change this later for multiple addresses
            $user_address = UserAddress::where('ex_users_id', $user->id)->first();
            $address = Addresses::find($user_address->address_id);

            //phone numbers
            $all_user_phones = UserPhone::where('ex_users_id', $user->id);
            $user_phones = $all_user_phones->get();
            $all_user_phones->delete();
            /* delete data */
            //delete phone numbers
            if (!empty($user_phones)) {
                foreach ($user_phones as $user_phone) {
                    $phones = Phone::find($user_phone->phones_id)->delete();
                }
            }

            //delete address
            $user_address->delete();
            $address->delete();

            //delete user
            $user->delete();
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    /* *
     *  Display data for ajax pagination
     *  Output stdClass
     * */
    function dataTablePagination(Request $request, array $select = array())
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $user = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        $query = $query->where('id', '!=', \Auth::user()->id);
        $user['total'] = $query->count();

        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->fullname = $value->given_name . " " . $value->surname;
            $value->DT_RowId = "row-" . $value->id;
            $roles = \Config::get('general.user_role');
            $value->role = $roles[$value->role];
        }
        $user['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $user['total'];
        $json->recordsFiltered = $user['total'];
        $json->data = $user['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url = '';// tenant()->url('user/' . $this->id);
        $this->edit_url = '';//tenant()->url('user/' . $this->id . '/edit');
        return $this->toArray();
    }
} 