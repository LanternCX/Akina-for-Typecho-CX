<?php $this->need('header.php'); ?>
<!-- 文章部分 -->
<div class="blank"></div>
<div class="headertop"></div>
<style type="text/css">.site-content {padding-top:0px !important}</style>
<?php if($this->hidden): ?>
<!-- 判断文章是否加密 -->
<div id="content" class="site-content">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<article class="hentry">
		<!-- 加密文章输出 -->
		<div class="entry-content">
		<?php $this->content(); ?>
		</div>
<?php else: ?>
<!-- 不是加密文章 -->
<?php 
    $bgImgUrl = '';
    if ( $this->fields->radioPostImg != 'none' && $this->fields->radioPostImg != null ) {
        switch ( $this->fields->radioPostImg ) {
        case 'custom':
            $bgImgUrl = $this->fields->thumbnail;
            break;
        case 'random':
            $bgImgUrl = theurl.'images/postbg/'.mt_rand(1,3).'.jpg';
            break;
        }
        echo('
            <div class="pattern-center">
                <div class="pattern-attachment-img" style="background-image: url('.$bgImgUrl.')"></div>
                    <header class="pattern-header">
                <h1 class="entry-title">'.$this->title.'</h1>
            </header>
            </div>
        ');
    }
?>
<!-- 透明导航栏后调整间距 -->
<?php if (strlen($bgImgUrl) <= 4 && !empty($this->options->menu) && in_array('transparent', $this->options->menu) ): ?>
<style>
  .site-main {
    padding: 160px 0 0;
  }
  @media (max-width: 860px){
    .site-main {
    padding: 80px 0 0;
  }
  }
</style>
<?php endif ?>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<div id="content" class="site-content">
<?php
    // 文章目录展示以及切换
    if ( $this->options->postDoc != 'none' && $this->options->postDoc != null ) {
        getCatalog();
        if ($this->options->postDoc == 'rightDoc') {
            echo('<style>#toc-container {right: -260px;}</style>');
        } else {
            echo('<style>#toc-container {left: -260px;}</style>');
        }
    }
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<article class="hentry">
		<!-- 文章头部 -->
		<header class="entry-header">
		<!-- 标题输出 -->
		<h1 class="entry-title"><?php $this->title() ?></h1>
		<hr>
		<div class="breadcrumbs">	
			<div itemscope itemtype="http://schema.org/WebPage" id="crumbs">最后更新时间：<?php echo date('Y年m月d日' , $this->modified);?></div>
		</div>	
		</header>
		<!-- 正文输出 -->
		<div class="entry-content">
		<?php
		    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
		    $replacement = '<a href="$1" alt="'.$this->title.'" title="点击放大图片"><img class="aligncenter" src="$1" title="'.$this->title.'"></a>';
		    echo preg_replace($pattern, $replacement, $this->content);
		?>
		</div>
		<!-- 广告展示 -->
		<?php
			if ($this->options->adPostImg){
				echo '<a href="'.$this->options->adPostkLink.'" target="_blank" rel="nofollow noopener noreferrer">
						<img style=" width: 100%; border-radius: 5px; margin: 10px 0;" src="'.$this->options->adPostImg.'">
					  </a>';
			}
		?>
		<!-- 文章底部 -->
		<footer class="post-footer">
			<!-- 阅读次数 -->
			<div class="post-like">
				<a href="javascript:;" data-action="ding" data-id="58" class="specsZan ">
					<i class="iconfont">&#xe612;</i>
					<span class="count"><?php echo Postviews($this)>=10000 ? round(Postviews($this)/10000,1) .'万' : Postviews($this);?></span>
				</a>
			</div>
			<!-- 分享按钮 -->
			<div class="post-share">
				<ul class="sharehidden">
					<li><a href="https://api.pwmqr.com/qrcode/create/?url=<?php $this->permalink(); ?>" onclick="window.open(this.href, 'renren-share', 'width=490,height=700');return false;" class="s-weixin"><img src="<?php echo theurl; ?>images/wechat.png"/></a></li>
					<li><a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php $this->permalink(); ?>&title=<?php $this->title() ?>" onclick="window.open(this.href, 'weibo-share', 'width=730,height=500');return false;" class="s-qq"><img src="<?php echo theurl; ?>images/qzone.png"/></a></li>
					<li><a href="http://service.weibo.com/share/share.php?url=<?php $this->permalink(); ?>&title=<?php $this->title() ?>" onclick="window.open(this.href, 'weibo-share', 'width=550,height=235');return false;" class="s-sina"><img src="<?php echo theurl; ?>images/sina.png"/></a></li>
				</ul>
				<i class="iconfont show-share">&#xe60c;</i>
			</div>
			<!-- 赞助按钮 -->
			<div class="donate">
			<a>赏</a>
				<ul class="donate_inner">
					<li class="wedonate"><img src="<?php echo authorProfile($this->options->wedo,theurl);?>"></li>
					<li class="alidonate"><img src="<?php echo authorProfile($this->options->alido,theurl);?>"></li>
				</ul>
			</div>
			<!-- 文章标签 -->
			<div class="post-tags">
				<i class="iconfont">&#xe602;</i>
				<?php if(  count($this->tags) == 0 ): ?>
					<?php $this->category('、', true, 'none'); ?>
				<?php else: ?>
					<?php $this->tags('、', true, 'none'); ?>
				<?php endif; ?>
			</div>
		</footer>
		</article>
		<!-- 版权声明 -->
		<div class="open-message">
			<p>声明：<?php $this->options->title() ?>|版权所有，违者必究|如未注明，均为原创|本网站采用<a href="https://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank">BY-NC-SA</a>协议进行授权</p>
			<p>转载：转载请注明原文链接 - <a href="<?php $this->permalink(); ?>"><?php $this->title() ?></a></p>	
		</div>
		<!-- 相邻文章 -->
		<section class="post-squares nextprev">
			<?php theNextPrev($this); ?>
		</section>
<?php endif; ?>
<!-- 判断文章加密结束 -->
		<!-- 个人信息 -->
		<section class="author-profile">
			<div class="info" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
				<div class="pf-gavtar">
					<div class="pf-tou" >
						<a><img src="<?php echo theprofile ?>"></a>
					</div>
				</div>
				<div class="meta">
					<span class="title">Author</span>
					<h3 itemprop="name">
						<a href="/" itemprop="url" rel="author"><?php $this->author(); ?></a>
					</h3>
				</div>
			</div>
			<hr>
            <p>
                <i class="iconfont">&#xe61a;</i>
                <span id="typewriter">
                    <script>
                        try{
                            const app = document.getElementById('typewriter');

                            const typewriter = new Typewriter(app, {
                                loop: true
                            });

                            const descStr = "<?php echo $this->options->headerinfo() ?>"
                            const descStrList = descStr.split(";")
                            descStrList.forEach( str => {
                                typewriter.typeString(str)
                                    .pauseFor(2500)
                                    .deleteAll()
                            })
                            typewriter.start()
                        }catch(e){
                            console.log(e)
                        }
                    </script>
                </span>
            </p>
		</section>
		</main>
	</div>
</div>
<?php if($this->hidden): ?>
<?php else: ?>
<!--评论输出地方-->
<?php $this->need('comments.php'); ?>
<?php endif; ?>
</div>
</section>
<?php $this->need('footer.php'); ?>
