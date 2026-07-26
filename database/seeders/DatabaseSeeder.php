<?php

namespace Database\Seeders;

use App\Models\AboutItem;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectStack;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'rizkidarma345@gmail.com',
        ], [
            'name' => 'Kiki',
            'password' => Hash::make('Kiki142004'),
        ]);

        Profile::query()->updateOrCreate([
            'id' => 1,
        ], [
            'name' => 'Muhammad Rizki Darmawan',
            'headline' => 'Personal Portfolio',
            'hero_greeting' => 'HI I AM',
            'hero_slogan' => "It's ALL ABOUT E'MEEEH",
            'profile_image' => '/images/component/Profile.png',
            'email' => 'hello@example.com',
            'instagram_url' => '#',
            'linkedin_url' => '#',
            'github_url' => '#',
        ]);

        collect([
            [
                'key' => 'projects',
                'label' => 'IT Projects',
                'title' => 'ABOUT ME',
                'content' => 'I enjoy building Laravel and Vue projects, from information systems and CRUD workflows to dashboards and API integrations. My work usually starts from a practical problem, then becomes a clean interface that is easier to use and maintain.',
                'sort_order' => 1,
            ],
            [
                'key' => 'writing',
                'label' => 'Writing',
                'title' => 'ABOUT ME',
                'content' => 'Beyond IT, I like writing about history, culture, reflection, opinion, and personal notes. Writing helps me arrange ideas carefully and keep a more human rhythm inside technical work.',
                'sort_order' => 2,
            ],
            [
                'key' => 'gallery',
                'label' => 'Gallery',
                'title' => 'ABOUT ME',
                'content' => 'The gallery collects documentation from activities, organizations, trips, and personal moments. It is a visual archive of learning, people, and places that shape the story behind the portfolio.',
                'sort_order' => 3,
            ],
        ])->each(fn (array $item) => AboutItem::query()->updateOrCreate([
            'key' => $item['key'],
        ], $item + ['is_active' => true]));

        Education::query()->updateOrCreate([
            'id' => 1,
        ], [
            'degree' => 'D3 Informatics Engineering',
            'institution' => 'PENS PSDKU Lamongan',
            'subtitle' => 'D3 Informatic Engineering',
            'start_year' => 2023,
            'end_year' => null,
            'is_current' => true,
            'description' => 'Learning software fundamentals, web development, databases, and practical information system development.',
            'image' => '/images/education/Gambar%20WhatsApp%202025-11-25%20pukul%2011.26.52_79f73091.jpg',
            'sort_order' => 1,
        ]);

        Experience::query()->updateOrCreate([
            'id' => 1,
        ], [
            'company_name' => 'PT ALFAHUMA REKAYASA TECHNOLOGI',
            'position' => 'Intern Programer',
            'start_date' => '2024-06-01',
            'end_date' => '2024-12-31',
            'is_current' => false,
            'location' => 'Lamongan',
            'description' => 'Lorem ipsum',
            'logo' => '/images/company/logo.png',
            'sort_order' => 1,
        ]);

        collect([
            ['title' => 'Frontend Development Fundamentals', 'issuer' => 'Learning Partner', 'year' => 2024, 'image' => '/images/certificate/Certificate_1.jpg', 'sort_order' => 1],
            ['title' => 'Laravel Web Application', 'issuer' => 'Tech Course', 'year' => 2024, 'image' => '/images/certificate/Certificate_2.jpg', 'sort_order' => 2],
            ['title' => 'Database and API Practice', 'issuer' => 'Campus Program', 'year' => 2025, 'image' => '/images/certificate/Certificate_3.jpg', 'sort_order' => 3],
            ['title' => 'UI Design Exploration', 'issuer' => 'Creative Class', 'year' => 2025, 'image' => '/images/certificate/Certificate_4.jpg', 'sort_order' => 4],
            ['title' => 'Cultural Documentation', 'issuer' => 'Personal Archive', 'year' => 2026, 'image' => '/images/certificate/Certificate_1.jpg', 'sort_order' => 5],
        ])->each(fn (array $certificate) => Certificate::query()->updateOrCreate([
            'title' => $certificate['title'],
        ], $certificate + ['is_active' => true]));

        $projects = collect([
            [
                'title' => 'Beswan E-Learning',
                'type' => 'IT',
                'category' => 'IT',
                'description' => 'Learning platform concept with course materials, student access, and practical dashboard workflows.',
                'detail' => 'A static preview for an e-learning idea focused on course discovery, learner progress, admin-friendly content management, and practical dashboard flows that can later be connected to Laravel APIs.',
                'thumbnail' => '/images/project/project_1_1.png',
                'stack' => ['Laravel', 'Vue', 'MySQL'],
                'sort_order' => 1,
            ],
            [
                'title' => 'Mentoring Web',
                'type' => 'IT',
                'category' => 'IT',
                'description' => 'Mentoring web concept with Laravel API, Vue interface, token authentication, and guided sessions.',
                'detail' => 'A mentoring platform concept for arranging sessions, protecting user areas with token authentication, and separating frontend interaction from Laravel API responsibilities.',
                'thumbnail' => '/images/project/project_1_2.png',
                'stack' => ['Laravel API', 'Vue', 'JWT'],
                'sort_order' => 2,
            ],
            [
                'title' => 'CMS Project',
                'type' => 'IT',
                'category' => 'IT',
                'description' => 'Content management dashboard for structured publishing and admin-side data management.',
                'detail' => 'A CMS-style dashboard concept with structured content editing, admin navigation, reusable layout sections, and a path toward CRUD-backed Laravel modules.',
                'thumbnail' => '/images/project/project_2_1.png',
                'stack' => ['Laravel', 'AdminLTE'],
                'sort_order' => 3,
            ],
            [
                'title' => 'Artikel Budaya',
                'type' => 'NON_IT',
                'category' => 'Non-IT',
                'description' => 'Short-form cultural writing that documents heritage, local memory, and everyday interpretation.',
                'detail' => 'A writing collection concept for cultural notes, local history, observation, and reflective interpretation outside software development work.',
                'thumbnail' => '/images/component/Pattern.jpg',
                'stack' => [],
                'sort_order' => 4,
            ],
            [
                'title' => 'Tulisan Reflektif',
                'type' => 'NON_IT',
                'category' => 'Non-IT',
                'description' => 'Personal essays about learning, discipline, identity, and small observations from daily life.',
                'detail' => 'A personal archive for reflection pieces, opinions, and essays that help preserve thought process, growth, and everyday lessons.',
                'thumbnail' => '/images/project/project_2_2.png',
                'stack' => [],
                'sort_order' => 5,
            ],
            [
                'title' => 'Dokumentasi Organisasi',
                'type' => 'NON_IT',
                'category' => 'Non-IT',
                'description' => 'Visual notes and written documentation from organization activities and collaborative events.',
                'detail' => 'A documentation concept for organization activities, event memories, visual records, and collaborative experience outside formal project work.',
                'thumbnail' => '/images/component/Profile.png',
                'stack' => [],
                'sort_order' => 6,
            ],
        ]);

        $projects->each(function (array $projectData): void {
            $stacks = $projectData['stack'];
            unset($projectData['stack']);

            $project = Project::query()->updateOrCreate([
                'slug' => Str::slug($projectData['title']),
            ], $projectData + [
                'is_active' => true,
                'is_featured' => $projectData['type'] === 'IT',
            ]);

            $project->stacks()->delete();

            collect($stacks)->each(fn (string $stack, int $index) => ProjectStack::query()->create([
                'project_id' => $project->id,
                'name' => $stack,
                'sort_order' => $index + 1,
            ]));
        });

        collect([
            ['title' => 'Profile Portrait', 'description' => 'Portrait image used as the main visual identity for the portfolio hero.', 'image' => '/images/component/Profile.png', 'category' => 'Profile', 'sort_order' => 1],
            ['title' => 'Ethnic Pattern', 'description' => 'Background motif that gives the page its ethnic and personal visual character.', 'image' => '/images/component/Pattern.jpg', 'category' => 'Visual', 'sort_order' => 2],
            ['title' => 'Project Preview 1', 'description' => 'Interface preview from an IT project archive.', 'image' => '/images/project/project_1_1.png', 'category' => 'Project', 'sort_order' => 3],
            ['title' => 'Project Preview 2', 'description' => 'Second project image used as portfolio documentation.', 'image' => '/images/project/project_1_2.png', 'category' => 'Project', 'sort_order' => 4],
            ['title' => 'Project Preview 3', 'description' => 'Dashboard-style visual documentation for project presentation.', 'image' => '/images/project/project_2_1.png', 'category' => 'Project', 'sort_order' => 5],
            ['title' => 'Project Preview 4', 'description' => 'Additional project image for visual context and archive.', 'image' => '/images/project/project_2_2.png', 'category' => 'Project', 'sort_order' => 6],
        ])->each(fn (array $galleryItem) => GalleryItem::query()->updateOrCreate([
            'title' => $galleryItem['title'],
        ], $galleryItem + [
            'alt_text' => $galleryItem['title'],
            'is_active' => true,
        ]));

        collect([
            ['key' => 'pattern_image', 'value' => '/images/component/Pattern.jpg', 'type' => 'image'],
            ['key' => 'footer_heading', 'value' => "Let's connect and build something thoughtful.", 'type' => 'string'],
        ])->each(fn (array $setting) => SiteSetting::query()->updateOrCreate([
            'key' => $setting['key'],
        ], $setting));
    }
}
