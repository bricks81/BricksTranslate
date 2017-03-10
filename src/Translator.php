<?php

/**
 * Bricks Framework & Bricks CMS
 * http://bricks-cms.org
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 bricks-cms.org
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Bricks\Translate;

use Bricks\Config\ConfigInterface;
use Bricks\Config\ConfigAwareInterface;
use Zend\I18n\Translator\TextDomain;
use Zend\I18n\Translator\Translator AS ZTranslator;

class Translator extends ZTranslator implements ConfigAwareInterface {

    /**
     * @var ConfigInterface
     */
    protected $config;

    public function setBricksConfig(ConfigInterface $config){
        $this->config = $config;
    }

    public function getBricksConfig(){
        return $this->config;
    }

    public function addMessages($messages=array(),$textDomain='default',$locale='de_DE'){
        $messages = new TextDomain($messages);
        if(isset($this->messages[$textDomain][$locale])) {
            $this->messages[$textDomain][$locale]->merge($messages);
        } else {
            $this->messages[$textDomain][$locale] = $messages;
        }
    }

}