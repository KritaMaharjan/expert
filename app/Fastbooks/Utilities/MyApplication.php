<?php

namespace App\Fastbooks\Utilities;
use Illuminate\Foundation\Application;

class MyApplication extends Application {

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        echo $this->basePath.'/public_html';
    }

}
