<?php

namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class VatPeriod extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_vat_period';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'year', 'period', 'months', 'status', 'sent_date', 'paid_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

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

    public function getVatPeriod($request)
    {
        //$vat_period = $this->vatPeriod->getVatPeriod($this->request->all());
        $year = $request['year'];
        $period= $request['period'];
        $vat_period = VatPeriod::firstOrCreate([
            'period' => $period,
            'year' => $year
        ]);
        return $vat_period;
    }

    public function changeStatus($request, $action)
    {
        $period = VatPeriod::find($request['period_id']);
        if(!empty($period))
        {
            if($action == 'sent') {
                $period->status = 1;
                $period->sent_date = $request['sent_date'];
            }
            elseif($action == 'paid') {
                $period->status = 2;
                $period->paid_date = $request['paid_date'];
            }
            $period->save();
            return true;
        }
        return false;
    }
}
