<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];
    public static function CreateDepartment(string $name): Department
    {
        return self::create(['name' => $name]);
    }

    public static function UpdateDepartment($id, string $name): bool
    {
        $organize = self::find($id);
        if (isset($organize)) {
            $organize->name = $name;
            return $organize->save();
        }
        return false;
    }

    public static function DeleteDepartment($id): ?bool
    {
        $organize = self::find($id);
        if (isset($organize)) {
            return $organize->delete();
        }
        return false;
    }
}
