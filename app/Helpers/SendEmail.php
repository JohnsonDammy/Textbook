<?php

namespace App\Helpers;

use App\Mail\DeliveryUpdateMail;
use App\Mail\NewCollectionRequestMail;
use App\Mail\ReplenishRequestForm;
use App\Mail\SetNewPassword;
use App\Mail\UpdateCollectionRequestMail;
use App\Mail\UserProfileUpdate;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEmail
{

    public static function SetNewPassword($user = null)
    {
        try {
            $response = self::GenerateTokenLink($user);
            Mail::to($user->email)->send(new SetNewPassword($response));
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    public static function sendnotification($SchooName, $Year, $selectedV, $emis)
    {
        $district_id = School::where('emis', $emis)->value('district_id');
        $district_email = User::where('District_Id', $district_id)->value('email');
 
        $data = [
            'SchooName' => $SchooName,
            'year' => $Year,
            'selectedV' => $selectedV,
        ];
 
        // Send the email
        // Mail::send('emails.procurement_selection', $data, function ($message) use ($SchooName, $selectedV, $district_email) {
        //     $message->to('olokojohnsonitrelated@gmail.com');
        //     $message->subject("Procurement Selection Request: $selectedV");
        // });
 
        Mail::send('emails.procurement_selection', $data, function ($message) use ($SchooName, $selectedV, $district_email) {
            $message->to($district_email);
            $message->subject("Procurement Selection Request: $selectedV");
        });
 
        //  $success = "Successfully created your request for " . $currentYear;
 
    }

  


public static function sendSupplierEmail($refNo, $closingDate, $attach1, $attach2 , $email,$schoolName){
    $data = [
        'schoolName' => $schoolName,
        'closingDate' => $closingDate,
    ];

    // Send the email with three attachments
    Mail::send('emails.supplier_quotation', $data, function ($message) use ($email, $attach1, $attach2,$refNo) {
        $message->to($email);
        $message->subject("Quotation Required for Reference $refNo");

        // Attachments
        $message->attach($attach1);
        $message->attach($attach2);
      
       $message->from('Ellavarsi.Pillay@itrelated.co.za', 'Ella Pillay'); 
    });
}
 
    // SendEmail::sendnotificationew($SchooName, $Year, $messages, $emis, $ReferencesID);
 
    public static function sendnotificationew($SchooName, $Year, $messages, $emis, $ReferencesID)
    {
        $district_id = School::where('emis', $emis)->value('district_id');
        $district_email = User::where('District_Id', $district_id)->value('email');
 
        $data = [
            'SchooName' => $SchooName,
            'Year' => $Year,
            'messages' => $messages,
            'district_email' =>$district_email,
            'ReferencesID' =>$ReferencesID,
            'emis' =>  $emis,
        ];
 
        // Send the email
        // Mail::send('emails.procurement_selection', $data, function ($message) use ($SchooName, $selectedV, $district_email) {
        //     $message->to('olokojohnsonitrelated@gmail.com');
        //     $message->subject("Procurement Selection Request: $selectedV");
        // });
 
        Mail::send('emails.fundRequestNotification', $data, function ($message) use ($SchooName, $Year, $messages, $district_email, $ReferencesID , $emis) {
            $message->to($district_email);
            $message->subject("Section 21 C : $ReferencesID");
        });
 
        //  $success = "Successfully created your request for " . $currentYear;
 
    }

    public static function UserProfileUpdate($user = null)
    {
        try {
            $response = self::GenerateTokenLink($user);
            Mail::to($user->email)->send(new UserProfileUpdate($response));
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    public static function GenerateTokenLink($user = null)
    {
        $token = Str::random(20);
        DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make($token), 'created_at' => Carbon::now()]);
        $url = config('app.url') . '/password/reset/' . $token . '?email=' . $user->email;
        return  [
            'url' => $url,
            'user' => $user,
        ];
    }

    public static function NewCollectionRequest($collReq = null, $broken_items = null)
    {

        try {
            $url = config('app.url') . '/furniture-replacement/collect/reference/' . $collReq->ref_number;
            $data = [
                'ref_number' => $collReq->ref_number,
                'school_name' => $collReq->school_name,
                'emis' => $collReq->emis,
                'broken_items' => $broken_items,
                'url' => $url
            ];
            $manufacturers = DB::table("model_has_permissions")->where('permission_id', 26)->get();
            // dd($manufacturers);
            $emails = [];
            foreach ($manufacturers as $m) {
                $manufact = User::where('id', '=', $m->model_id)->first();
                array_push($emails, $manufact->email);
            }
            // dd($emails);

            Mail::to($emails)->send(new NewCollectionRequestMail($data));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function UpdateCollectionRequest($collReq = null, $broken_items_list = null)
    {

        try {
            $url = config('app.url') . '/furniture-replacement/collect/reference/' . $collReq->ref_number;
            $data = [
                'ref_number' => $collReq->ref_number,
                'school_name' => $collReq->school_name,
                'emis' => $collReq->emis,
                'broken_items' => $broken_items_list,
                'url' => $url
            ];
            $manufacturers = DB::table("model_has_permissions")->where('permission_id', 26)->get();
            // dd($manufacturers);
            $emails = [];
            foreach ($manufacturers as $m) {
                $manufact = User::where('id', '=', $m->model_id)->first();
                array_push($emails, $manufact->email);
            }
            // dd($emails);

            Mail::to($emails)->send(new UpdateCollectionRequestMail($data));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //sending annaxure-c
    public static function sendReplenishRquestForm($data)
    {
        $does = User::where('organization', '=', 3)->get();
        $emails = [];
        foreach ($does as $m) {

            array_push($emails, $m->email);
        }
        try {
            Mail::to($emails)->send(new ReplenishRequestForm($data));
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function SendDeliveryNotification($data)
    {
        $user = User::where('username', '=', $data->school->emis)->first();
        try {
            
            Mail::to($user->email)->send(new DeliveryUpdateMail($data));
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

//     public static function sendRecommendedSupplierMail($requestType,$schoolName, $email, $attach1)
//     {
//         $data = [
//             'schoolName' => $requestType,
//             'closingDate' => $schoolName,
//         ];
    
//         // Send the email with three attachments
//         Mail::send('emails.recommendedSupplierMessage', $data, function ($message) use ($email, $attach1, $requestType, $schoolName) {
//             $message->to($email);
//             $message->subject("Order for .$requestType  .$schoolName");
    
//             // Attachments
//             $message->attach($attach1);
//            $message->from('Ellavarsi.Pillay@itrelated.co.za', 'Ella Pillay'); 
//         });

//         
//     }


public static function sendRecommendedSupplierMail($requestType,$schoolName, $email, $attach1){
    $data = [
        'schoolName' => $requestType,
        'closingDate' => $schoolName,
    ];

    // Send the email with three attachments
    Mail::send('emails.recommendedSupplierMessage', $data, function ($message) use ($email, $attach1, $requestType, $schoolName) {
        $message->to($email);
        $message->subject("Order for .$requestType  .$schoolName");

        // Attachments
        $message->attach($attach1);
       $message->from('Ellavarsi.Pillay@itrelated.co.za', 'Ella Pillay'); 
    });
}
}
