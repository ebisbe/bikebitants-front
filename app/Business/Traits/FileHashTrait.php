<?php

namespace App\Business\Traits;

trait FileHashTrait
{
    public function getFileHashAttribute()
    {
        return preg_replace('#\.(jpg|png|jpeg|gif)$#', '', $this->filename);
    }
}
