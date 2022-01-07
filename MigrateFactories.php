<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateFactories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:factoryMigrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $path = app_path('Models');
        $all_files = File::allFiles($path);
        foreach ($all_files as $file) {
            $after_models_path = preg_replace('/^\/.+Models\//','',$file->getPath());
            $file_name = $file->getFilenameWithoutExtension();
            $model_path = $after_models_path . '/' . $file_name;
            $context = [
                '{factoryName}' => $file_name . 'Factory',
                '{modelPath}' => $model_path
            ];
            Artisan::call(strtr('make:factory {factoryName} --model={modelPath}', $context));
        }
    }
}
