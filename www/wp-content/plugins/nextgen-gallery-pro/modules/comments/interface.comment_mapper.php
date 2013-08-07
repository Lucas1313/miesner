<?php

interface I_Comment_Mapper
{
    function find_by_post_title($name, $model = FALSE);
}
