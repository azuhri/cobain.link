<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\RandomLink;
use App\Models\CustomLink;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Nette\Utils\Random;

class LinkController extends Controller
{
    function __construct()
    {
        $this->faker = Faker::create("id_ID");
    }

    public function filterString($string)
    {
        $valueString = str_replace(" ","-", $string);$valueString = str_replace("_","-", $valueString);$valueString = str_replace("!","", $valueString);
        $valueString = str_replace("@","", $valueString);$valueString = str_replace("#","", $valueString);$valueString = str_replace("$","", $valueString);
        $valueString = str_replace("%","", $valueString);$valueString = str_replace("^","", $valueString);$valueString = str_replace("&","", $valueString);
        $valueString = str_replace("*","", $valueString);$valueString = str_replace("(","", $valueString);$valueString = str_replace(")","", $valueString);
        $valueString = str_replace("+","", $valueString);$valueString = str_replace("'","", $valueString);$valueString = str_replace('"',"", $valueString);
        $valueString = str_replace("~","", $valueString);$valueString = str_replace("`","", $valueString);$valueString = str_replace(">","", $valueString);
        $valueString = str_replace("","", $valueString);$valueString = str_replace("/","", $valueString);$valueString = str_replace('?',"", $valueString);
        $valueString = str_replace("<","", $valueString);$valueString = str_replace(".","", $valueString);$valueString = str_replace(";","", $valueString);
        $valueString = str_replace(":","", $valueString);$valueString = str_replace("{","", $valueString);$valueString = str_replace("}","", $valueString);
        $valueString = str_replace("|","", $valueString);$valueString = str_replace("[","", $valueString);$valueString = str_replace("]","", $valueString);
        return $valueString;
    }

    public function generateLink(Request $request)
    {
        $realLink = $request->real_link;
        $typeLink = $request->type_link;
        $checkLinkRealLink = Link::where("real_link", $realLink)->first();
        try {
            DB::beginTransaction();
            if(!$checkLinkRealLink) {
                if($typeLink == 0) {
                    $createLink = new Link();
                    $createLink->real_link = $realLink;
                    $createLink->type_link = $typeLink;
                    $createLink->save();

                    $createRandomLink = new RandomLink();
                    $createRandomLink->link_id = $createLink->id;
                    $createRandomLink->random_code = $createLink->randomCode();
                    $createRandomLink->save();

                    $link = $createRandomLink;
                    $sourceLink = $createLink;
                    $dataArray[] = "link";
                    $dataArray[] = "sourceLink";
                    DB::commit();
                    return view("pages.link-generate",compact($dataArray));
                } else if($typeLink == 1) {
                    $alias = $this->filterString($request->alias);

                    $createLink = new Link();
                    $createLink->real_link = $realLink;
                    $createLink->type_link = $typeLink;
                    $createLink->save();

                    $findAlias = CustomLink::where("alias", $alias)->first();
                    if(!$findAlias) {
                        $createCustomLink = new CustomLink();
                        $createCustomLink->link_id = $createLink->id;
                        $createCustomLink->alias = $alias;
                        $createCustomLink->save();
                        $link = $createCustomLink;
                    } else {
                        $link = $findAlias->alias;
                    }

                    $sourceLink = $createLink;
                    $dataArray[] = "link";
                    $dataArray[] = "sourceLink";
                    DB::commit();
                    return view("pages.link-generate",compact($dataArray));
                } else {
                    return redirect()->back()->with("errors","Sorry... data input is not valid");
                }
            } else {
                if($typeLink == 0) {
                    $link = RandomLink::where("link_id", $checkLinkRealLink->id)->first();
                    if(!$link) {
                        $link = CustomLink::where('link_id', $checkLinkRealLink->id)->first();
                    }
                    $sourceLink = $checkLinkRealLink;
                    $dataArray[] = "link";
                    $dataArray[] = "sourceLink";
                    return view("pages.link-generate",compact($dataArray));
                } else if($typeLink == 1) {
                    $link = CustomLink::where("link_id", $checkLinkRealLink->id)->first();
                    $sourceLink = $checkLinkRealLink;
                    $dataArray[] = "link";
                    $dataArray[] = "sourceLink";
                    return view("pages.link-generate",compact($dataArray));
                } else {
                    return redirect()->back()->with("errors","Sorry... data input is not valid");
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function aliasLink($alias_link)
    {
        $findCheckAliasInRandomLink = RandomLink::where("random_code", $alias_link)->first();
        if(!$findCheckAliasInRandomLink) {
            $findAliasCustomLink =  CustomLink::where("alias", $alias_link)->first();
            if($findAliasCustomLink) {
                $link = Link::find($findAliasCustomLink->link_id);
                if(!$link) {
                    abort(404);
                }
                return redirect()->to($link->real_link);
            } else {
                abort(404);
            }
        } else {
            $link = Link::find($findCheckAliasInRandomLink->link_id);
            if(!$link) {
                abort(404);
            }
            return redirect()->to($link->real_link);
        }
    }
}
