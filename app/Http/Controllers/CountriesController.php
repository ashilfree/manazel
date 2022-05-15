<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use Response;
use View;

class CountriesController extends Controller
{
    public function add_country()
    {
        return view('/countries/add_country');
    }

    public function all_countries()
    {
        $countries = Country::orderBy('id', 'DESC')->paginate(20);
        return view('/countries/all_countries', [ 'countries' => $countries ]);
    }

    public function modify_country($id)
    {
        $country = Country::where('id', $id)->firstOrFail();
        return view('/countries/modify_country', [ 'country' => $country ]);
    }

    public function set_country(Request $Request)
    {
        $rules = array(
            'ar_name' => 'required',
            'en_name' => 'required',
            'country_code' => 'required',
            'phone_code' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_name.required'=>'برجاء أدخال أسم الدولة بالغة العربية',
                'en_name.required'=>'برجاء أدخال أسم الدولة بالغة الانجليزية',
                'country_code.required'=>'برجاء أدخال رمز الدولة',
                'phone_code.required'=>'برجاء أدخال كود هاتف الدولة',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_name.required'=>'Please enter country name in arabic',
                'en_name.required'=>'Please enter country name in english',
                'country_code.required'=>'Please enter country code',
                'phone_code.required'=>'Please enter country phone code',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_name', 'en_name', 'phone_code');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        $country = new Country();
        $country->name = $Request->ar_name;
        $country->en_name = $Request->en_name;
        $country->country_code = $Request->country_code;
        $country->phone_code = $Request->phone_code;
        $country->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة الدولة بنجاح", "Country successfully added");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function update_country_data(Request $Request)
    {
        $country = Country::where('id', $Request->country_id)->firstOrFail();
        $rules = array(
            'ar_name' => 'required',
            'en_name' => 'required',
            'country_code' => 'required',
            'phone_code' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_name.required'=>'برجاء أدخال أسم الدولة بالغة العربية',
                'en_name.required'=>'برجاء أدخال أسم الدولة بالغة الانجليزية',
                'country_code.required'=>'برجاء أدخال رمز الدولة',
                'phone_code.required'=>'برجاء أدخال كود هاتف الدولة',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_name.required'=>'Please enter country name in arabic',
                'en_name.required'=>'Please enter country name in english',
                'country_code.required'=>'Please enter country iso code',
                'phone_code.required'=>'Please enter country phone code',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_name', 'en_name', 'phone_code');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        $country->name = $Request->ar_name;
        $country->en_name = $Request->en_name;
        $country->country_code = $Request->country_code;
        $country->phone_code = $Request->phone_code;
        $country->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الدولة بنجاح", "The country has been successfully modified");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function find_country(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;

        if($all == 'yes')
        {
            $countries = Country::orderBy('id', 'DESC')->paginate(20);
            $countries->setPath('/countries');
        }
        else
        {
            if(app()->getLocale() == "ar")
            {
                $countries = Country::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);

            }
            elseif (app()->getLocale() == "en")
            {
                $countries = Country::where('en_name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);

            }
            else
            {
                $countries = Country::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('countries.find_country_tl', array('countries' => $countries, 'all' => $all))->render());
    }

    public function delete_country(Request $request)
    {
        $country_id = $request->country_id;

        $country = Country::where('id', $country_id)->firstOrFail();

        if($country->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الدولة بنجاح", "Country successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
