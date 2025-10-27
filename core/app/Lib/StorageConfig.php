<?php

namespace App\Lib;

use App\Constants\Status;
use App\Models\StorageSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class StorageConfig
{
    public function getActiveStorage()
    {
        return StorageSetting::where('status', Status::ENABLE)->first();
    }

    public function configure($driver = null)
    {
        $storage = $driver ? StorageSetting::where('alias', $driver)->first() : $this->getActiveStorage();

        if (!$storage || !isset($storage->parameters)) {
            return 'local';
        }

        $config = $storage->parameters;

        if ($config->driver->value === 's3') {
            $this->setWasabiConfig($config);
            return 'wasabi';
        } elseif ($config->driver->value === 'ftp') {
            $this->setFtpConfig($config);
            return 'ftp';
        }

        return 'local';
    }

    public function fileExists($driver, $path): bool
    {
        return Storage::disk($driver)->exists($path);
    }

    public function deleteFile($driver, $path): void
    {
        if ($this->fileExists($driver, $path)) {
            Storage::disk($driver)->delete($path);
        }
    }

    public function getFileResponse($driver, $path)
    {
        return Storage::disk($driver)->response($path);
    }

    public function storeFile($driver, $filename, $file)
    {
        return $file->storeAs('shorts', $filename, $driver);
    }

    public function storeLocalFile($filename, $file)
    {
        $localPath = getFilePath('shorts') . '/' . $filename;
        if (!file_exists(dirname($localPath))) {
            mkdir(dirname($localPath), 0755, true);
        }
        return copy($file, $localPath);
    }

    private function setWasabiConfig($config)
    {
        Config::set('filesystems.disks.wasabi', [
            'driver'   => $config->driver->value,
            'key'      => $config->key->value,
            'secret'   => $config->secret->value,
            'region'   => $config->region->value,
            'bucket'   => $config->bucket->value,
            'endpoint' => $config->endpoint->value,
        ]);
    }

    private function setFtpConfig($config)
    {
        Config::set('filesystems.disks.ftp', [
            'driver'   => $config->driver->value,
            'host'     => $config->host->value,
            'username' => $config->username->value,
            'password' => $config->password->value,
            'port'     => (int) ($config->port->value),
            'root'     => $config->root->value,
        ]);
    }
}
