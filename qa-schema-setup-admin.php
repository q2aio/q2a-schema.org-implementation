<?php
/*

*/
class qa_schema_impl_admin
{
  function admin_form(&$qa_content)
  {
    $saved=false;

    if (qa_clicked('setup_schema_impl')) {
      qa_opt('disable_answer_upvote', (bool) qa_post_text('disable_answer_upvote_cb'));
      $saved=true;
    }

    return array(
      'ok' => $saved ? 'Changes saved' : null,

      'fields' => array(
        array(
          'label' => 'Do you want to disable answer upvote and downvote?',
          'type' => 'checkbox',
          'value' => (bool)qa_opt('disable_answer_upvote'),
          'tags' => 'NAME="disable_answer_upvote_cb"',
        ),
      ),

      'buttons' => array(
        array(
          'label' => 'Save Changes',
          'tags' => 'name="setup_schema_impl"',
        ),
      ),
    );
  }
}