<?php

namespace App\Console\Commands;

use App\Services\AgendaApiService;
use Illuminate\Console\Command;

class SyncAgendaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:sync {--pages=3 : Number of pages to sync} {--all : Sync all available pages from API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync agenda data from sektrabappeda API to local database';

    /**
     * Execute the console command.
     */
    public function handle(AgendaApiService $agendaService)
    {
        $this->info('Starting agenda synchronization from API...');

        $isAll = $this->option('all');
        $pages = $isAll ? 50 : (int) $this->option('pages');

        $result = $agendaService->syncRecent($pages, 30);

        $this->info("Synchronization finished!");
        $this->line("- Synced: <info>{$result['synced']}</info> agenda items");
        if ($result['errors'] > 0) {
            $this->line("- Errors: <error>{$result['errors']}</error> items");
        }

        return Command::SUCCESS;
    }
}
