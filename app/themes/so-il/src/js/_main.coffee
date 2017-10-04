window.raf = window.requestAnimationFrame

if jQuery.browser.mobile && not Modernizr.touch
  Modernizr.touch = true
  jQuery('html')
    .removeClass 'no-touch'
    .addClass 'touch'

main = ($) ->
  
  window.scrollTop = 0
  window.$window = $(window)
  

  SOIL =
    common:
      init: ->
        liberateBlocks() if onMobile()
        liberateExpandedProjects() if onMobile() and onHome()
        liberateProjectOverviewImages() if onMobileProject()
        addState (if onChrome() then 'on-chrome' else 'not-chrome'),
          html: true
        
        $('.content').createMedia()

        $window.scroll throttle setScrollTop()
        $window.resize resizeBackgrounds()
        $window.resize setupFormInputs()
        
        
        $(window).lazyLoadXT()

        fixActiveHeaderLink()
        watchNewsletterForm()
        watchSubsectionNavigation()
        
        showMediaShim() if onFirefox()

      desktop: ->
        $window.scroll fixStickyContainerPosition()
        if(!$('body').hasClass('project-overview'))
          $window.scroll throttle setCurrentBlock()
          $window.resize setCurrentBlock()

        watchMainNavigation()

      mobile: ->
        $("""
          .block h1,
          .block h2,
          .block h3,
          .block h4,
          .block h5,
          .block h6,
          .block article p,
          .block article p a,
          .block article p em,
          .block article blockquote,
          .block article li,
          .footnote,
          .related
        """).hyphenate('en-us')

      post: ->
        resizeBackgrounds()
        raf -> addState 'js-finished', html: true

    post_type_archive_project:
      desktop: ->
        $window.scroll throttle playVisibleVideos()
        playVisibleVideos()
        console.log('play visible videos')
      mobile: ->
        $window.on 'orientationchange', tableBlockShim()

    home:
      init: ->
        

      desktop: ->
        $window.scroll fixHomeProjectPosition
        $window.on('mousewheel', mouseWheel)
        
        
        setCurrentBlockByMouse()
        calculateExcerpts()
        bindArrowKeys()
        removeInitSlideshow()
        
        $('.block').on('click', watchProjectClicks)
        $('.block').setupBackgrounds()
        
        afterLoaded ->
          $('.prev-image').on 'click', prevImageClick
          $('.next-image').on 'click', nextImageClick
          initSlideshow()
          playVisibleHomeVideos()
        , 1000
        
      mobile: ->
  
        $('.block.writing').remove()
        $('.block-slideshow')
          .makeSlideshow
            items: '.block'
        $('.block').setupBackgrounds()

    project_overview:
      desktop: ->
        console.log('project overview')
        $window.resize setJumpCutsOverview()
        $window.scroll setCurrentFootnoteOverview()
        $window.scroll throttle playVisibleVideos()
        playVisibleVideos()
        watchImageCallout()
        scrollRelated()
        
        $('.close').on 'click', overviewClick

      mobile: ->
        $('.image').setupBackgrounds()
          .addCounters()
          .find('img').click ->
            if $('.images').hasClass('is-small') and
                not $('.images .container').hasTransitionClass()
              $contentToHide = $('.text .inner > h1, .text .inner > article, .related')
              $images = $('.images')
              $container = $images.find('.container')
              $banner = $('.banner')
              
              $contentToHide.hide()
              $images.removeClass 'is-small'
              $banner.css position: 'absolute'
              
              raf ->
                $container.css visibility: 'hidden'
                $container.slickReinit()
                resizeBackgrounds()
                raf -> $container.css visibility: ''
              
              $('.menu-images').activate()
              $('.menu-overview')
                .deactivate()
                .click (e) -> 
                  e.preventDefault()
                  $('.menu-overview').activate()
                  $('.menu-images').deactivate()
                  
                  $contentToHide.show()
                  $images.addClass 'is-small'
                  $banner.css position: ''
                  
                  raf ->
                    $container.css visibility: 'hidden'
                    $container.slickReinit()
                    resizeBackgrounds()
                    raf -> $container.css visibility: ''
        
        $('.images')
          .addClass 'is-small'
          .addClass 'should-show'
        $('.images .container')
          .makeSlideshow
            items: '.image'

    project_images:
      init: ->
        $('.block').on('click', watchProjectClicks)
        #openFirstImage()
        
      desktop: ->
        $window.scroll fixHomeProjectPosition
        $window.on('mousewheel', mouseWheel)

        setCurrentBlockByMouse()
        calculateExcerpts()
        bindArrowKeys()
        playVisibleVideos()
        
        $('.block').setupBackgrounds()
      
        #afterLoaded ->
        #    $window.mousemove setCurrentBlockByMouse
        #  , 1000
      
        afterLoaded ->
          $('.prev-image').on 'click', prevImageClick
          $('.next-image').on 'click', nextImageClick
          console.log('init slideshow')
          initSlideshow()
          playVisibleHomeVideos()
        , 1000
      
      mobile: ->
        $('.block.writing').remove()
        $('.block-slideshow')
          .makeSlideshow
            items: '.block'
        $('.block').setupBackgrounds()
      
      #raf -> addState 'showing-images', html: true

    single_writing:
      desktop: ->
        $window.resize fixWritingStickyContainerTop()

    page:
      desktop: ->
        
        figID = 0
        
        for figure in $('figure')
          figure.setAttribute('data-id', figID)
          figID++
        
        if $('body').hasClass('contact')
          setContactFormFields()
        else
          console.log('set current footnote')
          addImageClassesOnPage()
          #$window.resize setCaptions
          #$window.scroll setCurrentFootnote()
          #watchImageCallout()
          watchPageImageCallout()
      mobile: ->
        #console.log('this is mobile')
        #$('.block.writing').remove()
        #$('.page-slideshow')
        #  .makeSlideshow
        #    items: '.thumbnail'
        #$('.block').setupBackgrounds()
          
    post_type_archive:
      desktop: ->
        console.log('this is the news archive')
        console.log('set current footnote')
        #addImageClassesOnPage()
        #watchPageImageCallout()

    search:
      init: ->
        $('.menu-search').activate()
        
    contact:
      init: ->
        console.log('init')
        setContactFormFields()

  window.UTIL =
    fire: (func, funcname, args) ->
      namespace = SOIL
      funcname = if not funcname? then "init" else funcname
      if func isnt "" and namespace[func] and 
          typeof namespace[func][funcname] is "function"
        namespace[func][funcname] args 

    loadEvents: ->
      UTIL.fire "common"
      UTIL.fire "common", "desktop" if onDesktop()
      UTIL.fire "common", "mobile" if onMobile()
      for classnm in document.body.className.replace(/-/g, "_").split(/\s+/)
        UTIL.fire classnm
        UTIL.fire classnm, "desktop" if onDesktop()
        UTIL.fire classnm, "mobile" if onMobile()
      UTIL.fire "common", "post"

    load: ->
      if onDesktop() and loaderShouldShow()
        showLoader()
      else
        removeLoader()
        addState 'loaded', html: true
        UTIL.loadEvents()

  $(document).ready UTIL.load

main jQuery

# Functions:
timerInt = 0
timeoutTimerInt = 0
scrollTimeout = 0
isScrolling = false
scrollingNum = 0
jumpCuts = []
scrollTimer = 0
deltas = [null, null, null, null, null, null, null, null, null]
lock = 0

hasPeak = ->
	if (lock > 0) 
		lock-=.38; return false
	if (deltas[0] == null) 
		return false
	if (deltas[0] <  deltas[4] && deltas[1] <= deltas[4] && deltas[2] <= deltas[4] && deltas[3] <= deltas[4] && deltas[5] <= deltas[4] && deltas[6] <= deltas[4] && deltas[7] <= deltas[4] && deltas[8] <  deltas[4]
	) 
		return hasPeak
	
	return false

fire = (e) ->
  if(e.deltaY < 0)
    nextImageClick()
  else
    prevImageClick()

mouseWheel = (e) ->
  
	e.preventDefault()
	delta = 0
	
	if e.type == 'mousewheel'
		delta = e.originalEvent.wheelDeltaY * -1
	else
		delta = 40 * e.originalEvent.detail

  
	console.log('delta ' + delta)
	
	if (hasPeak()) 
    lock = 10;
    fire(e)
  else if ((deltas[8] == null || deltas[8] == 120) && Math.abs(delta) == 120)
    fire(e)
  
	deltas.shift()
	deltas.push(Math.abs(delta))
	
	return mouseWheel

setScrollTop = ->
  window.scrollTop = $window.scrollTop()
  return setScrollTop

fixStickyContainerPosition = ->
  window.$sticky or= $('.sticky-container')
  window.stickyTop or= parseInt($('.sticky-container').css('top'))
  if $sticky.length
    st = Math.max 0, $window.scrollTop()
    sl = Math.max 0, $window.scrollLeft()
    top = Math.max getLineHeight(), stickyTop - st
    left = -Math.min parseInt($('body').css('min-width')) - $window.width(), sl
    #$sticky.css top: top, marginLeft: Math.min 0, left
    return fixStickyContainerPosition
  else
    return false

fixWritingStickyContainerTop = ->
  window.stickyTop = $('article').position().top
  fixStickyContainerPosition()
  return fixWritingStickyContainerTop

fixHomeProjectPosition = ->
  sl = Math.max 0, $window.scrollLeft()
  left = -Math.min parseInt($('body').css('min-width')) - $window.width(), sl
  getBlocks().css marginLeft: Math.min 0, left
  return fixHomeProjectPosition

fixPopupImagePosition = ->
  sl = Math.max 0, $window.scrollLeft()
  left = -Math.min parseInt($('body').css('min-width')) - $window.width(), sl
  $('.popup .image, .project-images .banner').css marginLeft: Math.min 0, left
  return fixHomeProjectPosition

bindArrowKeys = ->
  
  $(document).keydown((e) ->
      e.stopPropagation()
      switch e.which
          when 37 then prevImageClick()
          when 39 then nextImageClick()
      e.preventDefault(); 
  )
  
  return bindArrowKeys

setCurrentBlock = ->
  unless $('.popup').length or onHome() or hasState 'project-images'
    $current = getBlocks().currentFromOffset()
    if $current? and !$current.isActive()
      getBlocks().setCurrent $current
      toggleWhiteStateFromBlock $current
      $('.images .image').deactivate()

  return setCurrentBlock

overviewClick = (e)->
  
  if $('body').hasClass('contents-hidden')
    e.preventDefault()
    $('body').removeClass('contents-hidden')
    $('.images').removeClass('popup')
    $('.block').removeClass('active block-init')
    $(window).off('mousewheel')
    $('.block').off('click', watchProjectClicks)
    $('body').trigger('scroll')
    $('.background-image').css('display', '')
    $('.video-positioner').css({ marginLeft:'', marginTop:'', height:'', position:'', top:'', left:'', width:'100%' })
    clearSlideshow()
    
  
  return overviewClick

nextImageClick = ->
  
  stopSlideshow()
  nextImage()
  
  return nextImageClick
  
prevImageClick = ->
  
  stopSlideshow()
  prevImage()
  
  return prevImageClick

nextImage = ->
  
  console.log('=========')
  console.log('%c[next Image]', 'color:blue')
  

  
  
  $featured = $('.image.block')
  $current = $('.image.block.active')
  
  $next = ''
  if($current.index() < $('.image.block').length - 1)
    $next = $('.image.block').eq($current.index() + 1)
  else
    $next = $('.image.block').eq(0)
  
  $featured.setCurrent $next
  
  setCaptions();
  
  return nextImage
  
prevImage = ->
  
  console.log('prev Image')
  
  $featured = $('.image.block')
  $current = $('.image.block.active')
  
  $prev = ''
  if($current.index() > 0)
    $prev = $('.image.block').eq($current.index() - 1)
  else
    $prev = $('.image.block').eq($('.image.block').length - 1)
  
  console.log($prev)
  $featured.setCurrent $prev
  
  setCaptions();
  
  return prevImage

  
initSlideshow = ->
	if(!$('body').hasClass('contents-hidden'))
  	#clearInterval(timerInt)
  	#timerInt = setInterval(nextImage, 3000)
  	#console.log('initSlideshow')
  	#setCaptions();
  
  return initSlideshow

clearSlideshow = ->
  clearInterval(timerInt)
  clearTimeout(timeoutTimerInt)
  
stopSlideshow = ->
  
  clearInterval(timerInt)
  clearTimeout(timeoutTimerInt)
  
  timeoutTimerInt = setTimeout ( ->
    timerInt = setInterval(nextImage, 6000)
  ), 12000
  
  
  return stopSlideshow

  
setCurrentBlockByMouse = (e) ->
  $featured = $('.block')
  $current = $featured.currentFromMousePosition e
  $featured.setCurrent $current
  toggleWhiteStateFromBlock $current
  
  if $current.hasClass 'excerpt_video'
    $current.showMedia()
  
  $featured.not($current).hideMedia()
  return setCurrentBlockByMouse

scrollOverview = ->

	padding = $('.banner').position().top + $('.banner').height();
	pr = Number( $('.content').css('padding-right').split('px').join('') )
	
	$('.overview-block .text').css('width', $('body').outerWidth() * .444 - pr / 2 )
	
	if( padding + $('.overview-block .text').height() < $(window).height())
	  
	  if $(window).scrollTop() > padding 
    
	    pageH = $('body')[0].scrollHeight - $window.height();
	    pageT = $(window).scrollTop()
    
	    yPos = pageT - padding
	    #yPos = -yPos
	    $('.overview-block .text').addClass('sticky').removeClass('fixed')
	    #$('.overview-block .text').css({"-webkit-transform":"translate(0px,"+yPos+"px)"});​
	  else
	    $('.overview-block .text').removeClass('sticky')
	else
		pb = Number( $('.content').css('padding-bottom').split('px').join('') )
		
		if $(window).scrollTop() > padding + $('.overview-block .text').height() - $(window).height() + (pb*2) && !$('.container').hasClass('fixed')
			$('.overview-block .text').addClass('fixed').removeClass('sticky')
		else
			$('.overview-block .text').removeClass('fixed')
    
scrollOverviewRelated = ->

	padding = $('.banner').position().top + $('.banner').height();
	pr = Number( $('.content').css('padding-right').split('px').join('') )
	ovr = Number( $('.overview-block .text .inner').css('padding-right').split('px').join('') )
	
	$('.related-right').css('width', $('body').outerWidth() * .222 - pr / 2 )
	
	if( padding + $('.related-right .inner').height() < $(window).height())
		if $(window).scrollTop() > padding
			#leftPos = $('.overview-block').width() - $('.related-right').width() + ovr / 2 + pr / 2
			leftPos = $('.content').outerWidth()  - $('.related-right').width() - 1
			
			$('.related-right').addClass('sticky').removeClass('fixed').css('left', leftPos)
		else
	    $('.related-right').removeClass('sticky').css('left', '')
	else
		pb = Number( $('.content').css('padding-bottom').split('px').join('') )
		console.log($(window).scrollTop())
		console.log(padding + $('.related-right .inner').height() - $(window).height() + pb)
		if $(window).scrollTop() > padding + $('.related-right .inner').height() - $(window).height() + (pb*2) - pb / 5
			leftPos = $('.content').outerWidth()  - $('.related-right').width() - .5
			$('.related-right').addClass('fixed').css('left', leftPos).removeClass('sticky')
		else
			$('.related-right').removeClass('fixed').css('left', '')

scrollRelated = ->

  if $('.sticky-container .related').height() + $('.sticky-container').position().top > $window.height()
    padding = ($('.content[role="document"]').outerHeight() - $('.content[role="document"]').height()) / 2;
    pageH = $('body')[0].scrollHeight - $window.height();
    pageT = $('body').scrollTop()
    
    console.log(padding)
    yPos = pageT / pageH * ($('.sticky-container .related').height() - $window.height() + padding)
    yPos = -yPos
    $('.sticky-container .related').css({"-webkit-transform":"translate(0px,"+yPos+"px)"});​

setJumpCuts = ->
  
  scrollHeight = $('body')[0].scrollHeight
  totalImages = $('.image').length
  
  $('.images').activate()
  
  i = 1
  while i <= totalImages
    jumpCuts.push( (scrollHeight / i) - $window.height() / 4 )
    i++
  
  jumpCuts.reverse()
  
  
setJumpCutsOverview = ->
  
  setCurrentFootnoteOverview()
  $('body').trigger('scroll')
  
  scrollHeight = $('body')[0].scrollHeight
  totalImages = $('.image').last().data('unique-set') + 1
  
  console.log('totalImages ' + totalImages);
  
  $('.images').activate()
  
  jumpCuts = []
  
  i = 1
  while i <= totalImages
    jumpCuts.push( (scrollHeight / i) - $window.height() / totalImages )
    i++
  
  jumpCuts.reverse()
  
  #console.log(jumpCuts)
  setJumpCutsOverview
  
  
setStickyContainers = ->
  
  setStickyContainers


setCurrentOverviewImage = ->
  $('.sticky-container').removeClass('all-visible')
  unless $('.popup').length
    raf ->
      $images = $('.image')
      $currentID = 0
      i = 0
      while i < jumpCuts.length
        
        if($('body').scrollTop() >= jumpCuts[i])
          $currentID = i
        i++
      
      if $('body').scrollTop() >= $('body')[0].scrollHeight - $window.height()
        $currentID = jumpCuts.length - 1
      else if($('body').scrollTop() <= jumpCuts[1])
        $currentID = 0
      
      #$active = $('.image[data-unque-set="'+ $currentID +'"]')
      $currentImages = $(".image[data-unique-set=#{$currentID}]")
      
      if $currentImages.hasClass('active')
        return setCurrentFootnoteOverview
      
      $images.not($currentImages).deactivate()
      
      $currentImages.each ->
        $active = $(this)
        $active.activate()
        return
      
      $images.active().showMedia()
      $images.inactive().hideMedia()
  
  setCurrentOverviewImage
  

setContentSticky = ->
  
  $('.sticky-container').addClass('all-visible')
  
  pb = Number( $('.content').css('padding-bottom').split('px').join('') )
  pr = Number( $('.content').css('padding-right').split('px').join('') )
  ovr = Number( $('.overview-block .text .inner').css('padding-right').split('px').join('') )
  
  console.log('pb ' + pr)
  
  tp = $('.overview-block .sticky-container .container').outerHeight() + $('.overview-block').position().top - $(window).height() + (pb*4) - pb*1.2
  
  if( $('.overview-block .sticky-container .container').outerHeight() <  $('.overview-block').outerHeight() )
    if($(window).scrollTop() > tp) 
  	  leftCont = $('.overview-block .text').width() + ovr*1.5
  	  $('.overview-block .sticky-container .container').addClass('fixed').css('left', leftCont)
    else
      $('.overview-block .sticky-container .container').removeClass('fixed').css('left', '')
  else
    $('.overview-block .sticky-container .container').removeClass('fixed').css('left', '')
  
  $('.overview-block .sticky-container .container').css('width', $('body').outerWidth() * .333 - ovr)
  
  console.log(tp)
  console.log($('body').scrollTop())
  
  
  
  
  setContentSticky

setCurrentFootnoteOverview = ->
  
	setContentSticky()
	scrollOverviewRelated()
	scrollOverview()
	setStickyContainers()
	
	setCurrentFootnoteOverview

setCurrentFootnote = ->
  window.$footnotes or= $($('.footnote').get().reverse())
  
  scrollRelated()
  
  unless $('.popup').length
    raf ->
      
      $images = $('.image')
      $currentID = 0
      
      i = 0
      while i < jumpCuts.length
        
        if($('body').scrollTop() >= jumpCuts[i])
          
          
          
          $currentID = i
        i++
      
      #console.log($('body').scrollTop())
      #console.log($('body')[0].scrollHeight - $window.height())
      
      if $('body').scrollTop() >= $('body')[0].scrollHeight - $window.height()
        $currentID = jumpCuts.length - 1
      else if($('body').scrollTop() <= jumpCuts[1])
        $currentID = 0
      
      $active = $('.image').eq($currentID)
      #console.log($currentID)
      $images.not($active).deactivate()
      $active.activate()
      
      $images.active().showMedia()
      $images.inactive().hideMedia()
      
      #$current = $footnotes.currentFromOffset
      #  hold: getBodyPadding() * 12

      #if $current? and $current.parents('.block').isActive()
      #  addState 'showing-footnote'
        
      #  if !$current.isActive()
      #    $footnotes.setCurrent $current

      #    $images = $current.parents('.content').find('.image')

      #    ids = $current.data('images') or []
      #    selector = ("[data-unique-id=#{id}]" for id in ids).join(', ')
      #    $active = $images.filter selector
          
      #    $images.not($active).deactivate()
      #    $active.activate()
          
      #    $images.active().showMedia()
      #    $images.inactive().hideMedia()

      #else 
      #  $footnotes.deactivate()
      #  $('.image').deactivate()
      #  removeState 'showing-footnote'

  setCurrentFootnote

fixActiveHeaderLink = ->
  $('.menu-projects').activate() if $('#menu-projects-sub-navigation').length
  $('.menu-research').activate() if $('#menu-research-sub-navigation').length
  $('.menu-info').activate() if $('#menu-information-sub-navigation').length
  $('.menu-archive').activate() if hasState 'post-type-archive-project'
  

setCaptions = ->
  
  console.log('set captions')
  
  
  $image = $('.block.active')
  $container = $('body')
  
  isWhite = $image.hasClass('white')
    
  $container.toggleClass 'white-text', isWhite
  toggleWhiteState isWhite
  
  $(".description").dotdotdot({
      ellipsis: ' [...]',
      watch: "window"
  });
  
  $('.description').off('mouseenter mouseleave', toggleCaption);
  $('.description.is-truncated').on('mouseenter', showCaption).on('mouseleave', hideCaption)
  
showCaption = (e) ->
  
  e.stopPropagation();
  
  $('.block.active .description').addClass('expanded');
  $('.block.slick-active .description').addClass('expanded');
  
  $('.block.active .description').trigger('destroy');
  $('.block.slick-active .description').trigger('destroy');
  console.log('show caption')


hideCaption = (e) ->
  
  e.stopPropagation();
  
  $('.block.active .description').removeClass('expanded');
  $('.block.slick-active .description').removeClass('expanded');
  
  console.log('hide caption')
  
  $(".description").dotdotdot({
      ellipsis: ' [...]',
      watch: "window"
  });


toggleCaption = (e) ->
  
  e.stopPropagation();
  
  $('.block.active .description').toggleClass('expanded');
  $('.block.slick-active .description').toggleClass('expanded');
  
  if $('.block.active .description').hasClass('expanded') && $('.block.active .description').hasClass('is-truncated') 
    console.log('destroy elips')
    $('.block.active .description').trigger('destroy');
   else 
    $(".description").dotdotdot({
        ellipsis: ' [...]',
        watch: "window"
    });
  
  if $('.block.slick-active .description').hasClass('expanded') && $('.block.slick-active .description').hasClass('is-truncated') 
    console.log('destroy elips')
    $('.block.slick-active .description').trigger('destroy');
   else 
    $(".description").dotdotdot({
        ellipsis: ' [...]',
        watch: "window"
    });
  
  
  stopSlideshow()

addImageClassesOnPage = ->
  
  #$('.slideshow-image').each(->
  #  console.log($(this).attr('src'));
    
  #  $(this).closest('.block').find('.background').attr('data-src', $(this).attr('src'));
    #$(this).addClass('block')
  #)
    
  $('.page-slideshow img').each(->
    $(this).addClass('thumbnail')
  )

removeInitSlideshow = ->
  setTimeout ->
      removeState 'init-slideshow'
      $('.block-slideshow').removeClass('init-slideshow')
    , 500
  

closePageSlideshow = ->
  stopSlideshow()
  removeState 'contents-hidden popup'
  $window.off('mousewheel')

watchImageCallout = ->
  $('.images .image').on 'click', (e) ->
    return if $('.popup').length
    $(this).openPopup
      fakePage: false,
      selectImage: $(e.currentTarget).index()


watchPageImageCallout = ->
  
  if $('.page-slideshow .thumbnail').length
      $('#menu-primary-navigation').append('<button class="close"><i></i></button>');
      $('.close').mouseenter -> addState 'blur-content'
      $('.close').mouseleave -> removeState 'blur-content'
      $('.close').click -> closePageSlideshow()
      
  $('.page-slideshow .thumbnail').on 'click', (e) ->
    addState 'contents-hidden init-slideshow'
    
    e.stopPropagation()
    
    figID = $(e.currentTarget).closest('figure').data('id')
    
    $('.block-slideshow .block').removeClass('active')
    $('.block-slideshow .block').eq(figID).addClass('active')
    
    setTimeout ->
        removeState 'init-slideshow'
      , 500
      
    if $('.popup').length 
      #alert('bind page mousewheel')
      $window.on('mousewheel', mouseWheel)
      return
    else
      $(this).openPopup
        fakePage: false
    addState 'popup'

watchSubsectionNavigation = ->
  $subnavigationItems = $('.subnav .active .controls a')
  $subnavigationItems.click (e) ->
    e.preventDefault()
    $control = $(this)
    index = $control.parents('.control-item').prevAll().length
    $window.scrollTop $('.subsection').eq(index).offset().top - getBodyPadding()

watchMainNavigation = ->
  $navigationItems = $('.main-nav a')
  $navigationItems.mouseenter -> addState 'blur-content'
  $navigationItems.mouseleave -> removeState 'blur-content'

watchNewsletterForm = ->
  $form = $('.newsletter-form')

  $('.show-newsletter-form').click ->
    $form.toggle()
    setupFormInputs()

  $form.find('.submit').click ->
    $form.submit()

setupFormInputs = ->
  $inputs = $('form input[type="text"]')
  $inputs.each ->
    $this = $(this)
    unless $this.parents('.input-wrapper').length
      $this.wrap '<div class="input-wrapper">'
    $wrapper = $this.parents('.input-wrapper')
    $label = $this.parent().siblings('label')
    $form = $this.parents('form')

    $wrapper.css marginLeft: $label.outerWidth()
    $this.css width: $form.width() - $label.outerWidth()

  return setupFormInputs

setContactFormFields = ->
  
  if $('#cscf').length
    console.log('form exists')
    $('#cscf_name').attr("placeholder", "Name:").show()
    $('#cscf_email').attr("placeholder", "Email:").show()
    $('#cscf_message').attr("placeholder", "Message:").show()
    $('#cscf_SubmitButton').attr('value', "Submit").show()
  
  return setContactFormFields

resizeBackgrounds = ->
  
  backgrounds = $('.popup .video-positioner')
    .add('.home .excerpt_video .video-positioner')
    .add('.slideshow .video-positioner')
    .add('.touch .project-overview .video-positioner')
    .add(window.backgroundImages)

  raf -> eachEl resizeBackground, backgrounds

  return resizeBackgrounds

eachEl = (fn, els) ->
  $.each els, (i, el) -> fn el

resizeBackground = (background, options = {}) ->
  $background = $(background)

  ratio = $background.data 'ratio'
  fullBleed = if onMobileProject() and $('.is-small').length
    false
  else
    $background.data 'full-bleed'
  padding = $background.largeImagePadding()

  if onDesktop()
    ww = Math.max getWindowWidth(), 1120
    wh = getWindowHeight()
  else
    parentSelector = if hasState 'project-images'
      '.image'
    else if onMobileProject()
      '.image'
    else
      '.block'
    $parent = $background.parents parentSelector
    ww = $parent.outerWidth()
    wh = $parent.outerHeight()

  if fullBleed
    width = ww
    height = width / ratio

    if height < wh
      height = wh
      width = height * ratio
  else
    maxHeight = wh - padding.y * 2
    maxWidth = ww - padding.x * 2

    width = maxWidth
    height = width / ratio

    if height > maxHeight
      height = maxHeight
      width = height * ratio

  $background.css
    position: 'absolute'
    top: '50%'
    left: '50%'
    marginLeft: -width / 2
    marginTop: -height / 2
    height: height
    width: width

  if onMobile() and not fullBleed
    $caption = $(this).backgroundCaption()
    
    $caption.css
      position: 'absolute'
      top: '50%'
      bottom: 'auto'
      marginTop: height / 2 + getLineHeight() / 2
      textAlign: 'center'

$.fn.largeImagePadding = ->
  if onMobileProject() and $('.is-small').length
    x: getBodyPadding()
    y: 0
  else if onMobile()
    multiplier = if isVertical()
      if onSmallScreen() then 4.5 else 3.5
    else 2.5
    x: getBodyPadding()
    y: getBodyPadding() + getLineHeight() * multiplier
  else
    $caption = $(this).backgroundCaption()
    captionHeight = Math.max getLineHeight(), $caption.height()
    x: getBodyPadding()
    y: getBodyPadding() + getLineHeight() + captionHeight

$.fn.backgroundCaption = ->
  if onHome()
    $(this).parents('.block-inner').find('h1')
  else
    $(this).parents('.image').find('.caption')

calculateExcerpts = ->
  raf ->
    $('.block').each (i, block) ->
      $(block).calculateExcerpt()
      
      

watchProjectClicks = (e) ->
    e.stopPropagation()
    e.preventDefault()
    console.log(e.target)
    
    if onHome()
      
      if(!$(e.target).hasClass('slideshow-nav'))
        #$(this).openHref()
 
        if e.clientX > $(window).width()*.5
          nextImageClick()
        else
          prevImageClick()
    else
    
      if(!$(e.target).hasClass('slideshow-nav'))
        #$(this).openHref()
        
        if e.clientX > $(window).width()*.5
          nextImageClick()
        else
          prevImageClick()
        
    #$(this).openHref()

openFirstImage = ->
  $('.images .image').openPopup()

playVisibleHomeVideos = ->
  
  $videos = $('.video-player')
  $videos.each (i, video) ->
    $video = $(video)
    offset = $video.offset().top
    $video.play()
    #$video.sizeMedia()
  
  return playVisibleHomeVideos

playVisibleVideos = ->
  $videos = $('.video-player')
  $videos.each (i, video) ->
    $video = $(video)
    offset = $video.offset().top
    
    if offset > window.scrollTop - $video.outerHeight() and
        offset < window.scrollTop + ($window.height() * 2)
      
      $video.play()
    else
      $video.play()
  
  
  console.log('play visible videos')
  return playVisibleVideos

liberateBlocks = ->
  $table = $('table')
  $('<div class="liberated-blocks">')
    .append $table.find('.block').clone()
    .insertBefore $table

liberateExpandedProjects = ->
  $('.block.expanded').each ->
    $block = $(this)
    $block.find('.related, article').remove()
    $block.removeClass 'expanded'
    $images = $block.find('.images')
    $image = $images.find('.image:first-child')
    if $image.hasClass 'video'
      $media = $image.find('.video-player')
      $block.addClass 'excerpt_video'
    else
      $clone = $image.find('img')
      $media = $('<div class="background"></div>')
        .attr 'data-full-bleed', $clone.attr 'data-full-bleed'
        .attr 'data-ratio', $clone.attr 'data-ratio'
        .attr 'data-image', $clone.attr 'src'
      $block.addClass 'excerpt'
    $images.replaceWith $media

liberateProjectOverviewImages = ->
  $('.images').insertAfter $('.text h1').first()

hideLoader = ->
  $loader = getLoader()
  
  if $loader.hasClass 'do-blur'
    $loader.data 'hold', true
    return
    
  if $loader.is(':visible')
    addState 'loaded', html: true
    $loader.trigger 'loaded'
    $loader.stop().fadeOut 400
    
    $('.video-player.should-play').parent().showMedia()

showLoader = ->
  $loader = getLoader()
  $background = getBlocks().find('.background').first().clone()

  $loader.find('.headline')
    .mouseenter -> $loader.addClass 'do-blur'
    .mouseleave ->
      $loader.removeClass 'do-blur'
      hideLoader() if $loader.data 'hold'
  
  if $background.length
    $background.css opacity: 0
    $loader.toggleClass 'white-text',
      $background.parents('.block').hasClass 'white'
    $loader.prepend $background
    $loader.imagesLoaded ->
      $background.fadeTo 400, 1

  setTimeout hideLoader, 4 * 1000 # 4 seconds
  $loader.click hideLoader

  raf ->
    $loader.show()
    loaderShown()
    UTIL.loadEvents()

afterLoaded = (fn, delay) ->
  if getLoader().length
    getLoader().on 'loaded', ->
      setTimeout fn, delay
  else
    fn()

loaderShouldShow = -> !!getLoader().length and not loaderHasShown()
loaderHasShown = -> $.cookie('loader_shown')?
loaderShown = -> $.cookie 'loader_shown', true

# Shims to fix dumb browser behaviour

tableBlockShim = ->
  if isHorizontal()
    $('table .block')
      .hide()
      .css width: $('table').width() / 2
      .show()
  return tableBlockShim

showMediaShim = ->
  addState 'flash-video', html: true
  
  shim = ->
    if onHome()
      $('.block.excerpt_video').active().showMedia()
      $('.block.expanded .image:visible').showMedia()
    else if hasState('post-type-archive-project')
      playVisibleVideos()
    else
      $('.image').active().showMedia()
  for offset in [1000, 2000, 4000]
    setTimeout shim, offset

# Utilities

onMobile = -> Modernizr.touch
onDesktop = -> not Modernizr.touch
onTablet = -> onMobile() and screen.width > 600
onHome = -> hasState 'home'
onChrome = -> window.chrome?
onFirefox = -> /firefox/i.test(navigator.userAgent)

isHorizontal = -> !!(window.orientation % 180)
isVertical = -> !isHorizontal()

onSmallScreen = -> screen.availWidth < 400

onMobileProject = ->
  onMobile() and hasState 'project-overview'

throttle = (fn, threshhold = 100, scope) ->
  last = undefined
  deferTimer = undefined
  ->
    context = scope or this
    now = +new Date
    args = arguments
    if last and now < last + threshhold
      clearTimeout deferTimer
      deferTimer = setTimeout(->
        last = now
        raf fn.bind context
      , threshhold)
    else
      last = now
      raf fn.bind context

getLineHeight = ->
  parseInt getBody().css 'line-height'

getBodyPadding = ->
  window.$bodyPadding ||= $('#body-padding')
  parseInt window.$bodyPadding.css 'height'

getWindowWidth = ->
  if onMobile()
    if isVertical() then screen.availWidth else screen.availHeight
  else
    $window.width()

getWindowHeight = ->
  if onMobile()
    if isVertical() then screen.availHeight else screen.availWidth
  else
    $window.height()

getBlocks = ->
  window.$blocks = $($('.block').get().reverse())
  window.$blocks

getBody = ->
  window.$body or= $('body')
  window.$body

getHTML = ->
  window.$_html or= $('html')
  window.$_html

getLoader = ->
  window.$_loader or= $('#loader')
  window.$_loader

removeLoader = ->
  getLoader().remove()
  delete window.$_loader

hasState = (state, options = {}) ->
  getStateSubject(options).hasClass state

toggleState = (state, condition, options = {}) ->
  getStateSubject(options).toggleClass state, condition

addState = (state, options = {}) ->
  getStateSubject(options).addClass state

removeState = (state, options = {}) ->
  getStateSubject(options).removeClass state

toggleWhiteState = (condition) ->
  toggleState 'white-text', condition

toggleWhiteStateFromBlock = (block) ->
  toggleWhiteState block.hasClass 'white'

getStateSubject = (options = {}) ->
  if options.html then getHTML() else getBody()

$.fn.activate   = -> $(this).addClass 'active'
$.fn.deactivate = -> $(this).removeClass 'active'
$.fn.isActive   = -> $(this).hasClass 'active'
$.fn.active     = -> $(this).filter '.active'
$.fn.inactive   = -> $(this).not '.active'

$.fn.createMedia = ->
  $(this).eachVideo createVideo

$.fn.showMedia = ->  
  $this = $(this)
  $videos = $this.find('.video-player')
  
  $videos.each (i, video) ->
    $video = $(video)
    $video.sizeMedia()
    
    # Not sure why these parens for hasState are necesary...
    if onHome() and not hasState('loaded', html: true)
      $video.addClass 'should-play'
    else
      $video.play()

  $this

$.fn.sizeMedia = ->
  $this = $(this)
  $positioner = $this.find('.video-positioner')
  
  ratio = $positioner.data('ratio')
  largeImageArea = $this.parents('.popup').length or
    $this.parents('.slideshow').length or
    onMobileProject() or
    (onHome() and $this.parents('.excerpt_video').length)

  $this.toggleClass 'inline-video', not largeImageArea
   
  bgImage = $positioner.data('poster') 
   
  if largeImageArea
    $positioner.css
      paddingTop: ''
  else
    $positioner.css
      paddingTop: "#{100 / ratio}%"
      width: '100%'
      height: 0
      position: ''
      height: ''
      margin: ''
      top: ''
      left: ''
      backgroundImage: 'url("' + bgImage + '")'
  

$.fn.hideMedia = ->
  $this = $(this)
  
  $videos = $this.find '.video-player'
  $videos.each (i, video) ->
    $(video).pause()
  
  $this

$.fn.eachVideo = (fn) ->
  $this = $(this)
  fn(v) for v in $this.find('.video-player').get()
  $this

# Yeah, play and pause are screwy, but this is how Firefox wants it :\
$.fn.play = ->
  $video = $(this)
  video = $video.data 'videojs'
  sound = $video.data 'play-sound'

  if video?.hasLoaded
    try
      video.ready ->
        if this.techName is 'Flash'
          if not $video.hasClass 'is-loaded'
            video.one 'loadeddata', ->
              setTimeout (-> raf -> $video.addClass 'is-loaded'), 50
          this.muted not sound
        this.play()
    catch error

$.fn.pause = ->
  video = $(this).data 'videojs'
  if video?.hasLoaded
    video.ready -> this.pause()

createVideo = (el) ->
  return unless videojs?

  $player = $(el)
  video = $player.data 'videojs'

  unless video?
    video = videojs $player.find('video').get(0)
    video.volume if $player.data 'play-sound' then 1 else 0
    video.controls false

    if onMobile()
      video.height 1
      video.width 1
    else
      video.height "100%"
      video.width "100%"

    video.ready -> this.hasLoaded = true

    $(video.el()).addClass 'vjs-player'

    $button = $player.find '.play-button'
    $button.on 'click', (e) ->
      e.stopPropagation()
      e.preventDefault()
      
      if video.hasLoaded
        video.play()
        video.requestFullscreen()

    $player.sizeMedia()
    $player.data 'videojs', video

  return video

$.fn.backgroundFrom = ($background) ->
  window.backgroundImages or= []
  $this = $(this)
  
  imageURL = $background.data('image') or $background.attr('src')

  return if $this.find('img').length

  image = $ '<img>', src: imageURL, class: 'background-image'
  image.attr 'data-ratio', $background.data('ratio')
  image.attr 'data-full-bleed', $background.data('full-bleed')
  image.css display: 'block'
  image.appendTo $this

  backgroundImages.push image
  $background.css display: ''
  resizeBackground image
  $this

$.fn.setupBackgrounds = ->
  $(this).each (i, image) ->
    $background = $(image).find('.background')
    $background.backgroundFrom $background

$.fn.currentFromOffset = (options = {}) ->
  $current = null
  $collection = $(this)
  hold = options.hold or= 0

  $collection.each (i, block) ->
    $block = $(block)
    top = $block.offset().top
    scrollOffset = getBodyPadding()

    if hold > 0
      # This branch is used for footnotes for now...
      if (top <= window.scrollTop + scrollOffset and
          top + $block.height() + hold >= window.scrollTop - scrollOffset) or
          (top >= window.scrollTop and i is $collection.length - 1)
        $current = $block
        return false

    else
      # This branch is used for blocks and defaults to the first one...
      scrollOffset += $window.height() / 2 if onHome()
      if top <= window.scrollTop + scrollOffset or 
          i is $collection.length - 1
        $current = $block
        return false

  $current

$.fn.currentFromMousePosition = (e, options = {}) ->
  $featured = $(this)
  if e? and $featured.length > 1 and 
      (not onHome() or not getLoader().is(':visible'))
    x = e.pageX - $window.scrollLeft()
    moduleWidth = $window.width() / $featured.length
    $featured.eq Math.min $featured.length - 1, Math.floor x / moduleWidth
  else if options.default?
    $featured.eq options.default
  else
    $featured.first()

$.fn.setCurrent = ($current) ->
  setTimeout(->
    $('.block-init').removeClass('block-init')
  , 500)
  
  if not $current.isActive()
    $(this).not($current).deactivate().trigger 'deactivate'
    $current.activate().trigger 'activate'

transitionClass = 'is-swiping'

$.fn.hasTransitionClass = ->
  $(this).hasClass transitionClass

$.fn.addTransitionClass = ->
  $this = $(this)
  unless $this.hasClass transitionClass
    $this.addClass transitionClass

$.fn.removeTransitionClass = ->
  $(this).removeClass transitionClass

$.fn.makeSlideshow = (options = {}) ->
  $slideshow = $(this)
  
  prev = '<div data-role="none" class="previous">Previous</div>'
  next = '<div data-role="none" class="next">Next</div>'
  
  
  $('.video-positioner').each ->
    $(this).css 'background-image', 'url(' + $(this).data('poster') + ')'
    return
  
  $('.background').each ->
    $(this).css 'background-image', 'url(' + $(this).data('image') + ')'
    return
    
  if(onHome())
    $('.block.image').each ->
      $(this).css 'background-image', 'url(' + $(this).find('.background').data('image') + ')'
      return
  
  beforeChange = =>
    $(this).addTransitionClass()
  
  afterChange = ->
    $current = this.$slides.eq this.currentSlide
    toggleWhiteStateFromBlock $current unless onMobileProject()
    this.$slider.removeTransitionClass()
    setCaptions()
  
  settings =
    arrows: true
    dots: false
    infinite: false
    slide: options.items or '.image'
    prevArrow: prev,
    nextArrow: next,
    onAfterChange: afterChange
  
  $slideshow
    .slick settings
    .on 'touchmove.slick', beforeChange
    .on 'click', '.previous:not(.slick-disabled)', beforeChange
    .on 'click', '.next:not(.slick-disabled)', beforeChange
    # Fixes default JS adding inline styles
    .find('.previous, .next').css display: ''

  unless onMobileProject()
    toggleWhiteStateFromBlock $slideshow.find '.slick-active'
  
  setCaptions()
  
  
  
  $slideshow

$.fn.openPopup = (options = {}) ->
  return if $('.popup').length
  
  $('.block').off('click', watchProjectClicks)
  
  setTimeout ->
      $('.block').on('click', watchProjectClicks)
      #watchProjectClicks()
    , 500
  
  
  $images = $('.image')
  $active = $('.image').eq( options.selectImage );
  $images.not($active).deactivate()
  $images.inactive().hideMedia()
  $images.active().showMedia()

  $('.image.block-init').removeClass('block-init')
  $('.image').eq( options.selectImage ).addClass('block-init active')
  $('.background-image').css('display', 'block')

  
  $this = $(this)
  $container = $this.parents '.images'
  $images = $container.find '.image'
  
  if $('body').hasClass('page')
    $container = $this.parents '.page-slideshow'
    $images = $container.find '.thumbnail'
  
  #$images.css display: ''
  #$images.deactivate()
  $images.addCounters()
  $images.setupBackgrounds() 
  
  if onMobile()    
    $container.addClass 'slideshow'

    $images.each (i, image) ->
      $image = $(image)
      $image.activate()
      $image.showMedia()
    
    $slideshow = $container.find('.container')
    $slideshow.makeSlideshow()

    resizeBackgrounds()

  else
    
    #alert('bind mousehweel')
    $window.on('mousewheel', mouseWheel)
    bindArrowKeys()
    
    $('.block-slideshow .block').first().addClass('active');
    $('.block-slideshow .block').setupBackgrounds()
    
    
  
    #afterLoaded ->
    #    $window.mousemove setCurrentBlockByMouse
    #  , 1000
    
    initSlideshow()
  
    afterLoaded ->
      $('.prev-image').on 'click', prevImageClick
      $('.next-image').on 'click', nextImageClick
      console.log('init slideshow')
      
      playVisibleHomeVideos()
    , 1000
    
    #options.currentIndex = $images.index $this

    $container.addClass 'popup'

    #$('.footnote').deactivate()
    addState 'contents-hidden'
    
    #$images.fanImages options
  
  
  setCaptions() 

$.fn.fanImages = (options = {}) ->
  $images = $(this)
  $container = $popup = $images.parents('.images')
  
  # This fakes opening the Images page
  if hasState 'project-overview'
    scrollPosition = window.scrollTop
    
    $('.menu-images').activate()
    $('.menu-overview')
      .deactivate()
      .click (e) -> 
        e.preventDefault()
        
        $('.menu-overview').activate()
        $('.menu-images').deactivate()
        
        $popup.unbind 'mousemove'
        $popup.removeClass 'popup'
        $popup.hideMedia().show()
        #$popup.find('.counter').remove()

        $window.unbind 'scroll.popup'

        removeState 'blur-content'
        removeState 'contents-hidden'

        $('.wrap').css height: ''

        $window.scrollTop scrollPosition
        $window.trigger 'scroll'
        $window.trigger 'resize'
  
  setCurrentImage = (e) ->
    $current = $images.currentFromMousePosition e,
      default: options.currentIndex

    if !$current.isActive()
      isWhite = $current.hasClass 'white'
      $images.setCurrent $current
      
      $container.toggleClass 'white-text', isWhite
      toggleWhiteState isWhite
      
      try
        $current.showMedia()
        $images.not($current).hideMedia()
      catch error
      
      resizeBackgrounds()

    return setCurrentImage

  $window.on 'scroll.popup', fixPopupImagePosition

  setTimeout ->
      $container.on 'mousemove', setCurrentImage
    , 200

  setCurrentImage()

$.fn.addCounters = ->
  $images = $(this)
  if $images.length > 1
    $images.each (i, image) ->
      counter = "<div class=\"counter\">#{i + 1}/#{$images.length}</div>"
      $caption = $(image).find '.caption-inner'
      #$caption.prepend counter

$.fn.openHref = ->
  href = $(this).data 'href'
  window.location = href if href?

$.fn.openSelectProjects = ->
  href = $('.menu-projects a').attr('href') + '/type/selected';
  window.location = href if href?

$.fn.calculateExcerpt = ->
  $article = $(this)

  calculator = $article.data 'excerptCalculator'
  unless calculator?
    calculator = new ExcerptCalculator $article
    $article.data 'excerptCalculator', calculator

  if onMobile() or not onHome() or $article.hasClass 'active'
    calculator.render()

  $article

$.fn.slickReinit = ->
  $(this).slickSetOption '_', true, true

class ExcerptCalculator

  constructor: ($el) ->
    @block = $el
    @$article = @block.find('article').first()
    @$images = @block.find '.images .image'
    @$related = @block.find '.related_post'

    $window.on 'resize', @render.bind(@)
    @block.on 'activate', @render.bind(@)
    $window.on 'orientationchange', @render.bind(@) if onMobile()

  render: -> raf =>
    targetHeight = @getTargetHeight()
    approximateWidth = @approximateWidth()

    if @currentHeight isnt targetHeight or
        @currentWidth isnt approximateWidth

      @truncateArticle(targetHeight, approximateWidth) if @$article.length
      @truncateImages(targetHeight, approximateWidth) if @$images.length
      @truncateRelated(targetHeight, approximateWidth) if @$related.length

    @$images.filter(':visible').showMedia()
    @$images.not(':visible').hideMedia()

    @currentHeight = targetHeight
    @currentWidth = approximateWidth

  truncateArticle: (height, width) ->
    height -= @block.find('h1').outerHeight(true) if onMobile()
    height -= getLineHeight() * 2 if onDesktop() and onHome()
    @paragraphs or= @getParagraphs()
    truncated = false

    @$article.empty()

    return unless height > getLineHeight()
    
    for paragraph in @paragraphs
      p = paragraph.el.clone()
      @$article.append p

      if @$article.height() > height
        p.empty()

        for word in paragraph.words
          p.append word.clone(), ' '

          if @$article.height() > height
            truncated = true
            break

        break

    if truncated
      p.find('> span:last-child').remove()
      p.find('> span:last-child').remove()
      p.append '<span>[&hellip;]</span>' if p.find('> span').length

    @$article.html @$article.html()

  truncateImages: (height, width) ->
    height += getLineHeight() * (onMobile() ? 1 : 3)
    @$images.hide()
    for image in @$images
      $image = $(image)
      $image.show()
      if @imagesHeight() > height
        $image.hide()
        break

  imagesHeight: ->
    @$imagesContainer or= @block.find('.images')
    @$imagesContainer.height()

  truncateRelated: (height, width) ->
    height += getLineHeight() * 3
    @$related.hide()
    for related in @$related
      $related = $(related)
      $related.showMedia().show()
      if @relatedHeight() > height
        $related.hideMedia().hide()
        break

  relatedHeight: ->
    @$relatedContainer or= @block.find('.related')
    @$relatedContainer.height()

  getTargetHeight: ->
    if onMobile() and
        (@block.hasClass('writing') or @block.hasClass('expanded'))
      maxHeight = parseInt @block.css 'max-height'
      maxHeight = @block.height() unless maxHeight
      maxHeight - getLineHeight() * 2
    else
      padding = getBodyPadding() * 3 + getLineHeight() * 3 - 5
      windowHeight = $window.height()
      windowHeight - padding - (windowHeight % getLineHeight())

  getParagraphs: ->
    paragraphs = []
    @$article.find('p').each (i, p) =>
      words = @getWords(p)
      p = $(p).clone()
      paragraphs.push el: p, words: words
    paragraphs

  getWords: (p) ->
    (@makeWord(word) for word in @getText(p).split(' '))

  getText: (p) ->
    $.trim($(p).text())

  makeWord: (word) ->
    $('<span>').html word.replace /SO\u2013IL/, '<span class="wordmark">SO<span class="hyphen">&ndash;</span>IL</span>'

  approximateWidth: ->
    width = @$article.width()
    width - width % 10
