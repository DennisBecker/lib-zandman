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
 * @package    Zandman_Translate
 * @subpackage Adapter
 * @author     Dennis Becker
 * @copyright  2012 Dennis Becker
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/DennisBecker/lib-zandman
 */

/**
 * Extends Zend_Translate_Adapter to allow loading translate data from a database.
 * 
 * To use this adapter you have to do create a database model which implements
 * Zandman_Translate_Database_ModelInterface and return the array as described in
 * the PHP DocBlock.
 *
 * @package    Zandman_Translate
 * @subpackage Adapter
 * @author     Dennis Becker
 * @copyright  2012 Dennis Becker
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       https://github.com/DennisBecker/lib-zandman
 */
class Zandman_Translate_Adapter_Database extends Zend_Translate_Adapter
{
    private $_data = array();
    
    /**
     * Load translation data
     *
     * @param  string|array  $data
     * @param  string        $locale  Locale/Language to add data for, identical with locale identifier,
     *                                see Zend_Locale for more information
     * @param  array         $options OPTIONAL Options to use
     * @return array
     */
    protected function _loadTranslationData($data, $locale, array $options = array())
    {
        if (!isset($options['dbAdapter'])) {
            throw new Zandman_Translate_Exception("dbAdapter not set in options");
        }
        
        if (!isset($options['dbModel'])) {
            throw new Zandman_Translate_Exception("dbModel not set in options");
        }
        
        $dbAdapter = $options['dbAdapter'];
        $dbModel = $options['dbModel'];
        
        $translationModel = new $dbModel($dbAdapter);
        
        if (!$dbModel instanceof Zandman_Translate_Database_ModelInterface) {
            throw new Zandman_Translate_Database_Exception(
                "Database model does not implement Zandman_Translate_Database_ModelInterface");
        }
        
        $data = $translationModel->getTranslations($locale);

        if (!isset($this->_data[$locale])) {
            $this->_data[$locale] = array();
        }

        $this->_data[$locale] = $data + $this->_data[$locale];
        return $this->_data;
    }

    /**
     * returns the adapters name
     *
     * @return string
     */
    public function toString() {
        return "Database";
    }
}