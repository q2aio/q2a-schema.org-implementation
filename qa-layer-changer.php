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
            $q_view = $this->content['q_view'];
            $raw = $q_view['raw'];
            $this->body_prefix();
            $this->notices();
            $this->output('<div class="qa-body-wrapper">', '');
            $this->widgets('full', 'top');
            $this->header();
            $this->widgets('full', 'high');
            $this->sidepanel();
            $this->output('<div itemscope itemtype="http://schema.org/Question">');
            $this->output('<link itemprop="image" href="https://storage.googleapis.com/publicityport-bucket/2017/11/767f1981-question2answer-logo-350x40.png" />');
            $this->output('<span style="display:none;" itemprop="upvoteCount">');
            $this->output($raw['netvotes']);
            $this->output('</span>');
            $this->output('<span style="display:none;" itemprop="answerCount">');
            $this->output($raw['acount']);            
            $this->output('</span>');
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
    
    public function q_view($q_view)
	{
        if($this->template=='question'){
            if (!empty($q_view)) {
                $raw = $q_view['raw'];
                $title = $raw['title'];
                $title = '<span itemprop="name">'.$title.'</span>';
                unset($raw['title']);
                $raw['title'] = $title;
                unset($q_view['raw']);
                $q_view['raw'] = $raw;
                $this->output('<div class="qa-q-item-stats">');
                $this->a_count($q_view);
                $this->output('</div>');
           }
        }

        qa_html_theme_base::q_view($q_view);
    }

    public function q_view_content($q_view)
	{
        if($this->template=='question'){
            $content = isset($q_view['content']) ? $q_view['content'] : '';
            $this->output('<div class="qa-q-view-content" itemprop="text">');
            $this->output_raw($content);
            $this->output('</div>');
        }
        else
         qa_html_theme_base::q_view_content($q_view);
    }

    public function a_list_item($a_item)
	{
        if($this->template=='question'){
            //file_put_contents('out.log', var_export($a_item, true),FILE_APPEND);
            $extraclass = @$a_item['classes'].($a_item['hidden'] ? ' qa-a-list-item-hidden' : ($a_item['selected'] ? ' qa-a-list-item-selected' : ''));
            $a_item['tags'] = $a_item['tags']. ' itemscope itemtype="http://schema.org/Answer"';
            $a_item['tags'] = $a_item['tags'] . ($a_item['selected'] ? ' itemprop="acceptedAnswer"' : '');
            $this->output('<div class="qa-a-list-item '.$extraclass.'" '.@$a_item['tags'].'>');
            if(!qa_opt('disable_answer_upvote')){
                if (isset($a_item['main_form_tags']))
                    $this->output('<form '.$a_item['main_form_tags'].'>'); // form for voting buttons
                $this->voting($a_item);
                if (isset($a_item['main_form_tags'])) {
                    $this->form_hidden_elements(@$a_item['voting_form_hidden']);
                    $this->output('</form>');
                }
            }
            $this->output('<span style="display:none;" itemprop="upvoteCount">');
            $this->output($a_item['raw']['netvotes']);
            $this->output('</span>');
            $this->a_item_main($a_item);
            $this->a_item_clear();
            $this->output('</div> <!-- END qa-a-list-item -->', '');
        }else
            qa_html_theme_base::a_list_item($a_item);
	}
    public function a_item_content($a_item)
	{
        if($this->template=='question'){
            $this->output('<div class="qa-a-item-content" itemprop="text">');
            $this->output_raw($a_item['content']);
            $this->output('</div>');
        }else
            qa_html_theme_base::a_item_content($a_item);
	}


}
