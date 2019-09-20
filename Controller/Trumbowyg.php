<?php

namespace SoosyzeExtension\Trumbowyg\Controller;

use Soosyze\Components\Validator\Validator;

class Trumbowyg extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathServices = dirname(__DIR__) . '/Config/service.json';
        $this->pathRoutes   = dirname(__DIR__) . '/Config/routing.json';
    }

    public function pluginUpload($req)
    {
        $server = $req->getServerParams();

        if (!empty($server[ 'HTTP_X_REQUESTED_WITH' ]) && strtolower($server[ 'HTTP_X_REQUESTED_WITH' ]) != 'xmlhttprequest') {
            $post = $req->getParsedBody();

            return $this->json(405, [
                    'message'  => 'uploadNotAjax',
                    'formData' => $post
            ]);
        }

        $files = $req->getUploadedFiles();

        $validator = (new Validator)
            ->setRules([
                'image' => 'image|max:200Kb',
            ])
            ->setInputs($files);

        if ($validator->isValid()) {
            $image = $validator->getInput('image');
            $path  = self::core()->getSetting('files_public', 'app/files/public');
            $link  = self::file()->cleanPathAndMoveTo($path, $image);

            $data = [
                'success' => true,
                'link'    => $link,
                'status'  => 200
            ];
        } else {
            $data = [
                'message' => 'uploadError',
                'status'  => 400
            ];
        }

        return $this->json($data[ 'status' ], $data);
    }
}
