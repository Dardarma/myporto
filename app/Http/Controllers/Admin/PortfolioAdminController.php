<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutItem;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectStack;
use App\Models\SiteSetting;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioAdminController extends Controller
{
    public function __construct(private readonly ImageUploadService $imageUpload) {}

    private const RESOURCES = [
        'profiles' => [
            'label' => 'Profile',
            'model' => Profile::class,
            'singleton' => true,
            'fields' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                ['name' => 'headline', 'label' => 'Headline', 'type' => 'text'],
                ['name' => 'hero_greeting', 'label' => 'Hero Greeting', 'type' => 'text'],
                ['name' => 'hero_slogan', 'label' => 'Hero Slogan', 'type' => 'text'],
                ['name' => 'profile_image', 'label' => 'Profile Image', 'type' => 'image'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
                ['name' => 'instagram_url', 'label' => 'Instagram URL', 'type' => 'text'],
                ['name' => 'linkedin_url', 'label' => 'LinkedIn URL', 'type' => 'text'],
                ['name' => 'github_url', 'label' => 'GitHub URL', 'type' => 'text'],
            ],
        ],
        'about-items' => [
            'label' => 'About Items',
            'model' => AboutItem::class,
            'fields' => [
                ['name' => 'key', 'label' => 'Key', 'type' => 'text', 'required' => true],
                ['name' => 'label', 'label' => 'Tab Label', 'type' => 'text', 'required' => true],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Active', 'type' => 'boolean'],
            ],
        ],
        'educations' => [
            'label' => 'Education',
            'model' => Education::class,
            'fields' => [
                ['name' => 'degree', 'label' => 'Degree', 'type' => 'text', 'required' => true],
                ['name' => 'institution', 'label' => 'Institution', 'type' => 'text', 'required' => true],
                ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text'],
                ['name' => 'start_year', 'label' => 'Start Year', 'type' => 'number'],
                ['name' => 'end_year', 'label' => 'End Year', 'type' => 'number'],
                ['name' => 'is_current', 'label' => 'Current', 'type' => 'boolean'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
            ],
        ],
        'experiences' => [
            'label' => 'Experience',
            'model' => Experience::class,
            'fields' => [
                ['name' => 'company_name', 'label' => 'Company', 'type' => 'text', 'required' => true],
                ['name' => 'position', 'label' => 'Position', 'type' => 'text', 'required' => true],
                ['name' => 'start_date', 'label' => 'Start Date', 'type' => 'date'],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date'],
                ['name' => 'is_current', 'label' => 'Current', 'type' => 'boolean'],
                ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ['name' => 'logo', 'label' => 'Logo', 'type' => 'image'],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
            ],
        ],
        'certificates' => [
            'label' => 'Certificates',
            'model' => Certificate::class,
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'issuer', 'label' => 'Issuer', 'type' => 'text'],
                ['name' => 'year', 'label' => 'Year', 'type' => 'number'],
                ['name' => 'issued_at', 'label' => 'Issued At', 'type' => 'date'],
                ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
                ['name' => 'credential_url', 'label' => 'Credential URL', 'type' => 'text'],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Active', 'type' => 'boolean'],
            ],
        ],
        'projects' => [
            'label' => 'Projects',
            'model' => Project::class,
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
                ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'options' => ['IT', 'NON_IT']],
                ['name' => 'category', 'label' => 'Category', 'type' => 'text'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
                ['name' => 'detail', 'label' => 'Detail', 'type' => 'textarea'],
                ['name' => 'thumbnail', 'label' => 'Thumbnail', 'type' => 'image'],
                ['name' => 'images', 'label' => 'Additional Images', 'type' => 'image_multiple'],
                ['name' => 'project_url', 'label' => 'Project URL', 'type' => 'text'],
                ['name' => 'repository_url', 'label' => 'Repository URL', 'type' => 'text'],
                ['name' => 'stacks_csv', 'label' => 'Stacks (comma separated)', 'type' => 'text'],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
                ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'boolean'],
                ['name' => 'is_active', 'label' => 'Active', 'type' => 'boolean'],
            ],
        ],
        'gallery-items' => [
            'label' => 'Gallery',
            'model' => GalleryItem::class,
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ['name' => 'image', 'label' => 'Image', 'type' => 'image', 'required' => true],
                ['name' => 'alt_text', 'label' => 'Alt Text', 'type' => 'text'],
                ['name' => 'category', 'label' => 'Category', 'type' => 'text'],
                ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Active', 'type' => 'boolean'],
            ],
        ],
        'site-settings' => [
            'label' => 'Site Settings',
            'model' => SiteSetting::class,
            'fields' => [
                ['name' => 'key', 'label' => 'Key', 'type' => 'text', 'required' => true],
                ['name' => 'value', 'label' => 'Value', 'type' => 'textarea'],
                ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'options' => ['string', 'text', 'image', 'url', 'boolean']],
            ],
        ],
    ];

    public function index(?string $resource = null): Response
    {
        $resource ??= 'profiles';
        $config = $this->resourceConfig($resource);

        /** @var class-string<Model> $model */
        $model = $config['model'];
        $query = $model::query();

        if ($resource === 'projects') {
            $query->with('stacks');
        }

        if ($this->hasSortOrder($config)) {
            $query->orderBy('sort_order');
        } else {
            $query->latest();
        }

        return Inertia::render('admin/PortfolioCrud', [
            'resource' => $resource,
            'resources' => $this->navigation(),
            'config' => Arr::except($config, ['model']),
            'records' => $query->get()->map(fn (Model $record) => $this->serializeRecord($record, $resource)),
        ]);
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $config = $this->resourceConfig($resource);
        $payload = $this->payload($request, $config, $resource);

        /** @var class-string<Model> $model */
        $model = $config['model'];

        if ($this->isSingleton($config)) {
            $record = $model::query()->first();

            if ($record) {
                $record->update($payload);
            } else {
                $model::query()->create($payload);
            }

            return back()->with('success', "{$config['label']} updated.");
        }

        $record = $model::query()->create($payload);

        if ($resource === 'projects') {
            $this->syncProjectStacks($record, $request->string('stacks_csv')->toString());
        }

        return back()->with('success', "{$config['label']} created.");
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $config = $this->resourceConfig($resource);

        /** @var class-string<Model> $model */
        $model = $config['model'];
        $record = $model::query()->findOrFail($id);
        $record->update($this->payload($request, $config, $resource, $record));

        if ($resource === 'projects') {
            $this->syncProjectStacks($record, $request->string('stacks_csv')->toString());
        }

        return back()->with('success', "{$config['label']} updated.");
    }

    public function destroy(string $resource, int $id): RedirectResponse
    {
        $config = $this->resourceConfig($resource);

        /** @var class-string<Model> $model */
        $model = $config['model'];
        $record = $model::query()->findOrFail($id);

        collect($config['fields'])
            ->whereIn('type', ['image', 'image_multiple'])
            ->each(function (array $field) use ($record): void {
                $value = $record->getAttribute($field['name']);

                foreach (is_array($value) ? $value : [$value] as $image) {
                    $this->imageUpload->delete($image);
                }
            });

        $record->delete();

        return back()->with('success', "{$config['label']} deleted.");
    }

    /**
     * @return array<string, mixed>
     */
    private function resourceConfig(string $resource): array
    {
        abort_unless(array_key_exists($resource, self::RESOURCES), 404);

        return self::RESOURCES[$resource];
    }

    /**
     * @return array<int, array{key: string, label: string}>
     */
    private function navigation(): array
    {
        return collect(self::RESOURCES)
            ->map(fn (array $config, string $key) => ['key' => $key, 'label' => $config['label']])
            ->values()
            ->all();
    }

    /**
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    private function payload(Request $request, array $config, string $resource, ?Model $record = null): array
    {
        $imageFields = collect($config['fields'])
            ->where('type', 'image')
            ->pluck('name')
            ->all();

        foreach ($imageFields as $imageField) {
            $field = collect($config['fields'])->firstWhere('name', $imageField);
            $presenceRule = ! $record && ($field['required'] ?? false) ? 'required' : 'nullable';

            $request->validate([
                $imageField => [$presenceRule, 'image', 'mimes:jpeg,png,webp', 'max:10240'],
            ]);
        }

        $multipleImageFields = collect($config['fields'])
            ->where('type', 'image_multiple')
            ->pluck('name')
            ->all();

        foreach ($multipleImageFields as $imageField) {
            $request->validate([
                $imageField => ['nullable', 'array', 'max:12'],
                $imageField.'.*' => ['image', 'mimes:jpeg,png,webp', 'max:10240'],
            ]);
        }

        $payload = [];

        foreach ($config['fields'] as $field) {
            $name = $field['name'];

            if ($name === 'stacks_csv') {
                continue;
            }

            if (($field['type'] ?? 'text') === 'image') {
                if ($request->hasFile($name)) {
                    $this->imageUpload->delete($record?->getAttribute($name));
                    $payload[$name] = $this->imageUpload->store($request->file($name));
                } elseif ($record) {
                    $payload[$name] = $record->getAttribute($name);
                } else {
                    $payload[$name] = null;
                }

                continue;
            }

            if (($field['type'] ?? 'text') === 'image_multiple') {
                $existingImages = $record?->getAttribute($name) ?? [];
                $uploadedImages = collect($request->file($name, []))
                    ->map(fn ($image) => $this->imageUpload->store($image))
                    ->all();

                $payload[$name] = array_values(array_unique([
                    ...$existingImages,
                    ...$uploadedImages,
                ]));

                continue;
            }

            $value = $request->input($name);

            if (($field['type'] ?? 'text') === 'boolean') {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }

            if (($field['type'] ?? 'text') === 'number' && $value === '') {
                $value = null;
            }

            if (($field['type'] ?? 'text') === 'date' && $value === '') {
                $value = null;
            }

            $payload[$name] = $value;
        }

        if ($resource === 'projects' && blank($payload['slug'] ?? null)) {
            $payload['slug'] = Str::slug($payload['title'] ?? $record?->getAttribute('title') ?? Str::random(8));
        }

        return $payload;
    }

    private function serializeRecord(Model $record, string $resource): array
    {
        $data = $record->toArray();

        if ($resource === 'projects' && $record instanceof Project) {
            $data['stacks_csv'] = $record->stacks->pluck('name')->implode(', ');
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $config
     */
    private function hasSortOrder(array $config): bool
    {
        return collect($config['fields'])->contains(fn (array $field) => $field['name'] === 'sort_order');
    }

    /**
     * @param array<string, mixed> $config
     */
    private function isSingleton(array $config): bool
    {
        return (bool) ($config['singleton'] ?? false);
    }

    private function syncProjectStacks(Model $project, string $stacksCsv): void
    {
        if (! $project instanceof Project) {
            return;
        }

        $project->stacks()->delete();

        collect(explode(',', $stacksCsv))
            ->map(fn (string $stack) => trim($stack))
            ->filter()
            ->values()
            ->each(fn (string $stack, int $index) => ProjectStack::query()->create([
                'project_id' => $project->id,
                'name' => $stack,
                'sort_order' => $index + 1,
            ]));
    }
}
