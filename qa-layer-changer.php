<?php

class qa_html_theme_layer extends qa_html_theme_base
{
    public function html()
	{
        //file_put_contents('out.log', var_export($this->template, true),FILE_APPEND);        
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
        if($this->template=='question'){
            $q_view = $this->content['q_view'];
            $raw = $q_view['raw'];
            if (strlen(@$this->content['description']))
			    $this->output('<meta name="description" itemprop="description" content="'.$this->content['description'].'"/>');
		    if (strlen(@$this->content['keywords'])) // as far as I know, meta keywords have zero effect on search rankings or listings
                $this->output('<meta name="keywords" content="'.$this->content['keywords'].'"/>');
            if(strlen($raw['title']))
                $this->output('<meta name="og:title" itemprop="title" content="'.$raw['title'].'"/>');
            $this->output('<meta property="og:image" itemprop="image primaryImageOfPage" content="'.qa_opt('schema_impl_logo_url').'" />');
        }else
            qa_html_theme_base::head_metas();
		
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
                $q_view['tags'] = $q_view['tags']. ' itemscope itemtype="http://schema.org/Question"';
           }
        }

        qa_html_theme_base::q_view($q_view);
    }

    public function q_view_content($q_view)
	{
        if($this->template=='question'){
            $raw = $q_view['raw'];
            $this->output('<link itemprop="image" href="'.qa_opt('schema_impl_logo_url').'" />');
            $this->output('<span style="display:none;" itemprop="upvoteCount">');
            $this->output($raw['netvotes']);
            $this->output('</span>');
            $this->output('<span style="display:none;" itemprop="answerCount">');
            $this->output($raw['acount']);            
            $this->output('</span>');

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
            //file_put_contents('log.txt', print_r($a_item['tags'], true));
            if (strpos($a_item['tags'], 'schema.org') == false){
                $a_item['tags'] = $a_item['tags']. ' itemscope itemtype="http://schema.org/Answer"';
                $a_item['tags'] = $a_item['tags'] . ($a_item['selected'] ? ' itemprop="acceptedAnswer"' : '');
            }
        }
        qa_html_theme_base::a_list_item($a_item);
	}
    public function a_item_content($a_item)
	{
        if($this->template=='question'){
            $this->output('<span style="display:none;" itemprop="upvoteCount">');
            $this->output($a_item['raw']['netvotes']);
            $this->output('</span>');
            
            $this->output('<div class="qa-a-item-content" itemprop="text">');
            $this->output_raw($a_item['content']);
            $this->output('</div>');
        }else
            qa_html_theme_base::a_item_content($a_item);
	}
}
