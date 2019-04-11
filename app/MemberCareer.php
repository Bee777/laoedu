<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCareer extends Model
{
    protected $dates = ['start_date', 'end_date'];

    public function work_categories()
    {
        return $this->hasMany(CareerWorkDepartments::class, 'career_id');
    }

    public function workCategoriesData()
    {
        $o = $this->work_categories;
        $o->map(function ($work_department) {
            $department = $work_department->department;
            $work_department->label = $department->name;
            $work_department->value = $department->id;
            unset($work_department->department, $work_department->career_id, $work_department->created_at, $work_department->updated_at, $work_department->department_id);
        });
        return $o;
    }

    public function organize()
    {
        return $this->belongsTo(Organize::class);
    }

    public function organizeData()
    {
        $o = $this->organize;
        if (isset($o)) {
            return ['label' => $o->name, 'value' => $o->id];
        }
        return ['label' => '', 'value' => ''];
    }
}
