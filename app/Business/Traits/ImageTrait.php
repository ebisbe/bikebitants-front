<?php

namespace App\Business\Traits;

use App\Business\Services\WordpressService;
use Illuminate\Http\Response as IlluminateResponse;
use \Image;
use Storage;
use \File;

trait ImageTrait
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

        if (strpos($filter, '/') !== false) {
            list($width) = explode('/', $filter);
        } else {
            $width = $filter;
        }
        $wp_file = Storage::get(WordpressService::$WP_FILE . '/' . $filename);
        $image = Image::make($wp_file)
            ->fit($width, (int)$width + 30)
            ->interlace();

        if (env('APP_ENV') == 'local') {
            $image->text($width, 50, 10, function ($font) {
                $font->file(5);
                $font->size(60);
                $font->color('#fdf6e3');
                $font->align('center');
                $font->valign('top');
            });
        }

        $dir = storage_path("app/public/img/$filter/");
        File::makeDirectory($dir, 0777, true, true);

        $file_path = $dir.$filename;
        $newImage = $image->save($file_path);

        return $this->buildResponse($newImage);
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