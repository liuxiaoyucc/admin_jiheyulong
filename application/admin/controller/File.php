<?php


namespace app\admin\controller;

use app\extra\ExtraUpload;

class File extends Basic
{
    public function upload()
    {
        $extraUpload = new ExtraUpload();
        $file = $extraUpload->uploadDetail('file');

        return ['code'=> 0, 'message'=> 'ok', 'data'=> $file];
    }

    public function edit_upload(ExtraUpload $extraUpload)
    {
        $file = $extraUpload->uploadDetail('file');
        return [
            'code'=> 0,
            'msg'=> '',
            'data'=> [
                'src'=> $file['fullPath'],
                'title'=> $file['name']
            ]
        ];
    }
}