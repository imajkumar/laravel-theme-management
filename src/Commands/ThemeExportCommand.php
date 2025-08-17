<?php namespace Ayra\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use ZipArchive;

class ThemeExportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'theme:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export theme to ZIP file for backup or sharing.';

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
     * @return \Ayra\Theme\Commands\ThemeExportCommand
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
        $outputPath = $this->option('output');

        if (!$this->files->isDirectory($this->getThemePath($theme))) {
            return $this->error('Theme "' . $theme . '" does not exist.');
        }

        $zipPath = $this->createZip($theme, $outputPath);

        if ($zipPath) {
            $this->info('Theme "' . $theme . '" has been exported to: ' . $zipPath);
        } else {
            $this->error('Failed to export theme "' . $theme . '".');
        }
    }

    /**
     * Create ZIP file from theme
     *
     * @param string $theme
     * @param string $outputPath
     * @return string|false
     */
    protected function createZip($theme, $outputPath)
    {
        $themePath = $this->getThemePath($theme);
        
        if (!$outputPath) {
            $outputPath = storage_path('app/themes/' . $theme . '.zip');
        }

        // Ensure output directory exists
        $outputDir = dirname($outputPath);
        if (!$this->files->isDirectory($outputDir)) {
            $this->files->makeDirectory($outputDir, 0755, true);
        }

        $zip = new ZipArchive();
        
        if ($zip->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }

        $this->addDirectoryToZip($zip, $themePath, $theme);
        $zip->close();

        return $outputPath;
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
            array('name', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Name of the theme to export.'),
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
            array('output', 'o', \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL, 'Output path for ZIP file.', null),
        );
    }
}
