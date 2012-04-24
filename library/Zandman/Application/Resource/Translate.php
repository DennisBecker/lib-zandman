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
 * Extends Zend_Application_Resource_Translate to allow loading translate data
 * from a database. This application resource tries to preload
 * Zend_Application_Resource_Db or Zend_Application_Resource_Multidb 
 *
 * To use this adapter you have to do create a database model which implements
 * Zandman_Translate_Database_ModelInterface and return the array as described in
 * the PHP DocBlock.
 *
 * @package    Zandman_Application_Resource
 * @author     Dennis Becker
 * @copyright  2012 Dennis Becker
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/DennisBecker/lib-zandman
 */
class Zandman_Application_Resource_Translate extends Zend_Application_Resource_Translate
{
    public function getTranslate()
    {
        $options = $this->getOptions();
        
        if ($options["adapter"] == "Zandman_Translate_Adapter_Database") {
            $bootstrap = $this->getBootstrap();
            $dbResource = null;
            
            try {
            	$bootstrap->bootstrap('Db');
            } catch (Zend_Application_Bootstrap_Exception $e) {
            	$bootstrap->bootstrap('Multidb');
            }
            
            if (isset($options["dbAdapter"])) {
            	$dbResource = $bootstrap->getPluginResource('Multidb');
            	$options["dbAdapter"] = $dbResource->getDb($options["dbAdapter"]);
            } else {
                $options["dbAdapter"] = Zend_Db_Table::getDefaultAdapter();
            }
            
            $this->setOptions($options);
        }
        
        return parent::getTranslate();
    }
}