<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace common\helpers;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

class FileDependencyHelper extends \yii\base\BaseObject
{

    /**
     * @var string 文件依赖缓存根目录
     */
    public $rootDir = '@runtime/cache/file_dependency/';

    /**
     * @var string 文件名
     */
    public $fileName;


    /**
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public function createFileIfNotExists()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if ( !file_exists(dirname($cacheDependencyFileName)) ) {
            FileHelper::createDirectory(dirname($cacheDependencyFileName));
        }
        if (!file_exists($cacheDependencyFileName)){
            if (! file_put_contents($cacheDependencyFileName, uniqid()) ){
                throw new Exception("create cache dependency file error: " . $cacheDependencyFileName);
            }
        }
        return $cacheDependencyFileName;
    }

    /**
     * 更新缓存依赖文件
     */
    public function updateFile()
    {
        $cacheDependencyFileName = $this->getDependencyFileName();
        if (file_exists($cacheDependencyFileName)) {
            file_put_contents($cacheDependencyFileName, uniqid());
        }
    }

    /**
     * 获取包含路径的文件名
     *
     * @return bool|string
     */
    protected function getDependencyFileName()
    {
        return Yii::getAlias($this->rootDir . $this->fileName);
    }
}