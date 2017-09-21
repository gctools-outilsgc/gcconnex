<?php
/**
 * Copyright 2011 Bas de Nooijer. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this listof conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are
 * those of the authors and should not be interpreted as representing official
 * policies, either expressed or implied, of the copyright holder.
 *
 * @copyright Copyright 2011 Bas de Nooijer <solarium@raspberry.nl>
 * @license http://github.com/basdenooijer/solarium/raw/master/COPYING
 * @link http://www.solarium-project.org/
 */

/**
 * @namespace
 */
namespace Solarium\QueryType\Analysis\RequestBuilder;

use Solarium\Core\Query\RequestBuilder as BaseRequestBuilder;
use Solarium\Core\Client\Request;
use Solarium\QueryType\Analysis\Query\Document as QueryDocument;
use Solarium\Core\Query\QueryInterface;

/**
 * Build a document analysis request
 */
class Document extends BaseRequestBuilder
{
    /**
     * Build request for an analysis document query
     *
     * @param  QueryInterface|QueryDocument $query
     * @return Request
     */
    public function build(QueryInterface $query)
    {
        $request = parent::build($query);
        $request->setRawData($this->getRawData($query));
        $request->setMethod(Request::METHOD_POST);

        return $request;
    }

    /**
     * Create the raw post data (xml)
     *
     * @param  QueryDocument $query
     * @return string
     */
    public function getRawData($query)
    {
        $xml = '<docs>';

        foreach ($query->getDocuments() as $doc) {
            $xml .= '<doc>';

            foreach ($doc->getFields() as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $multival) {
                        $xml .= $this->buildFieldXml($name, $multival);
                    }
                } else {
                    $xml .= $this->buildFieldXml($name, $value);
                }
            }

            $xml .= '</doc>';
        }

        $xml .= '</docs>';

        return $xml;
    }

    /**
     * Build XML for a field
     *
     * @param  string $name
     * @param  mixed  $value
     * @return string
     */
    protected function buildFieldXml($name, $value)
    {
        return '<field name="' . $name . '">' . htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8') . '</field>';
    }
}
