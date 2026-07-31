<?php

namespace App\Http\Controllers;

use App\Models\AboutItem;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioHomeController extends Controller
{
    public function __invoke(): Response
    {
        $profile = Profile::query()->first();

        return Inertia::render('PortfolioHome', [
            'profile' => $profile ? [
                'name' => $profile->name,
                'headline' => $profile->headline,
                'heroGreeting' => $profile->hero_greeting,
                'heroSlogan' => $profile->hero_slogan,
                'profileImage' => $profile->profile_image,
                'email' => $profile->email,
                'phone' => $profile->phone,
                'instagramUrl' => $profile->instagram_url,
                'linkedinUrl' => $profile->linkedin_url,
                'githubUrl' => $profile->github_url,
            ] : null,
            'aboutItems' => AboutItem::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (AboutItem $item) => [
                    'key' => $item->key,
                    'label' => $item->label,
                    'title' => $item->title,
                    'content' => $item->content,
                ]),
            'educations' => Education::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Education $education) => [
                    'degree' => $education->degree,
                    'institution' => $education->institution,
                    'subtitle' => $education->subtitle,
                    'startYear' => $education->start_year,
                    'endYear' => $education->end_year,
                    'isCurrent' => $education->is_current,
                    'description' => $education->description,
                    'image' => $education->image,
                ]),
            'experiences' => Experience::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Experience $experience) => [
                    'companyName' => $experience->company_name,
                    'position' => $experience->position,
                    'startDate' => $experience->start_date?->format('Y-m-d'),
                    'endDate' => $experience->end_date?->format('Y-m-d'),
                    'isCurrent' => $experience->is_current,
                    'location' => $experience->location,
                    'description' => $experience->description,
                    'logo' => $experience->logo,
                ]),
            'certificates' => Certificate::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Certificate $certificate) => [
                    'image' => $certificate->image,
                    'title' => $certificate->title,
                    'issuer' => $certificate->issuer,
                    'year' => (string) $certificate->year,
                    'credentialUrl' => $certificate->credential_url,
                ]),
            'projects' => Project::query()
                ->with('stacks')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Project $project) => [
                    'type' => $project->type,
                    'title' => $project->title,
                    'description' => $project->description,
                    'detail' => $project->detail,
                    'category' => $project->category,
                    'stack' => $project->stacks->pluck('name')->values(),
                    'thumbnail' => $project->thumbnail,
                    'images' => collect($project->images)
                        ->when($project->thumbnail, fn ($images) => $images->prepend($project->thumbnail))
                        ->filter()
                        ->unique()
                        ->values(),
                    'projectUrl' => $project->project_url,
                    'repositoryUrl' => $project->repository_url,
                ]),
            'galleryItems' => GalleryItem::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (GalleryItem $item) => [
                    'image' => $item->image,
                    'title' => $item->title,
                    'description' => $item->description,
                    'altText' => $item->alt_text,
                    'category' => $item->category,
                ]),
            'siteSettings' => SiteSetting::query()
                ->pluck('value', 'key'),
        ]);
    }
}
