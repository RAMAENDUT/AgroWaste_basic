<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $hasEnrollments = false;
        if ($request->user()) {
            $hasEnrollments = \App\Models\CourseEnrollment::where('user_id', $request->user()->id)->exists();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'hasEnrollments' => $hasEnrollments,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'quiz_result' => fn () => $request->session()->get('quiz_result'),
            ],
        ];
    }
}
