<?php namespace Ayra\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use ZipArchive;

class ThemeBackupCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'theme:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create backup of theme with automatic naming and rotation.';

    /**
     * Repository config.
     *
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Filesystem
     *
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Config\Repository     $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return \Ayra\Theme\Commands\ThemeBackupCommand
     */
    public function __construct(Repository $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $theme = $this->argument('name');
        $keepBackups = $this->option('keep');

        if (!$this->files->isDirectory($this->getThemePath($theme))) {
            return $this->error('Theme "' . $theme . '" does not exist.');
        }

        $backupPath = $this->createBackup($theme);
        
        if ($backupPath) {
            $this->info('Theme "' . $theme . '" has been backed up to: ' . $backupPath);
            
            // Clean old backups
            $this->cleanOldBackups($theme, $keepBackups);
        } else {
            $this->error('Failed to backup theme "' . $theme . '".');
        }
    }

    /**
     * Create backup of theme
     *
     * @param string $theme
     * @return string|false
     */
    protected function createBackup($theme)
    {
        $backupDir = storage_path('app/theme-backups/' . $theme);
        
        if (!$this->files->isDirectory($backupDir)) {
            $this->files->makeDirectory($backupDir, 0755, true);
        }

        $timestamp = date('Y-m-d_H-i-s');
        $backupPath = $backupDir . '/' . $theme . '_' . $timestamp . '.zip';

        $zip = new ZipArchive();
        
        if ($zip->open($backupPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }

        $themePath = $this->getThemePath($theme);
        $this->addDirectoryToZip($zip, $themePath, $theme);
        $zip->close();

        return $backupPath;
    }

    /**
     * Add directory contents to ZIP
     *
     * @param ZipArchive $zip
     * @param string $dirPath
     * @param string $baseName
     * @return void
     */
    protected function addDirectoryToZip($zip, $dirPath, $baseName)
    {
        $files = $this->files->allFiles($dirPath);
        
        foreach ($files as $file) {
            $relativePath = str_replace($dirPath . '/', '', $file);
            $zipPath = $baseName . '/' . $relativePath;
            
            $zip->addFile($file, $zipPath);
        }
    }

    /**
     * Clean old backups
     *
     * @param string $theme
     * @param int $keepBackups
     * @return void
     */
    protected function cleanOldBackups($theme, $keepBackups)
    {
        $backupDir = storage_path('app/theme-backups/' . $theme);
        
        if (!$this->files->isDirectory($backupDir)) {
            return;
        }

        $backups = $this->files->files($backupDir);
        
        // Sort backups by modification time (newest first)
        usort($backups, function($a, $b) {
            return $this->files->lastModified($b) - $this->files->lastModified($a);
        });

        // Remove old backups
        if (count($backups) > $keepBackups) {
            $oldBackups = array_slice($backups, $keepBackups);
            
            foreach ($oldBackups as $backup) {
                $this->files->delete($backup);
                $this->line('Removed old backup: ' . basename($backup));
            }
        }
    }

    /**
     * Get theme path
     *
     * @param string $theme
     * @return string
     */
    protected function getThemePath($theme)
    {
        $themeDir = $this->config->get('theme.themeDir', 'public/themes');
        return base_path($themeDir . '/' . $theme);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Name of the theme to backup.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('keep', 'k', \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Number of backups to keep (default: 5).', 5),
        );
    }
}
