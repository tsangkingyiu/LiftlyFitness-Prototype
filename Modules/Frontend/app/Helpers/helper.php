<?php
use App\Models\Setting;
use Modules\Frontend\Models\UserPreference;
use Illuminate\Support\Facades\Crypt;

function DummyData($key){
    $dummy_title = 'XXXXXXXXXXXX';
    $dummy_description = 'xxxxxxxxxxxxxxxx xxxxxxxxx xxxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxxxxxx xxxxxxxxx xxxxxxxxxxx xxxxxxxxxxxxxxxxx';

    switch ($key) {
        case 'dummy_title':
            return $dummy_title;
        case 'dummy_description':
            return $dummy_description;
        default:
            return '';
    }
}

function uploadMediaFile($model,$file,$name)
{
    if($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }

    return true;
}

function getSingleMediaSettingImage($model = null, $collection_name, $check_collection_type = null) {
    $image = null;
    
    if ($model !== null) {
        $image = $model->getFirstMedia($collection_name);
    }

    if ($image !== null && getFileExistsCheck($image))
    {
        return $image->getFullUrl();
    }else{
        switch ($collection_name) {
            case 'logo_image':
            case 'playstore_image':
            case 'appstore_image':
            case 'client-testimonial':
            case 'fitness-product':
            case 'bodypart_image':
            case 'equipment_image':
            case 'level_image':
            case 'workout_image':
            case 'ultimate-workout':
            case 'diet_image':
            case 'categorydiet_image':
            case 'productcategory_image':
            case 'product_image':
            case 'post_image':
            case 'walkthrough':
            case 'exercise_image':
                $image = asset('frontend-section/images/default-image-dark.png');
                break;
            case 'image':
                switch ($check_collection_type) {
                    case 'app-info':
                    case 'download-app':
                    case 'nutrition':
                    case 'fitness-blog':
                        $image = asset('frontend-section/images/default-image-dark.png');
                        break;
                }
            break;
        }
        return $image;
    }
}

function getSettingFirstData($type = null, $key = null)
{
    return Setting::where('type', $type)->where('key', $key)->first();
}

function renderStars($rating) {
    $rating = is_numeric($rating) ? min(5, max(0, $rating)) : 0;        
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;

    return str_repeat('<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.13706 0.632812L11.1885 6.94636H17.8269L12.4563 10.8484L14.5077 17.1619L9.13706 13.2599L3.76643 17.1619L5.81783 10.8484L0.447199 6.94636H7.08566L9.13706 0.632812Z" fill="var(--site-color)"/></svg>', $fullStars) .
            ($halfStar ? '<svg width="18" height="18" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.23374 1.32853L11.0807 7.0128L11.1289 7.16135H11.2851H17.2619L12.4266 10.6744L12.3002 10.7662L12.3485 10.9148L14.1954 16.5991L9.3601 13.086L9.23374 12.9942L9.10737 13.086L4.27204 16.5991L6.11897 10.9148L6.16724 10.7662L6.04087 10.6744L1.20555 7.16135H7.18234H7.33854L7.38681 7.0128L9.23374 1.32853Z" stroke="var(--site-color)" stroke-width="0.429979"/><mask id="mask0_293_3300" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path d="M9.23374 0.632812L11.2851 6.94636H17.9236L12.553 10.8484L14.6044 17.1619L9.23374 13.2599L3.86311 17.1619L5.91451 10.8484L0.543879 6.94636H7.18234L9.23374 0.632812Z" fill="var(--site-color)"/></mask><g mask="url(#mask0_293_3300)"><rect x="0.419189" y="-6.46191" width="9.45954" height="38.3756" fill="var(--site-color)"/></g></svg>' : '') .
            str_repeat('<svg width="18" height="18" viewBox="0 0 42 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 1.61804L25.4638 15.3561L25.576 15.7016H25.9393H40.3844L28.6981 24.1922L28.4042 24.4058L28.5164 24.7513L32.9802 38.4894L21.2939 29.9987L21 29.7852L20.7061 29.9987L9.01978 38.4894L13.4836 24.7513L13.5958 24.4058L13.3019 24.1922L1.6156 15.7016H16.0607H16.424L16.5362 15.3561L21 1.61804Z" stroke="#8A8A8A"/></svg>', $emptyStars);
}


function getblankHeartSvg()
{
    return '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.96173 18.9109L9.55171 18.1625L8.96173 18.9109ZM12 5.50063L11.3134 6.1615C11.493 6.34815 11.7409 6.45362 12 6.45362C12.2591 6.45362 12.507 6.34815 12.6866 6.1615L12 5.50063ZM15.0383 18.9109L15.6282 19.6593L15.0383 18.9109ZM9.55171 18.1625C8.02401 16.9582 6.38919 15.8078 5.09006 14.345C3.82362 12.9189 2.95299 11.2711 2.95299 9.1371H1.04701C1.04701 11.866 2.1861 13.9454 3.66494 15.6106C5.11111 17.239 6.95714 18.5441 8.37175 19.6593L9.55171 18.1625ZM2.95299 9.1371C2.95299 7.06218 4.12514 5.33268 5.70875 4.60881C7.23228 3.9124 9.30736 4.07732 11.3134 6.1615L12.6866 4.83976C10.1928 2.24878 7.26788 1.80046 4.91637 2.87534C2.62494 3.92276 1.04701 6.34908 1.04701 9.1371H2.95299ZM8.37175 19.6593C8.88212 20.0616 9.44292 20.5012 10.0144 20.8352C10.5856 21.1689 11.2581 21.453 12 21.453V19.547C11.7419 19.547 11.4144 19.4457 10.976 19.1896C10.5379 18.9336 10.0796 18.5786 9.55171 18.1625L8.37175 19.6593ZM15.6282 19.6593C17.0429 18.5441 18.8889 17.239 20.3351 15.6106C21.8139 13.9454 22.953 11.866 22.953 9.1371H21.047C21.047 11.2711 20.1764 12.9189 18.9099 14.345C17.6108 15.8078 15.976 16.9582 14.4483 18.1625L15.6282 19.6593ZM22.953 9.1371C22.953 6.34908 21.3751 3.92276 19.0836 2.87534C16.7321 1.80046 13.8072 2.24878 11.3134 4.83976L12.6866 6.1615C14.6926 4.07732 16.7677 3.9124 18.2913 4.60881C19.8749 5.33268 21.047 7.06218 21.047 9.1371H22.953ZM14.4483 18.1625C13.9204 18.5786 13.4621 18.9336 13.024 19.1896C12.5856 19.4457 12.2581 19.547 12 19.547V21.453C12.7419 21.453 13.4144 21.1689 13.9856 20.8352C14.5571 20.5012 15.1179 20.0616 15.6282 19.6593L14.4483 18.1625Z" fill="var(--site-color)"/>
            </svg>';
}

function getUserPreference($data_key = null,$data_type =null)
{
    $auth_user = auth()->user();
    if ( isset($auth_user) && $data_key != null) {
         $user_preference_data = UserPreference::where('user_id',$auth_user->id)->where('key',$data_key)->first();

         if ( isset($user_preference_data) ) {
            if ($data_type == 'data') {
               return $user_preference_data;
            }
            return $user_preference_data->value;
         }

        return null;
    }

    return null;
}

function getfilledHeartSvg()
{
    return '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.00049 9.13734C2.00049 14.0003 6.01991 16.5917 8.96222 18.9111C10.0005 19.7296 11.0005 20.5002 12.0005 20.5002C13.0005 20.5002 14.0005 19.7296 15.0388 18.9111C17.9811 16.5917 22.0005 14.0003 22.0005 9.13734C22.0005 4.27441 16.5003 0.825708 12.0005 5.50088C7.50065 0.825708 2.00049 4.27441 2.00049 9.13734Z" fill="var(--site-color)"/>
            </svg>';
}

function encryptDecryptId($request_id = null,$type = null)
{
    if ($type == 'encrypt') {
        return $request_id ? Crypt::encryptString($request_id) : null;
    }
    
    if ($type === 'decrypt') {
        return $request_id ? Crypt::decryptString($request_id) : null;
    }

    return null;
}

if (!function_exists('checkPremium')) {
    function checkPremium($type, $user) {
        if ($type->id == null) return 'javascript:void(0)';
        
        if (SettingData('subscription', 'subscription_system') == 0) return false;
        
        return $type->is_premium == 1 && (!$user || !$user->is_subscribe);
    }
}