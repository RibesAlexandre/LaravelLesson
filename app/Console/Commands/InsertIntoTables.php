<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InsertIntoTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insère des articles en BDD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jsonData = json_decode(file_get_contents(resource_path('data/articles.json')));
        $articles = $jsonData->articles;

        $bar = $this->output->createProgressBar(count($articles));
        foreach( $articles as $article ) {
            if( !is_null($article->author) ) {
                $user = User::firstOrCreate([
                    'email'     =>  Str::slug($article->author) . '@gmail.com',
                ], [
                    'name'      =>  $article->author,
                    'password'  =>  bcrypt(Str::random(20)),
                ]);
            } else {
                $user = User::find(1);
            }

            $user->articles()->firstOrCreate([
                'slug'     =>  Str::slug($article->title),
            ], [
                'slug'      =>  Str::slug($article->title),
                'content'   =>  $article->content,
                'title'     =>  $article->title,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info('Commande exécutée');
        return Command::SUCCESS;
    }
}
