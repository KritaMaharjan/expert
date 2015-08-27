<?php
namespace App\Models\System\Client;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\System\Client\ClientAddress;
use App\Models\System\Profile\Phone;
use App\Models\System\Profile\Addresses;
use App\Models\System\Client\ClientPhone;

class Client extends Model
{

    protected $table = 'ex_clients';
    protected $fillable = ['preferred_name', 'given_name', 'surname', 'home', 'mobile', 'email', 'salary', 'salary_type', 'occupation', 'address_id', 'introducer', 'title', 'added_by_users_id'];

    /* DEFINE RELATIONSHIPS */

    // each client has many addresses
    public function client_addresses()
    {
        return $this->hasMany('App\Models\System\Client\ClientAddress', 'ex_clients_id');
    }

    // each client has many phones
    public function client_phones()
    {
        return $this->hasMany('App\Models\System\Client\ClientPhone', 'ex_clients_id');
    }

    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $client = Client::create([
                'preferred_name' => $request['preferred_name'],
                'given_name' => $request['given_name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'salary' => $request['salary'],
                'occupation' => $request['occupation'],
                'salary_type' => $request['salary_type'],
                'introducer' => $request['introducer'],
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

            $client_address = ClientAddress::create([
                'ex_clients_id' => $client->id,
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

                    ClientPhone::create([
                        'phones_id' => $phone->id,
                        'ex_clients_id' => $client->id
                    ]);
                }
            }

            DB::commit();
            return $client->id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($client) return true;
        else return false;

    }

    /*
     * Update client info
     * Output boolean
     */
    function edit(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $client = Client::find($client_id);

            $client->preferred_name = $request['preferred_name'];
            $client->given_name = $request['given_name'];
            $client->surname = $request['surname'];
            $client->email = $request['email'];
            $client->salary = $request['salary'];
            $client->occupation = $request['occupation'];
            $client->salary_type = $request['salary_type'];
            $client->introducer = $request['introducer'];
            $client->title = $request['title'];
            $client->save();

            /* Delete associated addresses and phone numbers... change this later for code optimization */
            Client::find($client_id)->client_addresses()->with('address')->delete();
            Client::find($client_id)->client_phones()->with('phone')->delete();
            //change this later for multiple addresses

            $address = Addresses::create([
                'line1' => $request['line1'],
                'line2' => $request['line2'],
                'suburb' => $request['suburb'],
                'state' => $request['state'],
                'postcode' => $request['postcode'],
                'country' => $request['country']
            ]);

            ClientAddress::create([
                'ex_clients_id' => $client->id,
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

                    ClientPhone::create([
                        'phones_id' => $phone->id,
                        'ex_clients_id' => $client->id
                    ]);
                }
            }

            DB::commit();
            return $client->id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($client) return true;
        else return false;

    }

    /*
     * Delete client
     * parameter client id int
    */
    function remove($client_id)
    {
        DB::beginTransaction();

        try {
            //get details
            $client = Client::find($client_id);

            //change this later for multiple addresses
            $client_address = ClientAddress::where('ex_clients_id', $client->id)->first();
            $address = Addresses::find($client_address->address_id);

            //phone numbers
            $all_client_phones = ClientPhone::where('ex_clients_id', $client->id);
            $client_phones = $all_client_phones->get();
            $all_client_phones->delete();
            /* delete data */
            //delete phone numbers
            if (!empty($client_phones)) {
                foreach ($client_phones as $client_phone) {
                    $phones = Phone::find($client_phone->phones_id)->delete();
                }
            }

            //delete address
            $client_address->delete();
            $address->delete();

            //delete client
            $client->delete();
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

        $client = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('domain', 'LIKE', "%$search%")->orwhere('email', 'LIKE', "%$search%");
        }
        $client['total'] = $query->count();

        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->fullname = $value->given_name . " " . $value->surname;
            $value->DT_RowId = "row-" . $value->id;
        }
        $client['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $client['total'];
        $json->recordsFiltered = $client['total'];
        $json->data = $client['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url = '';// tenant()->url('client/' . $this->id);
        $this->edit_url = '';//tenant()->url('client/' . $this->id . '/edit');
        return $this->toArray();
    }
} 