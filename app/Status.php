<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Status extends Model
{
    use SoftDeletes;
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['will_delete_in'];

    /**
     * Get the user record associated with the Status.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User','user');
    }

    /**
     * ready to delete
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReadyToDelete($query)
    {
        $query->whereStatus('live');
        $query->where('delete_in', '<', date('Y-m-d H:i:s'));
        return $query;
    }

    /**
     * ready to delete
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReadyToPost($query)
    {
        $query->whereStatus('pending');
        $query->where('post_in', '<', date('Y-m-d H:i:s'));
        return $query;
    }
    
    /**
     * Get WillDeleteIn.
     *
     * @param  string  $value
     * @return string
     */
    public function getWillDeleteInAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->delete_in))->diffForHumans();
    }

    /**
     * Get WillPostIn.
     *
     * @param  string  $value
     * @return string
     */
    public function getWillPostInAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->post_in))->diffForHumans();
    }
}
