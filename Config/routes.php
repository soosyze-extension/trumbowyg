<?php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\Trumbowyg\Controller');

R::post('trumbowyg.upload', 'trumbowyg/upload', 'Trumbowyg@pluginUpload');
