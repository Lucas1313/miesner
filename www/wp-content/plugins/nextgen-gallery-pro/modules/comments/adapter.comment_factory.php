<?php

class A_Comment_Factory extends Mixin
{
    function comment_container($mapper=FALSE, $properties=array(), $context=FALSE)
    {
        return new C_Comment_Container($mapper, $properties, $context);
    }
}