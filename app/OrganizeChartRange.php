<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizeChartRange extends Model
{
    protected $fillable = ['name', 'position_order'];

    public static function getDesc($with_check_member = false)
    {
        if ($with_check_member) {
            return self::select('organize_chart_ranges.*')->join('organize_chart_members', 'organize_chart_members.organize_chart_range_id', 'organize_chart_ranges.id')->groupBy('organize_chart_members.organize_chart_range_id')->orderBy('organize_chart_ranges.position_order', 'desc')->get();
        }
        return self::orderBy('position_order', 'desc')->get();
    }
}
