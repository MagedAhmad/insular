<?php

use Illuminate\Http\JsonResponse;
use MagedAhmad\Insular\Types\MetaType;
use MagedAhmad\Insular\Types\MessageType;
use MagedAhmad\Insular\Exceptions\AppException;
use MagedAhmad\Insular\Jobs\RespondErrorJsonJob;
use MagedAhmad\Insular\Types\ErrorResponsePayload;

if (! function_exists('ok')) {
    function ok(MessageType $message = null, int $status = 200, $data = null, array $filters = [], MetaType $meta = null, $ranges = null, $range = null): JsonResponse
    {
        $response = [];

        if ($data) {
            $response['data'] = $data;
        }


        if ($message) {
            $response['message'] = $message;
        }

        if ($status) {
            $response['status'] = $status;
        }

        return response()->json($response);
    }
}

if (! function_exists('err')) {
    function err(MessageType $message = null, int $status = 200, array $data = []): JsonResponse
    {
        return (new RespondErrorJsonJob(
            error: new ErrorResponsePayload(
            status: $status,
            message: $message,
            data: $data,
        )
        ))->do();
    }
}

if (! function_exists('gobad')) {
    function gobad(string $message = 'bad_request')
    {
        throw new AppException($message);
    }
}


if (! function_exists('rename_file')) {

    /**
     * Rename a file before uploading it.
     *
     * @param File
     * @return string|null
     */
    function rename_file($file): ?string
    {
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $random = \Str::random(30);
            return "{$time}.{$random}.$extension";
        }
        return null;
    }
}


/*
 * Transform indian numbers into 123 numbers.
 */
function ar_numbers(string $numbers): ?string
{
    if ($numbers) {
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $replacedNumbers = str_replace(
            search: $eastern,
            replace: $western,
            subject: $numbers
        );

        if ($replacedNumbers) {
            return $replacedNumbers;
        }
    }
    return null;
}

/*
 * Get full international mobile number with country code.
 */
function full_mobile(string $mobile, ?string $mobile_code = '966'): ?int
{
    $mobile = ar_numbers(numbers: $mobile);

    // Sanitize mobile number string, remove leading 0, leading + and any letters.
    $mobile = (int) $mobile;

    // Sanitize mobile code number string, remove leading 0, leading + and any letters.
    $mobile_code = (int) $mobile_code;

    // After sanitizing check if we still have a mobile number to work with.
    if (! $mobile) {
        return null;
    }

    if (preg_match(
        pattern: '/^' . preg_quote(str: (string) $mobile_code, delimiter: '/') . '/',
        subject: (string) $mobile
    )) {
        $int = preg_replace(
            pattern: '/'.$mobile_code.'/',
            replacement: '',
            subject: (string) $mobile,
            limit: 1
        );

        $mobile = (int) $int;
    }

    return (int) "{$mobile_code}{$mobile}";
}

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
