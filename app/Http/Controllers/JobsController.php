<?php

namespace App\Http\Controllers;

use App\Mail\JobCreated;
use App\Models\Click;
use App\Models\Jobs;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Notification;
use App\Notifications\JobCreatedNotification;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        $query = Jobs::query()
            ->where('is_active', true)
            ->with('tags')
            ->latest();

        if ($request->has('s')) {
            $searchQuery = trim($request->get('s'));

            $query->where(function (Builder $builder) use ($searchQuery) {
                $builder
                    ->orWhere('title', 'like', "%{$searchQuery}%")
                    ->orWhere('company', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        }

        if ($request->has('tag')) {
            $tag = $request->get('tag');
            $query->whereHas('tags', function (Builder $builder) use ($tag) {
                $builder->where('slug', $tag);
            });
        }

        $jobs = $query->paginate($perPage);

        $tags = Tag::orderBy('name')->get();

        return view('jobs.index', compact('jobs', 'tags'));
    }

    public function show(Jobs $jobs, Request $request)
    {
        return view('jobs.show', compact('jobs'));
    }

    public function apply(Jobs $jobs, Request $request)
    {
        $jobs_id = $jobs->id;
        $jobs->clicks()->create([
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'jobs_id' => $jobs_id,
        ]);

        // If you want to log and retrieve the last executed query
        //     DB::enableQueryLog();
        //     $users = Click::get();
        // $d=DB::getQueryLog();
        //     $lastQuery = end($d);
        //     dd($lastQuery);

        return redirect()->to($jobs->apply_link);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validationArray = [
            'title' => 'required',
            'company' => 'required',
            'logo' => 'file|max:2048',
            'location' => 'required',
            'apply_link' => 'required|url',
            'content' => 'required',
        ];

        if (!Auth::check()) {
            $validationArray = array_merge($validationArray, [
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:5',
                'name' => 'required',
            ]);
        }

        $request->validate($validationArray);

        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // $user->createAsStripeCustomer();

            Auth::login($user);
        }

        // Process the payment and create the Jobs
        try {
            $amount = 9900;
            if ($request->filled('is_highlighted')) {
                $amount += 1900;
            }

            if ($request->filled('payment_method_id')) {
                $user->charge($amount, $request->payment_method_id);
            }

            $md = new \ParsedownExtra();

            $job = $user->jobs()
                ->create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                    'company' => $request->company,
                    'logo' => basename($request->file('logo')->store('public')),
                    'location' => $request->location,
                    'apply_link' => $request->apply_link,
                    'content' => $md->text($request->input('content')),
                    'is_highlighted' => $request->filled('is_highlighted'),
                    'is_active' => true,
                ]);

            foreach (explode(',', $request->tags) as $requestTag) {
                $tag = Tag::firstOrCreate([
                    'slug' => Str::slug(trim($requestTag)),
                ], [
                    'name' => ucwords(trim($requestTag)),
                ]);

                $tag->jobs()->attach($job->id);
            }

            // Send email notification
            Mail::to($user->email)->send(new JobCreated($job));

            // Send notification
            // Notification::send($user, new JobCreatedNotification($job));

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function saveToken(Request $request)
    {
        $user = auth()->user();


        if ($user) {

            $user->update(['device_token' => $request->input('token')]);

            return response()->json(['message' => 'Device token saved successfully.']);
        } else {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }
    }
    public function profile()
    {
        return view('jobs.profile');
    }
}
