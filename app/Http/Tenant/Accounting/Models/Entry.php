<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_entries';


    const CREDIT = 1;
    const DEBIT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'transaction_id', 'account_code', 'subledger', 'description', 'amount', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public $timestamps = false;


    function account_code()
    {
        if (!is_null($this->subledger)) {
            return $this->account_code . ':' . $this->subledger;
        }

        return $this->account_code;
    }

    function transaction()
    {
        return $this->belongsTo('App\Http\Tenant\Accounting\Models\Transaction');
    }

    public function getVatEntries($request = null)
    {
        $vat = \Config::get('accounts.vat');
        $query = $this->from('fb_entries as e')->select('e.account_code', 'e.description', 'e.amount', 't.created_at')->join('fb_transactions as t', 'e.transaction_id', '=', 't.id')->where('e.type', 1)->whereIn('e.account_code', $vat);

        if($request != null) {
            if(isset($request['year']) && $request['year'] != '')
                $query = $query->whereRaw('YEAR(t.created_at) = '.$request['year']);

            if(isset($request['period']) && $request['period'] != '') {
                $month = $this->getMonth($request['period']);
                $query = $query->whereIn(\DB::raw('MONTH(t.created_at)'), $month);
            }
        }
        $vat_entries = $query->get();
        return $vat_entries;
    }

    public function getMonth($period)
    {
        switch ($period)
        {
            case 1:
                return [01, 02];
            case 2:
                return [03, 04];
            case 3:
                return [5, 6];
            case 4:
                return [7, 8];
            case 5:
                return [9, 10];
            case 6:
                return [11, 12];
        }
        return false;
    }
}