var interact = {
}
// ACCORDION
interact.accordion = function (options) {
    var instance = this;
    instance.Options = new interact.accordion.opt();
    function animate(obj, opt) {
        opt.obj = obj;
        switch (opt.transition) {
            case 'fade':
                if (opt.state == 'open') {
                    $(obj).next().fadeIn(opt.speed);
                    if (opt.openCallBack != '') {
                        opt.openCallBack(opt);
                    }
                }
                else {
                    $(obj).next().fadeOut(opt.speed);
                    if (opt.closeCallBack != '') {
                        opt.closeCallBack(opt);
                    }
                }
            case 'slide':
                if (opt.state == 'open') {
                    $(obj).next().slideDown(opt.speed);
                    if (opt.openCallBack != '') {
                        opt.openCallBack(opt);
                    }
                }
                else {
                    $(obj).next().slideUp(opt.speed, function () {
                        $(this).height('auto');
                    });
                    if (opt.closeCallBack != '') {
                        opt.closeCallBack(opt);
                    }
                }
                break;
        }
    };
    function init() {
        switch (instance.Options.start) {
            case 'closed':
                $(instance.Options.selector).each(function () {
                    if (!$(this).hasClass('open')) {
                        // explicitly set the height on the element to allow the calculation below to work (as element is hidden)
                        $(this).next().height($(this).next().height());
                        $(this).next().hide();
                    }
                });
                break;
            case 'open':
                $(instance.Options.selector).addClass('open');
        }
        $(instance.Options.selector).on('click', function () {
            instance.Options.speed = $(this).next().height() * instance.Options.speedMod;
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                instance.Options.state = 'closed';
                animate($(this), instance.Options);
            }
            else {
                // find the open drawer, remove the class, move to the next element following it and hide it
                if (instance.Options.parent != '') {
                    var prevObj = $(instance.Options.parent).find('.open');
                }
                else {
                    var prevObj = $(this).parent().find('.open');
                }
                if (prevObj) {
                    $(prevObj).removeClass('open');
                    instance.Options.state = 'closed';
                    animate(prevObj, instance.Options);
                }
                // add the open class to this A, move to the next element (i.e UL) and show it
                $(this).addClass('open');
                instance.Options.state = 'open';
                animate($(this), instance.Options);
            }
            return false;
        });
        if (instance.Options.buildCallBack) {
            instance.Options.buildCallBack(instance.Options);
        }
    };
    this.Init = init;
    function openAll() {
        instance.Options.state = 'open';
        $(instance.Options.selector).addClass('open');
        animate(instance.Options.selector, instance.Options);
    };
    this.OpenAll = openAll;
    function closeAll() {
        instance.Options.state = 'closed';
        $(instance.Options.selector).removeClass('open');
        animate(instance.Options.selector, instance.Options);
    };
    this.CloseAll = closeAll;
};
interact.accordion.opt = function () {
    this.selector = '.accordion';
    this.start = 'closed';
    this.transition = 'slide';
    this.speedMod = 1;
    this.parent = '';
    this.buildCallBack = '';
    this.openCallBack = '';
    this.closeCallBack = '';
}
// TABS
interact.tabs = function (options) {
    var instance = this;
    instance.Options = new interact.tabs.opt();
    function animate(obj, opt, tab) {
        opt.obj = obj;
        switch (opt.transition) {
            case 'none':
                $(obj).hide(0, function () {
                    bindTabEvents();
                    $(this).removeClass(opt.currentTabClass);
                    $(opt.tabContentContainer + '>:nth-child(' + tab + ')').addClass(opt.currentTabClass).show(0);
                    if (opt.changeCallBack != '') {
                        opt.changeCallBack(opt);
                    }
                });
                break;
            case 'fade':
                $(obj).fadeOut(opt.transitionSpeed, function () {
                    bindTabEvents();
                    $(this).removeClass(opt.currentTabClass);
                    $(opt.tabContentContainer + '>:nth-child(' + tab + ')').addClass(opt.currentTabClass).fadeIn(opt.transitionSpeed);
                    if (opt.changeCallBack != '') {
                        opt.changeCallBack(opt);
                    }
                });
                break;
            case 'slide':
                $(obj).slideUp(opt.transitionSpeed, function () {
                    bindTabEvents();
                    $(this).removeClass(opt.currentTabClass);
                    $(opt.tabContentContainer + '>:nth-child(' + tab + ')').addClass(opt.currentTabClass).slideDown(opt.transitionSpeed);
                    if (opt.changeCallBack != '') {
                        opt.changeCallBack(opt);
                    }
                });
        }
        if (instance.Options.addHashValue) {
            if ($(opt.tabsContainer + '>:nth-child(' + tab + ')').attr('id')) {
                window.location.hash = "tab-" + $(opt.tabsContainer + '>:nth-child(' + tab + ')').attr('id');
            }
        }
    };
    function bindTabEvents() {
        $(instance.Options.tabsContainer).children().off('click.tab').off('click.blank').on('click.tab', function () {
            $(instance.Options.tabsContainer).children().off('click.tab');
            $(instance.Options.tabsContainer).children().on('click.blank', function () {
                return false;
            });
            $(this).siblings().removeClass(instance.Options.selectedTabClass);
            $(this).addClass(instance.Options.selectedTabClass);
            var tab = $(instance.Options.tabsContainer).children().index($(this)) + 1;
            animate($(instance.Options.tabContentContainer).children(' .' + instance.Options.currentTabClass), instance.Options, tab);
            return false;
        });
    }
    function setTabState(reset) {
        // hide all tab's content and only show the selected tab
        $(instance.Options.tabContentContainer).children().hide();
        if (reset) {
            $(instance.Options.tabsContainer).children().removeClass(instance.Options.selectedTabClass);
        }
        // if no tab has been set as selected in the markup, look to see if a hash value has been set in the URL and use this, otherwise assume it is the first tab
        if (!$(instance.Options.tabsContainer).children().hasClass(instance.Options.selectedTabClass)) {
            $(instance.Options.tabsContainer + '>:first-child').addClass(instance.Options.selectedTabClass);
            if (instance.Options.addHashValue && window.location.hash) {
                var tabToSelect = window.location.hash.split('-');
                $.each($(instance.Options.tabsContainer).children(), function () {
                    if ($(this).attr('id') == tabToSelect[1]) {
                        $(this).siblings().removeClass(instance.Options.selectedTabClass);
                        $(this).addClass(instance.Options.selectedTabClass);
                    }
                });
            }
        }
        var selected = $(instance.Options.tabsContainer + ' .' + instance.Options.selectedTabClass).index() + 1;
        $(instance.Options.tabContentContainer + '>:nth-child(' + selected + ')').addClass(instance.Options.currentTabClass).show();
    }
    this.SetTabState = setTabState;
    function init() {
        setTabState();
        // change the displayed content when a tab is clicked on
        bindTabEvents();
        if (instance.Options.buildCallBack) {
            instance.Options.buildCallBack(opt);
        }
    };
    this.Init = init;
};
interact.tabs.opt = function () {
    this.tabsContainer = '.tabs';
    this.tabContentContainer = '.tabContent';
    this.selectedTabClass = 'selectedTab';
    this.currentTabClass = 'currentTab';
    this.transition = 'none';
    this.transitionSpeed = 500;
    this.addHashValue = false;
    this.buildCallBack = '';
    this.changeCallBack = '';
}
// CAROUSEL
interact.carousel = function (options) {
    var instance = this;
    instance.Options = new interact.carousel.opt();
    function runCarousel(direction, opt, slide) {
        switch (direction) {
            case 'forward':
                opt.nextPosition = opt.currentPosition - opt.carouselItemWidth;
                if (opt.nextPosition <= opt.carouselForwardLimit + opt.carouselStart) {
                    nextItem(opt.nextPosition, 'yes', opt)
                }
                else {
                    nextItem(opt.nextPosition, 'no', opt)
                }
                break;
            case 'backward':
                opt.nextPosition = opt.currentPosition + opt.carouselItemWidth;
                if (opt.nextPosition >= opt.carouselBackwardLimit - opt.carouselStart) {
                    nextItem(opt.nextPosition, 'yes', opt)
                }
                else {
                    nextItem(opt.nextPosition, 'no', opt)
                }
                break;
            case 'scrollTo':
                opt.slidePosition = parseInt(slide) + (opt.carouselCount - 2);
                if (opt.difference) {
                    opt.nextPosition = (-(opt.slidePosition * opt.carouselItemWidth) - opt.difference);
                }
                else {
                    opt.nextPosition = (-(opt.slidePosition * opt.carouselItemWidth));
                }
                nextItem(opt.nextPosition, 'no', opt)
        }
    };
    function nextItem(nextPosition, limited, opt) {
        switch (limited) {
            case 'yes':
                $(opt.carouselWrap + ' > ' + opt.carouselContainer).animate({ left: nextPosition }, opt.slideSpeed, function () {
                    $(opt.carouselWrap + ' > ' + opt.carouselContainer).css({ left: opt.carouselStart });
                    opt.currentPosition = opt.carouselStart;
                    if (opt.addControls == true) {
                        bindControls(opt);
                    }
                    if (opt.slideCallBack) {
                        opt.slideCallBack(opt);
                    }
                });
                break;
            case 'no':
                $(opt.carouselWrap + ' > ' + opt.carouselContainer).animate({ left: nextPosition }, opt.slideSpeed, function () {
                    opt.currentPosition = nextPosition;
                    if (opt.addControls == true) {
                        bindControls(opt);
                    }
                    if (opt.slideCallBack) {
                        opt.slideCallBack(opt);
                    }
                });
        }
    };
    function bindControls(opt) {
        // binds and unbinds the click funtionality on the controls to prevent it breaking if the user clicks repeatedly once the animation has started
        $(opt.carouselWrap).find('.carouselControls .prev').off('click.prev').on('click.prev', function () {
            $(opt.carouselWrap).find('.carouselControls .prev').off('click.prev').on('click.prev', function () {
                return false;
            });
            prev();
            return false;
        });
        $(opt.carouselWrap).find('.carouselControls .next').off('click.next').on('click.next', function () {
            $(opt.carouselWrap).find('.carouselControls .next').off('click.next').on('click.next', function () {
                return false;
            });
            next();
            return false;
        });
        $(opt.carouselWrap).find('.carouselControls .scrollTo a').off('click.scroll').on('click.scroll', function () {
            $(opt.carouselWrap).find('.carouselControls .scrollTo a').off('click.scroll').on('click.scroll', function () {
                return false;
            });
            instance.ScrollTo($(this).text());
            $(opt.carouselWrap).find('.carouselControls .scrollTo a').removeClass('selected');
            $(this).addClass('selected');
            clearInterval(instance.Options.carouselTimer);
            return false;
        });
    };
    function reset() {
        $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer + ' > ' + instance.Options.carouselContents).removeAttr('style');
        $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).removeAttr('style');
        init();
    };
    this.Reset = reset;
    function init() {
        // Set core objects
        instance.Options.carouselItems = $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer + ' > ' + instance.Options.carouselContents);
        instance.Options.carouselItemWidth = $(instance.Options.carouselItems).outerWidth();
        $(instance.Options.carouselItems).css('width', instance.Options.carouselItemWidth);
        // Add all carousel content items to an array
        if (instance.Options.itemsCloned == true) {
            instance.Options.carouselCount = $(instance.Options.carouselItems).length / 3;
        }
        else {
            instance.Options.carouselCount = $(instance.Options.carouselItems).length;
        }
        // Add controls to the carousel if the option is set
        if (instance.Options.addControls == true && instance.Options.controlsSet == false) {
            instance.Options.controlsSet = true;
            var controlsContent = "<div class='carouselControls'>";
            controlsContent += "<a href='#' class='prev'>Previous</a><div class='scrollTo'>";
            for (var i = 1; i < (instance.Options.carouselCount + 1); i++) {
                controlsContent += "<a href='#'";
                if (i == instance.Options.startPosition) {
                    controlsContent += " class='selected'";
                }
                controlsContent += ">" + i + "</a>";
            }
            controlsContent += "</div><a href='#' class='next'>Next</a>";
            controlsContent += "</div>";
            switch (instance.Options.controlsLocation) {
                case 'before':
                    $(instance.Options.carouselWrap).prepend(controlsContent);
                    break;
                case 'after':
                    $(instance.Options.carouselWrap).append(controlsContent);
            }
            bindControls(instance.Options);
        };
        // Enable touch interactions if a touch screen device is being used
        if ('ontouchstart' in document.documentElement) {
            $(instance.Options.carouselWrap).attr('id', 'touch');
            var carouselWrap = document.getElementById('touch');
            $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).attr('id', 'touchContainer');
            var carouselContainer = document.getElementById('touchContainer');
            var startPoint;
            var endPoint;
            var endFunction = (function (e) {
                carouselWrap.removeEventListener("touchend", endFunction);
                if (startPoint > endPoint) {
                    var baseSpeed = instance.Options.slideSpeed;
                    instance.Options.slideSpeed = (startPoint - endPoint) / 2;
                    next();
                    instance.Options.slideSpeed = baseSpeed;
                }
                else {
                    var baseSpeed = instance.Options.slideSpeed;
                    instance.Options.slideSpeed = (endPoint - startPoint) / 2;
                    prev();
                    instance.Options.slideSpeed = baseSpeed;
                }
                addTouchEvents();
            });
            function addTouchEvents() {
                carouselContainer.addEventListener("touchstart", function touchStart(e) { startPoint = e.touches[0].pageX; }, false);
                carouselContainer.addEventListener("touchmove", function touchMove(e) { e.preventDefault(); endPoint = e.touches[0].pageX }, false);
                carouselContainer.addEventListener("touchend", endFunction);
            };
            addTouchEvents();
        }
        // Calculate and set the required width of the carousel container
        $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).width(((instance.Options.carouselCount) * 3) * instance.Options.carouselItemWidth);
        // Clone the carousel contents to the left and right of the actual items
        if (instance.Options.addControls == true && instance.Options.itemsCloned == false) {
            instance.Options.itemsCloned = true;
            $(instance.Options.carouselItems).clone().addClass('clone').prependTo(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer);
            $(instance.Options.carouselItems).clone().addClass('clone').appendTo(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer);
        }
        // Set the start point of the carousel to show the actual items with the second item centered within the wrapper
        // NOTE: The wrapper cannot be any larger than the width of 3 carousel items
        var wrapperWidth = $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).parent().width();
        if (wrapperWidth == (instance.Options.carouselItemWidth * 3)) {
            instance.Options.carouselStart = (-(instance.Options.carouselItemWidth * (instance.Options.carouselCount)));
            instance.Options.slidePosition = parseInt(instance.Options.startPosition) + (instance.Options.carouselCount - 2);
            var leftPosition = (-instance.Options.slidePosition * instance.Options.carouselItemWidth);
            $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).css({ left: leftPosition });
            instance.Options.currentPosition = leftPosition;
            // Calculate and set the movement limit of the carousel
            instance.Options.carouselForwardLimit = instance.Options.carouselStart;
            instance.Options.carouselBackwardLimit = instance.Options.carouselStart;
        }
        else {
            instance.Options.difference = ((instance.Options.carouselItemWidth * 3) - wrapperWidth) / 2;
            instance.Options.carouselStart = (-(instance.Options.carouselItemWidth * (instance.Options.carouselCount)) - instance.Options.difference);
            instance.Options.slidePosition = parseInt(instance.Options.startPosition) + (instance.Options.carouselCount - 2);
            var leftPosition = (-(instance.Options.slidePosition * instance.Options.carouselItemWidth) - instance.Options.difference);
            $(instance.Options.carouselWrap + ' > ' + instance.Options.carouselContainer).css({ left: leftPosition });
            instance.Options.currentPosition = leftPosition;
            // Calculate and set the movement limit of the carousel
            instance.Options.carouselForwardLimit = instance.Options.carouselStart + instance.Options.difference;
            instance.Options.carouselBackwardLimit = instance.Options.carouselStart - instance.Options.difference;
        }
        // Run the carousel if set in global variable - carouselAuto (true / false)
        if (instance.Options.carouselAuto) {
            instance.Options.carouselTimer = setInterval(function () {
                runCarousel(instance.Options.carouselDirection, instance.Options);
                if (instance.Options.addControls == true) {
                    if ($('#' + $(instance.Options.carouselWrap).attr('id') + ' .carouselControls .scrollTo .selected').next().length != 0) {
                        $('#' + $(instance.Options.carouselWrap).attr('id') + ' .carouselControls .scrollTo .selected').removeClass('selected').next().addClass('selected');
                    }
                    else {
                        $('#' + $(instance.Options.carouselWrap).attr('id') + ' .carouselControls .scrollTo a').removeClass('selected');
                        $('#' + $(instance.Options.carouselWrap).attr('id') + ' .carouselControls .scrollTo a:first-child').addClass('selected');
                    }
                }
            }, instance.Options.carouselInterval);
        };
        window.onresize = function () {
            var winWidth = window.innerWidth;
            reset();
        }
    };
    this.Init = init;
    function prev() {
        runCarousel('backward', instance.Options);
        clearInterval(instance.Options.carouselTimer);
        if (instance.Options.addControls == true) {
            if ($(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').prev().length == 0) {
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a').removeClass('selected');
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a:last-child').addClass('selected');
            }
            else {
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').removeClass('selected').prev().addClass('selected');
            }
        }
    };
    this.Prev = prev;
    function next() {
        runCarousel('forward', instance.Options);
        clearInterval(instance.Options.carouselTimer);
        if (instance.Options.addControls == true) {
            if ($(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').next().length == 0) {
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a').removeClass('selected');
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a:first-child').addClass('selected');
            }
            else {
                $(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').removeClass('selected').next().addClass('selected');
            }
        }
    };
    this.Next = next;
    function scrollTo(slide) {
        runCarousel('scrollTo', instance.Options, slide);
        clearInterval(instance.Options.carouselTimer);
    };
    this.ScrollTo = scrollTo;
    function auto() {
        instance.Options.carouselTimer = setInterval(function () {
            runCarousel(instance.Options.carouselDirection, instance.Options);
            if (instance.Options.addControls == true) {
                if ($(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').next().length == 0) {
                    $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a').removeClass('selected');
                    $(instance.Options.carouselWrap).find('.carouselControls .scrollTo a:first-child').addClass('selected');
                }
                else {
                    $(instance.Options.carouselWrap).find('.carouselControls .scrollTo .selected').removeClass('selected').next().addClass('selected');
                }
            }
        }, instance.Options.carouselInterval);
    };
    this.Auto = auto;
    function stop() {
        clearInterval(instance.Options.carouselTimer);
    };
    this.Stop = stop;
};
interact.carousel.opt = function () {
    this.carouselWrap = '.carousel'
    this.carouselContainer = 'ul';
    this.carouselContents = 'li';
    this.carouselAuto = false;
    this.carouselInterval = 5000;
    this.startPosition = 1;
    this.carouselDirection = 'forward';
    this.slideSpeed = 1000;
    this.addControls = false;
    this.controlsLocation = 'before';
    this.slideCallBack = '';
    this.itemsCloned = false;
    this.controlsSet = false;
}
// QUICKBOX
interact.quickbox = function (options) {
    var instance = this;
    instance.Options = new interact.quickbox.opt();

    function closeBox(opt) {
        $(opt.quickboxContainer).fadeOut(opt.fadeSpeed, function () {
            $(this).empty();
            $(this).css('margin-top', '');
            $('#' + opt.backgroundContainerID).remove();
            if (instance.Options.closeCallBack) {
                instance.Options.closeCallBack(opt);
            }
        });
    };
    function init() {
        $(instance.Options.quickboxActivator).on('click', function () {
            if (!$('#' + instance.Options.backgroundContainerID).length) {
                $(instance.Options.quickboxContainer).before("<div id='" + instance.Options.backgroundContainerID + "'></div>");
            }
            if ($(this).is('img')) {
                // if the images links off to a larger version show this in the popup, otherwise just show the original image
                if ($(this).parent('a').length > 0) {
                    var imageLarge = $(this).parent().attr('href');
                }
                else {
                    var imageLarge = $(this).attr('src');
                }
                // generate the popup window content
                $(instance.Options.quickboxContainer).append("<div class='popUpContent'><a id='" + instance.Options.closeLinkID + "' href='#'>Close</a><img src='" + imageLarge + "' alt='" + $(this).attr('alt') + "'/></div>");
                $('.popUpContent img').load(function () {
                    $('#' + instance.Options.backgroundContainerID).fadeIn(instance.Options.fadeSpeed);
                    $(instance.Options.quickboxContainer).fadeIn(instance.Options.fadeSpeed, function () {
                        if (instance.Options.openCallBack) {
                            instance.Options.openCallBack(instance.Options);
                        }
                    });
                    // set width of popup box to that of the loaded image
                    $('.popUpContent').css('width', $(this).innerWidth());
                    if (instance.Options.topIndent == 'middle') {
                        // vertically center the popup, if the popup is too high for the window fix it 20px from the top
                        if (($(this).innerHeight() + 20) <= $(window).height()) {
                            var centeredIndent = ($(window).height() / 2) - ($(this).innerHeight() / 2);
                        }
                        else {
                            var centeredIndent = 20;
                        }
                        $(instance.Options.quickboxContainer).css('margin-top', centeredIndent + $(window).scrollTop());
                    }
                    else {
                        $(instance.Options.quickboxContainer).css('margin-top', instance.Options.topIndent + $(window).scrollTop());
                    }
                });
                $('#' + instance.Options.closeLinkID).on('click.close', function () {
                    closeBox(instance.Options);
                    return false;
                });
                $('#' + instance.Options.backgroundContainerID).on('click.close', function () {
                    closeBox(instance.Options);
                    return false;
                });
            }
            else {
                $(instance.Options.quickboxContainer).load($(this).attr('href'), function () {
                    $('#' + instance.Options.backgroundContainerID).fadeIn(instance.Options.fadeSpeed);
                    $(instance.Options.quickboxContainer).fadeIn(instance.Options.fadeSpeed, function () {
                        if (instance.Options.openCallBack) {
                            instance.Options.openCallBack(instance.Options);
                        }
                    });
                    if (instance.Options.topIndent == 'middle') {
                        // vertically center the popup, if the popup is too high for the window fix it 20px from the top
                        var popUpHeight = $(instance.Options.quickboxContainer + ' .popUpContent').innerHeight();
                        if ((popUpHeight + 20) <= $(window).height()) {
                            var centeredIndent = ($(window).height() / 2) - (popUpHeight / 2);
                        }
                        else {
                            var centeredIndent = 20;
                        }
                        $(instance.Options.quickboxContainer).css('margin-top', centeredIndent + $(window).scrollTop());
                    }
                    else {
                        $(instance.Options.quickboxContainer).css('margin-top', instance.Options.topIndent + $(window).scrollTop());
                    }
                });
            }
            return false;
        });
    };
    this.Init = init;
    function close() {
        $('#' + instance.Options.closeLinkID).on('click.close', function () {
            closeBox(instance.Options);
            return false;
        });
        $('#' + instance.Options.backgroundContainerID).on('click.close', function () {
            closeBox(instance.Options);
            return false;
        });
    }
    this.Close = close;
};
interact.quickbox.opt = function () {
    this.quickboxContainer = '#quickbox';
    this.quickboxActivator = '.quickbox';
    this.backgroundContainerID = 'background';
    this.closeLinkID = 'close';
    this.fadeSpeed = 500;
    this.topIndent = 'middle';
    this.openCallBack = '';
    this.closeCallBack = '';

}
// SLIDESHOW
interact.slideshow = function (options) {
    var instance = this;
    instance.Options = new interact.slideshow.opt();
    function rotateImages(opt) {
        var currImg = $(opt.slideshowContainer + ' img.' + opt.currentImageClass);
        var nextImg = currImg.next();
        if (nextImg.length == 0) {
            nextImg = $(opt.slideshowContainer + ' img:first');
        }
        currImg.removeClass(opt.currentImageClass).addClass(opt.previousImageClass);
        nextImg.css({ opacity: 0.0 }).addClass(opt.currentImageClass).animate({ opacity: 1.0 }, opt.animationSpeed, function () {
            currImg.removeClass(opt.previousImageClass);
        });
    };
    function init() {
        // set absolute position in JS so that it falls back to a simple list when JS is disabled
        $(instance.Options.slideshowContainer + ' img').css('position', 'absolute');
        setInterval(function () {
            rotateImages(instance.Options);
        }, instance.Options.intervalSpeed);
    };
    this.Init = init;
};
interact.slideshow.opt = function () {
    this.slideshowContainer = '#slideshow';
    this.currentImageClass = 'current';
    this.previousImageClass = 'previous';
    this.animationSpeed = 1000;
    this.intervalSpeed = 5000;
}