<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Item extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

	const STATUS_AT_IN_ZONE      = 1;
	const STATUS_GO_TO_WAREHOUSE = 2;
	const STATUS_IN_WAREHOUSE    = 3;
	const STATUS_GO_TO_OUT_ZONE  = 4;
	const STATUS_AT_OUT_ZONE     = 5;

	public function getDeadstockPeriod() {
		$importDate    = $this->created_at->timestamp;
		$deadstockDate = strtotime('-'.$this->product->deadstock_period.' days');
		$period = ($importDate-$deadstockDate)*60*60*24;
		return $period;
	}
	public function product() {
		return $this->belongsTo('App\Models\Product');
	}
	public function warehouse() {
		return $this->belongsTo('App\Models\Warehouse');
	}

	public static function getDeadstockList() {
		$deadstockIndex = [];
        foreach(static::where('status', Item::STATUS_IN_WAREHOUSE)->get() as $index => $item) {
            if($item->getDeadstockPeriod() <= 0) {
                $deadstockIndex[] = $item;
            }
        }
        return $deadstockIndex;
	}
}
