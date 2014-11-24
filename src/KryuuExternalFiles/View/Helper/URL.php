<?php

namespace KryuuExternalFiles\View\Helper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use Zend\View\Helper\AbstractHelper;
use KryuuExternalFiles\Entity\File;

class URL extends AbstractHelper
{
    
    
    protected $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',


        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    public function __construct($serviceLocator) 
    {
        $this->entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $tmpConfig = $serviceLocator->get('config');
        $this->rootFilePath = $tmpConfig['KryuuExternalFiles']['rootFilePath'];
        $this->isActive = $tmpConfig['KryuuExternalFiles']['active'];
        $this->router = $serviceLocator->get('ViewHelperManager')->get('url');
        
        if ($this->rootFilePath == '')
        {
            $this->rootFilePath = './';
        }
        if ($this->isActive == '')
        {
            $this->isActive = TRUE;
        }
    }
    
    public function __invoke($filepath)
    {
        if ($this->isActive == TRUE)
        {
            $file = $this->entityManager->getRepository('KryuuExternalFiles\Entity\File')->findOneBy(array('path'=>$filepath,'theme'=>__THEME__));
            if (!$file)
            {

                $fullFilePath = $this->rootFilePath . $filepath;
                $ext = pathinfo($fullFilePath, PATHINFO_EXTENSION);
                $file = new File();
                $file->__set('path', $filepath);
                $file->__set('size', filesize($fullFilePath));
                $file->__set('name', basename($fullFilePath));
                $file->__set('mimetype', $this->mime_types[$ext]);
                $file->__set('theme', __THEME__);
                $this->entityManager->persist($file);
                $this->entityManager->flush();
                $file = $this->entityManager->getRepository('KryuuExternalFiles\Entity\File')->findOneBy(array('path'=>$filepath,'theme'=>__THEME__));
            }
            return $this->router->__invoke('KryuuExternalFiles/file',array('id' => $file->id));
        }
        else
        {
            return $filepath;
        }
    }

}
