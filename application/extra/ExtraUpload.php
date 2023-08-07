<?php
namespace app\extra;

//适配移动设备图片上传
use think\Exception;
use think\facade\Request;

class ExtraUpload{

    /**
     * 默认上传配置
     * @var array
     */
    private $config = [
        'image' => [
            'validate' => [
                'size' => 10*1024*1024,
                'ext'  => 'jpg,png,gif,jpeg',
            ],
            'rootPath'      =>  './uploads/images/', //保存根路径
        ],
        'audio' => [
            'validate' => [
                'size' => 100*1024*1024,
                'ext'  => 'mp3,wav,cd,ogg,wma,asf,rm,real,ape,midi',
            ],
            'rootPath'      =>  './uploads/audios/', //保存根路径
        ],
        'video' => [
            'validate' => [
                'size' => 100*1024*1024,
                'ext'  => 'MP4,mp4,avi,rmvb,rm,mpg,mpeg,wmv,mkv,flv',
            ],
            'rootPath'      =>  './uploads/videos/', //保存根路径
        ],
        'file' => [
            'validate' => [
                'size' => 5*1024*1024,
                'ext'  => 'doc,docx,xls,xlsx,pdf,ppt,txt,rar',
            ],
            'rootPath' =>  './uploads/files/', //保存根路径
        ],
    ];
    private $domain;
    function __construct()
    {
        //获取当前域名
        $this->domain = Request::instance()->domain();
    }

    public function upload($fileName){
        if(empty($_FILES) || empty($_FILES[$fileName])){
            return '';
        }
        try{
            $file = request()->file($fileName);
            if (is_array($file)){
                $path = [];
                foreach ($file as $item){
                    $path[] =  $this->save($item);
                }
            } else {
                $path = $this->save($file);
            }
            return $path;
        } catch (\Exception $e){
            $arr = [
                'status' => 0,
                'message' => $e->getMessage(),
            ];
            header('Content-Type: application/json; charset=UTF-8');
            exit(json_encode($arr));
        }
    }
    public function uploadDetail($fileName){
        if(empty($_FILES) || empty($_FILES[$fileName])){
            return [];
        }
        try{
            $file = request()->file($fileName);
            if (is_array($file)){
                $path = [];
                foreach ($file as $item){
                    $detail = $item->getInfo();
                    $returnData['name'] = $detail['name'];
                    $returnData['type'] = $detail['type'];
                    $returnData['size'] = $detail['size'];
                    $returnData['filePath'] = $this->save($item);
                    $returnData['fullPath'] = $this->domain.$returnData['filePath'];
                    $path[] = $returnData;
                }
            } else {
                $detail = $file->getInfo();
                $returnData['name'] = $detail['name'];
                $returnData['type'] = $detail['type'];
                $returnData['size'] = $detail['size'];
                $returnData['filePath'] = $this->save($file);
                $returnData['fullPath'] = $this->domain.$returnData['filePath'];
                $path = $returnData;
            }
            return $path;
        } catch (\Exception $e){
            $arr = [
                'status' => 0,
                'message' => $e->getMessage(),
            ];
            header('Content-Type: application/json; charset=UTF-8');
            exit(json_encode($arr));
        }
    }
    private function getConfig($file){
        c_log(json_encode($file), 'file_upload');
        $name = pathinfo($file['name']);
        $end = $name['extension'];
        foreach ($this->config as $key=>$item){
            if ($item['validate']['ext'] && strpos($item['validate']['ext'], $end) !== false){
                return $this->config[$key];
            }
        }
        return null;
    }
    private function save(&$file){
        $config = $this->getConfig($file->getInfo());
        if (empty($config)){
            throw new Exception('上传文件类型不被允许！');
        }
        // 移动到框架应用根目录/uploads/ 目录下
        if ($config['validate']) {
            $file->validate($config['validate']);
            $result = $file->move($config['rootPath']);
        } else {
            $result = $file->move($config['rootPath']);
        }
        if($result){
            $path = $config['rootPath'];
            if (strstr($path,'.') !== false){
                $path = str_replace('.', '', $path);
            }
            /*
             * getSaveName返回斜杠反了, 这里替换下
             */
            return str_replace("\\","/",$path.$result->getSaveName());
        }else{
            // 上传失败获取错误信息
            throw new Exception($file->getError());
        }
    }
}