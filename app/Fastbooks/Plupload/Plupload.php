<?php
namespace App\Fastbooks\Plupload;

Class Plupload {

    protected $pickerID = 'pickfiles';
    protected $uploadButtonID = 'uploadfiles';
    protected $filelist = 'filelist';
    protected $container = 'container';

    protected $maxSize = '10mb';
    protected $mimeTypes = '';
    protected $autoStart = true;
    protected $url = '';
    protected $flashUrl = "/assets/plugins/plupload/js/Moxie.swf";
    protected $silverlightUrl = "/assets/plugins/plupload/js/Moxie.xap";

    protected $successCallback;


    function button($button)
    {
        $this->pickerID = $button;

        return $this;
    }

    function url($url)
    {
        $this->url = $url;

        return $this;
    }

    function autoStart($start = true)
    {
        $this->autoStart = $start;

        return $this;
    }

    function mimeTypes($type)
    {
        $mime = '';
        if (is_array($type)) {
            foreach ($type as $t) {
                $mime .= $this->getMimeType($t);
            }
        } else {
            $mime .= $this->getMimeType($type);
        }

        $this->mimeTypes = $mime;

        return $this;
    }


    function getMimeType($type)
    {
        $mimes = [
            'image' => "{title : 'Image files', extensions : 'jpg,gif,png'}",
            'zip'   => "{title : 'Zip files', extensions : 'zip'}",
            'doc'   => "{title : 'Doc files', extensions : 'doc, docx, exl, exlsx, pdf, ppt, pptx'}"
        ];

        return isset($mimes[$type]) ? $mimes[$type] : die('File Type not supported at the moment');
    }

    function maxSize($size)
    {
        $this->maxSize = $size;

        return $this;
    }

    function success($callback)
    {
        $this->successCallback = $callback;

        return $this;
    }


    function init()
    {
        $html = "var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',

            browse_button : '$this->pickerID', // you can pass in id...
            container: document.getElementById('$this->container'), // ... or DOM Element itself

            url : '$this->url',

            filters : {
                    max_file_size : '$this->maxSize',
                mime_types: [
                   $this->mimeTypes
                ]
            },

            // Flash settings
            flash_swf_url : '$this->flashUrl',

            // Silverlight settings
            silverlight_xap_url : '$this->silverlightUrl',


            init: {
                    PostInit: function() {
                        document.getElementById('$this->filelist').innerHTML = '';";

        if (!$this->autoStart):
            $html .= "document.getElementById('$this->uploadButtonID').onclick = function() {
                            uploader.start();
                            return false;
                        };";
        endif;
        $html .= "},

                    FilesAdded: function(up, files) {
                        plupload.each(files, function(file) {
                            document.getElementById('$this->filelist').innerHTML += '<div id=\"' + file.id + '\">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        });";

        if ($this->autoStart):
            $html .= "setTimeout(function () { up.start(); }, 100);";
        endif;

        $html .= "},

                    UploadProgress: function(up, file) {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + '%</span>';
                    },

                    Error: function(up, err) {
                        document.getElementById('console').innerHTML += 'Error #' + err.code + ': ' + err.message;
                    }
                }
            });

            uploader.init();

             $(document).on('shown.bs.modal', '#compose-modal', function (event) {
                uploader.refresh();
             });

             uploader.bind('FileUploaded', function(upldr, file, object) {";

        $html .= $this->successCallback;

        $html .= "});

            ";

        echo $html;
    }


    function buttons($pickerName, $uploaderName = 'Upload')
    {
        $buttons = '<div id="container">
                <a id="' . $this->pickerID . '" href="javascript:;" class="btn btn-success btn-file">
                  ' . $pickerName . '
                </a>';
        if (!$this->autoStart) {
            $buttons .= '<a id="' . $this->uploadButtonID . '" href="javascript:;" class="btn btn-primary btn-file">
                  ' . $uploaderName . '
                </a>
            </div>';
        }
        return $buttons;
    }


    function render()
    {
        $render = "<div id='$this->filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>";

        $render .= "<pre id='console'></pre>";

        return $render;
    }

}