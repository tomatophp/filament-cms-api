<?php

use TomatoPHP\FilamentCms\Models\Category;
use TomatoPHP\FilamentCms\Models\Post;
use TomatoPHP\FilamentCmsApi\Transformers\CategoryResource;
use TomatoPHP\FilamentCmsApi\Transformers\PostResource;

return [
    /*
     * Register the API routes. Set to false to register your own routes
     * against the package controllers.
     */
    'active' => true,

    /*
     * URL prefix and middleware for every CMS API route.
     * Add 'auth:sanctum' (or any guard) to make the API private.
     */
    'prefix' => 'api/cms',

    'middleware' => [
        'api',
    ],

    /*
     * Pagination for list endpoints (?per_page= is capped by max_per_page).
     */
    'per_page' => 15,

    'max_per_page' => 100,

    /*
     * Models served by the API.
     */
    'models' => [
        'post' => Post::class,
        'category' => Category::class,
    ],

    /*
     * JSON resources used to transform the models.
     */
    'resources' => [
        'post' => PostResource::class,
        'category' => CategoryResource::class,
    ],
];
