<?php
use App\Models\Log;
use App\Models\Media;
use App\Models\UserMeta;
use App\Models\Setting;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Returns prefix for routes to be used by admin
function getAdminRoutePrefix()
{
    
    return "/admin";
}
//Returns prefix for routes to be used by admin
function getUserRoutePrefix()
{
    return "/user";
}
//Returns prefix for routes to be used by admin
function getRoutePrefix()
{
    switch (session('role')) {
        case 'admin':
            # code...
            return getAdminRoutePrefix();
            break;

            case 'user':
                # code...
                return getUserRoutePrefix();
                break;
    }
}

//Returns path for directory
function getFileDirectory() {
    return "uploaded-media/".date('Y')."/".date('m')."/".date('d')."/";
}

function getGmailFileDirectory() {
    return "gmail-attachments/".date('Y')."/".date('m')."/".date('d')."/";
}
//Logging actions performed by the user.
function logActivity($user_id,$action,$action_details,$nature,$level="Normal")
{
    $log = new Log();
    $log->action = $action;
    $log->details = $action_details;
    $log->nature = $nature;
    $log->level = $level;
    $log->user_id = $user_id;
    $log->save();
    
}

//Get month from number
function getMonthName($month)
{
    
    switch ($month) {
        case 1:
            return "January";
        case 2:
            return "February";
        case 3:
            return "March";
        case 4:
            return "April";
        case 5:
            return "May";
        case 6:
            return "June";
        case 7:
            return "July";
        case 8:
            return "August";
        case 9:
            return "September";
        case 10:
            return "October";
        case 11:
            return "November";
        case 12:
            return "December";        
    }
    
}
//Get short month name from number
function getShortMonthName($month)
{
    
    switch ($month) {
        case 1:
            return "Jan";
        case 2:
            return "Feb";
        case 3:
            return "Mar";
        case 4:
            return "Apr";
        case 5:
            return "May";
        case 6:
            return "Jun";
        case 7:
            return "Jul";
        case 8:
            return "Aug";
        case 9:
            return "Sep";
        case 10:
            return "Oct";
        case 11:
            return "Nov";
        case 12:
            return "Dec";        
    }
    
}

//Save a meta value for a user
function saveUserMeta($userId,$metaKey,$metaValue)
{    
    $userMeta = new UserMeta();
    $userMeta->user_id = $userId;
    $userMeta->meta_key = $metaKey;
    $userMeta->meta_value = $metaValue;
    $userMeta->save();
    return $userMeta->save();
}

//Get meta value for a user
function getUserMeta($userId,$metaKey)
{    
    if($meta = UserMeta::where('user_id',$userId)
            ->where('meta_key',$metaKey)
            ->first())
    {
        return $meta->meta_value;
    }
    return false;        
    
    
}
//Updates meta value for a user
function updateUserMeta($userId,$metaKey,$newValue)
{    
    $userMeta = UserMeta::where('user_id',$userId)
            ->where('meta_key',$metaKey)
            ->first();
    if($userMeta)
    {
        $userMeta->meta_value = $newValue;
        return $userMeta->save();
    }
    else
    {
        return saveUserMeta($userId, $metaKey, $newValue);
    }
    return false;
    
}

//Save a setting value for a user
function saveSetting($tbl,$key,$value,$userId,$itemId)
{    
    $setting = new Setting();
    $setting->tbl = $tbl;
    $setting->setting_key = $key;
    $setting->setting_value = $value;
    $setting->user_id = $userId;
    $setting->item_id = $itemId;
    return $setting->save();
}

//Get setting value for a user
function getSetting($tbl,$key,$userId,$itemId)
{    
    if($setting = Setting::where('tbl',$tbl)
            ->where('setting_key',$key)
             ->where('user_id',$userId)            
            ->where('item_id',$itemId)
            ->first())
    {
        return $setting->setting_value;
    }
    return false;        
    
    
}


//Updates setting value for a user
function saveOrUpdateSetting($tbl,$key,$value,$userId,$itemId)
{    
    $setting = Setting::where('tbl',$tbl)
            ->where('setting_key',$key)
             ->where('user_id',$userId)            
            ->where('item_id',$itemId)
            ->first();
    if($setting)
    {
        $setting->setting_value = $value;
        return $setting->save();
    }
    else
    {
        return saveSetting($tbl,$key,$value,$userId,$itemId);
    }
    return false;
    
}

//Updates setting value for a user
function deleteOrUpdateSetting($tbl,$key,$value,$userId,$itemId)
{    
    $setting = Setting::where('tbl',$tbl)
            ->where('setting_key',$key)
             ->where('user_id',$userId)            
            ->where('item_id',$itemId)
            ->first();
    if($setting)
    {
        return $setting->delete();
    }
    return false;
    
}

//Finds if a student is registered in a course or not
//Returns true if registered, false otherwise
function isStudentRegisteredInCourse($courseId,$studentId,$teacherId)
{
    return DB::table('course_user')->where('course_id',$courseId)
            ->where('user_id',$studentId)
            ->where('teacher_id',$teacherId)
            ->exists();
}
//Finds if a student is registered in a course or not
//Returns true if registered, false otherwise
function isStudentInRoster($rosterId,$studentId)
{
    return DB::table('roster_user')->where('roster_id',$rosterId)
            ->where('user_id',$studentId)
            ->exists();
}
//Finds if a student has purchased encyclopedia
function hasStudentPurchasedEncyclopedia($studentId,$encyId = 0)
{
    if($encyId == 0)
        return User::find($studentId)->courses()
        ->where("type","encyclopedia")->exists();
    else
        return User::find($studentId)->courses()
            ->where("courses.id",$encyId)
            ->where("type","encyclopedia")
            ->exists();
}

//Finds if a package has a book or not
function isPackageHasBook($packageId)
{
   return Package::find($packageId)->courses()->where("type","book")->exists();
}

//Helper method for converting HTML5 form datetime-local to MySQL datetime field format
function convertHtml5DateTimeToMySQLFormat($datetime)
{
    $datetimeAr = explode("T", $datetime);
    return $datetimeAr[0]." ".$datetimeAr[1].":00";
}

//Shuffle models
function shuffleModels($models)
{
    $temp = [];
    foreach ($models as $model) {
        $temp[] = $model;
    }
    return collect($temp)->shuffle();
}

//Takes a date and returns an amer
function convertDBDateUSFormat($date)
{
    if(!empty($date))
    {
        try{
            if(str_contains($date, ":"))
            {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
                return $date->format('n-j-Y  g:i a');
            }
            else
            {
                $date = Carbon::createFromFormat('Y-m-d', $date);
                return $date->format('n-j-Y');
            }        
        } catch (Exception $ex) {
            return '';
        }
        
    }
    return '';
}

//Returns carbon date with
function todayDate()
{
    return Carbon::create(date('Y'),date('m'),date('d'));
}
//Returns carbon date with
function fileCatSubmittedByClient($cat, $userId)
{
    $cat = str_replace('-','/', $cat);
    $submited = Media::where('user_id',$userId)
    ->where('category', $cat)
    ->exists();
    if(!$submited || Media::where('user_id',$userId)
    ->where('category', $cat)->count() === 0)
    {
        return false;
    }
    return true;
}
//Returns carbon date with
function fileCatVerified($cat, $userId)
{
    $cat = str_replace('-','/', $cat);
    $verfied = Media::where('user_id',$userId)
    ->where('category',$cat)
    ->where(function($q){
        $q->where('status','Not Verified')->orWhereNull('status');
    })->exists() || Media::where('user_id',$userId)
    ->where('category',$cat)->count() == 0;
    if($verfied)
    {
        return false;
    }
    return true;
}
//Returns carbon date with
function getCatComments($cat, $userId)
{
    $cat = str_replace('-','/', $cat);
    $comment = Media::where('user_id',$userId)
    ->where('category',$cat)
    ->whereNotNull('cat_comments')
    ->first();
    if($comment)
    {
        return $comment->cat_comments;
    }
    return "";
}
//Returns carbon date with
function getUserCatComments($cat, $userId)
{
    $cat = str_replace('-','/', $cat);
    $comment = Media::where('user_id',$userId)
    ->where('category',$cat)
    ->whereNotNull('user_cat_comments')
    ->first();
    if($comment)
    {
        return $comment->user_cat_comments;
    }
    return "";
}
//Returns carbon date with
function fileCatCount($cat, $userId)
{
    $cat = str_replace('-','/', $cat);
    return Media::where('user_id',$userId)
    ->where('category',$cat)
    ->count();
}
//Returns link for the category
function getCatLink($cat)
{
    $cat = str_replace('-','/', $cat);
    $link = "";
    switch($cat)
    {
        case "Bank Statements":
            $link = "bank-statement";
            break;
        case "Bank Statements":
            $link = "bank-statement";
            break;
        case "Pay Stubs":
            $link = "pay-stub";
            break;
        case "Tax Returns":
            $link = "tax-return";
            break;
        case "ID/Driver's License":
            $link = "id-license";
            break;
        case "Loan Application":
            $link = "1003";
            break;
        case "Mortgage Statement":
            $link = "mortgage-statement";
            break;
        case "Evidence of Insurance":
            $link = "insurance-evidence";
            break;
        case "Purchase Agreement":
            $link = "purchase-agreement";
            break;
        case "Miscellaneous":
            $link = "miscellaneous";
            break;
        
        default:
            $link = "";
    }
    return $link;
}
