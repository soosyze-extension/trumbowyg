<?php

namespace SoosyzeExtension\Trumbowyg\Services;

class Trumbowyg
{
    /**
     * @var \Soosyze\App
     */
    protected $core;

    public function __construct($core, $router)
    {
        $this->core   = $core;
        $this->router = $router;
    }

    public function getEditor($request, &$response)
    {
        $vendor = $this->router->getBasePath() . $this->core->getSetting('modules_contributed') . 'Trumbowyg/vendor/';
        $script = $response->getBlock('this')->getVar('scripts');
        $style  = $response->getBlock('this')->getVar('styles');
        $script .= '<script src="' . $vendor . 'dist/trumbowyg.min.js"></script>
                <script type="text/javascript" src="' . $vendor . 'dist/langs/fr.min.js"></script>
                        <script src="' . $vendor . 'dist/plugins/upload/trumbowyg.upload.min.js"></script>
                        <script src="' . $vendor . 'dist/plugins/noembed/trumbowyg.noembed.min.js"></script>
                        <script src="' . $vendor . 'dist/plugins/preformatted/trumbowyg.preformatted.min.js"></script>
			<script>
                        $(function(){
                            $.trumbowyg.svgPath = "' . $vendor . 'dist/icons.svg";
                            $("textarea").trumbowyg({
                            lang: "fr",
                            btnsDef: {
                                // Create a new dropdown
                                image: {
                                    dropdown: ["insertImage", "upload", "noembed"],
                                    ico: "insertImage"
                                }
                            },
                            // Redefine the button pane
                            btns: [
                                ["viewHTML"],
                                ["undo", "redo"], // Only supported in Blink browsers
                                ["formatting"],
                                ["preformatted"],
                                ["strong", "em", "del"],
                                ["superscript", "subscript"],
                                ["link"],
                                ["image"],
                                ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                                ["unorderedList", "orderedList"],
                                ["horizontalRule"],
                                ["removeformat"],
                                ["fullscreen"]
                            ],
                            plugins: {
                                // Add imagur parameters to upload plugin for demo purposes
                                upload: {
                                    serverPath: "' . $this->router->getRoute('trumbowyg.upload') . '",
                                    fileFieldName: "image",
                                    urlPropertyName: "link"
                                }
                            }
                        });
                    }); 
                    </script>';
        $style  = '<link rel="stylesheet" href="' . $vendor . 'dist/ui/trumbowyg.css">
                        <style>
                        .trumbowyg-editor[contenteditable=true]:empty::before{
                            content: attr(placeholder);
                            color: #999;
                        }
                        </style>';
        $response->view('this', [
            'scripts' => $script,
            'styles'  => $style
        ]);
    }
}
