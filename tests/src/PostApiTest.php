<?php

use TomatoPHP\FilamentCms\Models\Category;
use TomatoPHP\FilamentCms\Models\Post;

use function Pest\Laravel\getJson;

function publishedPost(array $attributes = []): Post
{
    return Post::factory()->published()->create($attributes);
}

it('lists only published posts', function () {
    $published = publishedPost(['slug' => 'visible']);
    Post::factory()->unpublished()->create(['slug' => 'draft']);
    Post::factory()->create(['slug' => 'scheduled', 'is_published' => true, 'published_at' => now()->addWeek()]);

    getJson('/api/cms/posts')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', $published->slug)
        ->assertJsonStructure(['data' => [['id', 'type', 'title', 'slug', 'body', 'feature_image', 'categories', 'tags', 'published_at']], 'links', 'meta']);
});

it('filters posts by type, category, tag, trend and search', function () {
    $category = Category::factory()->forPost()->asCategory()->create(['slug' => 'news']);
    $tag = Category::factory()->forPost()->asTag()->create(['slug' => 'laravel']);

    $news = publishedPost(['type' => 'post', 'title' => 'Hello News', 'is_trend' => true]);
    $news->categories()->attach($category);
    $news->tags()->attach($tag);
    publishedPost(['type' => 'service', 'title' => 'Other', 'is_trend' => false]);

    getJson('/api/cms/posts?type=service')->assertJsonCount(1, 'data')->assertJsonPath('data.0.type', 'service');
    getJson('/api/cms/posts?category=news')->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $news->id);
    getJson('/api/cms/posts?tag=laravel')->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $news->id);
    getJson('/api/cms/posts?trend=1')->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $news->id);
    getJson('/api/cms/posts?search=Hello')->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $news->id);
});

it('caps per_page at the configured maximum', function () {
    config()->set('filament-cms-api.max_per_page', 2);
    Post::factory()->published()->count(3)->create();

    getJson('/api/cms/posts?per_page=50')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('meta.per_page', 2);
});

it('shows a published post by slug', function () {
    $post = publishedPost(['slug' => 'hello-world']);

    getJson('/api/cms/posts/hello-world')
        ->assertOk()
        ->assertJsonPath('data.id', $post->id)
        ->assertJsonPath('data.slug', 'hello-world');
});

it('hides unpublished and unknown posts', function () {
    Post::factory()->unpublished()->create(['slug' => 'secret']);

    getJson('/api/cms/posts/secret')->assertNotFound();
    getJson('/api/cms/posts/missing')->assertNotFound();
});

it('returns translated fields in the requested locale', function () {
    publishedPost(['slug' => 'translated', 'title' => ['en' => 'Hello', 'ar' => 'Marhaba']]);

    getJson('/api/cms/posts/translated?locale=ar')->assertJsonPath('data.title', 'Marhaba');
    getJson('/api/cms/posts/translated?locale=en')->assertJsonPath('data.title', 'Hello');
});

it('ignores malformed locales', function () {
    publishedPost(['slug' => 'safe', 'title' => ['en' => 'Hello']]);

    getJson('/api/cms/posts/safe?locale=../../etc')->assertOk()->assertJsonPath('data.title', 'Hello');
});
