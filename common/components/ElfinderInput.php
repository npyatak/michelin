<?php

namespace common\components;

use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;

class ElfinderInput extends InputFile {

    public $filter = 'image';    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    public $template = '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>';
    public $options = ['class' => 'form-control'];
    public $buttonOptions = ['class' => 'btn btn-default'];
    public $multiple = false;       // возможность выбора нескольких файлов
	public $buttonName = 'Обзор';
	public $path = 'images';
}