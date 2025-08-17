<?php namespace Ayra\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use ZipArchive;

class ThemeImportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'theme:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import theme from ZIP file.';

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
     * @return \Ayra\Theme\Commands\ThemeImportCommand
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
        $zipPath = $this->argument('zip');
        $themeName = $this->option('name');

        if (!$this->files->exists($zipPath)) {
            return $this->error('ZIP file not found: ' . $zipPath);
        }

        if (!$this->isValidZip($zipPath)) {
            return $this->error('Invalid ZIP file or corrupted archive.');
        }

        $themeName = $themeName ?: $this->extractThemeName($zipPath);
        
        if ($this->themeExists($themeName) && !$this->option('force')) {
            return $this->error('Theme "' . $themeName . '" already exists. Use --force to overwrite.');
        }

        if ($this->importTheme($zipPath, $themeName)) {
            $this->info('Theme "' . $themeName . '" has been imported successfully.');
        } else {
            $this->error('Failed to import theme from: ' . $zipPath);
        }
    }

    /**
     * Check if ZIP file is valid
     *
     * @param string $zipPath
     * @return bool
     */
    protected function isValidZip($zipPath)
    {
        $zip = new ZipArchive();
        return $zip->open($zipPath) === TRUE;
    }

    /**
     * Extract theme name from ZIP
     *
     * @param string $zipPath
     * @return string
     */
    protected function extractThemeName($zipPath)
    {
        $zip = new ZipArchive();
        $zip->open($zipPath);
        
        $firstEntry = $zip->getNameIndex(0);
        $themeName = explode('/', $firstEntry)[0];
        
        $zip->close();
        
        return $themeName;
    }

    /**
     * Check if theme exists
     *
     * @param string $themeName
     * @return bool
     */
    protected function themeExists($themeName)
    {
        $themePath = $this->getThemePath($themeName);
        return $this->files->isDirectory($themePath);
    }

    /**
     * Import theme from ZIP
     *
     * @param string $zipPath
     * @param string $themeName
     * @return bool
     */
    protected function importTheme($zipPath, $themeName)
    {
        $themePath = $this->getThemePath($themeName);
        
        // Remove existing theme if force option is used
        if ($this->option('force') && $this->files->isDirectory($themePath)) {
            $this->files->deleteDirectory($themePath);
        }

        // Create theme directory
        $this->files->makeDirectory($themePath, 0755, true);

        $zip = new ZipArchive();
        
        if ($zip->open($zipPath) !== TRUE) {
            return false;
        }

        // Extract theme files
        $zip->extractTo($themePath);
        $zip->close();

        // Fix file permissions
        $this->fixPermissions($themePath);

        return true;
    }

    /**
     * Fix file permissions
     *
     * @param string $themePath
     * @return void
     */
    protected function fixPermissions($themePath)
    {
        $this->files->chmod($themePath, 0755);
        
        $files = $this->files->allFiles($themePath);
        foreach ($files as $file) {
            $this->files->chmod($file, 0644);
        }
    }

    /**
     * Get theme path
     *
     * @param string $themeName
     * @return string
     */
    protected function getThemePath($themeName)
    {
        $themeDir = $this->config->get('theme.themeDir', 'public/themes');
        return base_path($themeDir . '/' . $themeName);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('zip', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Path to ZIP file containing theme.'),
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
            array('name', null, \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Custom name for the imported theme.', null),
            array('force', 'f', \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Overwrite existing theme if it exists.'),
        );
    }
}
