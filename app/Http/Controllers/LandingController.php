<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\SubscriptionPlan;
use App\Models\Testimonial;
use App\Models\LegalPage;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\NewsletterSubscriber;
use App\Models\HelpCategory;
use App\Models\HelpArticle;
use App\Models\HelpArticleFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    /**
     * Display the landing homepage
     */
    public function home()
    {
        // Get featured certifications (top 6-8 popular ones)
        $certifications = Certification::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();
        
        // Get subscription plans
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // Get featured testimonials
        $testimonials = Testimonial::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        // Get trial period from settings
        $trialDays = Cache::remember('trial_period_days', 3600, function () {
            return \DB::table('settings')->where('key', 'trial_period_days')->value('value') ?? 7;
        });
        
        return view('landing.home.index', compact('certifications', 'plans', 'testimonials', 'trialDays'));
    }
    
    /**
     * Display the pricing page
     */
    public function pricing()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $trialDays = Cache::remember('trial_period_days', 3600, function () {
            return \DB::table('settings')->where('key', 'trial_period_days')->value('value') ?? 7;
        });
        
        return view('landing.pricing.index', compact('plans', 'trialDays'));
    }
    
    /**
     * Display the certifications catalog
     */
    public function certifications()
    {
        $certifications = Certification::where('is_active', true)
            ->orderBy('name')
            ->paginate(12);
        
        return view('landing.certifications.index', compact('certifications'));
    }
    
    /**
     * Display a specific certification detail page
     */
    public function certificationShow($slug)
    {
        $certification = Certification::where('slug', $slug)
            ->where('is_active', true)
            ->withCount('domains')
            ->firstOrFail();
        
        // Load domains for the certification
        $certification->load('domains');
        
        // Get related certifications from same provider
        $relatedCertifications = Certification::where('is_active', true)
            ->where('provider', $certification->provider)
            ->where('id', '!=', $certification->id)
            ->take(3)
            ->get();
        
        // If less than 3, fill with random certifications
        if ($relatedCertifications->count() < 3) {
            $additional = Certification::where('is_active', true)
                ->where('id', '!=', $certification->id)
                ->whereNotIn('id', $relatedCertifications->pluck('id'))
                ->inRandomOrder()
                ->take(3 - $relatedCertifications->count())
                ->get();
            $relatedCertifications = $relatedCertifications->merge($additional);
        }
        
        // Get testimonials for social proof
        $testimonials = Testimonial::where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(2)
            ->get();
        
        // Social proof metrics (can be made dynamic from database)
        $activeStudents = rand(8000, 12000); // TODO: Get from actual data
        $passRate = 87; // TODO: Calculate from actual exam attempts
        $studyingNow = rand(50, 200); // TODO: Get from active sessions
        
        return view('landing.certifications.show', compact(
            'certification',
            'relatedCertifications',
            'testimonials',
            'activeStudents',
            'passRate',
            'studyingNow'
        ));
    }
    
    /**
     * Display the about us page
     */
    public function about()
    {
        return view('landing.about.index');
    }
    
    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('landing.contact.index');
    }
    
    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'newsletter' => 'nullable|boolean'
        ]);
        
        // TODO: Send email to support
        // For now, just store in database or log
        
        // If newsletter checkbox is checked, subscribe
        if ($request->newsletter) {
            NewsletterSubscriber::firstOrCreate(
                ['email' => $request->email],
                ['subscribed_at' => now()]
            );
        }
        
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
    
    /**
     * Display the blog index page
     */
    public function blogIndex()
    {
        $posts = BlogPost::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        
        $categories = BlogCategory::where('is_active', true)
            ->withCount('posts')
            ->get();
        
        return view('landing.blog.index', compact('posts', 'categories'));
    }
    
    /**
     * Display a specific blog post
     */
    public function blogShow($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->firstOrFail();
        
        // Increment views
        $post->incrementViews();
        
        // Get related posts
        $relatedPosts = BlogPost::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        return view('landing.blog.show', compact('post', 'relatedPosts'));
    }
    
    /**
     * Display the help center landing page
     */
    public function helpIndex()
    {
        $categories = HelpCategory::with('articles')
            ->orderBy('order')
            ->get();
        
        $featuredArticles = HelpArticle::where('is_featured', true)
            ->with('category')
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();
        
        return view('landing.help.index', compact('categories', 'featuredArticles'));
    }
    
    /**
     * Search help articles
     */
    public function helpSearch(Request $request)
    {
        $query = $request->input('q');
        
        $articles = HelpArticle::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->with('category')
            ->paginate(10);
        
        return view('landing.help.search', compact('articles', 'query'));
    }
    
    /**
     * Display a specific help article
     */
    public function helpArticleShow($slug)
    {
        $article = HelpArticle::where('slug', $slug)
            ->with('category')
            ->firstOrFail();
        
        // Increment view count
        $article->incrementViews();
        
        // Get related articles from the same category
        $relatedArticles = HelpArticle::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();
        
        // Check if user already voted
        $hasVoted = HelpArticleFeedback::where('help_article_id', $article->id)
            ->where('session_id', session()->getId())
            ->exists();
        
        return view('landing.help.show', compact('article', 'relatedArticles', 'hasVoted'));
    }
    
    /**
     * Submit feedback for a help article
     */
    public function helpArticleFeedback(Request $request, $slug)
    {
        $article = HelpArticle::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'is_helpful' => 'required|boolean',
            'comment' => 'nullable|string|max:500',
        ]);
        
        // Check if user already voted
        $existingFeedback = HelpArticleFeedback::where('help_article_id', $article->id)
            ->where('session_id', session()->getId())
            ->first();
        
        if ($existingFeedback) {
            return back()->with('error', 'You have already submitted feedback for this article.');
        }
        
        // Create feedback
        HelpArticleFeedback::create([
            'help_article_id' => $article->id,
            'session_id' => session()->getId(),
            'is_helpful' => $validated['is_helpful'],
            'comment' => $validated['comment'] ?? null,
            'ip_address' => $request->ip(),
        ]);
        
        return back()->with('success', 'Thank you for your feedback!');
    }
    
    /**
     * Display a legal page
     */
    public function legalShow($slug)
    {
        $page = LegalPage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        return view('landing.legal.show', compact('page'));
    }
    
    /**
     * Handle newsletter subscription
     */
    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);
        
        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $request->email],
            ['subscribed_at' => now()]
        );
        
        if ($subscriber->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This email is already subscribed.'
            ]);
        }
    }
}
