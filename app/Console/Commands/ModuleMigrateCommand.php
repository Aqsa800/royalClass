<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class ModuleMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:module {module : The name of the module to migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for a specific module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->argument('module');
        
        // Check if the specified module exists
        if (!Module::has($moduleName)) {
            $this->error("Module '$moduleName' does not exist.");
            return 1;
        }
        
        // Get the module's migration path
        $module = Module::find($moduleName);
        $migrationsPath = $module->getPath() . '/Database/migrations';

        // Check if the migrations directory contains files
        if (!is_dir($migrationsPath)) {
            $this->warn("Migration directory does not exist for module '$moduleName'.");
            return 1;
        }

        $migrationFiles = glob($migrationsPath . '/*.php');

        if (empty($migrationFiles)) {
            $this->warn("No migrations found in $migrationsPath for module '$moduleName'.");
            return 1;
        }

        // Run each migration file separately
        $this->info("Running migrations for module: $moduleName");
        
        foreach ($migrationFiles as $file) {
            // Convert full path to relative path
            $relativePath = str_replace(base_path() . '/', '', $file);

            $this->info("Migrating: $relativePath");

            Artisan::call('migrate', [
                '--path' => $relativePath,
                '--force' => true,
            ]);
            
            $this->info(Artisan::output());
        }
        
        return 0;
    }
}
