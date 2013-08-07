<?php

class A_NextGen_Pro_Masonry_Mapper extends Mixin
{
    /**
     * Adds a hook for setting default values
     */
    function initialize()
    {
        $this->object->add_post_hook('set_defaults', get_class(), get_class(), 'set_defaults');
    }

    function set_defaults($entity)
    {
        if ($entity->name == NEXTGEN_GALLERY_NEXTGEN_PRO_MASONRY)
        {
            $this->object->_set_default_value($entity, 'settings', 'size', 180);
            $this->object->_set_default_value($entity, 'settings', 'padding', 10);
        }
    }
}
