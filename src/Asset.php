<?php namespace Ayra\Theme;

use Closure;
use Illuminate\Support\Facades\URL;

class Asset {

	/**
	 * Path to assets.
	 *
	 * @var string
	 */
	public static $path;

	/**
	 * All of the instantiated asset containers.
	 *
	 * @var array
	 */
	public static $containers = array();

	/**
	 * Asset buffering.
	 *
	 * @var array
	 */
	protected $stacks = array(
		'cooks'  => array(),
		'serves' => array()
	);


	/**
	 * Asset construct.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Add a path to theme.
	 *
	 * @param string $path
	 */
	public function addPath($path)
	{
		static::$path = rtrim($path, '/').'/';
	}

	/**
	 * Get an asset container instance.
	 *
	 * <code>
	 *		// Get the default asset container
	 *		$container = Asset::container();
	 *
	 *		// Get a named asset container
	 *		$container = Asset::container('footer');
	 * </code>
	 *
	 * @param  string            $container
	 * @return AssetContainer
	 */
	public static function container($container = 'default')
	{
		if ( ! isset(static::$containers[$container]))
		{
			static::$containers[$container] = new AssetContainer($container);
		}

		return static::$containers[$container];
	}

	/**
	 * Cooking your assets.
	 *
	 * @param  string  $name
	 * @param  Closure $callbacks
	 * @return void
	 */
	public function cook($name, Closure $callbacks)
	{
		$this->stacks['cooks'][$name] = $callbacks;
	}

	/**
	 * Serve asset preparing from cook.
	 *
	 * @param  string $name
	 * @return Asset
	 */
	public function serve($name)
	{
		$this->stacks['serves'][$name] = true;

		return $this;
	}

	/**
	 * Flush all cooks.
	 *
	 * @return void
	 */
	public function flush()
	{
		foreach ($this->stacks['serves'] as $key => $val)
		{
			if (array_key_exists($key, $this->stacks['cooks']))
			{
				$callback = $this->stacks['cooks'][$key];

				if ($callback instanceof Closure)
				{
					$callback($this);
				}
			}
		}
	}

	/**
	 * Magic Method for calling methods on the default container.
	 *
	 * <code>
	 *		// Call the "styles" method on the default container
	 *		echo Asset::styles();
	 *
	 *		// Call the "add" method on the default container
	 *		Asset::add('jquery', 'js/jquery.js');
	 * </code>
	 */
	public function __call($method, $parameters)
	{
		return call_user_func_array(array(static::container(), $method), $parameters);
	}

    /**
     * Enable CDN for assets
     *
     * @param string $cdnUrl
     * @return $this
     */
    public function enableCdn($cdnUrl)
    {
        $this->cdnUrl = rtrim($cdnUrl, '/');
        return $this;
    }

    /**
     * Disable CDN
     *
     * @return $this
     */
    public function disableCdn()
    {
        $this->cdnUrl = null;
        return $this;
    }

    /**
     * Add asset with versioning
     *
     * @param string $name
     * @param string $path
     * @param array $dependencies
     * @param string $version
     * @return $this
     */
    public function addVersioned($name, $path, $dependencies = [], $version = null)
    {
        $version = $version ?: $this->getAssetVersion($path);
        $versionedPath = $this->addVersionToPath($path, $version);
        
        return $this->add($name, $versionedPath, $dependencies);
    }

    /**
     * Get asset version from file modification time
     *
     * @param string $path
     * @return string
     */
    protected function getAssetVersion($path)
    {
        $fullPath = public_path($path);
        
        if (file_exists($fullPath)) {
            return (string) filemtime($fullPath);
        }
        
        return '1.0';
    }

    /**
     * Add version to asset path
     *
     * @param string $path
     * @param string $version
     * @return string
     */
    protected function addVersionToPath($path, $version)
    {
        $pathInfo = pathinfo($path);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.v' . $version . '.' . $pathInfo['extension'];
    }

    /**
     * Optimize assets for production
     *
     * @param bool $enabled
     * @return $this
     */
    public function optimize($enabled = true)
    {
        $this->optimized = $enabled;
        return $this;
    }

    /**
     * Get optimized asset path
     *
     * @param string $path
     * @return string
     */
    protected function getOptimizedPath($path)
    {
        if (!$this->optimized) {
            return $path;
        }

        $pathInfo = pathinfo($path);
        $optimizedPath = $pathInfo['dirname'] . '/min/' . $pathInfo['filename'] . '.min.' . $pathInfo['extension'];
        
        return file_exists(public_path($optimizedPath)) ? $optimizedPath : $path;
    }

    /**
     * Add conditional assets
     *
     * @param string $condition
     * @param string $name
     * @param string $path
     * @param array $dependencies
     * @return $this
     */
    public function addConditional($condition, $name, $path, $dependencies = [])
    {
        $this->conditionalAssets[$condition][$name] = [
            'path' => $path,
            'dependencies' => $dependencies
        ];
        
        return $this;
    }

    /**
     * Get conditional assets for specific condition
     *
     * @param string $condition
     * @return array
     */
    public function getConditionalAssets($condition)
    {
        return $this->conditionalAssets[$condition] ?? [];
    }

    /**
     * Add asset with integrity check (SRI)
     *
     * @param string $name
     * @param string $path
     * @param string $integrity
     * @param array $dependencies
     * @return $this
     */
    public function addWithIntegrity($name, $path, $integrity, $dependencies = [])
    {
        $this->assets[$name] = [
            'path' => $path,
            'dependencies' => $dependencies,
            'integrity' => $integrity
        ];
        
        return $this;
    }

    /**
     * Get asset integrity attribute
     *
     * @param string $name
     * @return string
     */
    protected function getAssetIntegrity($name)
    {
        if (isset($this->assets[$name]['integrity'])) {
            return ' integrity="' . $this->assets[$name]['integrity'] . '" crossorigin="anonymous"';
        }
        
        return '';
    }

}