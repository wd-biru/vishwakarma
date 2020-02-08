<?php
function my_asset($path, $secure = null){
    return app('url')->asset("public/".$path, $secure);
    //return app('url')->asset($path, $secure);
}

function nameOrDash($object)
{
    return ($object && $object->name) ? $object->name : '--';
}

// function icon($icon)
// {
//     echo FA::icon($icon);
// }

function gravatar($email, $size = 30)
{
    $gravatarURL  = gravatarUrl($email, $size);

    return '<img id = '.$email.''.$size.' class="gravatar" src="'.$gravatarURL.'" width="'.$size.'">';
}

function gravatarUrl($email, $size)
{
    $email = md5(strtolower(trim($email)));
    //$gravatarURL = "https://www.gravatar.com/avatar/" . $email."?s=".$size."&d=mm";
    $defaultImage = urlencode('https://raw.githubusercontent.com/BadChoice/handesk/master/public/images/default-avatar.png');

    return 'https://www.gravatar.com/avatar/'.$email.'?s='.$size."&default={$defaultImage}";
}

function toTime($minutes)
{
    $minutes_per_day = (Carbon::HOURS_PER_DAY * Carbon::MINUTES_PER_HOUR);
    $days            = floor($minutes / ($minutes_per_day));
    $hours           = floor(($minutes - $days * ($minutes_per_day)) / Carbon::MINUTES_PER_HOUR);
    $mins            = (int) ($minutes - ($days * ($minutes_per_day)) - ($hours * 60));

    return "{$days} Days {$hours} Hours {$mins} Mins";
}

function toPercentage($value, $inverse = false)
{
    return  ($inverse ? 1 - $value : $value) * 100;
}

function createSelectArray($array, $withNull = false)
{
    
    if (! $array) {
        return [];
    }
    $values = $array->pluck('name', 'id')->toArray();
    if ($withNull) {
        return ['' => '--'] + $values;
    }

    return $values;
}
function getPortalImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('portal_images/'.$pImageName)){
        return Storage::disk('uploads')->url('portal_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('portal_images/default.jpg');
    }
}

function getVendorImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('portal_images/'.$pImageName)){
        return Storage::disk('uploads')->url('portal_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('portal_images/default.jpg');
    }
}

function getAdminImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('admin_images/'.$pImageName)){
        return Storage::disk('uploads')->url('admin_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('portal_images/default.jpg');
    }
}

function getChatImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('Chat_images/'.$pImageName)){
        return Storage::disk('uploads')->url('Chat_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('portal_images/default.jpg');
    }
}
function getCompanyImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('company_images/'.$pImageName)){
        return Storage::disk('uploads')->url('company_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('company_images/default.jpg');
    }
}
function getEmployeeImageUrl($pImageName){
    if(isset($pImageName) && $pImageName!="" && Storage::disk('uploads')->exists('profile_images/'.$pImageName)){
        return Storage::disk('uploads')->url('profile_images/'.$pImageName);
    }
    else{
        return Storage::disk('uploads')->url('profile_images/default.jpg');
    }
}
function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}
function displayLimitedWords($string, $count = 20) {
   
    $original_string = $string;
    $words = explode(' ', $original_string);

    if (count($words) > $count){
    $words = array_slice($words, 0, $count);
    $string = implode(' ', $words);
    }

    return $string;
}
function formatBookingStatus($pStatus,$pText){
    $retVal ='';
    if(isset($pText) && $pText!=""){
        switch($pStatus){
            case '0':
                $retVal='<span class="badge badge-dark">'.$pText.'</span>';
            break;
            case '1':
                $retVal='<span class="badge badge-success">'.$pText.'</span>';
            break;
            case '2':
                $retVal='<span class="badge badge-danger">'.$pText.'</span>';
            break;
            case '3':
                $retVal='<span class="badge badge-info">'.$pText.'</span>';
            break;
            case '4':
                $retVal='<span class="badge badge-primary">'.$pText.'</span>';
            break;
            default:
                $retVal='<span class="badge badge-dark">'.$pText.'</span>';
            break;
        }
    }
    return $retVal;
}
function formatDate($pDate,$pFormat="d/m/Y"){
    if(isset($pDate) && $pDate!=""){
        $pDate = date($pFormat,strtotime($pDate));
    }
    return $pDate;
}

////PMO PMO PMO

/**
 * Rupiah Format.
 *
 * @param int $number money in integer format
 *
 * @return string money in string format
 */
function formatNo($number)
{
    return number_format($number, 0, ',', '.');
}

function formatRp($number)
{
    $moneySign = Option::get('money_sign', 'EUR.');

    if ($number == 0) {
        return $moneySign.' 0';
    }

    if ($number < 0) {
        return '- '.$moneySign.' '.formatNo(abs($number));
    }

    return $moneySign.' '.formatNo($number);
}

function formatDecimal($number)
{
    return number_format($number, 2, ',', '.');
}


function dateId($date)
{
    if (is_null($date) || $date == '0000-00-00') {
        return '-';
    }

    $explodedDate = explode('-', $date);

    if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[2], $explodedDate[0])) {
        $months = getMonths();

        return $explodedDate[2].' '.$months[$explodedDate[1]].' '.$explodedDate[0];
    }

    throw new App\Exceptions\InvalidDateException('Invalid date format.');
}

function monthNumber($number)
{
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

function monthId($monthNumber)
{
    if (is_null($monthNumber)) {
        return $monthNumber;
    }

    $months = getMonths();
    $monthNumber = monthNumber($monthNumber);

    return $months[$monthNumber];
}

function getMonths()
{
    return [
        '01' => __('time.month.01'),
        '02' => __('time.month.02'),
        '03' => __('time.month.03'),
        '04' => __('time.month.04'),
        '05' => __('time.month.05'),
        '06' => __('time.month.06'),
        '07' => __('time.month.07'),
        '08' => __('time.month.08'),
        '09' => __('time.month.09'),
        '10' => __('time.month.10'),
        '11' => __('time.month.11'),
        '12' => __('time.month.12'),
    ];
}

function getYears()
{
    $yearRange = range(2014, date('Y'));
    foreach ($yearRange as $year) {
        $years[$year] = $year;
    }

    return $years;
}

function str_split_ucwords($string)
{
    return ucwords(str_replace('_', ' ', $string));
}

/**
 * Convert file size to have unit string.
 *
 * @param int $bytes File size.
 *
 * @return string Converted file size with unit.
 */
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2).' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2).' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2).' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes.' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes.' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Overide Laravel Collective  link_to_route helper function.
 *
 * @param string $name       Name of route
 * @param string $title      Text that displayed on view
 * @param array  $parameters URL Parameter
 * @param array  $attributes The anchor tag atributes
 */
function html_link_to_route($name, $title = null, $parameters = [], $attributes = [])
{ 
    if (array_key_exists('icon', $attributes)) {
        $title = '<i class="fa fa-'.$attributes['icon'].'"></i> '.$title;
    }

    return app('html')->decode(link_to_route($name, $title, $parameters, $attributes));
}

function dateDifference($date1, $date2, $differenceFormat = '%a')
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function appLogoImage($attributes = [])
{
    return Html::image(
        appLogoPath(),
        'Logo '.Option::get('agency_name', 'Laravel'),
        $attributes
    );
}

function appLogoPath()
{
    $defaultLogoImagePath = 'default-logo.png';
    $optionLogoImagePath = Option::get('agency_logo_path');

    if (is_file(public_path('assets/imgs/'.$optionLogoImagePath))) {
        return asset('assets/imgs/'.$optionLogoImagePath);
    }

    return asset('assets/imgs/'.$defaultLogoImagePath);
}

function monthDateArray($year, $month)
{
    $dateCount = Carbon::parse($year.'-'.$month)->format('t');
    $dates = [];
    foreach (range(1, $dateCount) as $dateNumber) {
        $dates[] = str_pad($dateNumber, 2, '0', STR_PAD_LEFT);
    }

    return $dates;
}
