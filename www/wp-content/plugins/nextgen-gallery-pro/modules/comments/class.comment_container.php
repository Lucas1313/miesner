<?php

class C_Comment_Container extends C_DataMapper_Model
{
    function define($mapper, $properties, $context=FALSE)
    {
        parent::define($mapper, $properties, $context);
        $this->add_mixin('Mixin_Comment_Container_Validation');
        $this->add_mixin('Mixin_Wordpress_Comment_Container');
    }
}

class Mixin_Comment_Container_Validation extends Mixin
{
    function validation()
    {
        $this->object->validates_presence_of('name');
        $this->object->validates_uniqueness_of('name');
        return $this->object->is_valid();
    }
}

class Mixin_Wordpress_Comment_Container extends Mixin
{
    function get_comments_data($page = 0)
    {
        $retval = array();
        $retval['container_id'] = $this->object->{$this->object->id_field};

        ob_start();
        $args = array(
            'post_type' => 'photocrati-comments',
            'p' => $retval['container_id'],
            'cpage' => (int)$page
        );
        query_posts($args);
        while (have_posts()) {
            the_post();
            comments_template('ngg_comments');
        }
        $retval['rendered_view'] = ob_get_contents();
        wp_reset_query();
        ob_end_clean();

        return $retval;
    }
}