<?php

use TomatoPHP\FilamentCms\Models\Category;

use function Pest\Laravel\getJson;

it('lists only active categories', function () {
    Category::factory()->forPost()->asCategory()->create(['slug' => 'active']);
    Category::factory()->forPost()->asCategory()->inactive()->create(['slug' => 'hidden']);

    getJson('/api/cms/categories')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'active')
        ->assertJsonStructure(['data' => [['id', 'parent_id', 'for', 'type', 'name', 'slug', 'icon', 'color', 'feature_image']], 'links', 'meta']);
});

it('filters categories by for, type, menu and root', function () {
    $parent = Category::factory()->forPost()->asCategory()->create(['slug' => 'parent', 'show_in_menu' => true]);
    Category::factory()->forPost()->asCategory()->withParent($parent)->create(['slug' => 'child', 'show_in_menu' => false]);
    Category::factory()->forPost()->asTag()->create(['slug' => 'tag', 'show_in_menu' => false]);
    Category::factory()->asCategory()->create(['slug' => 'portfolio', 'for' => 'portfolio', 'show_in_menu' => false]);

    getJson('/api/cms/categories?for=portfolio')->assertJsonCount(1, 'data')->assertJsonPath('data.0.slug', 'portfolio');
    getJson('/api/cms/categories?type=tag')->assertJsonCount(1, 'data')->assertJsonPath('data.0.slug', 'tag');
    getJson('/api/cms/categories?menu=1')->assertJsonCount(1, 'data')->assertJsonPath('data.0.slug', 'parent');
    getJson('/api/cms/categories?root=1&for=post&type=category')->assertJsonCount(1, 'data')->assertJsonPath('data.0.slug', 'parent');
});

it('shows a category with its active children', function () {
    $parent = Category::factory()->forPost()->asCategory()->create(['slug' => 'parent']);
    Category::factory()->forPost()->asCategory()->withParent($parent)->create(['slug' => 'child']);
    Category::factory()->forPost()->asCategory()->withParent($parent)->inactive()->create(['slug' => 'hidden-child']);

    getJson('/api/cms/categories/parent')
        ->assertOk()
        ->assertJsonPath('data.slug', 'parent')
        ->assertJsonCount(1, 'data.children')
        ->assertJsonPath('data.children.0.slug', 'child');
});

it('hides inactive categories', function () {
    Category::factory()->inactive()->create(['slug' => 'hidden']);

    getJson('/api/cms/categories/hidden')->assertNotFound();
});
