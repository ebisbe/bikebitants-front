<?php

namespace App\Traits;

use Intervention\Image\ImageManager;
use Session;
use Illuminate\Http\Response as IlluminateResponse;
use Config;
use Storage;

trait Image
{
    /**
     * Get HTTP response of either original image file or
     * template applied file.
     *
     * @param  string $filter
     * @param  string $filename
     * @return IlluminateResponse
     */
    public function getResponse($filter, $filename)
    {
        switch (strtolower($filter)) {
            case 'original':
                return $this->getOriginal($filename);

            case 'download':
                return $this->getDownload($filename);

            default:
                return $this->getImage($filter, $filename);
        }
    }

    /**
     * Get HTTP response of template applied image file
     *
     * @param  string $filter
     * @param  string $filename
     * @return IlluminateResponse
     */
    public function getImage($filter, $filename)
    {
        $manager = new ImageManager(Config::get('image'));
        $content = $manager->cache(function ($image) use ($filter, $filename) {

            $height = null;
            if (strpos($filter, '/') !== false) {
                list($width, $height) = explode('/', $filter);
            } else {
                $width = $filter;
            }
            $image->make(Storage::get($filename))
                /*->resize($width, $height, function ($constraint) use ($height) {
                    if (is_null($height)) {
                        $constraint->aspectRatio();
                    }
                })*/
                ->fit($width, (int)$width + 30)
                ->text($width, 50, 10, function ($font) {
                    $font->file(5);
                    $font->size(60);
                    $font->color('#fdf6e3');
                    $font->align('center');
                    $font->valign('top');
                });

        }, config('cache.image.lifetime'));

        return $this->buildResponse($content);
    }

    /**
     * Get HTTP response of original image file
     *
     * @param  string $filename
     * @return IlluminateResponse
     */
    public function getOriginal($filename)
    {
        return $this->buildResponse(Storage::get($filename));
    }

    /**
     * Get HTTP response of original image as download
     *
     * @param  string $filename
     * @return IlluminateResponse
     */
    public function getDownload($filename)
    {
        $response = $this->getOriginal($filename);

        return $response->header(
            'Content-Disposition',
            'attachment; filename=' . $filename
        );
    }

    /**
     * Builds HTTP response from given image data
     *
     * @param  string $content
     * @return IlluminateResponse
     */
    private function buildResponse($content)
    {
        // define mime type
        $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $content);

        // return http response
        return new IlluminateResponse($content, 200, array(
            'Content-Type' => $mime,
            'Cache-Control' => 'max-age=' . (config('cache.image.lifetime') * 60) . ', public',
            'Etag' => md5($content)
        ));
    }
}