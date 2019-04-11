<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizeChartMember extends Model
{
    public static $uploadPath = '/assets/images/organize_chart/';

    protected $fillable = ['name', 'surname', 'university', 'company', 'image', 'position_order', 'position', 'organize_chart_range_id'];

}
