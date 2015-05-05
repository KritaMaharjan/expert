<?php
namespace App\Http\Tenant\Collection\Models;

use Carbon\Carbon;
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

    public static function  getStep($step = '')
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
                throw new \Exception('Invalid Case');
                break;
        }
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