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
    protected $resizeHeight = '';
    protected $resizeWidth = '';
    protected $resize = false;
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
            'doc'   => "{title : 'Doc files', extensions : 'doc,docx,xls,xlsx,pdf,ppt,pptx'}",
            'file' => "{title : 'files', extensions : 'zip,jpg,gif,png,doc,docx,xls,xlsx,pdf,ppt,pptx'}",
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
            drop_element : '$this->pickerID',
            browse_button : '$this->pickerID', // you can pass in id...
            container: document.getElementById('$this->container'), // ... or DOM Element itself

            url : '$this->url',

            max_file_count : 2,

            filters : {
                max_file_size : '$this->maxSize',
                mime_types: [
                   $this->mimeTypes
                ]
            },

            // Flash settings
            flash_swf_url : '$this->flashUrl',

            // Silverlight settings
            silverlight_xap_url : '$this->silverlightUrl',";

        if($this->resize === true)
            $html .="resize: {
                width: '$this->resizeWidth',
                height: '$this->resizeHeight'
            },";


        $html .= "
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
                              var max_files = 1;
                              var files_no = up.files.length - up.total.uploaded;


                            if (files_no > max_files) {
                                  alert('You are allowed to add only ' + max_files + ' files.');

                                    plupload.each(files, function(file) {
                                          up.removeFile(file);
                                      });

                                  return;
                              }


                           plupload.each(files, function(file) {
                            document.getElementById('$this->filelist').innerHTML += '<div id=\"' + file.id + '\">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                            });";

                            if ($this->autoStart):
                            $html .= "setTimeout(function () { up.start(); }, 100);";
                            endif;

                      $html .= "},

                    UploadProgress: function(up, file) {
                        fileDiv = $('#'+file.id)
                        if(fileDiv.find('.progress').length > 0)
                        {
                            fileDiv.find('.progress-bar').css('width',file.percent+'%');
                        }
                        else
                        {
                         fileDiv.append('<div class=\"progress\" style=\"height: 2px;\"><div class=\"progress-bar\" style=\"width: 0%\"></div></div>');
                        }

                       fileDiv.find('b').html(file.percent + '%');

                    },

                    Error: function(up, err) {
                        alert(err.message);
                    }
                }
            });

            uploader.init();


              uploader.bind('Init', function(up, params) {
                if (uploader.features.dragdrop) {
                  var target =  document.getElementById('$this->pickerID');

                  target.ondragover = function(event) {
                    event.dataTransfer.dropEffect = 'copy';
                  };

                  target.ondragenter = function() {
                    this.className = 'dragover';
                  };

                  target.ondragleave = function() {
                    this.className = '';
                  };

                  target.ondrop = function() {
                    this.className = '';
                  };
                }
              });



             $(document).on('shown.bs.modal', '#compose-modal', function (event) {
                uploader.refresh();
             });

             uploader.bind('FileUploaded', function(upldr, file, object) {";




        $html .= $this->successCallback;

        $html .= "});

            ";

        return $html;
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

        //   $render .= "<pre id='console'></pre>";
        return $render;
    }

    function resize($height, $width)
    {
        $this->resizeHeight = $height;
        $this->resizeWidth = $width;
        $this->resize = true;
        return $this;
    }

}