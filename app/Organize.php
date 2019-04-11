<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organize extends Model
{
    protected $fillable = ['name', 'government_organize'];

    public static function CreateOrganize(string $name, string $government_organize): Organize
    {
        return self::create(['name' => $name, 'government_organize' => $government_organize]);
    }

    public static function UpdateOrganize($id, string $name, string $government_organize): bool
    {
        $organize = self::find($id);
        if (isset($organize)) {
            $organize->name = $name;
            $organize->government_organize = $government_organize;
            return $organize->save();
        }
        return false;
    }

    public static function DeleteOrganize($id): ?bool
    {
        $organize = self::find($id);
        if (isset($organize)) {
            return $organize->delete();
        }
        return false;
    }
}
