<?php

namespace App\Traits;

trait UploadFileTrait
{
    public function upload($file, $folder = null)
    {
        if (!$file || !$file->isValid()) {
            return;
        }

        $file_name = md5($file->getClientOriginalName().microtime()).'.'.$file->getClientOriginalExtension();

        return $file->storeAs($folder, $file_name, 'public');
    }
}