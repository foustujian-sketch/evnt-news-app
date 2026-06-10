<?php

namespace App\Services;

use App\Models\EventNews;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsApiService
{
    /**
     * Fetch tech events from NewsAPI and save them to the database.
     *
     * @return int The number of new events saved.
     */
    public function fetchTechEvents(?string $tag = null): int
    {
        $apiKey = config('services.newsapi.key');

        if (!$apiKey) {
            Log::error('NewsAPI key is missing.');
            return 0;
        }

        // Keywords based on user requirements or specific tag
        if ($tag) {
            $query = '("' . $tag . '")';
        } else {
            $query = '("hackathon" OR "tech conference" OR "developer event" OR "programming workshop" OR "advanced IoT" OR "cybersecurity summit" OR "AI expo")';
        }

        $response = Http::get('https://newsapi.org/v2/everything', [
            'q' => $query,
            'language' => 'en',
            'sortBy' => 'publishedAt',
            'pageSize' => 100, // Developer tier limit max pageSize
            'apiKey' => $apiKey,
        ]);

        if ($response->failed()) {
            Log::error('NewsAPI fetch failed: ' . $response->body());
            return 0;
        }

        $data = $response->json();
        
        if (isset($data['status']) && $data['status'] === 'error') {
            Log::error('NewsAPI returned an error: ' . ($data['message'] ?? 'Unknown error'));
            return 0;
        }

        $articles = $data['articles'] ?? [];
        $savedCount = 0;

        foreach ($articles as $article) {
            // Skip invalid articles
            if (empty($article['title']) || $article['title'] === '[Removed]') {
                continue;
            }

            // Map and sanitize the data
            $title = $article['title'];
            $slug = Str::slug(Str::limit($title, 100)) . '-' . substr(md5($article['url'] ?? uniqid()), 0, 8);
            $content = $article['content'] ?? $article['description'] ?? 'No content available.';
            $sourceUrl = $article['url'] ?? null;
            $imagePath = $article['urlToImage'] ?? null;
            $authorName = $article['author'] ?? $article['source']['name'] ?? 'Unknown Author';
            $publishDate = isset($article['publishedAt']) ? Carbon::parse($article['publishedAt']) : now();

            // We use updateOrCreate matching by source_url to prevent duplicates.
            if ($sourceUrl) {
                $event = EventNews::updateOrCreate(
                    ['source_url' => Str::limit($sourceUrl, 250, '')],
                    [
                        'user_id' => null, // Automated API ingest
                        'title' => Str::limit($title, 250, ''),
                        'slug' => $slug,
                        'content' => $content,
                        'image_path' => Str::limit($imagePath, 250, ''),
                        'author_name' => Str::limit($authorName, 250, ''),
                        'publish_date' => $publishDate,
                    ]
                );

                if ($event->wasRecentlyCreated) {
                    $savedCount++;
                }
            }
        }

        Log::info("NewsAPI Fetcher completed: {$savedCount} new events added.");
        return $savedCount;
    }
}
