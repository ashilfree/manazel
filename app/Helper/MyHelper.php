<?php


namespace App\Helper;

use App\Setting;
use Illuminate\Support\Facades\Session;
use App\User;

class MyHelper
{
    private const SERVER_KEY = 'AAAAJWM_Ato:APA91bGrf9EGBFUy_fcniyGhIvADwcYr33eb9RK2Y-2t7oaPGHLxfcQ-f7A3j-O-SbW2_To5KlIsFbQowT7NCoNg-sAPbuFNxbGPUIIoiZh5Rdh18nKjYYXC1gSlkufgm94n02cDK4VP';


    public static function ReturnMessageByLang($ar, $en)
    {
        if(auth()->check() && auth()->user()->lang)
        {
            if(auth()->user()->lang == 'ar')
            {
                return $ar;
            }
            elseif(auth()->user()->lang == 'en')
            {
                return $en;
            }
            else
            {
                return $ar;
            }
        }
        else
        {
            if (session()->has('lang'))
            {
                if(session()->get('lang') == 'ar')
                {
                    return $ar;
                }
                elseif(session()->get('lang') == 'en')
                {
                    return $en;
                }
                else
                {
                    return $ar;
                }
            }
            else
            {
                if(app()->getLocale() == 'ar')
                {
                    return $ar;
                }
                elseif(app()->getLocale() == 'en')
                {
                    return $en;
                }
                else
                {
                    return $ar;
                }
            }
        }
    }

    public static function getFileNameFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        return basename($path);
    }

    public static function ShowWelcomeMessage()
    {
        //Session::pull('welcome_message');

        $welcome_message = Setting::where('name', 'welcome_message')->first();
        if($welcome_message)
        {
            if($welcome_message->status == 1)
            {
                if(!Session::has('welcome_message'))
                {
                    Session::put('welcome_message', true);
                    return $welcome_message;
                }
                else
                {
                    return null;
                }
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }

    public static function ReturnValueByLang($ar, $en)
    {
        if(app()->getLocale() == 'ar')
        {
            return $ar;
        }
        elseif(app()->getLocale() == 'en')
        {
            return $en;
        }

    }

    public static function GetYoutubeVideoId($link)
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $matches);
        $id = $matches[1];
        return $id;
    }

    public static function GetBase64Image($image_name)
    {

        return 'data: '.mime_content_type(storage_path('app/user_images/'.$image_name)).';base64,'.base64_encode(file_get_contents(storage_path('app/user_images/'.$image_name)));
    }

    public static function returnBase64Image($path)
    {

        return 'data: '.mime_content_type($path).';base64,'.base64_encode(file_get_contents($path));
    }

    public static function returnBase64Data($path)
    {

        if($path && file_exists($path))
        {
            return 'data: '.mime_content_type($path).';base64,'.base64_encode(file_get_contents($path));
        }
        else
        {
            return null;
        }

    }

    public static function GetDateFromTimeStamp($dt)
    {
        if(app()->getLocale() == 'ar')
        {
            //$date = new \DateTime($dt);
            //$string = $date->format('Y-m-d');
            $pieces1 = explode(" ", $dt);

            $pieces = explode("-", $pieces1[0]);
            $day = $pieces[0];
            $month = $pieces[1];
            $year = $pieces[2];

            switch ($month) {
                case 1:
                    $month = "يناير";
                    break;
                case 2:
                    $month = "فبراير";
                    break;
                case 3:
                    $month = "مارس";
                    break;
                case 4:
                    $month = "أبريل";
                    break;
                case 5:
                    $month = "مايو";
                    break;
                case 6:
                    $month = "يونيو";
                    break;
                case 7:
                    $month = "يوليو";
                    break;
                case 8:
                    $month = "أغسطس";
                    break;
                case 9:
                    $month = "سبتمبر";
                    break;
                case 10:
                    $month = "أكتوبر";
                    break;
                case 11:
                    $month = "نوفمبر";
                    break;
                case 12:
                    $month = "ديسمبر";
                    break;
                default:
                    $month = $month;
            }
            return $year . " " . $month . " " . $day;
        }
        elseif(app()->getLocale() == 'en')
        {
            $date = new \DateTime($dt);
            $date = $date->format('d F Y');
            return $date;
        }
    }

    public static function GetRating($rating)
    {
        if(app()->getLocale() == 'en')
        {
            if ($rating == 0.5)
            {
                return '<i class="fas fa-star-half-alt red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';

            }
            elseif ($rating == 1)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 1.5)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="fas fa-star-half-alt red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 2)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="fas fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 2.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt gold-color"></i>
                        <i class="far fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 3)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 3.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 4)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 4.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt gold-color"></i>';
            }
            elseif ($rating == 5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>';
            }
        }
        elseif (app()->getLocale() == 'ar')
        {
            if ($rating == 0.5)
            {
                return '<i class="fas fa-star-half-alt fa-flip-horizontal red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';

            }
            elseif ($rating == 1)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 1.5)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="fas fa-star-half-alt fa-flip-horizontal red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 2)
            {
                return '<i class="fas fa-star red-color"></i>
                        <i class="fas fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>
                        <i class="far fa-star red-color"></i>';
            }
            elseif ($rating == 2.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt fa-flip-horizontal gold-color"></i>
                        <i class="far fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 3)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 3.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt fa-flip-horizontal gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 4)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="far fa-star gold-color"></i>';
            }
            elseif ($rating == 4.5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star-half-alt fa-flip-horizontal gold-color"></i>';
            }
            elseif ($rating == 5)
            {
                return '<i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>
                        <i class="fas fa-star gold-color"></i>';
            }
        }
    }

    public static function ChangeTimestampFormat($timestamp)
    {
        if(app()->getLocale() == 'ar')
        {
            $date = new \DateTime($timestamp);
            $time = $date->format('H');
            if($time < '12')
            {
                $string = $date->format('Y-m-d - g:i');
                return $string . ' ص';
            }
            elseif($time >= '12')
            {
                $string = $date->format('Y-m-d - g:i');
                return $string . ' م';
            }
        }
        elseif(app()->getLocale() == 'en')
        {
            $date = new \DateTime($timestamp);
            $time = $date->format('d-m-Y - g:i A');
            return $time;
        }
    }

    public static function arTimestampFormat($timestamp)
    {
            $date = new \DateTime($timestamp);
            $time = $date->format('H');
            if($time < '12')
            {
                $string = $date->format('Y-m-d - g:i');
                return $string . ' ص';
            }
            elseif($time >= '12')
            {
                $string = $date->format('Y-m-d - g:i');
                return $string . ' م';
            }

    }

    public static function ChangeARTimestampFormat($timestamp)
    {
        $date = new \DateTime($timestamp);
        $time = $date->format('H');
        if($time < '12')
        {
            $string = $date->format('Y-m-d - g');
            return $string . ' ص';
        }
        elseif($time >= '12')
        {
            $string = $date->format('Y-m-d - g');
            return $string . ' م';
        }

    }

    public static function saveBase64ToFile($base64_data, $save_path, $image_name)
    {
        $image_blob = $base64_data;
        $img = str_replace('data:image/png;base64,', '', $image_blob);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $img = explode(',', $image_blob);
        $ini =substr($img[0], 11);
        $type = explode(';', $ini);

        //$image_name= time().'.'.$type[0];
        $path = base_path() . $save_path . $image_name;
        file_put_contents($path, $data);

        /*$img = str_replace('data:image/png;base64,', '', $base64_data);
        $img = str_replace(' ', '+', $img);
        $imageStr = base64_decode($img);
        $image = imagecreatefromstring($imageStr);
        $path = base_path() . $save_path . $image_name;
        imagepng($image, $path);*/

    }

    public static function SendNotification($title, $notification, $user_id = null, $notificationTo = null)
    {
        $target_array = array();
        $target = '/topics/all';

        if($user_id)
        {
            $user_token = User::select('push_token')->where('id', $user_id)->first();
            if($user_token)
            {
                array_push($target_array, $user_token->push_token);
            }
            $target = $target_array;
        }

        if($notificationTo == "students")
        {
            $target = '/topics/students';
        }
        elseif ($notificationTo == "teachers")
        {
            $target = '/topics/teachers';
        }

        $notif_title = $title;
        $notif_body = $notification;
        $data = array("title" => $notif_title,
            "body" => $notif_body,
            "vibrate"=>1,
            "sound"=> "default",
            "soundname"=> "default",
            "image"=> "note");



        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array();
        $fields['notification'] = $data;
        if(is_array($target))
        {
            $fields['registration_ids'] = $target;
        }
        else
        {
            $fields['to'] = $target;
        }

        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.self::SERVER_KEY
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE)
        {
            //die('Oops! FCM Send Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        else
        {
            curl_close($ch);
            return true;
        }
        curl_close($ch);
    }
}