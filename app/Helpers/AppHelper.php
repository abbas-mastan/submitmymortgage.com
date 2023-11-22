<?php

use Carbon\Carbon;
use App\Models\{Media};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Returns prefix for routes to be used by admin
function getSuperAdminRoutePrefix()
{
    return "/superadmin";
}
function getAdminRoutePrefix()
{
    return "/admin";
}
//Returns prefix for routes to be used by admin
function getUserRoutePrefix()
{
    return "/user";
}
function getAssociateRoutePrefix()
{
    return "/associate";
}
function getAssistantRoutePrefix()
{
    return "/assistant";
}
//Returns prefix for routes to be used by admin
function getRoutePrefix()
{
    switch (session('role')) {
        case 'Admin':
            return getAdminRoutePrefix();
            break;

            case 'Super Admin':
            return getSuperAdminRoutePrefix();
            break;

        case 'Processor':
            return getAdminRoutePrefix();
            break;

        case 'Associate':
            return getAssociateRoutePrefix();
            break;

        case 'Junior Associate':
            return getAssociateRoutePrefix();
            break;

        case 'Borrower':
            return getUserRoutePrefix();
            break;
        case 'Assistant':
            return getAssistantRoutePrefix();
            break;
    }
}

function getVariable($var)
{
    if ($var == 'Basic Info') {
        return auth()
            ->user()
            ->info()
            ->exists();
    }
    if ($var == 'Credit Report') {
        return Auth::user()
            ->media()
            ->where('category', 'Credit Report')
            ->exists();
    }
    if ($var == 'Bank Statements') {
        return Auth::user()
            ->media()
            ->where('category', 'Bank Statements')
            ->exists();
    }
    if ($var == 'Tax Returns') {
        return Auth::user()
            ->media()
            ->where('category', 'Tax Returns')
            ->exists();
    }
    if ($var == 'Pay Stubs') {
        return Auth::user()
            ->media()
            ->where('category', 'Pay Stubs')
            ->exists();
    }
    if ($var == "ID/Driver' License") {
        return Auth::user()
            ->media()
            ->where('category', "ID/Driver's License")
            ->exists();
    }
    if ($var == '1003 Form') {
        return Auth::user()
            ->media()
            ->where('category', '1003 Form')
            ->exists();
    }
    if ($var == 'Mortgage Statement') {
        return Auth::user()
            ->media()
            ->where('category', 'Mortgage Statement')
            ->exists();
    }
    if ($var == 'Evidence Of Insuranc') {
        return Auth::user()
            ->media()
            ->where('category', 'Evidence of Insurance')
            ->exists();
    }
    if ($var == 'Purchase Agreement') {
        return Auth::user()
            ->media()
            ->where('category', 'Purchase Agreement')
            ->exists();
    }
    if ($var == 'Miscellaneous') {
        return  Auth::user()
            ->media()
            ->where('category', 'Miscellaneous')
            ->exists();
    }
    if ($var == 'Loan Application') {
        return auth()
            ->user()
            ->application()
            ->exists();
    }else{
        return Auth::user()->media()->where('category',$var)->exists();
    }
}

// applications index blade tables ids 
function getTableId($key)
{
    $table = [0 => 'user-table', 1 => 'completed-table', 2 => 'incomplete-table' ,3 => 'deleted-table'];
    return $table[$key] ?? null;
}

//Returns path for directory
function getFileDirectory()
{
    return "uploaded-media/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
}

function getGmailFileDirectory()
{
    return "gmail-attachments/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
}

//Takes a date and returns an amer
function convertDBDateUSFormat($date)
{
    if (!empty($date)) {
        try {
            if (str_contains($date, ":")) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
                return $date->format('n-j-Y  g:i a');
            } else {
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
function fileCatSubmittedByClient($cat, $userId)
{
    $cat = str_replace('-', '/', $cat);
    $submited = Media::where('user_id', $userId)
        ->where('category', $cat)
        ->exists();
    if (
        !$submited || Media::where('user_id', $userId)
        ->where('category', $cat)->count() === 0
    ) {
        return false;
    }
    return true;
}
//Returns carbon date with
function fileCatVerified($cat, $userId)
{
    $cat = str_replace('-', '/', $cat);
    $verfied = Media::where('user_id', $userId)
        ->where('category', $cat)
        ->where(function ($q) {
            $q->where('status', 'Not Verified')->orWhereNull('status');
        })->exists() || Media::where('user_id', $userId)
        ->where('category', $cat)->count() == 0;
    if ($verfied) {
        return false;
    }
    return true;
}
//Returns carbon date with
function getCatComments($cat, $userId)
{
    $cat = str_replace('-', '/', $cat);
    $comment = Media::where('user_id', $userId)
        ->where('category', $cat)
        ->whereNotNull('cat_comments')
        ->first();
    if ($comment) {
        return $comment->cat_comments;
    }
    return "";
}
//Returns carbon date with
function getUserCatComments($cat, $userId)
{
    $cat = str_replace('-', '/', $cat);
    $comment = Media::where('user_id', $userId)
        ->where('category', $cat)
        ->whereNotNull('user_cat_comments')
        ->first();
    if ($comment) {
        return $comment->user_cat_comments;
    }
    return "";
}
//Returns carbon date with
function fileCatCount($cat, $userId)
{
    $cat = str_replace('-', '/', $cat);
    return DB::table('media')->where('user_id',$userId)->where('category',$cat)->count();
}
//Returns link for the category
function getCatLink($cat)
{
    $cat = str_replace('-', '/', $cat);
    return match ($cat) {
        "Bank Statements" => "bank-statement",
        "Pay Stubs" => "pay-stub",
        "Tax Returns" => "tax-return",
        "ID/Driver's License" => "id-license",
        "1003 Form" => "1003",
        "Mortgage Statement" => "mortgage-statement",
        "Evidence of Insurance" => "insurance-evidence",
        "Purchase Agreement" => "purchase-agreement",
        "Miscellaneous" => "miscellaneous",
        "Loan Application" => "application",
        "Credit Report" => "credit-report",
        "Basic Info" => "basic-info",
        // default => "category/".Str::of($cat)->slug('-'),
        default => "category/".str_replace(' ','-',$cat),
    };
}