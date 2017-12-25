<?php

class qa_html_theme_layer extends qa_html_theme_base
{
    public function html()
	{
        //file_put_contents('out.log', var_export($this->template, true));        
        if($this->template=='question'){
            $attribution = '<!-- Powered by Question2Answer - http://www.question2answer.org/ -->';
            $this->output(
                '<html itemscope itemtype="http://schema.org/QAPage" lang="'.$this->content['language'].'">',
                $attribution
            );
            $this->head();
            $this->body();
            $this->output(
                $attribution,
                '</html>'
            );
        }else
            qa_html_theme_base::html();
    }
    
    public function head_metas()
	{
        //file_put_contents('out.log', var_export($this->content['q_view'], true)); 
        //file_put_contents('out.log', var_export($this->content, true)); 
        
        //file_put_contents('out.log', var_export($raw, true)); 
        if($this->template=='question'){
            $q_view = $this->content['q_view'];
            $raw = $q_view['raw'];
            if (strlen(@$this->content['description']))
			    $this->output('<meta name="description" itemprop="description" content="'.$this->content['description'].'"/>');
		    if (strlen(@$this->content['keywords'])) // as far as I know, meta keywords have zero effect on search rankings or listings
                $this->output('<meta name="keywords" content="'.$this->content['keywords'].'"/>');
            if(strlen($raw['title']))
                $this->output('<meta name="og:title" itemprop="title" content="'.$raw['title'].'"/>');
            $this->output('<meta property="og:image" itemprop="image primaryImageOfPage" content="https://storage.googleapis.com/publicityport-bucket/2017/11/767f1981-question2answer-logo-350x40.png" />');
        }else
            qa_html_theme_base::head_metas();
		
    }
   
    public function body_content()
	{
        if($this->template=='question'){
            $this->body_prefix();
            $this->notices();
            $this->output('<div class="qa-body-wrapper">', '');
            $this->widgets('full', 'top');
            $this->header();
            $this->widgets('full', 'high');
            $this->sidepanel();
            $this->output('<div itemscope itemtype="http://schema.org/Question">');
            $this->output('<link itemprop="image" href="https://storage.googleapis.com/publicityport-bucket/2017/11/767f1981-question2answer-logo-350x40.png" />');
            $this->main();
            $this->output('</div>');
            $this->widgets('full', 'low');
            $this->footer();
            $this->widgets('full', 'bottom');
            $this->output('</div> <!-- END body-wrapper -->');
            $this->body_suffix();
        }else
            qa_html_theme_base::body_content();
    }
    /*
    public function q_view($q_view)
	{
        if($this->template=='question'){
            if (!empty($q_view)) {
                $raw = $q_view['raw'];
                $title = $raw['title'];
                $this->output('<div class="qa-q-view'.(@$q_view['hidden'] ? ' qa-q-view-hidden' : '').rtrim(' '.@$q_view['classes']).'"'.rtrim(' '.@$q_view['tags']).'>');
                //$this->output('<span style="display:none;" itemprop="name">');
                //file_put_contents('out.log', var_export($q_view, true));
                //$this->output($title);
                //$this->output('</span');
                if (isset($q_view['main_form_tags']))
                    $this->output('<form '.$q_view['main_form_tags'].'>'); // form for voting buttons
                $this->q_view_stats($q_view);
                if (isset($q_view['main_form_tags'])) {
                    $this->form_hidden_elements(@$q_view['voting_form_hidden']);
                    $this->output('</form>');
                }
                $this->q_view_main($q_view);
                $this->q_view_clear();
                
                $this->output('</div> <!-- END qa-q-view -->', '');
            }
        }else
            qa_html_theme_base::q_view($q_view);
	}
*/
    
}
