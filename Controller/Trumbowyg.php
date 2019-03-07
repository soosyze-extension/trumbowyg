<?php

namespace Trumbowyg\Controller;

use Soosyze\Components\Http\Response;
use Soosyze\Components\Http\Stream;
use Soosyze\Components\Validator\Validator;

define('CONFIG_TRUMBOWYG', MODULES_CONTRIBUED . 'Trumbowyg' . DS . 'Config' . DS);

class Trumbowyg extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathServices = CONFIG_TRUMBOWYG . 'service.json';
        $this->pathRoutes   = CONFIG_TRUMBOWYG . 'routing.json';
    }

    public function pluginUpload($req)
    {
        $server = $req->getServerParams();

        if (!empty($server[ 'HTTP_X_REQUESTED_WITH' ]) && strtolower($server[ 'HTTP_X_REQUESTED_WITH' ]) != 'xmlhttprequest') {
            $post = $req->getParsedBody();

            $response = new Response(405, new Stream(json_encode([
                    'message'  => 'uploadNotAjax',
                    'formData' => $post
            ])));

            return $response->withHeader('Content-Type', [ 'application/json' ]);
        }

        $files = $req->getUploadedFiles();

        $validator = (new Validator())
            ->setRules([
                'image' => 'image|max:2000000',
            ])
            ->setInputs($files);

        if ($validator->isValid()) {
            $image = $validator->getInput('image');
            $path  = self::core()->getSetting('files_public', 'app/files');
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

        $response = new Response($data[ 'status' ], new Stream(json_encode($data)));

        return $response->withHeader('Content-Type', [ 'application/json' ]);
    }
}
