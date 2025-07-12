<?php

namespace App\Lib;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StorageManager
{
    /**
     * storage
     *
     *
     * @var object
     */

    public $server;
    /**
     *  driver
     *
     *
     * @var object
     */

    protected $driver;

    /**
     * The file which will be uploaded
     *
     *
     * @var object
     */

    protected $file;

    /**
     * The path where will be uploaded
     *
     * @var string
     */
    public $path;

    /**
     * The size, if the file is image
     *
     * @var string
     */
    public $size;

    /**
     * Check the file is image or not
     *
     * @var boolean
     */
    protected $isImage;

    /**
     * Thumbnail version size, if required
     * and if the file is image
     *
     * @var string
     */
    public $thumb;

    /**
     * Old filename, which will be removed
     *
     * @var string
     */
    public $old;

    /**
     * Current filename, which is uploading
     *
     * @var string
     */
    public $filename;

    public function __construct($server, $file = null)
    {
        $this->file = $file;
        if ($file) {
            $imageExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
            if (in_array($file->getClientOriginalExtension(), $imageExtensions)) {
                $this->isImage = true;
            } else {
                $this->isImage = false;
            }
        }
        $this->setConfiguration($server);

        $this->driver = Storage::disk($server);
    }

    private function setConfiguration($server)
    {
        $general      = gs();
        $this->server = $server;
        $method       = $server . 'Configuration';
        $this->$method($general);
    }

    public function upload()
    {
        //create the directory if doesn't exists
        $path = $this->makeDirectory();

        if (!$path) {
            throw new \Exception('File could not been created.');
        }

        $filename       = $this->getFileName();
        $this->filename = $filename;

        //upload file or image
        if ($this->isImage == true) {
            $this->uploadImage();
        } else {
            $this->uploadFile();
        }
    }

    public function uploadImage($image = null, $filename = null, $isThumb = false)
    {
        if ($filename) {
            $this->filename = $filename;
        }

        if ($isThumb) {
            $this->thumb = true;
            $separator   = '/thumb_';
        } else {
            $this->thumb = false;
            $separator   = '/';
        }

        //remove the old file if exist
        if ($this->old) {
            $this->removeFile();
        }

        $path = $this->path . $separator . $this->filename;
        $this->driver->put($path, (string) $image->encode());
    }

    /**
     * Upload the file if this is not a image
     *
     * @return void
     */

    protected function uploadFile()
    {
        //remove the old file if exist
        if ($this->old) {
            $this->removeFile();
        }

        $this->driver->put($this->path . '/' . $this->filename, fopen($this->file, 'r+'));
    }

    /**
     * Generating the filename which is uploading
     *
     * @return string
     */

    protected function getFileName()
    {
        return uniqid() . time() . '.' . $this->file->getClientOriginalExtension();
    }

    /**
     * Remove the file if exists
     * Developer can also call this method statically
     *
     * @param $path
     * @return void
     */

    public function removeFile($path = null)
    {
        if (str_contains($this->old, '/')) {
            $files     = explode('/', $this->old);
            $this->old = end($files);
        }

        if ($this->thumb) {
            $path = $this->path . '/thumb_' . $this->old;
        }

        if (!$path) {
            $path = $this->path . '/' . $this->old;
        }

        if ($this->driver->exists($path)) {
            $this->driver->delete($path);
        }
    }

    /**
     * Make directory doesn't exists
     * Developer can also call this method statically
     *
     * @param $location
     * @return string
     */

    protected function makeDirectory()
    {

        $test = $this->driver->exists($this->path);

        if ($test) {
            return $this->path;
        }
        return $this->driver->makeDirectory($this->path);
    }

    private function ftpConfiguration($general)
    {
        Config::set('filesystems.disks.ftp', [
            'driver'   => 'ftp',
            'host'     => @$general->ftp->host,
            'username' => @$general->ftp->username,
            'password' => @$general->ftp->password,
            'port'     => (int) @$general->ftp->port,
            'root'     => @$general->ftp->root_path,
        ]);
    }

    private function wasabiConfiguration($general)
    {
        Config::set('filesystems.disks.wasabi', [
            'driver'   => $general->wasabi->driver,
            'key'      => $general->wasabi->key,
            'secret'   => $general->wasabi->secret,
            'region'   => $general->wasabi->region,
            'bucket'   => $general->wasabi->bucket,
            'endpoint' => $general->wasabi->endpoint,
        ]);
    }

}
