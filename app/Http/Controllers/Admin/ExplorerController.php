<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class ExplorerController extends Controller
{
    private $base;

    public function __construct()
    {
        parent::__construct();
        $this->base = storage_path('app');
    }

    public function index()
    {
        $path = $this->safePath(request('path'));
        $realPath = $this->realPath($path);
        ! File::exists($realPath) && abort(404);
        $directories = File::directories($realPath);
        $originFiles = File::files($realPath);
        $directories = array_map(function($d) use ($path) {
            $d = str_replace('\\', '\/', $d);
            return [
                'no' => explode('.', basename($d))[0],
                'name' => basename($d),
                'path' => $path . ($path ? '/' : '') . basename($d),
            ];
        }, $directories);
        $routeUri = parse_url(route('explorer.content'))['path'];
        $files = [];
        foreach($originFiles as $f) {
            try {
                $files[] = [
                    'no' => $f->getFilenameWithoutExtension(),
                    'file' => $path . '/' . $f->getBasename(),
                    'name' => $f->getBasename(),
                    'size' => (int)($f->getSize() / 1024),
                    'ext' => $f->getExtension(),
                    'img' => @exif_imagetype($f->getRealPath()) !== false,
                    'url' => $routeUri . '?file=' . $path . ($path ? '/' : '') . $f->getBasename(),
                ];
            } catch (\Throwable $e) {
                continue;
            }
        }
        usort($files, function($a, $b) {
            return (is_numeric($a['no']) && is_numeric($b['no'])) ? $a['no'] - $b['no'] : strcmp($a['name'], $b['name']);
        });
        usort($directories, function($a, $b) {
            return (is_numeric($a['no']) && is_numeric($b['no'])) ? $a['no'] - $b['no'] : strcmp($a['name'], $b['name']);
        });
        return $this->view('explorer.index', compact('directories', 'files'));
    }

    public function content()
    {
        $path = $this->safePath(request('file'));
        $realPath = $this->realPath($path);
        ! File::exists($realPath) && abort(404);
        $mime = strtolower(mimetype_from_filename($realPath));
        $mime = $mime ?: File::mimeType($realPath);
        if (File::size($realPath) > 100 * 1024 * 1024) {
            return 'file size is too large (more than 100 M)';
        }
        $response = response(file_get_contents($realPath))->header('Content-Type', $mime);
        if ($mime == 'application/octet-stream') {
            $response->header('Content-Disposition', 'form-data; name="fieldName"; filename="' . basename($path) . '"');
        }
        return $response;
    }

    public function upload()
    {
        $this->vld(['file' => 'file']);
        $file = request()->file('file');
        $path = $this->safePath(request('path'));
        $realPath = $this->realPath($path);
        try {
            if (File::isDirectory($realPath)) {
                $realFile = $realPath . '/' . $file->getClientOriginalName();
            } else {
                $realFile = $realPath;
                ! File::exists(dirname($realFile)) && File::makeDirectory(dirname($realFile));
            }
            expIf(File::exists($realFile), 'file already exists');
            File::move($file->getRealPath(), $realFile);
            return rs(['name' => basename($realFile)], __('msg.success'));
        } catch (\Exception $e) {
            return ers($e->getMessage());
        }
    }

    public function delete()
    {
        $path = $this->safePath(request('file'));
        $realPath = $this->realPath($path);
        try {
            File::delete($realPath);
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function move()
    {
        [$fromPath, $toPath] = [$this->safePath(request('from')), $this->safePath(request('to'))];
        [$fromRealPath, $toRealPath] = [$this->realPath($fromPath), $this->realPath($toPath)];
        try {
            expIf(! File::exists($fromRealPath), 'from not exists');
            expIf(File::exists($toRealPath), 'to already exists');
            File::isFile($fromRealPath) ? File::move($fromRealPath, $toRealPath) : File::moveDirectory($fromRealPath, $toRealPath);
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function copy()
    {
        [$fromPath, $toPath] = [$this->safePath(request('from')), $this->safePath(request('to'))];
        [$fromRealPath, $toRealPath] = [$this->realPath($fromPath), $this->realPath($toPath)];
        try {
            expIf(! File::exists($fromRealPath), 'from not exists');
            expIf(File::exists($toRealPath), 'to already exists');
            File::isFile($fromRealPath) ? File::copy($fromRealPath, $toRealPath) : File::copyDirectory($fromRealPath, $toRealPath);
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function mkdir()
    {
        $path = $this->safePath(request('path'));
        $realPath = $this->realPath($path);
        ! $realPath && abort(404);
        try {
            File::makeDirectory($realPath, 0755, true);
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function rmdir()
    {
        $path = $this->safePath(request('path'));
        $realPath = $this->realPath($path);
        ! $realPath && abort(404);
        try {
            File::deleteDirectory($realPath);
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    private function safePath($path)
    {
        $pathPieces = explode('/', $path ?? '');
        $safe = [];
        foreach ($pathPieces as $pathPiece) {
            $pathPiece != '..' && $safe[] = $pathPiece;
        }
        return join('/', $safe);
    }

    private function realPath($path)
    {
        return $this->base . '/' . $path;
    }
}