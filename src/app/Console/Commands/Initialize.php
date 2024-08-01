<?php

namespace App\Console\Commands;

use FilesystemIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Initialize extends Command
{
    protected $signature = 'app:init {--force : Do not ask for user confirmation }';

    protected $description = 'Run & Install dummy data for the Cultural Web Application';

    public function handle(): void
    {
        try {
            DB::connection()->getPdo();
            Log::debug('Database connection successful.');
        } catch (\Exception $e) {
            Log::debug('Database connection failed: '.$e->getMessage());
        }

        if ($this->option('force')) {
            $this->proceed();
        } elseif ($this->confirm('This command will delete your all current inserted data and, Install dummy data. Are you Sure!')) {
            $this->proceed();
        }
    }

    protected function proceed(): void
    {
        $this->call('optimize:clear');
        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        $this->copy();

        $storage = $this->callSilent('storage:link');

        if ($storage) {
            $this->info('Storage Folder Created Successfully');
        } else {
            $this->info('Storage Folder is already exist!');
        }
//        $this->createFolders();

        updateFolderPermissions(storage_path());

        $this->info('Required all data successfully installed!');
    }

    protected function copy(): void
    {
        File::deleteDirectory(public_path('storage'));
        $dummyRootPath = public_path('dummy');
        $publicRootPath = storage_path('app/public');

        File::deleteDirectory($publicRootPath);

        $this->recursiveCopy($dummyRootPath, $publicRootPath);
    }

    protected function recursiveCopy($sourceDirectory, $targetDirectory): void
    {
        File::ensureDirectoryExists($targetDirectory);

        $directories = File::directories($sourceDirectory);

        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $newTargetDir = $targetDirectory . DIRECTORY_SEPARATOR . $dirName;

            File::ensureDirectoryExists($newTargetDir);

            $this->createSizeFolders($newTargetDir);

            $this->recursiveCopy($directory, $newTargetDir);
        }

        $files = File::files($sourceDirectory);
        foreach ($files as $file) {
            $this->copyToSizeFolders($file, $targetDirectory);
        }
    }

    protected function createSizeFolders($targetDirectory): void
    {
        $sizeFolders = ['large', 'medium', 'thumbnail'];

        foreach ($sizeFolders as $size) {
            $sizeFolderPath = $targetDirectory . DIRECTORY_SEPARATOR . $size;
            File::ensureDirectoryExists($sizeFolderPath);
        }
    }

    protected function copyToSizeFolders($file, $targetDirectory): void
    {
        $sizeFolders = ['large', 'medium', 'thumbnail'];

        foreach ($sizeFolders as $size) {
            $targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $size . DIRECTORY_SEPARATOR . $file->getFilename();
            File::copy($file->getRealPath(), $targetPath);
        }
    }

    protected function createFolders(): void
    {
        $folders = [
            'banners',
            'crews',
            'casts',
            'films',
        ];

        collect($folders)->each(function ($folder) {
            $sizes = collect(['thumbnail', 'large', 'medium']);

            $sizes->each(function ($size) use ($folder) {
                Storage::disk('public')->makeDirectory($folder . '/' . $size);
            });
        });
    }
}
