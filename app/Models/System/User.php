<?php
/**
 * User: manishg.singh
 * Date: 2/13/2015
 * Time: 3:15 PM
 */

namespace App\Models\System;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    protected $role = [1 => 'Admin', 2 => 'Staff'];

    function redirectIfValid($user)
    {
        if ($user->status == 0) {
            \Auth::logout();

            return redirect()->route('system.login')->withInput()->with('message', lang('Your account has not been activated.'));
        } elseif ($user->status == 2) {
            \Auth::logout();

            return redirect()->route('system.login')->withInput()->with('message', lang('Your account has been suspended.'));
        } elseif ($user->status == 3) {
            \Auth::logout();

            return redirect()->route('system.login')->withInput()->with('message', lang('Your account has been permanently blocked.'));
        }

        return redirect('system');
    }

    function role()
    {
        return isset($this->role[$this->role]) ? $this->role[$this->role] : 'Unknown';
    }


} 