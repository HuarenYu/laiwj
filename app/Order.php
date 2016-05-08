<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Inn;

class Order extends Model
{

    public function inn()
    {
        return $this->belongsTo('App\Inn', 'inn_id');
    }

    public function releaseBookedDays()
    {
        $inn = Inn::find($this->inn_id);
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $innSchedule = json_decode($inn->schedule);
        $newSchedule = [];
        foreach ($innSchedule as $bookDate) {
            $tmpDate = Carbon::parse($bookDate);
            if ($tmpDate->lt($startDate) || $tmpDate->gte($endDate)) {
                $newSchedule[] = $bookDate;
            }
        }
        $inn->schedule = json_encode($newSchedule);
        $inn->save();
    }

}
