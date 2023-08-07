jQuery(function ($) {
    let iframe = document.getElementById("jw-pagefactory-view");
    let canvasArea = $('.canvas-area'),
        canvasAreaId = canvasArea.attr('data-id'),
        bubbleColor = canvasArea.attr('data-bubble-color');
    let options = {
        radius: 45,
        densety: 0.1,
        color: bubbleColor,
        // color: 'random',
        clearOffset: .3
    }
    if(iframe) {
        if (iframe.attachEvent) {
            iframe.attachEvent("onload", function() {
                //iframe加载完成后你需要进行的操作
                initCanvas();
            });
        } else {
            iframe.onload = function(n) {
                //iframe加载完成后你需要进行的操作
                initCanvas();
            };
        }
    }else {
        initCanvas();
    }

    function initCanvas() {
        if(iframe) {
            canvasArea = $(window.frames["jw-pagefactory-view"].document).find('.canvas-area')
            canvasAreaId = canvasArea.attr('data-id')
            bubbleColor = canvasArea.attr('data-bubble-color')
            options.color = bubbleColor
        }
        if(canvasAreaId) {
            canvasAirBubble(canvasAreaId, options);
            $(window).resize(function() {
                canvasAirBubble(canvasAreaId, options);
            });
        }
    }

    function canvasAirBubble(domId, options) {
        var curDom = $('#' + domId),
            width = curDom.width(),
            height = curDom.height(),
            canvas, ctx, target,
            animateHeader = true,
            circles = [],
            settings = $.extend({
                color: 'rgba(255,255,255,.4)',
                radius: 20,
                densety: 0.3,
                clearOffset: 0.2
            }, options);
        if(iframe) {
            curDom = $(window.frames["jw-pagefactory-view"].document).find('#' + domId)
            width = curDom.width()
            height = curDom.height()
        }
        initContainer();
        function initContainer() {
            target = {
                x: 0,
                y: height
            };
            initCanvas();
            canvas = document.getElementById('canvas-' + domId);
            if(iframe) {
                canvas = window.frames["jw-pagefactory-view"].document.getElementById('canvas-' + domId)
                // console.log('canvas', canvas)
            }
            if(canvas) {
                canvas.width = width;
                canvas.height = height;
                ctx = canvas.getContext('2d');
                for (var x = 0; x < width * settings.densety; x++) {
                    var c = new Circle();
                    circles.push(c)
                }
                animate()
            }
        }

        function initCanvas() {
            var canvasElement = document.createElement('canvas');
            canvasElement.id = 'canvas-' + domId;
            curDom.html(canvasElement);
            // curDom.append(canvasElement)
        }

        function animate() {
            if (animateHeader) {
                ctx.clearRect(0, 0, width, height);
                for (var i in circles) {
                    circles[i].draw()
                }
            }
            requestAnimationFrame(animate)
        }

        function randomColor() {
            return "rgba(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + "," +
                Math.floor(Math.random() * 255) + "," + Math.random().toPrecision(2) + ")"
            // return "rgba(255, 255, 255, " + Math.random().toPrecision(2) + ")"
        }

        function Circle() {
            var self = this;
            (function() {
                self.pos = {};
                init()
            })();

            function init() {
                self.pos.x = Math.random() * width;
                self.pos.y = height + Math.random() * 100;
                self.alpha = 0.1 + Math.random() * settings.clearOffset;
                self.scale = 0.1 + Math.random() * 0.3;
                self.speed = Math.random();
                if (settings.color == 'random') {
                    self.color = randomColor()
                } else {
                    self.color = settings.color
                }
            }

            this.draw = function() {
                if (self.alpha <= 0) {
                    init()
                }
                self.pos.y -= self.speed;
                self.alpha -= 0.0005;
                ctx.beginPath();
                ctx.arc(self.pos.x, self.pos.y, self.scale * settings.radius, 0, 2 * Math.PI, false);
                ctx.fillStyle = self.color;
                ctx.fill();
                ctx.closePath()
            }
        }
    }
})

