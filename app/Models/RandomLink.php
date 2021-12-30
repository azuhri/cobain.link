<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Link;

class RandomLink extends Model
{
    use HasFactory;

    public function getRealLink($link_id)
    {
        $findLink = Link::find($link_id);
        if(!$findLink) {
            return false;
        }

        return $findLink;
    }
}
