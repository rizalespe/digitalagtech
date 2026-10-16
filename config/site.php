<?php

/*
|--------------------------------------------------------------------------
| Site content
|--------------------------------------------------------------------------
|
| Static copy that appears across the public site. Move these into the
| database once an admin panel exists to edit them.
|
*/

return [

    'contact' => [
        'email' => env('SITE_CONTACT_EMAIL', 'agtech@gmail.com'),
        'location' => 'Malang, Indonesia',
    ],

    'socials' => [
        'x' => env('SITE_SOCIAL_X', '#'),
        'instagram' => env('SITE_SOCIAL_INSTAGRAM', '#'),
        'linkedin' => env('SITE_SOCIAL_LINKEDIN', '#'),
        'youtube' => env('SITE_SOCIAL_YOUTUBE', '#'),
    ],

    // "About" section on the home page.
    'home_stats' => [
        ['value' => '150+', 'label' => 'Startups', 'icon' => 'pen', 'accent' => true],
        ['value' => '10+', 'label' => 'Cities', 'icon' => 'building', 'accent' => false],
        ['value' => '500+', 'label' => 'Participants', 'icon' => 'users', 'accent' => false],
        ['value' => '20+', 'label' => 'Mentors', 'icon' => 'sprout', 'accent' => true],
    ],

    // "Digital Agtech in Numbers" on the Business Incubation page.
    'incubation_stats' => [
        ['value' => '320+', 'label' => 'Program Applicants'],
        ['value' => '120+', 'label' => 'Participants Engaged'],
        ['value' => '45+', 'label' => 'AgTech Startups Supported'],
        ['value' => '12+', 'label' => 'Winning Teams'],
    ],

];
