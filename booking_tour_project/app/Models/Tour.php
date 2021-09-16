<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';
    protected $fillable = [
        'cate_id',
        'name',
        'avata',
        'description',
        'priceChild',
        'priceAdult',
        'date_start',
        'date_end'
    ];
    public function image(){
        return $this->hasMany(Image::class, 'tour_id', 'id');
    }

    public function tour_route()
    {
        return $this->hasMany(TourRoute::class, 'tour_id', 'id');
    }

    public function booking_detail()
    {
        return $this->hasMany(BookingDetail::class, 'tour_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'tour_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }

    public function getRate()
    {
        return $this->rate * 10;
    }

    public function scopeSearchTour($query, $cate_id, $date)
    {
        return $query->when($cate_id != null, function ($qr) use ($cate_id, $date) {
                    $qr->where('cate_id', $cate_id)->where('date_start', '>' , $date);
                }, function ($qr) use ($date) {
                    $qr->where('date_start', '>', $date);
                });
    }
    public function scopeTopTour()
    {
        $values = BookingDetail::select(DB::raw('COUNT(tour_id)'), 'tour_id')
            ->orderBy(DB::raw('COUNT(tour_id)'), 'DESC')
            ->groupBy('tour_id')
            ->limit(9)
            ->get();
        $tours = [];
        foreach ($values as $value) {
            $item = Tour::find($value->tour_id);
            array_push($tours, $item);
        }
        return $tours;
    }

    public function scopePopularityTour($query)
    {
        return $query->select('tours.*')
            ->join('booking_details', 'tours.id', '=', 'booking_details.tour_id')
            ->orderBy(DB::raw('COUNT(booking_details.tour_id)'), 'DESC')
            ->groupBy('tours.id')
            ->paginate(12);
    }

    public function scopePrice($query){
        return $query->orderBy('priceAdult')->paginate(12);
    }
    public function scopePriceDESC($query){
        return $query->orderBy('priceAdult', 'DESC')->paginate(12);
    }
    public function scopeTopRate()
    {
        $values = AssessRate::select(DB::raw('AVG(number_rate)'), 'tour_id')
            ->orderBy(DB::raw('AGV(number_rate)', 'DESC'))
            ->limit(4)
            ->get();
        $tours = [];
        foreach ($values as $value) {
            $item = Tour::find($value->tour_id);
            array_push($tours, $item);
        }
        return $tours;
    }
}
