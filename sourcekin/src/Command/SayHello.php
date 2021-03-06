<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin\Command;


class SayHello {

    protected $name;

    /**
     * SayHello constructor.
     *
     * @param $name
     */
    public function __construct($name) { $this->name = $name; }

    public function name()
    {
        return $this->name;
    }

}