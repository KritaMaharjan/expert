<?php
namespace App\Http\Tenant\Collection\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_collection';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'bill_id', 'step', 'file'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public $timestamps = false;

    const STEP_PURRING = 1;
    const STEP_INKASSOVARSEL = 2;
    const STEP_BETALINGSAPPFORDING = 3;
    const STEP_COURT = 4;
    const STEP_UTLEGG = 5;


    const INTEERST_RATE = 9.5;



    public static function getStep($step = '')
    {
        $step = strtolower($step);
        switch ($step) {
            case 'purring':
                return self::STEP_PURRING;
                break;

            case 'inkassovarsel':
                return self::STEP_INKASSOVARSEL;
                break;

            case 'betalingsappfording':
                return self::STEP_BETALINGSAPPFORDING;
                break;

            case 'court':
                return self::STEP_COURT;
                break;

            case 'utlegg':
                return self::STEP_UTLEGG;
                break;

            default:
                return NULL;
                break;
        }
    }

    public static function nextStep($step = '')
    {
        $step = strtolower($step);
        switch ($step) {
            case 'purring':
                return 'inkassovarsel';
                break;

            case 'inkassovarsel':
                return 'betalingsappfording';
                break;

            case 'betalingsappfording':
                return 'court';
                break;

            case 'court':
                return 'utlegg';
                break;

            default:
                return NULL;
                break;
        }
    }

    static function isValidStep($step)
    {
        if(!is_null(self::getStep($step)))
        {
            return true;
        }

        return false;
    }


    public static  function isGoToStep($created_at)
    {
        $dStart = new \DateTime();
        $dEnd  = new \DateTime($created_at);
        $dDiff = $dStart->diff($dEnd);
        $diff = $dDiff->format('%R').$dDiff->days;
       if($diff <= -14)
       {
           return true;
       }
        else
            return false;
    }


    public static function fee($step)
    {
        return self::getStep($step) * 65;
    }

    public static function interest($invoice_date, $bill_amount)
    {
        $dStart = new \DateTime();
        $dEnd  = new \DateTime($invoice_date);
        $dDiff = $dStart->diff($dEnd);
        $diff = $dDiff->days;
        // Formula (9,5% / 365)*amount*days
        $interest =((self::INTEERST_RATE/100) / 365) * $bill_amount * $diff;
        return number_format($interest, 2);
    }

    public static function deadline($created_at)
    {
        $dStart = new \DateTime();
        $dEnd  = new \DateTime($created_at);
        $dDiff = $dStart->diff($dEnd);
        $diff = $dDiff->days;
        return $diff;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $dt = new \DateTime();
            $model->created_at = $dt->format('Y-m-d H:i:s');

            return true;
        });
    }
}