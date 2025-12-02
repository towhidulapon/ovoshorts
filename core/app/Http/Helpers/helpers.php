<?php

use App\Constants\Status;
use App\Events\QrCodeLogin;
use App\Lib\Captcha;
use App\Lib\ClientInfo;
use App\Lib\CurlRequest;
use App\Lib\Export\ExportManager;
use App\Lib\FileManager;
use App\Lib\GoogleAuthenticator;
use App\Models\Extension;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\QrCode;
use App\Models\StorageSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Notify\Notify;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

function systemDetails()
{
    $system['name']                = 'ovopanel';
    $system['web_version']         = '1.0';
    $system['admin_panel_version'] = '1.0.1';
    $system['mobile_app_version']  = '1.0';
    $system['android_version']     = '1.0';
    $system['ios_version']         = '1.0';
    $system['flutter_version']     = '1.0';
    return $system;
}

function slug($string)
{
    return Str::slug($string);
}

function verificationCode($length)
{
    if ($length == 0) {
        return 0;
    }

    $min = pow(10, $length - 1);
    $max = (int) ($min - 1) . '9';
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters       = '1234567890';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function activeTemplate($asset = false)
{
    $template = session('template') ?? gs('active_template');
    if ($asset) {
        return 'assets/templates/' . $template . '/';
    }

    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $template = session('template') ?? gs('active_template');
    return $template;
}

function siteLogo($type = null)
{
    $name = $type ? "/logo_$type.png" : '/logo.png';
    return getImage(getFilePath('logoIcon') . $name);
}
function siteFavicon()
{
    return getImage(getFilePath('logoIcon') . '/favicon.png');
}

function loadReCaptcha()
{
    return Captcha::reCaptcha();
}

function loadCustomCaptcha($width = '100%', $height = 46, $bgColor = '#003')
{
    return Captcha::customCaptcha($width, $height, $bgColor);
}

function verifyCaptcha()
{
    return Captcha::verify();
}

function loadExtension($key)
{
    $extension = Extension::where('act', $key)->where('status', Status::ENABLE)->first();
    return $extension ? $extension->generateScript() : '';
}

function getTrx($length = 12)
{
    $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount ?? 0, $length);
    return $amount + 0;
}

function showAmount($amount, $decimal = null, $separate = true, $exceptZeros = false, $currencyFormat = true, $separator = '')
{
    if (!$decimal) {
        $decimal = gs('allow_precision');
    }

    if ($separate && !$separator) {
        $separator = str_replace(['space', 'none'], [' ', ''], gs('thousand_separator'));
    }

    $printAmount = number_format($amount, $decimal, '.', $separator);
    if ($exceptZeros) {
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        } else {
            $printAmount = rtrim($printAmount, '0');
        }
    }
    if ($currencyFormat) {
        if (gs('currency_format') == Status::CUR_BOTH) {
            return gs('cur_sym') . $printAmount . ' ' . __(gs('cur_text'));
        } elseif (gs('currency_format') == Status::CUR_TEXT) {
            return $printAmount . ' ' . __(gs('cur_text'));
        } else {
            return gs('cur_sym') . $printAmount;
        }
    }
    return $printAmount;
}

function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet)
{
    return "https://api.qrserver.com/v1/create-qr-code/?data=$wallet&size=300x300&ecc=m";
}

function keyToTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}

function titleToKey($text)
{
    return strtolower(str_replace(' ', '_', $text));
}

function strLimit($title = null, $length = 10)
{
    return Str::limit($title, $length);
}

function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}

function osBrowser()
{
    $osBrowser = ClientInfo::osBrowser();
    return $osBrowser;
}

function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website']      = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url                   = "#";
    $response              = CurlRequest::curlPostContent($url, $param);
    if ($response) {
        return $response;
    } else {
        return null;
    }
}

function getPageSections($arr = false)
{
    $jsonUrl  = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}

function getImage($image, $size = null, $isAvatar = false)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    if ($isAvatar) {
        return asset('assets/images/avatar.jpg');
    }
    if ($size) {
        return route('placeholder.image', $size);
    }
    return asset('assets/images/default.png');
}

function notify($user, $templateName, $shortCodes = null, $sendVia = null, $createLog = true, $pushImage = null)
{
    $globalShortCodes = [
        'site_name'       => gs('site_name'),
        'site_currency'   => gs('cur_text'),
        'currency_symbol' => gs('cur_sym'),
    ];

    if (gettype($user) == 'array') {
        $user = (object) $user;
    }

    $shortCodes = array_merge($shortCodes ?? [], $globalShortCodes);

    $notify               = new Notify($sendVia);
    $notify->templateName = $templateName;
    $notify->shortCodes   = $shortCodes;
    $notify->user         = $user;
    $notify->createLog    = $createLog;
    $notify->pushImage    = $pushImage;
    $notify->userColumn   = isset($user->id) ? $user->getForeignKey() : 'user_id';
    $notify->send();
}

function getPaginate($paginate = null)
{
    if (!$paginate) {
        $paginate = request()->paginate ?? gs('paginate_number');
    }
    return $paginate;
}

function getOrderBy($orderBy = null)
{
    if (!$orderBy) {
        $orderBy = request()->order_by ?? 'desc';
    }
    return $orderBy;
}

function paginateLinks($data, $view = null)
{
    $paginationHtml = $data->appends(request()->all())->links($view);
    echo '<div class="pagination-wrapper w-100">' . $paginationHtml . '</div>';
}

function menuActive($routeName, $param = null, $className = 'active')
{

    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $className;
            }

        }
    } elseif (request()->routeIs($routeName)) {
        if ($param) {
            $routeParam = array_values(@request()->route()->parameters ?? []);
            if (strtolower(@$routeParam[0]) == strtolower($param)) {
                return $className;
            } else {
                return;
            }

        }
        return $className;
    }
}

function fileUploader($file, $location, $size = null, $old = null, $thumb = null, $filename = null)
{
    $fileManager           = new FileManager($file);
    $fileManager->path     = $location;
    $fileManager->size     = $size;
    $fileManager->old      = $old;
    $fileManager->thumb    = $thumb;
    $fileManager->filename = $filename;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager()
{
    return new FileManager();
}

function getFilePath($key)
{
    return fileManager()->$key()->path;
}

function getFileSize($key)
{
    return fileManager()->$key()->size;
}

function getFileExt($key)
{
    return fileManager()->$key()->extensions;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    if (!$lang) {
        $lang = getDefaultLang();
    }

    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function checkSpecialRegex($string)
{
    $regex = '/[+\-*\/%==!=<>]=?|&&|\|\||\.\.|::|->|@|\$|\^|~|\[|\]|\{|\}|\(|\)|;|,|=>|:]/';
    return preg_match($regex, $string);
}

function showDateTime($date, $format = null, $lang = null)
{
    if (!$date) {
        return '-';
    }
    if (!$lang) {
        $lang = session()->get('lang');
        if (!$lang) {
            $lang = getDefaultLang();
        }
    }

    if (!$format) {
        $format = gs('date_format') . ' ' . gs('time_format');
    }

    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}

function getDefaultLang()
{
    return config('app.local') ?? 'en';
}

function getContent($dataKeys, $singleQuery = false, $limit = null, $orderById = false)
{

    $templateName = activeTemplateName();
    if ($singleQuery) {
        $content = Frontend::where('tempname', $templateName)->where('data_keys', $dataKeys)->orderBy('id', 'desc')->first();
    } else {
        $article = Frontend::where('tempname', $templateName);
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if ($orderById) {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id')->get();
        } else {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id', 'desc')->get();
        }
    }
    return $content;
}

function verifyG2fa($user, $code, $secret = null)
{
    $authenticator = new GoogleAuthenticator();
    if (!$secret) {
        $secret = $user->tsc;
    }
    $oneCode  = $authenticator->getCode($secret);
    $userCode = $code;
    if ($oneCode == $userCode) {
        $user->tv = Status::YES;
        $user->save();
        return true;
    } else {
        return false;
    }
}

function urlPath($routeName, $routeParam = null)
{
    if ($routeParam == null) {
        $url = route($routeName);
    } else {
        $url = route($routeName, $routeParam);
    }
    $basePath = route('home');
    $path     = str_replace($basePath, '', $url);
    return $path;
}

function showMobileNumber($number)
{
    $length = strlen($number);
    return substr_replace($number, '***', 2, $length - 4);
}

function showEmailAddress($email)
{
    $endPosition = strpos($email, '@') - 1;
    return substr_replace($email, '***', 1, $endPosition);
}

function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }

    return $ip;
}

function appendQuery($key, $value)
{
    return request()->fullUrlWithQuery([$key => $value]);
}

function dateSort($a, $b)
{
    return strtotime($a) - strtotime($b);
}

function dateSorting($arr)
{
    usort($arr, "dateSort");
    return $arr;
}

function gs($key = null)
{
    $general = Cache::get('GeneralSetting');
    if (!$general) {
        $general = GeneralSetting::first();
        Cache::put('GeneralSetting', $general);
    }
    if ($key) {
        return @$general->$key;
    }

    return $general;
}
function isImage($string)
{
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension     = pathinfo($string, PATHINFO_EXTENSION);
    return in_array($fileExtension, $allowedExtensions);
}

function isHtml($string)
{
    if (preg_match('/<.*?>/', $string)) {
        return true;
    } else {
        return false;
    }
}

function convertToReadableSize($size)
{
    preg_match('/^(\d+)([KMG])$/', $size, $matches);
    $size = (int) $matches[1];
    $unit = $matches[2];

    if ($unit == 'G') {
        return $size . 'GB';
    }

    if ($unit == 'M') {
        return $size . 'MB';
    }

    if ($unit == 'K') {
        return $size . 'KB';
    }

    return $size . $unit;
}

function frontendImage($sectionName, $image, $size = null, $seo = false)
{
    if ($seo) {
        return getImage('assets/images/frontend/' . $sectionName . '/seo/' . $image, $size);
    }
    return getImage('assets/images/frontend/' . $sectionName . '/' . $image, $size);
}

function isApiRequest()
{
    return request()->is('api/*');
}
function isAjaxRequest()
{
    return request()->ajax();
}

function responseManager(string $remark, string $message, string $responseType = 'error', array $responseData = [], array $igNoreOnApi = [])
{

    if (isApiRequest() || isAjaxRequest()) {
        $notify[]     = $message;
        $ignoreForApi = array_merge($igNoreOnApi, ['view', 'pageTitle', 'redirect']);
        $responseData = array_diff_key(
            $responseData,
            array_flip($ignoreForApi)
        );
        $responseDataToSnake = array_combine(
            array_map(function ($key) {
                return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            }, array_keys($responseData)),
            array_values($responseData)
        );

        return apiResponse($remark, $responseType, $notify, $responseDataToSnake);
    }

    if (array_key_exists('redirect', $responseData)) {
        $notify[] = [$responseType, $message];
        return redirect()->route($responseData['redirect'])->withNotify($notify);
        // return to_route($responseData['redirect'])->withNotify($notify);
    }

    if (array_key_exists('view', $responseData)) {
        return view($responseData['view'], $responseData);
    }

    $notify[] = [$responseType, $message];
    return back()->withNotify($notify);
}

function apiResponse(string $remark, string $status, array $message = [], array $data = [], $statusCode = 200): JsonResponse
{
    $response = [
        'remark' => $remark,
        'status' => $status,
    ];

    if (count($message)) {
        $response['message'] = $message;
    }

    if (count($data)) {
        $response['data'] = $data;
    }

    return response()->json($response, $statusCode);
}

function exportData($baseQuery, $exportType, $modelName, $printPageSize = "A4 portrait")
{
    try {
        return (new ExportManager($baseQuery, $modelName, $exportType, $printPageSize))->export();
    } catch (Exception $ex) {
        $notify[] = ['error', $ex->getMessage()];
        return back()->withNotify($notify);
    }
}

function os(): array
{
    return [
        'windows',
        'windows 10',
        'windows 7',
        'windows 8',
        'windows xp' . 'linux',
        'apple',
        'android',
        'ubuntu',
    ];
}

function supportedDateFormats(): array
{
    return [
        'Y-m-d',
        'd-m-Y',
        'd/m/Y',
        'm-d-Y',
        'm/d/Y',
        'D, M j, Y',
        'l, F j, Y',
        'F j, Y',
        'M j, Y',
    ];
}
function supportedTimeFormats(): array
{
    return [
        'H:i:s',
        'H:i',
        'h:i A',
        'g:i a',
        'g:i:s a',
    ];
}
function supportedThousandSeparator(): array
{
    return [
        ","     => "Comma",
        "."     => "Dot",
        "'"     => "Apostrophe",
        "space" => "Space",
        "none"  => "None",
    ];
}

function getS3FileUri($fileName)
{
    static $wasabi     = null;
    static $s3Client   = null;
    static $bucketName = null;

    if ($wasabi === null) {
        $wasabi = StorageSetting::where('alias', 'wasabi')->first();

        if (!$wasabi || !isset($wasabi->parameters)) {
            return null;
        }

        $config = $wasabi->parameters;

        $accessKey  = $config->key->value ?? null;
        $secretKey  = $config->secret->value ?? null;
        $bucketName = $config->bucket->value ?? null;
        $region     = $config->region->value ?? null;
        $endpoint   = $config->endpoint->value ?? null;

        if (!$accessKey || !$secretKey || !$bucketName || !$endpoint) {
            return null;
        }

        $credentials = new Credentials($accessKey, $secretKey);

        $s3Client = new S3Client([
            'version'                 => 'latest',
            'region'                  => $region,
            'endpoint'                => $endpoint,
            'credentials'             => $credentials,
            'use_path_style_endpoint' => true,
        ]);
    }

    if (!$s3Client || !$bucketName) {
        return null;
    }

    $objectKey = 'shorts/' . $fileName;

    try {
        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucketName,
            'Key'    => $objectKey,
        ]);

        $request = $s3Client->createPresignedRequest($command, '+1 hour');
        return (string) $request->getUri();
    } catch (Exception $ex) {
        return null;
    }
}

if (!function_exists('s3Client')) {
    function s3Client($storage)
    {
        try {
            $s3Client = new S3Client([
                'region'                  => @$storage->parameters->region->value,
                'credentials'             => [
                    'key'    => @$storage->parameters->key->value,
                    'secret' => @$storage->parameters->secret->value,
                ],
                'endpoint'                => @$storage->parameters->endpoint->value,
                'use_path_style_endpoint' => true,
            ]);
            return $s3Client;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

function showFormatCount($num)
{
    if ($num >= 1000000) {
        return rtrim(rtrim(number_format($num / 1000000, 1), '0'), '.') . 'M';
    }
    if ($num >= 1000) {
        return rtrim(rtrim(number_format($num / 1000, 1), '0'), '.') . 'k';
    }
    return (string) $num;
}

function formatPlayTime($seconds)
{
    $seconds = (int) $seconds;
    $hours   = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf('%dh:%02dm:%02ds', $hours, $minutes, $seconds);
}

function prepareShortData($short, $userReactions = [])
{
    if ($short->storage_driver === 'wasabi') {
        $short->fileUrl = getS3FileUri($short->name);
    } elseif ($short->storage_driver === 'local') {
        $short->fileUrl = asset(getFilePath('shorts') . '/' . $short->name);
    } else {
        $short->fileUrl = route('short.file', $short->name);
    }

    $short->extension = pathinfo($short->name, PATHINFO_EXTENSION);

    $short->is_liked = in_array($short->id, $userReactions);

    $escapedDescription = e($short->description);
    $short->description = preg_replace(
        '/#(\w+)/',
        '<a href="' . url('short/$1') . '" class="hashtag"><strong>#$1</strong></a>',
        $escapedDescription
    );

    return $short;
}

function userReferralCommission($user, $amount)
{
    $referrer           = User::active()->find($user->ref_by);
    $referralPercentage = gs('referral_commission');

    if (!$referrer || $referralPercentage <= 0) {
        return false;
    }

    $referralAmount = ($amount * $referralPercentage) / 100;

    $referrer->balance += $referralAmount;
    $referrer->save();

    $transaction               = new Transaction();
    $transaction->user_id      = $referrer->id;
    $transaction->amount       = $referralAmount;
    $transaction->post_balance = $referrer->balance;
    $transaction->charge       = 0;
    $transaction->trx_type     = '+';
    $transaction->trx          = getTrx();
    $transaction->remark       = 'referral_commission';
    $transaction->details      = 'Referral Commission';
    $transaction->save();

    notify($referrer, 'REFERRAL_COMMISSION', [
        'amount'       => showAmount($referralAmount, currencyFormat: false),
        'user'         => $user->username,
        'trx'          => $transaction->trx,
        'remark'       => $transaction->remark,
        'post_balance' => showAmount($referrer->balance, currencyFormat: false),
    ]);

    return true;

}

function keyGenerator($length = 50)
{
    $characters = 'abcdefghijklmnpqrstuvwxyz0123456789';
    $string     = '';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}

function getQrCodeUrl($guard = 'user')
{
    $user       = auth()->user();
    $columnName = 'user_id';

    $qrCode = $user->qrCode;

    if (!$qrCode) {
        $qrCode              = new QrCode();
        $qrCode->$columnName = $user->id;
        $qrCode->unique_code = keyGenerator(15);
        $qrCode->save();
    }

    $uniqueCode = $qrCode->unique_code;
    $qrCode     = cryptoQR($uniqueCode);

    return $qrCode;
}

function getQrCodeUrlForLogin( $checkExists = true)
{

    if ($checkExists) {
        $qrCode = QrCode::first();
    } else {
        $qrCode = null;
    }

    if (!$qrCode) {
        $qrCode              = new QrCode();
        $qrCode->unique_code = keyGenerator(15);
        $qrCode->save();
    }

    $code = base64_encode($qrCode->unique_code);

    return $code;
}

function qrCodeLoginAttempt($guard, $encodeId, $encodedCode)
{
    try {
        $code = base64_decode($encodedCode);
    } catch (Exception $ex) {
        $notify[] = "The something went to wrong";
        return apiResponse('exception', "error", $notify);
    }

    $qrCode = QrCode::where('unique_code', $code)->first();

    if (!$qrCode) {
        $message[] = "The qr code token is mismatch, Please try again";
        return apiResponse('expired', 'error', $message);
    }

    try {
        $id = base64_decode($encodeId);
    } catch (Exception $ex) {
        $notify[] = "The something went to wrong";
        return apiResponse('exception', "error", $notify);
    }

    $user = User::find($id);

    if (!$user) {
        $notify[] = "The user account is not found";
        return apiResponse('not_found', "error", $notify);
    }

    if ($user->status == Status::USER_BAN) {
        $notify[] = "Your account is banned";
        return apiResponse('banned', "error", $notify);
    }

    if ($user->status == Status::USER_DELETE) {
        $notify[] = "Your account is deleted";
        return apiResponse('banned', "error", $notify);
    }

    //check the token
    $rawToken = base64_decode(request()->s_token);

    if (!$rawToken) {
        $notify[] = "Something went to wrong. Please try again";
        return apiResponse('exception', "error", $notify);
    }

    try {
        $rawToken = base64_decode(request()->s_token);
    } catch (Exception $ex) {
        $notify[] = "Something went to wrong. Please try again";
        return apiResponse('exception', "error", $notify);
    }

    [$tokenId, $token] = explode('|', $rawToken, 2);
    $accessToken       = PersonalAccessToken::find($tokenId);

    if (!$accessToken) {
        $notify[] = "Something went to wrong. Please try again";
        return apiResponse('error', "error", $notify);
    }

    if (!hash_equals($accessToken->token, hash('sha256', $token))) {
        $notify[] = "Something went to wrong. Please try again";
        return apiResponse('error', "error", $notify);
    }

    $tokenUser = @$accessToken->tokenable;

    if (@$tokenUser->username != @$user->username) {
        $notify[] = "Something went to wrong. Please try again";
        return apiResponse('error', "error", $notify);
    }

    Auth::loginUsingId($id);

    //save ip data
    $ip        = getRealIP();
    $exist     = UserLogin::where('user_ip', $ip)->first();
    $userLogin = new UserLogin();

    if ($exist) {
        $userLogin->longitude    = $exist->longitude;
        $userLogin->latitude     = $exist->latitude;
        $userLogin->city         = $exist->city;
        $userLogin->country_code = $exist->country_code;
        $userLogin->country      = $exist->country;
    } else {
        $info                    = json_decode(json_encode(getIpInfo()), true);
        $userLogin->longitude    = @implode(',', $info['long']);
        $userLogin->latitude     = @implode(',', $info['lat']);
        $userLogin->city         = @implode(',', $info['city']);
        $userLogin->country_code = @implode(',', $info['code']);
        $userLogin->country      = @implode(',', $info['country']);
    }

    $userAgent          = osBrowser();
    $userLogin->user_id = $user->id;
    $userLogin->user_ip = $ip;

    $userLogin->browser = @$userAgent['browser'];
    $userLogin->os      = @$userAgent['os_platform'];
    $userLogin->save();

    $notify[] = "Login successfully";
    return apiResponse('success', "success", $notify);
}

function verifyQrCodeForLogin($encodedCode)
{
    try {
        $code = base64_decode($encodedCode);
    } catch (Exception $ex) {
        $notify[] = "The something went to wrong";
        return apiResponse('exception', "error", $notify);
    }

    $qrCode = QrCode::where('unique_code', $code)->first();

    if (!$qrCode) {
        $message[] = "The qr code is not available, Please try again";
        return apiResponse('expired', 'error', $message);
    }

    $user  = auth()->user();
    $token = request()->bearerToken();

    event(new QrCodeLogin("user-qr-code-login", [
        "user"    => base64_encode($user->id),
        "s_token" => base64_encode($token),
        'qr_code' => $encodedCode,
    ]));

    $message[] = "Qr code login successfully";
    return apiResponse('success', 'success', $message);
}
