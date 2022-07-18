<?php

namespace Ubuntu\Press\Fields;

use Ubuntu\Press\MarkdownParser;


class Body extends FieldContract
{
    public static function process($type, $value, $data)
    {
        return [
            $type => MarkdownParser::parse($value),
        ];
    }
}