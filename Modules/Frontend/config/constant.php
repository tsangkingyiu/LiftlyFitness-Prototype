<?php
return [

    'FIREBASE_SETTING' => [
        'FIREBASE_API_KEY' => env('FIREBASE_API_KEY'),
        'FIREBASE_AUTH_DOMAIN' => env('FIREBASE_AUTH_DOMAIN'),
        'FIREBASE_PROJECT_ID' => env('FIREBASE_PROJECT_ID'),
        'FIREBASE_STORAGE_BUCKET' => env('FIREBASE_STORAGE_BUCKET'),
        'FIREBASE_MESSAGING_SENDER_ID'=> env('FIREBASE_MESSAGING_SENDER_ID'),
        'FIREBASE_APP_ID' => env('FIREBASE_APP_ID'),
        'FIREBASE_MEASUREMENT_ID' => env('FIREBASE_MEASUREMENT_ID'),
    ],

    'SUBSCRIPTION_STATUS' => [
        'PENDING'   => 'pending',
        'ACTIVE'    => 'active',
        'INACTIVE'  => 'inactive',
    ],

    'METRICS' => [
        'weight' => '',
        'heart_rate'   => '',
        'push_up'   => '',
    ],

    'app-info' => [ 
        'app_name'    => 'Liftly_App',
        'title'       => 'Liftly_Finess',
        'description' => 'test_abcde',
        'image'       => 'abc',
        'logo_image'  => 'abc',
    ],

    'ultimate-workout' => [
        'title'    => 'Liftly_Fitness_Ultimate',
        'subtitle' => 'abc',
    ],

    'section' => [
        'title' => 'Liftly Fitness Section',
        'subtitle' => 'abc',
        'description' => 'abc',
        'image' => 'abc',
    ],

    'nutrition' => [
        'title'       => 'Liftly Fitness Nutrition',
        'subtitle'    => 'abc',
        'description' => 'abc',
        'image'       => 'abc',
    ],

    'fitness-product' => [
        'title'    => 'Liftly_Fitness',
        'subtitle' => 'abc',
    ],

    'fitness-blog' => [
        'title'       => 'Liftly Fitness Blog',
        'subtitle'    => 'abc',
        'description' => 'abc',
        'image'       => 'abc',
    ],

    'download-app' => [
        'title'           => 'Liftly Fitness Download App',
        'subtitle'        => 'abc',
        'playstore_url'   => 'abc',
        'appstore_url'    => 'abc',
        'description'     => 'abc',
        'trustpilot_url'  => 'abc',
        'image'           => 'abc',
        'playstore_image' => 'abc',
        'appstore_image'  => 'abc',
    ],

    'client-testimonial' => [
        'title'                  => 'Liftly Fitness client-test',
        'subtitle'               => 'abc',
        'playstore_totalreview'  => 'abc',
        'appstore_totalreview'   => 'abc',
        'trustpilot_totalreview' => 'abc',
        'playstore_review'       => 'abc',
        'appstore_review'        => 'abc',
        'trustpilot_review'      => 'abc',
    ],

    'newsletter' => [
        'title' => 'Liftly Fitness News',
    ],

    'walkthrough' => [ '' => '' ],
];
