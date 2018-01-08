<?php
/*

*/
class qa_schema_impl_admin
{
    function option_default($option) {

        switch($option) {
          case 'schema_impl_logo_url':
            return 'https://storage.googleapis.com/publicityport-bucket/2017/11/767f1981-question2answer-logo-350x40.png';
          default:
            return null;
        }
        
      }

  function admin_form(&$qa_content)
  {
    $saved=false;

    if (qa_clicked('schema_impl_save_button')) {
      qa_opt('schema_impl_logo_url', qa_post_text('schema_impl_logo_url_field'));
      $saved=true;
    }

    return array(
      'ok' => $saved ? 'Settings saved' : null,

      'fields' => array(
        array(
          'label' => 'Enter your logo url.',
          'type' => 'text',
          'value' => qa_opt('schema_impl_logo_url'),
          'tags' => 'NAME="schema_impl_logo_url_field"',
        ),
      ),

      'buttons' => array(
        array(
          'label' => 'Save Changes',
          'tags' => 'name="schema_impl_save_button"',
        ),
      ),
    );
  }
}