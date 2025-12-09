<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\CategoryDiet;
use App\Models\AppSetting;
use App\Models\Diet;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Level;
use App\Models\Package;
use Modules\Frontend\Models\Pages;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\Tags;
use App\Models\User;
use App\Models\UserFavouriteDiet;
use App\Models\UserFavouriteWorkout;
use Modules\Frontend\Models\UserPreference;
use Modules\Frontend\Http\Requests\UserProfileRequest;
use Modules\Frontend\Http\Requests\OtpRegisterRequest;
use Modules\Frontend\Http\Requests\RegisterRequest;
use Modules\Frontend\Http\Requests\WebSiteSettingRequest;
use Modules\Frontend\Http\Requests\FrontendSettingRequest;
use App\Models\UserProfile;
use App\Models\Workout;
use App\Models\WorkoutDay;
use App\Models\WorkoutDayExercise;
use App\Models\WorkoutType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Frontend\Models\FrontendData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class FrontendController extends Controller
{

    public function frontendUserStore(RegisterRequest $request)
    {
        $request['status'] = 'active';
        $request['password'] = bcrypt($request->password);
        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100,1000);
        $request['display_name'] = $request['first_name']." ".$request['last_name'];
        $user = User::create($request->all());
        $user->assignRole('user');
    
        UserProfile::create([
            'user_id' => $user->id,
            'age' => $request->age,
            'weight' => $request->weight,
            'weight_unit' => $request->weight_unit,
            'height' => $request->height,
            'height_unit' => $request->height_unit,
            'address' => $request->address,
        ]);
        Auth::login($user);

        return redirect()->route('user.dashboard')->withSuccess(__('message.save_form', ['form' => __('message.user')]));
    }

    public function websiteSettingForm($type)
    {
        $data = config('frontend.constant.'.$type);
        $title = str_replace('-','_',$type);
        $pageTitle =  __('frontend::message.'.$title );

        if ( empty($data) || $data == null ) {
            return redirect()->back();
        }

        foreach ($data as $key => $val) {
            if ($type == 'section') {
                $frontend_data = FrontendData::where('id',request('frontend_id'));
                if( in_array( $key, ['image'])) {
                    $data[$key] = $frontend_data->first();
                } else {
                    $data[$key] = $frontend_data->pluck($key)->first();
                }
            }else{
                if( in_array( $key, ['image','logo_image','playstore_image','appstore_image'])) {
                    $data[$key] = Setting::where('type', $type)->where('key',$key)->first();
                } else {
                    $data[$key] = Setting::where('type', $type)->where('key',$key)->pluck('value')->first();
                }
            }
        }

        if (request()->ajax()) {
            $sub_type = request('sub_type');
            $frontend_id = request('frontend_id');
            $view = view('frontend::frontend.websitesection.section', compact('data', 'pageTitle', 'type','sub_type','frontend_id'))->render();
            return response()->json([ 'data' => $view, 'status' => true ]);
        }
        
        return view('frontend::frontend.websitesection.form', compact('data', 'pageTitle', 'type'));
    }

    public function websiteSettingUpdate(WebSiteSettingRequest $request, $type)
    {
        $data = $request->all();

        foreach(config('frontend.constant.'.$type) as $key => $val){
            $input = [
                'type'  => $type,
                'key'   => $key,
                'value' => $data[$key] ?? null,
            ];
            $result = Setting::updateOrCreate(['key' => $key, 'type' => $type],$input);

            if( in_array($key, ['image','logo_image','playstore_image','appstore_image',] ) ) {
                uploadMediaFile($result,$request->$key, $key);
            }
        }
        $title = str_replace('-','_',$type);


        return redirect()->back()->withSuccess(__('message.save_form', ['form' => __('frontend::message.'.$title)]));
    }

    public function storeFrontendData(FrontendSettingRequest $request)
    {
        $data = $request->all();
        $id = request('frontend_id');
        $result = FrontendData::updateOrCreate(['id' => $id],$data);

        storeMediaFile($result,$request->image, $request->type); 
        $title = str_replace('-','_',$request->type);
        $count_data = FrontendData::where('type',$result->type)->orderBy('id', 'desc')->count();
        $message = __('message.save_form', ['form' => __('frontend::message.'.$title)]);
        return response()->json(['status' => true, 'count_data' => $count_data, 'frontend_id' => $id, 'type' => $request->type, 'event' => 'norefresh', 'message' => $message]);
    }
    
    public function getFrontendDatatList(Request $request)
    {
        $type = request('type');
        $data = FrontendData::where('type',$type)->orderBy('id', 'desc')->get();
        $title = str_replace('-','_',$type);
        $count_data = FrontendData::where('type',$type)->orderBy('id', 'desc')->count();
        $view = view('frontend::frontend.websitesection.frontend-data-list',compact('type', 'data','title'))->render();
        return response()->json([ 'data' => $view, 'status' => true ,'count_data' => $count_data, 'type' => $type]);
    }

    public function frontendDataDestroy(Request $request)
    {
        $frontend_data = FrontendData::find($request->id);

        $title = str_replace('-','_',$frontend_data->type);
        $status = 'errors';
        $message = __('message.not_found_entry', ['name' => __('frontend::message.'.$title)]);
        if($frontend_data != '') {
            $frontend_data->delete();
            $status = 'success';
            $message = __('message.delete_form', ['form' => __('frontend::message.'.$title)]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'type' => $frontend_data->type, 'event' => 'norefresh']);
        }

        return redirect()->back()->with($status,$message);
    }
    public function index()
    {
        $assets = ['animation'];

        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        
        $data['app-info'] = [
            'app_name'    => SettingData('app-info', 'app_name') ?? 'XXXXX',
            'title'       => SettingData('app-info', 'title') ?? '',
            'description' => SettingData('app-info', 'description') ?? $data['dummy_description'],
            'image'       => getSingleMediaSettingImage(getSettingFirstData('app-info','image'),'image','app-info'),
        ];


        $data['ultimate-workout'] = [
            'title'    => SettingData('ultimate-workout', 'title') ?? $data['dummy_title'],
            'subtitle' => SettingData('ultimate-workout', 'subtitle') ?? $data['dummy_title'],
        ];

        $ultimate_workout = FrontendData::where('type', 'ultimate-workout')->get();

        $data['nutrition'] = [
            'title'       => SettingData('nutrition', 'title') ?? $data['dummy_title'],
            'subtitle'    => SettingData('nutrition', 'subtitle') ?? $data['dummy_title'],
            'description' => SettingData('nutrition', 'description') ?? $data['dummy_description'],
            'image'       => getSingleMediaSettingImage(getSettingFirstData('nutrition','image'),'image','nutrition'),
        ];

        $data['fitness-product'] = [
            'title'    => SettingData('fitness-product', 'title') ?? $data['dummy_title'],
            'subtitle' => SettingData('fitness-product', 'subtitle') ?? $data['dummy_title'],
        ];

        $data['fitness-blog'] = [
            'title'       => SettingData('fitness-blog', 'title') ?? $data['dummy_title'],
            'subtitle'    => SettingData('fitness-blog', 'subtitle') ?? $data['dummy_title'],
            'description' => SettingData('fitness-blog', 'description') ?? $data['dummy_description'],
            'image'       => getSingleMediaSettingImage(getSettingFirstData('fitness-blog','image'),'image','fitness-blog'),
        ];

        $fitness_product = FrontendData::where('type', 'fitness-product')->get();

        $data['client-testimonial'] = [
            'title'       => SettingData('client-testimonial', 'title') ?? $data['dummy_title'],
            'subtitle'    => SettingData('client-testimonial', 'subtitle') ?? $data['dummy_title'],
            'playstore_totalreview' => SettingData('client-testimonial', 'playstore_totalreview') ?? 'xx',
            'appstore_totalreview' => SettingData('client-testimonial', 'appstore_totalreview') ?? 'xx',
            'trustpilot_totalreview' => SettingData('client-testimonial', 'trustpilot_totalreview') ?? 'xx',
            'playstore_review' => SettingData('client-testimonial', 'playstore_review') ?? 'xx',
            'appstore_review' => SettingData('client-testimonial', 'appstore_review') ?? 'xx',
            'trustpilot_review' => SettingData('client-testimonial', 'trustpilot_review') ?? 'xx',
        ];

        $client_testimonial =  FrontendData::where('type','client-testimonial')->orderBy('id','desc')->get();

        $data['download-app'] = [
            'title'           => SettingData('download-app', 'title') ?? $data['dummy_title'],
            'subtitle'        => SettingData('download-app', 'subtitle') ?? $data['dummy_title'],
            'playstore_url' => [
                'url' => SettingData('download-app', 'playstore_url') ?? 'javascript:void(0)',
                'target' => SettingData('download-app', 'playstore_url') ? 'target="_blank"' : ''
            ],
            'appstore_url' => [
                'url' => SettingData('download-app', 'appstore_url') ?? 'javascript:void(0)',
                'target' => SettingData('download-app', 'appstore_url') ? 'target="_blank"' : ''
            ],
            'trustpilot_url' => [
                'url' => SettingData('download-app', 'trustpilot_url') ?? 'javascript:void(0)',
                'target' => SettingData('download-app', 'trustpilot_url') ? 'target="_blank"' : ''
            ],
            'description'     => SettingData('download-app', 'description') ?? $data['dummy_description'],
            'image'           => getSingleMediaSettingImage(getSettingFirstData('download-app','image'),'image','download-app'),
            'playstore_image' => getSingleMediaSettingImage(getSettingFirstData('download-app','playstore_image'),'playstore_image'),
            'appstore_image'  => getSingleMediaSettingImage(getSettingFirstData('download-app','appstore_image'),'appstore_image'),
        ];

        $data['newsletter'] = [
            'title'    => SettingData('newsletter', 'title') ?? $data['dummy_title'],
        ];

        return view('frontend::frontend.index', compact('data', 'ultimate_workout', 'fitness_product', 'client_testimonial', 'assets'));

        // return view('frontend-website.index',compact('data','ultimate_workout','fitness_product','client_testimonial','assets'));
    }

    public function signup()
    {
        $assets = ['phone'];
        return view('frontend::frontend.auth.register', compact('assets'));
    }

    public function forgotPassword()
    {
        return view('frontend::frontend.auth.forgot-password');
    }

    public function otpLogin()
    {
        $assets = ['firebase','phone'];
        return view('frontend::frontend.auth.otp-login', compact('assets'));
    }

    public function diet()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');
        
        $data['category_diet'] = CategoryDiet::where('status','active')->orderBy('title','asc')->paginate(20);
        $data['diet'] = Diet::where('status','active')->where('is_featured','no')->orderBy('title','asc')->paginate(20);

        $section = 'diet';
        return view('frontend::frontend.diet.index',compact('data','section'));
    }

    public function dietCategories(Request $request)
    {
        $perPage = 12;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['category_diet'] = CategoryDiet::where('status','active')->orderBy('title','asc')->paginate($perPage);
        $data['hasData'] = $data['category_diet']->total() > $perPage;

        if($request->ajax())
        {
            $type = 'diet-categories';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['category_diet']),
            ]);
        }

        return view('frontend::frontend.diet.categories',compact('data'));
    }

    public function dietCategoriesList(Request $request)
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $categoryDiet = CategoryDiet::where('slug', request('slug'))->first();
        $data['diet_list'] = diet::where('categorydiet_id', $categoryDiet->id)->where('status','active')->orderBy('title','asc')->get();

        return view('frontend::frontend.diet.categories-list',compact('data'));
    }

    public function dietList(Request $request)
    {
        $perPage = 8;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['diet'] = Diet::where('status','active')->where('is_featured','no')->orderBy('title','asc')->paginate($perPage);
        $data['hasData'] = $data['diet']->total() > $perPage;

        if($request->ajax())
        {        
            $type = 'dietary-options';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
        
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['diet']),
            ]);
        }

        return view('frontend::frontend.diet.list',compact('data'));
    }

    public function dietDetails(Request $request)
    {
        $data['diet'] = Diet::where('slug', $request->slug)->firstOrFail();
        return view('frontend::frontend.diet.details',compact('data'));
    }

    public function workouts()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['body_parts'] = BodyPart::where('status','active')->orderBy('id','desc')->paginate(20);
        $data['equipment'] = Equipment::where('status','active')->orderBy('id','desc')->paginate(20);
        $data['workout'] = Workout::where('status','active')->orderBy('id','desc')->paginate(10);
        $data['level'] = Level::where('status','active')->orderBy('id','desc')->paginate(10);

        $section = 'exercise';
        return view('frontend::frontend.workouts.index', compact('data','section'));
    }

    public function bodypartExercises(Request $request)
    {
        $perPage = 12;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['body_parts'] = BodyPart::where('status','active')->orderBy('title','asc')->paginate($perPage);
        $data['hasData'] = $data['body_parts']->total() > $perPage;

        if($request->ajax())
        {
            $type = 'body-parts';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
        
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['body_parts']),

            ]);
        }
        return view('frontend::frontend.workouts.bodypart_exercises',compact('data'));
    }

    public function bodypartExercisesList(Request $request)
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $bodypart = BodyPart::where('slug',request('slug'))->first();
        $data['exercise'] = Exercise::whereJsonContains('bodypart_ids', (string ) $bodypart->id)->orderBy('id','desc')->where('status','active')->get();
        $data['body_parts'] = BodyPart::find($bodypart->id);
        $section = 'bodypart_exercise';

        return view('frontend::frontend.workouts.bodypart_exercises_list', compact('data','section'));
    }

    public function equipmentExercisesList()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $equipment = Equipment::where('slug',request('slug'))->first();
        $data['exercise'] = Exercise::where('equipment_id', $equipment->id)->where('status','active')->orderBy('id','desc')->get();
        $data['body_parts'] = Equipment::find($equipment->id);
        $section = 'equipment_exercise';
        return view('frontend::frontend.workouts.bodypart_exercises_list',compact('data','section'));
    }

    public function bodypartExercisesDetail(Request $request)
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $assets = ['videojs'];
        $data['exercise'] = Exercise::where('slug', $request->slug)->first();

        $data['exercise_bodypart'] = [];
        if(isset($data['exercise']->bodypart_ids)) {
            $data['exercise_bodypart'] = BodyPart::whereIn('id', $data['exercise']->bodypart_ids)->get();
        }

        return view('frontend::frontend.workouts.bodypart_exercises_detail',compact('data','assets'));
    }

    public function getLevels(Request $request)
    {
        $perPage = 6;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['level'] = Level::where('status','active')->orderBy('title', 'asc')->paginate($perPage);
        $data['hasData'] = $data['level']->total() > $perPage;

        if($request->ajax())
        {
            $type = 'workout-level';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
        
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['level']),
            ]);
        }
        return view('frontend::frontend.workouts.level',compact('data'));
    }

    public function workoutLevel()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $level = Level::where('slug',request('slug'))->first();
        $data['exercise'] = Exercise::where('level_id', $level->id)->where('status','active')->orderBy('id','desc')->get();
        $data['body_parts'] = Level::find($level->id);
        $section = 'exercise_level';
        return view('frontend::frontend.workouts.bodypart_exercises_list',compact('data','section'));
    }

    public function equipmentBasedExercise(Request $request)
    {
        $perPage = 12;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['equipment'] = Equipment::where('status','active')->orderBy('title', 'asc')->paginate($perPage);
        $data['hasData'] = $data['equipment']->total() > $perPage; 
        if ($request->ajax()) {
            
            $type = 'equipment-based-exercise';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['equipment']),
            ]);
        }

        return view('frontend::frontend.workouts.equipment_based_exercise',compact('data'));
    }

    public function workoutAll()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['workout'] = Workout::where('status','active')->orderBy('id','desc')->get();
        $assets = ['dynamic_list'];
        return view('frontend::frontend.workouts.workout_all',compact('data','assets'));
    }

    public function workoutAllList()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['filter_type'] = request('filter_type') ?? 'all';
        $ids_name = $data['filter_type'].'_ids';
        $data[$ids_name] = request($ids_name) ?? [];
        $data['data_key'] = request('data_key');

        $data['selected_type'] = request('selected_type') ?? 'select_all';

        $workout = Workout::where('status', 'active');
        $exercise = Exercise::where('status', 'active');

        if (request()->has('workout_type_ids') && !empty(request('workout_type_ids')) && $data['filter_type'] == 'workout_type') {
            $workout->whereIn('workout_type_id', $data['workout_type_ids']);
        }

        if (request()->has('equipment_ids') && !empty(request('equipment_ids')) && $data['filter_type'] == 'equipment') {
            $exercise->whereIn('equipment_id', $data['equipment_ids']);
        }

        if (request()->has('level_ids') && !empty(request('level_ids')) && $data['filter_type'] == 'level') {
            $workout->whereIn('level_id', $data['level_ids']);
            $exercise->whereIn('level_id', $data['level_ids']);
        }

        $query = request('q');
        if (request()->has('q') && !empty($query) && $data['data_key'] == 'exercise') {
            $exercise->where('title', 'LIKE', "%$query%")->orderBy('title','asc');
        }

        $data['workout'] = $workout->orderBy('title', 'asc')->paginate(8);
        $data['exercise'] = $exercise->orderBy('title', 'asc')->paginate(8);
        $data['workout_type'] = WorkoutType::where('status', 'active')->orderBy('title', 'asc')->get();
        $data['level'] = Level::where('status', 'active')->orderBy('title', 'asc')->get();
        $data['equipment'] = Equipment::where('status', 'active')->orderBy('title', 'asc')->get();

        $view = view('frontend::frontend.workouts.workout_list', compact('data'))->render();
        $data_type = $data['data_key'];
        $append_status = false;
        $data_id = '#get-dynamic-data-list';

        if ( in_array($data['data_key'],['workout_pagination','exercise_pagination']) ) {
            
            $data_type = str_replace('_pagination','',$data['data_key']);
            $type = $data['data_key'];
            $data_id = '#'.$type;
            $append_status = true;
            $view = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
            
        }

        $pagination_response = json_pagination_response($data[$data_type]);
        return response()->json(['data_id' => $data_id,'append_status' => $append_status,'pagination' => $pagination_response,'data' => $view]);
    }


    public function workoutDetail(Request $request)
    {
        $data['workout'] = Workout::where('slug', $request->slug)->first();

        return view('frontend::frontend.workouts.detail',compact('data'));
    }

    public function getWorkoutDayExercise(Request $request)
    {
        $id = encryptDecryptId(request('id'),'decrypt');
        // $data = WorkoutDayExercise::where('workout_day_id', $id)->get();
        $data = WorkoutDayExercise::where('workout_day_id', $id)
        ->whereHas('exercise', function ($query) {
            $query->where('status', 'active');
        })->get();

        $view = view('frontend::frontend/workouts/workoutday-exercise',compact('data'))->render();
        return response()->json([ 'data' => $view, 'status' => true , 'workout_days' => $request->workout_days ]);
    }

    public function product()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');
        
        $data['product_category'] = ProductCategory::orderBy('title','asc')->paginate(20);
        $data['product'] = Product::where('status','active')->orderBy('title','asc')->paginate(20);

        $section = 'product';
        return view('frontend::frontend.product.index',compact('data','section'));
    }

    public function productCategories(Request $request)
    {
        $perPage = 12;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['product_category'] = ProductCategory::orderBy('title','asc')->paginate($perPage);
        $data['hasData'] =  $data['product_category']->total() > $perPage;
        if ($request->ajax()) {
            
            $type = 'product-categories';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['product_category']),
            ]);
        }

        return view('frontend::frontend.product.categories',compact('data'));
    }

    public function productCategoriesList(Request $request)
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $productCategory = ProductCategory::where('slug',$request->slug)->first();
        $data['product_list'] = Product::where('productcategory_id',$productCategory->id)->where('status','active')->orderBy('title','asc')->get();

        return view('frontend::frontend.product.categories-list',compact('data'));
    }


    public function productList(Request $request)
    {
        $perPage = 12;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['product'] = Product::where('status','active')->orderBy('title','asc')->paginate($perPage);
        $data['hasData'] = $data['product']->total() > $perPage;

        if ($request->ajax()) {
            
            $type = 'product-accessories';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['product']),
            ]);
        }


        return view('frontend::frontend.product.list',compact('data'));
    }

    public function productDetails(Request $request)
    {
        $data['product'] = Product::where('slug', $request->slug)->first();
        return view('frontend::frontend.product.details',compact('data'));
    }

    public function blog()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['latest_blog'] = Post::where('status', 'publish')->where('is_featured','yes')->orderBy('title', 'asc')->paginate(10);

        $data['blog'] = Post::where('status','publish')->where('is_featured','no')->orderBy('title', 'asc')->paginate(10)->map(function($blog){
            $blog->category_titles = Category::whereIn('id',$blog->category_ids)->pluck('title');
            return $blog;
        });

        $section = 'blog';
        return view('frontend::frontend.blog.index',compact('data','section'));
    }

    public function recentBlog(Request $request)
    {
        $perPage = 8; 
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['recent_blog'] = Post::where('status', 'publish')->where('is_featured', 'yes')->orderBy('title', 'asc')->paginate($perPage);

        $data['recent_blog']->getCollection()->transform(function($blog) {
            $blog->category_titles = Category::whereIn('id', $blog->category_ids)->pluck('title');
            return $blog;
        });

        $data['hasData'] = $data['recent_blog']->total() > $perPage;

        if ($request->ajax()) {
            $type = 'recent-blog';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
    
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['recent_blog']),
            ]);
        }
        
        return view('frontend::frontend.blog.recent',compact('data'));
    }

    public function trendingBlog(Request $request)
    {
        $perPage = 8;
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['trending_blog'] = Post::where('status', 'publish')->where('is_featured', 'no')->orderBy('title', 'asc')->paginate($perPage);

        $data['trending_blog']->getCollection()->transform(function($blog) {
            $blog->category_titles = Category::whereIn('id', $blog->category_ids)->pluck('title');
            return $blog;
        });

        $data['hasData'] = $data['trending_blog']->total() > $perPage;

        if ($request->ajax()) {
    
            $type = 'trending-blog';
            $html = view('frontend::frontend.ajaxloadmore', compact('data', 'type'))->render();
    
            return response()->json([
                'html' => $html,
                'pagination' => json_pagination_response($data['trending_blog']),
            ]);
        }

        return view('frontend::frontend.blog.trending-list',compact('data'));
    }

    public function BlogDetails()
    {
        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');

        $data['blog_detail'] = Post::where('slug',request('slug'))->where('status', 'publish')->orderBy('id','desc')->first();

        if ($data['blog_detail']) {
            $data['blog_detail']->category_titles = Category::whereIn('id', $data['blog_detail']->category_ids)->pluck('title');
            $data['blog_detail']->tags = Tags::whereIn('id', $data['blog_detail']->tags_id)->pluck('title');
        }

        $data['related_blog'] = Post::where('status', 'publish')->whereNotIn('slug', [request('slug')])->orderBy('id', 'desc')->take(6)->get();

        foreach ($data['related_blog'] as $relatedBlog) {
            $relatedBlog->category_titles = Category::whereIn('id', $relatedBlog->category_ids)->pluck('title');
        }

        return view('frontend::frontend.blog.details',compact('data'));
    }

    public function price()
    {
        if (Auth::check() && Auth::user()->is_subscribe) {
            return redirect()->route('browse'); 
        }

        $data['dummy_title']  = DummyData('dummy_title');
        $data['dummy_description'] = DummyData('dummy_description');
        $data['package'] = Package::where('status','active')->get();

        return view('frontend::frontend.pricing',compact('data'));
    }

    public function toggleFavorite(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'redirect' => route('frontend.signin')]);
        }
    
        $user = auth()->user();
        $type = request('type');
    
        if ($type === 'workout') {
            $favorite = UserFavouriteWorkout::where('user_id', $user->id)->where('workout_id', request('id'))->first();
    
            if ($favorite) {
                $favorite->delete();
                return response()->json(['success' => true, 'isFavorite' => false, 'message' => __('message.unfavourite_workout_list'), 'blankHeartSvg' => getblankHeartSvg()]);
            } else {
                UserFavouriteWorkout::create(['user_id' => $user->id, 'workout_id' => request('id')]);
                return response()->json(['success' => true, 'isFavorite' => true, 'message' => __('message.favourite_workout_list'),'filledHeartSvg' => getfilledHeartSvg()]);
            }
        }

        if ($type === 'diet') {
            $favorite = UserFavouriteDiet::where('user_id', $user->id)->where('diet_id', request('id'))->first();
    
            if ($favorite) {
                $favorite->delete();
                return response()->json(['success' => true, 'isFavorite' => false, 'message' => __('message.unfavourite_diet_list') , 'blankHeartSvg' => getblankHeartSvg()]);
            } else {
                UserFavouriteDiet::create(['user_id' => $user->id, 'diet_id' => request('id')]);
                return response()->json(['success' => true, 'isFavorite' => true, 'message' => __('message.favourite_diet_list') , 'filledHeartSvg' => getfilledHeartSvg()]);
            }
        }
    }

    public function userDashboard()
    {       
        $user = Auth::user();

        $pageTitle = __('message.add_form_title', ['form' => __('message.order')]);
        $assets = ['chart'];
        $user_id = auth()->user()->id;
        $data = User::with('userProfile','roles')->findOrFail($user_id);

        $metricKeys = array_keys(config('frontend.constant.METRICS'));

        $metrics_setting = UserPreference::where('user_id', $user_id)->whereIn('key', $metricKeys)->pluck('value', 'key')->toArray();
        foreach ($metricKeys as $key) {
            if (!array_key_exists($key, $metrics_setting)) {
                $metrics_setting[$key] = null;
            }
        }

        return view('frontend::frontend.user.dashboard', compact('pageTitle','data','metrics_setting','assets'));
    }
    
    public function userProfile()
    {
        $user = User::find(auth()->user()->id);
        $user_profile = UserProfile::where('user_id', auth()->user()->id)->first();
        $assets = ['phone'];
        $data = [
            'user_data' => $user,
            'user_profile' => $user_profile
        ];

        return view('frontend::frontend.user.profile',compact('data','assets'));
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
     
        $user->fill($data)->save();
    
        UserProfile::updateOrCreate(
            ['user_id' => $user->id], 
            [
                'age' => $request->age,
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit,
                'height' => $request->height,
                'height_unit' => $request->height_unit,
                'address' => $request->address,
            ]
        );
        if ($request->hasFile('profile_image')) {
            storeMediaFile($user, $request->file('profile_image'), 'profile_image');
        }

        return redirect()->route('profile')->withSuccess( __('message.profile').' '.__('message.updated'));
    }

    public function favourite()
    {
        $sub_type = request('subtype');
        $type = 'workouts';
        return view('frontend::frontend.user.favourite', compact('type','sub_type'));
    } 

    public function favouriteList(Request $request)
    {
        $type = request('type') ?? 'workouts';
        $sub_type = $request->sub_type;
        $message = false;

        $workouts = Workout::query();
        $diet = Diet::query();

        if($type == 'workouts'){
            $favourite_workout = UserFavouriteWorkout::where('user_id', auth()->id())->where('workout_id',request('favourite_id'))->first();
            if ($favourite_workout != null) {
                $favourite_workout->delete();
                $message = __('message.unfavourite_workout_list');
            } else {
                if(request('favourite_id') != null) {
                    UserFavouriteWorkout::create(['user_id' => auth()->id(), 'workout_id' => request('favourite_id')]);
                    $message = __('message.favourite_workout_list');
                }
            }
        }

        if($type == 'diets'){
            $favourite_diet = UserFavouriteDiet::where('user_id', auth()->id())->where('diet_id',request('favourite_id'))->first();
            if ($favourite_diet != null) {
                $favourite_diet->delete();
                $message = __('message.unfavourite_diet_list');
            } else {
                if(request('favourite_id') != null) {
                    UserFavouriteDiet::create(['user_id' => auth()->id(), 'diet_id' => request('favourite_id')]);
                    $message = __('message.favourite_diet_list');
                }
            }
        }

        if($request->sub_type =='assign-workout-diet'){
            $workout = $workouts->MyAssignWorkout();
            $diet = $diet->MyAssignDiet();
        }else{
            $workout = $workouts->MyWorkout();
            $diet = $diet->MyDiet();
        }
        
        $data['workouts'] = $workout->get();
        $data['diets'] =$diet->get();
        
        $view = view('frontend::frontend.user.favouritelist',compact('data','type','sub_type'))->render();
        return response()->json([ 'data' => $view, 'status' => true, 'message' => $message ]);
    }   

    public function dailyReminder()
    {
        return view('frontend::frontend.user.dailyreminder');
    }

    public function mySubscription()
    {
        $subscription = SettingData('subscription', 'subscription_system');
        if($subscription == 0){
            return redirect()->route('user.dashboard');
        }
        $type = 'active';
        $subscription_list = Subscription::where('user_id',auth()->id())->orderBy('status', 'asc')->get();
        $active_subscription = Subscription::where('user_id', auth()->id())->where('status', 'active')->get();

        return view('frontend::frontend.user.my-subscription',compact('type','subscription_list','active_subscription'));
    }

    public function cancelSubscription(Request $request)
    {

        $user_id = auth()->id();
        $id = $request->id;
        $user_subscription = Subscription::where('id', $id )->where('user_id', $user_id)->first();
        $user = User::where('id', $user_id)->first();

        if($user_subscription)
        {
            $user_subscription->status = config('frontend.constant.SUBSCRIPTION_STATUS.INACTIVE');
            $user_subscription->save();
            $user->is_subscribe = 0;
            $user->save();
        }

        return redirect()->back()->withSuccess(__('message.subscription_cancelled'));

    }

    public function metricsSetting()
    {
        $data = config('frontend.constant.METRICS');  
        $user_id = auth()->id(); 
        foreach ($data as $key => $val) {
            $data[$key] = UserPreference::where('user_id', $user_id)->where('key', $key)->pluck('value')->first();
        }

        return view('frontend::frontend.user.metrics_setting', compact('data'));
    }

    public function configurePassword()
    {
        $settings = AppSetting::first();
        $user_data = User::find(auth()->user()->id);
        $envSettting = $envSettting_value = [];
               
        if(count($envSettting) > 0 ){
            $envSettting_value = Setting::whereIn('key',array_keys($envSettting))->get();
        }
        if($settings == null){
            $settings = new AppSetting;
        }elseif($user_data == null){
            $user_data = new User;
        }
        return view('frontend::frontend.user.change-password',compact('settings','user_data'));
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();

        if($user == "") {
            $message = __('message.not_found_entry',[ 'name' => __('message.user') ]);
            return json_message_response($message,400);   
        }
        
        $validator= Validator::make($request->all(), [
            'old' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.changepassword')->with('errors',$validator->errors());
        }
           
        $hashedPassword = $user->password;

        $match = Hash::check($request->old, $hashedPassword);

        $same_exits = Hash::check($request->password, $hashedPassword);
        if ($match)
        {
            if($same_exits){
                $message = __('message.old_new_pass_same');
                return redirect()->route('user.changepassword')->with('error',$message);
            }

			$user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            Auth::logout();
            $message = __('message.password_change');
            return redirect()->route('frontend.signin')->withSuccess($message);
        }
        else
        {
            $message = __('message.valid_password');
            return redirect()->route('user.changepassword')->with('error',$message);
        }
        
    }

    public function logout()
    {
        return view('frontend::frontend.user.logout');
    }

    public function changeSettingStatus(Request $request)
    {
        $value = ['user_id' => $request->user_id, 'key' => $request->key_name];
        $data = $value;
        $data['value'] = $request->status == 0 ? '0' : '1';
    
        $result = UserPreference::updateOrCreate($value, $data);
          
        $message = __('message.update_form',['form' => __('message.status')]);
        return json_custom_response(['message'=> $message , 'status' => true]);
    }

    public function search(Request $request)
    {
        $section = $request->get('section');
        $query = $request->get('query');

        if($query == null) {
            return redirect()->back();
        }
        
        $assets = [];
        $data_id = '';

        switch ($section) {
            case 'exercise':
                $results = Exercise::where('title', 'LIKE', "%$query%")->orderBy('title','asc')->get();
                $assets = ['dynamic_list'];
                break;
            
            case 'diet':
                $results = Diet::where('title', 'LIKE', "%$query%")->get();
                break;

            case 'blog':
                $results = Post::where('title', 'LIKE', "%$query%")->get()->map(function($blog){
                    $blog->category_titles = Category::whereIn('id',$blog->category_ids)->pluck('title');
                    return $blog;
                });
                break;

            case 'product':
                $results = Product::where('title', 'LIKE', "%$query%")->get();
                break;
            case 'bodypart_exercise':
            case 'equipment_exercise':
            case 'exercise_level':
                $results = Exercise::where('title', 'LIKE', "%$query%")->get();
                break;
            default:
                $results = [];
                break;
        }

        return view('frontend::frontend.search', compact('results', 'section','assets'));
    }

    public function getSuggestions(Request $request)
    {
        $section = $request->get('section');
        $query = $request->get('query');

        $suggestions = [];

        $bodypart = BodyPart::where('slug',request('slug'))->first();
        $equipment = Equipment::where('slug',request('slug'))->first();
        $level = Level::where('slug',request('slug'))->first();

        $exercise = Exercise::query();

        switch ($section) {
            case 'exercise':
                $suggestions = $exercise->where('title', 'LIKE', "%$query%")->orderBy('title','asc')->pluck('title')->toArray();
                break;
            case 'diet':
                $suggestions = Diet::where('title', 'LIKE', "%$query%")->orderBy('title','asc')->pluck('title')->toArray();
                break;
            case 'blog':
                $suggestions = Post::where('title', 'LIKE', "%$query%")->orderBy('title','asc')->pluck('title')->toArray();
                break;
            case 'product':
                $suggestions = Product::where('title', 'LIKE', "%$query%")->orderBy('title','asc')->pluck('title')->toArray();
                break;
            case 'bodypart_exercise':
            case 'equipment_exercise':
            case 'exercise_level':
                if ($section == 'bodypart_exercise') {
                    $exercise->whereJsonContains('bodypart_ids', (string ) $bodypart->id);
                }
                if ($section == 'equipment_exercise') {
                    $exercise->where('equipment_id', $equipment->id);
                }
                if ($section == 'exercise_level') {
                    $exercise->where('level_id', $level->id);
                }

                $suggestions = $exercise->where('title', 'LIKE', "%$query%")->orderBy('title','asc')->pluck('title')->toArray();
                break;
            
            default:
                break;
        }

        return response()->json($suggestions);
    }

    public function page($slug)
    {
        $page = Pages::where('slug', $slug)->firstOrFail();
        return view('frontend::frontend.pages', compact('page'));
    }

    public function otpUserRegister(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'uid' => 'required|string',
        ]);
    
        $phoneNumber = preg_replace('/\D+/', '', $validated['phone_number']);
    
        $user = User::where('phone_number', $phoneNumber)->first();
    
        if (!$user) {
            return response()->json([
                'success' => true,
                'is_new_user' => true,
                'redirect_url' => route('user.dashboard'),
            ]);
        } else {
            if ($user->status == 'banned') {
                $message = __('message.account_banned');
            } elseif (in_array($user->status, ['pending', 'inactive'])) {
                $message = __('message.permission_denied_for_account');
            }
            
            if (isset($message)) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'redirect_url' => route('frontend.signin'),
                ]);
            }
            $language_code = getUserPreference('language_code') ?? app()->getLocale();
            App::setLocale($language_code);
            session()->put('locale', $language_code);
            Auth::login($user);
            session()->flash('success', __('message.login_success'));
    
            return response()->json([
                'success' => true,
                'is_new_user' => false,
                'redirect_url' => route('user.dashboard'),
            ]);
        }
    }

    public function completeRegistration(OtpRegisterRequest $request)
    {
        $PhoneNumber = preg_replace('/\D+/', '', $request['phone_number']);

        $user = User::where('phone_number', $request['phone_number'])->where('login_type','mobile')->first();

        if (!$user) {
            $user = User::create([
                'username' => $PhoneNumber,
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'display_name' => $request['first_name']." ".$request['last_name'],
                'email' => $request['email'],
                'phone_number' => $PhoneNumber,
                'uid' => $request['uid'],
                'password' => bcrypt($PhoneNumber),
                'status' => 'active',
                'login_type' => 'mobile'
            ]);
            $user->assignRole('user');
        }

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect_url' => route('user.dashboard')
        ]);
    }

    public function saveUserTheme(Request $request) {
        $user = auth()->user();
        $theme = $request->input('theme');
        
        UserPreference::MyPreference()->updateOrCreate(
            ['key' => 'theme','user_id' => $user->id],
            ['value' => $theme]
        );
        
        return response()->json(['success' => true]);
    }

    public function languageSetting() {
        return view('frontend::frontend.language');
    }
}