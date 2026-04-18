<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ExternalApiService
{
    public function getSuggestion(): array
    {
        return Cache::remember('external_suggestion', 60, function () {
            $id = rand(1, 100);

            return Http::get("https://jsonplaceholder.typicode.com/posts/$id")
                ->json();
        });
    }
}