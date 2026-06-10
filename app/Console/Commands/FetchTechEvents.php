<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsApiService;

class FetchTechEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:fetch {tag?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches tech events, hackathons, and conferences from NewsAPI and saves them to the database';

    /**
     * Execute the console command.
     */
    public function handle(NewsApiService $newsApiService)
    {
        $tag = $this->argument('tag');
        $this->info($tag ? "Starting NewsAPI Fetcher for tag: {$tag}..." : 'Starting NewsAPI Fetcher...');
        
        $count = $newsApiService->fetchTechEvents($tag);

        if ($count > 0) {
            $this->info("Successfully fetched and inserted {$count} new tech events!");
        } else {
            $this->warn('No new events were found or an error occurred. Check Laravel logs for details.');
        }

        return Command::SUCCESS;
    }
}
