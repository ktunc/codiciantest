<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Screen\Capture;

class CompanyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $companies = DB::table('company')->orderBy('id')->get();
        return view('company.index',['companies'=>$companies]);
    }

    public function companyinfo(Request $request){
        if ($request->isMethod('post')) {
            $company = DB::table('company')->where('id', $request->cid)->first();
            if($company){
                return response()->json($company);
            }else{
                return response()->json(false);
            }
        }else{
            return response()->json(false);
        }
    }

    public function companysave(Request $request){
        if ($request->isMethod('post')) {
            if($request->has('cid')){
                $html = self::get_html(trim($request->internet_address));
                $durum = DB::table('company')
                    ->where('id', $request->cid)
                    ->update([
                        'name' => trim($request->name),
                        'internet_address' => trim($request->internet_address),
                        'html' => mb_convert_encoding($html, 'UTF-8', 'UTF-8')
                    ]);

                if($html && $durum){
                    $screenCapture = new Capture($request->internet_address);
                    $screenCapture->save('storage\\company\\'.$request->cid);
                }

            } else{
                $html = self::get_html(trim($request->internet_address));
                $durum = DB::table('company')
                    ->insertGetId([
                        'name' => ($request->name),
                        'internet_address' => ($request->internet_address),
                        'html' => mb_convert_encoding($html, 'UTF-8', 'UTF-8')
                    ]);

                if($html && $durum){
                    $screenCapture = new Capture($request->internet_address);
                    $screenCapture->save('storage\\company\\'.$durum);
                }
            }
            return response()->json($durum);
        } else {
            return response()->json(false);
        }
    }

    public function companydelete(Request $request){
        $durum = false;
        if ($request->isMethod('post')) {
            if($request->has('cid')){
                $durum = DB::table('company')
                    ->where([
                        'id' => $request->cid
                    ])
                    ->delete();
            }
        }

        return response()->json($durum);
    }

    /** Person *****************************/
    public function person(Request $request){
        $company = DB::table('company')->where('id', $request->cid)->first();
        $persons = DB::table('person')->where('company_id', $request->cid)->orderBy('id')->get();
        return view('company.person',['company'=>$company, 'persons'=>$persons]);
    }

    public function personinfo(Request $request){
        if ($request->isMethod('post')) {
            $person = DB::table('person')
                ->where([
                    'id' => $request->pid,
                    'company_id' => $request->cid
                ])
                ->first();
            if($person){
                return response()->json($person);
            }else{
                return response()->json(false);
            }
        }else{
            return response()->json(false);
        }
    }

    public function personsave(Request $request){
        if ($request->isMethod('post')) {
            if($request->has('pid')){
                $durum = DB::table('person')
                    ->where([
                        'id' => $request->pid,
                        'company_id' => $request->cid
                    ])
                    ->update([
                        'first_name' => trim($request->first_name),
                        'last_name' => trim($request->last_name),
                        'title' => trim($request->title),
                        'email' => trim($request->email),
                        'phone' => trim($request->phone)
                    ]);
            } else{
                $durum = DB::table('person')
                    ->insert([
                        'company_id' => trim($request->cid),
                        'first_name' => trim($request->first_name),
                        'last_name' => trim($request->last_name),
                        'title' => trim($request->title),
                        'email' => trim($request->email),
                        'phone' => trim($request->phone)
                    ]);
            }
            return response()->json($durum);
        } else {
            return response()->json(false);
        }
    }

    public function persondelete(Request $request){
        $durum = false;
        if ($request->isMethod('post')) {
            if($request->has('pid') && $request->has('cid')){
                $durum = DB::table('person')
                    ->where([
                        'id' => $request->pid,
                        'company_id' => $request->cid
                    ])
                    ->delete();
            }
        }

        return response()->json($durum);
    }

    /** Address *****************************/
    public function address(Request $request){
        $company = DB::table('company')->where('id', $request->cid)->first();
        $addresses = DB::table('address')->where('company_id', $request->cid)->orderBy('id')->get();
        return view('company.address',['company'=>$company, 'addresses'=>$addresses]);
    }

    public function addressinfo(Request $request){
        if ($request->isMethod('post')) {
            $address = DB::table('address')
                ->where([
                    'id' => $request->aid,
                    'company_id' => $request->cid
                ])
                ->first();
            if($address){
                return response()->json($address);
            }else{
                return response()->json(false);
            }
        }else{
            return response()->json(false);
        }
    }

    public function addresssave(Request $request){
        if ($request->isMethod('post')) {
            if($request->has('aid')){
                $durum = DB::table('address')
                    ->where([
                        'id' => $request->aid,
                        'company_id' => $request->cid
                    ])
                    ->update([
                        'address' => trim($request->address),
                        'latitude' => trim($request->latitude),
                        'longitude' => trim($request->longitude)
                    ]);
            } else{
                $durum = DB::table('address')
                    ->insert([
                        'company_id' => trim($request->cid),
                        'address' => trim($request->address),
                        'latitude' => trim($request->latitude),
                        'longitude' => trim($request->longitude)
                    ]);
            }
            return response()->json($durum);
        } else {
            return response()->json(false);
        }
    }

    public function addressdelete(Request $request){
        $durum = false;
        if ($request->isMethod('post')) {
            if($request->has('aid') && $request->has('cid')){
                $durum = DB::table('address')
                    ->where([
                        'id' => $request->aid,
                        'company_id' => $request->cid
                    ])
                    ->delete();
            }
        }

        return response()->json($durum);
    }

    private function get_html($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
