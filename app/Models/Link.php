<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RandomLink;
use App\Models\CustomLink;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    public function deleteLink($link_id, $type_link)
    {
        if($type_link == 0) {
            $data = RandomLink::where('link_id', $link_id)->first();
            return true;
        } else if($type_link == 1) {
            $data = CustomLink::where('link_id', $link_id)->first();
        } else {
            return false;
        }

        if(!$data) {
            return false;
        } else {
            $data->delete();
            return true;
        }
    }

    public function randomCode()
    {
        $indicator = 0;
        while($indicator == 0) {
            $randomCode = Str::random(5);
            $checkRandomCode = RandomLink::where("random_code", $randomCode)->first();
            if(!$checkRandomCode) {
                $indicator = 1;
            }
        }
        return $randomCode;
    }
}
