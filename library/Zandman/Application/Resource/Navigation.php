<?php
/**
 * lib-zandman
 *
 * Copyright (c) 2012, Dennis Becker.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Dennis Becker nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Zandman_Application_Resource
 * @author     Dennis Becker
 * @copyright  2012 Dennis Becker
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/DennisBecker/lib-zandman
 */

/**
 * Extends Zend_Application_Resource_Navigation to add 'config' option which
 * includes a PHP file
 *
 * @package    Zandman_Application_Resource
 * @author     Dennis Becker
 * @copyright  2012 Dennis Becker
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/DennisBecker/lib-zandman
 */
class Zandman_Application_Resource_Navigation
    extends Zend_Application_Resource_Navigation
{
    public function init()
    {
        if (!$this->_container) {
            $options = $this->getOptions();

            if (isset($options['config'])) {
                $this->_container = new Zend_Navigation(new Zend_Config(include $options['config']));
            }
        }
        
        return parent::init();
    }
}
