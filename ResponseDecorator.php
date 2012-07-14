<?php

namespace FSC\P3PBundle;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * ResponseDecorator
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ResponseDecorator
{
    protected $value;
    protected $pattern;

    public function __construct($value = null, $pattern = null)
    {
        $this->value = $value ?: 'IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT';
        $this->pattern = $pattern ?: '//';
    }

    public function decorate(Response $response, Request $request)
    {
        if ($response->headers->has('P3P')) {
            return;
        }

        if (0 === preg_match($this->pattern, $request->getPathInfo())) {
            return;
        }

        $response->headers->set('P3P', sprintf('CP="%s"', $this->value));
    }
}
