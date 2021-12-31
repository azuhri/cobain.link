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
    // Function to filter valid url
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

    // Function to generate link
    public function generateLink(Request $request)
    {
        $realLink = $request->real_link;
        $typeLink = $request->type_link;

        $checkLinkRealLink = Link::where("real_link", $realLink)->first(); // Check real link into database

        // trying this block codes until getting error
        try {
            DB::beginTransaction();                         // Function to checkpoint for storing DB until commit and save into DB
            if(!$checkLinkRealLink) {                       // If real link is not stored in database
                if($typeLink == 0) {                        // Check type link 0 is for generate random link
                    $createLink = new Link();
                    $createLink->real_link = $realLink;
                    $createLink->type_link = $typeLink;
                    $createLink->save();

                    $createRandomLink = new RandomLink();
                    $createRandomLink->link_id = $createLink->id;
                    $createRandomLink->random_code = $createLink->randomCode(); // Generate Random code for URL
                    $createRandomLink->save();

                    $link = $createRandomLink;
                    $sourceLink = $createLink;
                    $dataArray[] = "link";
                    $dataArray[] = "sourceLink";
                    DB::commit();                                               // Commit to storing data into database
                    return view("pages.link-generate",compact($dataArray));
                } else if($typeLink == 1) {                                     // Check link type 1 is for generate custom link
                    $alias = $this->filterString($request->alias);

                    $createLink = new Link();
                    $createLink->real_link = $realLink;
                    $createLink->type_link = $typeLink;
                    $createLink->save();

                    $findAlias = CustomLink::where("alias", $alias)->first();   // Check alias custom link was stored or not
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
                    return redirect()->back()->with("errors","Sorry... data input is not valid");  // Check link type if more than number 1 is not valid link type
                }
            } else {                                                                              // If real link was stored in database
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
        } catch (\Throwable $th) {                          // Block codes of throw any error
            dd($th);
            DB::rollBack();
            return redirect()->back();
        }
    }


    // Function to redirect read link
    public function aliasLink($alias_link)
    {
        $findCheckAliasInRandomLink = RandomLink::where("random_code", $alias_link)->first();       // Check alias link is random link
        if(!$findCheckAliasInRandomLink) {              // If real link is not found
            $findAliasCustomLink =  CustomLink::where("alias", $alias_link)->first();  // Check again if link is custom link
            if($findAliasCustomLink) {
                $link = Link::find($findAliasCustomLink->link_id);
                if(!$link) {            // If link is not found so return 404 page
                    abort(404);
                }
                return redirect()->to($link->real_link);
            } else {
                abort(404);
            }
        } else { // IF link is random link
            $link = Link::find($findCheckAliasInRandomLink->link_id);
            if(!$link) {                // If link is not found so return 404 page
                abort(404);
            }
            return redirect()->to($link->real_link);
        }
    }
}
