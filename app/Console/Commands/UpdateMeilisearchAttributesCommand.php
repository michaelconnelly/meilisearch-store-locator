<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;

class UpdateMeilisearchAttributesCommand extends Command
{
    protected MeiliSearchClient $client;

    protected string $index;

    protected string $key;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:update-attributes {index?} {key?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Meilisearch Attributes';

    public function __construct()
    {
        parent::__construct();

        $this->client = new MeiliSearchClient(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert('Update Meilisearch Attributes');

        $this->index = $this->argument('index') ?? $this->choice('Select Index', $this->getIndexes());

        $this->key = $this->argument('key') ?? $this->ask('Enter Key');

        $this->updateSettings();

        $this->alert("$this->index:$this->key Updated");

        return Command::SUCCESS;
    }

    protected function getIndexes()
    {
        return Arr::pluck($this->client->getAllRawIndexes()['results'], 'uid');
    }

    protected function updateSettings()
    {
        $this->client->index($this->index)->updateSettings([
            'sortableAttributes' => [
                $this->key,
            ],
            'filterableAttributes' => [
                $this->key,
            ],
        ]);
    }
}
