<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class SettingsController extends Controller
{

    public function index()
    {
        $gateways = PaymentGateway::where('enabled', true)->get();


        return response()->json([
            'branding' => [
                'logo'    => logo_url(),
                'favicon' => favicon_url(),
            ],

            'general' => setting('general', [
                'site_name'         => '',
                'tagline'           => '',
                'theme_color'       => '',
                'dark_mode'         => '',
                'language'  => '',
                'timezone'          => '',
                'website_url'       => '',
                'maintenance_mode'  => '',

            ]),
            'contact' => setting('contact', [
                'phone' => '',
                'email' => '',
                'address' => '',
                'whatsapp' => '',
                'facebook' => '',
                'twitter' => '',
                'linkedin' => '',
                'youtube' => '',
            ]),

            'seo' => setting('seo', [
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'facebook_verification_code' => '',
                'facebook_pixel_id' => '',
                'google_analytics_id' => '',
                'google_tag_manager_id' => '',
                'google_verification' => '',
                'bing_verification' => '',
                'yandex_verification' => '',
            ]),


            'payment_gateways' => $gateways->map(function ($gateway) {
                return [
                    'id'         => $gateway->id,
                    'key'        => $gateway->key,
                    'name'       => $gateway->name,
                    'enabled'    => $gateway->enabled,
                    'logo_url'   => $gateway->logo_url,
                    'sandbox'    => $gateway->sandbox,
                ];
            }),

        ], Response::HTTP_OK);
    }


    public function logo(Request $request)
    {
        $request->validate([
            'logo'    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,ico|max:512',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->storeAs('logo', 'logo.png', config('app.disk'));
            Image::read($request->file('logo'))->save(Storage::disk(config('app.disk'))->path($logoPath));
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->storeAs('logo', 'favicon.png', config('app.disk'));
            Image::read($request->file('favicon'))->resize(128, 128)->save(Storage::disk(config('app.disk'))->path($faviconPath));
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo and favicon updated successfully.',
        ]);
    }

    public function getGeneral()
    {
        return response()->json([
            'general' => setting('general', [
                'site_name'         => '',
                'tagline'           => '',
                'theme_color'       => '',
                'dark_mode'         => '',
                'language'  => '',
                'timezone'          => '',
                'website_url'       => '',
                'maintenance_mode'  => '',
                'logo_url'  => '',
                'favicon_url'  => '',
            ]),
        ], Response::HTTP_OK);
    }

    public function general(Request $request)
    {
        $request->validate([
            'site_name'         => 'required|string|max:100',
            'tagline'           => 'nullable|string|max:150',
            'theme_color'       => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'dark_mode'         => 'nullable|boolean',
            'language'          => 'required|string|in:en,bn',
            'timezone'          => 'required|timezone',
            'website_url'       => 'required|url',
            'maintenance_mode'  => 'nullable|boolean',
        ]);

        setting(['general' => [
            'site_name' => $request->site_name,
            'tagline' => $request->tagline,
            'theme_color' => $request->theme_color,
            'dark_mode' => $request->dark_mode,
            'language' => $request->language,
            'timezone' => $request->timezone,
            'website_url' => $request->website_url,
            'maintenance_mode' => (bool) $request->maintenance_mode,
        ]])->save();


        return response()->json([
            'success' => true,
            'message' => 'General Settings Updated',
        ], Response::HTTP_OK);
    }

    public function getContact()
    {
        return response()->json([
            'contact' => setting('contact', [
                'phone' => '',
                'email' => '',
                'address' => '',
                'facebook' => '',
                'twitter' => '',
                'linkedin' => '',
                'youtube' => '',
            ]),
        ], Response::HTTP_OK);
    }

    public function contact(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'whatsapp' => 'required|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        setting(['contact' => [
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ]])->save();

        return response()->json([
            'success' => true,
            'message' => 'Contact and Social Links Updated',
        ], Response::HTTP_OK);
    }

    public function getSeo()
    {
        return response()->json([
            'seo' => setting('seo', [
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'og_image_url' => '',
                'facebook_verification_code' => '',
                'facebook_pixel_id' => '',
                'google_analytics_id' => '',
                'google_tag_manager_id' => '',
                'google_verification' => '',
                'bing_verification' => '',
                'yandex_verification' => '',
            ]),
        ], Response::HTTP_OK);
    }

    public function seo(Request $request)
    {
        $request->validate([
            'meta_title'                => 'required|string|max:255',
            'meta_description'          => 'nullable|string|max:500',
            'meta_keywords'             => 'nullable|string',
            'og_image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facebook_verification_code' => 'nullable|string',
            'facebook_pixel_id'         => 'nullable|string',
            'google_analytics_id'       => 'nullable|string',
            'google_tag_manager_id'     => 'nullable|string',
            'google_verification'       => 'nullable|string',
            'bing_verification'         => 'nullable|string',
            'yandex_verification'       => 'nullable|string',
        ]);

        setting(['seo' => [
            'meta_title'               => $request->meta_title,
            'meta_description'         => $request->meta_description,
            'meta_keywords'            => $request->meta_keywords,
            'facebook_verification_code' => $request->facebook_verification_code,
            'facebook_pixel_id'         => $request->facebook_pixel_id,
            'google_analytics_id'       => $request->google_analytics_id,
            'google_tag_manager_id'     => $request->google_tag_manager_id,
            'google_verification'       => $request->google_verification,
            'bing_verification'         => $request->bing_verification,
            'yandex_verification'       => $request->yandex_verification,
        ]])->save();

        return response()->json([
            'success' => true,
            'message' => 'SEO settings updated successfully.',
        ], Response::HTTP_OK);
    }


    public function getSMS()
    {
        return response()->json([
            'sms' => setting('sms', [
                'base_url' => '',
                'api_key' => '',
                'type' => '',
                'sender_id' => '',
                'enabled' => '',
            ]),
        ], Response::HTTP_OK);
    }

    public function sms(Request $request)
    {
        $request->validate([
            'base_url' => 'required|url',
            'api_key' => 'required|string',
            'type' => 'required|in:text,unicode',
            'sender_id' => 'required|string',
            'enabled' => 'required|in:0,1',
        ]);

        if (! $request->user()->tokenCan((UserRole::ADMIN)->value)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update payment gateway settings.',
            ], Response::HTTP_FORBIDDEN);
        }

        setting(['sms' => [
            'base_url'        => $request->base_url,
            'api_key'         => $request->api_key,
            'type'            => $request->type,
            'sender_id'       => $request->sender_id,
            'enabled'         => (bool) $request->enabled,
        ]])->save();

        return response()->json([
            'success' => true,
            'message' => 'SMS settings updated successfully.',
        ], Response::HTTP_OK);
    }


    public function seed(): JsonResponse
    {
        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Database refreshed and seeders executed successfully.',
        ], Response::HTTP_OK);
    }


    public function flushTokens()
    {
        PersonalAccessToken::query()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tokens revoked successfully'
        ], Response::HTTP_OK);
    }




    public function reboot(): JsonResponse
    {
        artisan::call('config:clear');
        artisan::call('route:clear');
        artisan::call('cache:clear');
        artisan::call('optimize:clear');

        return response()->json([
            'success' => true,
            'message' => 'Cache cleared successfully!',
        ], Response::HTTP_OK);
    }


    public function storageLink()
    {
        Artisan::call('storage:link');

        return response()->json([
            'status' => 'success',
            'message' => 'Storage link created successfully.',
        ]);
    }

    public function uploadHeroBanner(Request $request)
    {
        $request->validate([
            'hero'    => 'nullable|image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('hero')) {
            $request->file('hero')->storeAs('/', 'hero.png', config('app.disk'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero Banner updated  successfully.',
        ]);
    }

    public function uploadPreviewApp(Request $request)
    {
        $request->validate([
            'app'    => 'nullable|image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('app')) {
            $request->file('app')->storeAs('/', 'app.png', config('app.disk'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Preview App updated  successfully.',
        ]);
    }


    public function getHomepage()
    {
        return response()->json([
            'hero' => [
                'title' => setting('hero.title'),
                'headline' => setting('hero.headline'),
                'overview' => setting('hero.overview'),
                'banner_url'    => Storage::disk(config('app.disk'))->url('hero.png'),
            ],
            'topCategories' => setting('topCategories'),
            'benefits' => setting('benefits'),
            'reviews' => setting('reviews'),
            'instructors' => setting('instructors'),
            'cta' => [
                'title' => setting('cta.title'),
                'subtitle' => setting('cta.subtitle'),
                'app_url'    => Storage::disk(config('app.disk'))->url('app.png'),
                'app_links' => [
                    'google_play' => setting('cta.app_links.google_play'),
                    'app_store' => setting('cta.app_links.app_store'),
                ],
                'social' => [
                    'heading' => setting('cta.social.heading'),
                    'description' => setting('cta.social.description'),
                    'links' => [
                        'facebook' => setting('cta.social.links.facebook'),
                        'twitter' => setting('cta.social.links.twitter'),
                        'instagram' => setting('cta.social.links.instagram'),
                        'linkedin' => setting('cta.social.links.linkedin'),
                        'youtube' => setting('cta.social.links.youtube'),
                    ],

                ]


            ],
        ]);
    }

    public function updateHomepage(Request $request)
    {
        setting([
            'hero' => $request->hero,
            'topCategories' => $request->topCategories,
            'benefits' => $request->benefits,
            'reviews' => $request->reviews,
            'instructors' => $request->instructors,
            'cta' => $request->cta,
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Homepage settings updated successfully.',
        ]);
    }

    public function getAbout()
    {
        return response()->json([
            'data' => setting('about')
        ]);
    }

    public function updateAbout(Request $request)
    {
        setting(['about' => $request->about])->save();
        return response()->json(['message' => 'About page settings updated.']);
    }
}
