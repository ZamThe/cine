 const slider = document.querySelector(".slider");
        const sliderItems = document.querySelectorAll(".slider img");
        const sliderCount = sliderItems.length;
        let currentIndex = 0;

        function nextSlide() {
            currentIndex = (currentIndex + 1) % sliderCount;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + sliderCount) % sliderCount;
            updateSlider();
        }

        function updateSlider() {
            const translateX = -currentIndex * 100;
            slider.style.transform = `translateX(${translateX}%)`;
        }

        // Agregar la función para avanzar automáticamente cada 3 segundos
        setInterval(nextSlide, 3000); // Cambiar de imagen cada 3 segundos


        /*
* 
* Credits to https://css-tricks.com/long-dropdowns-solution/
*
*/

var maxHeight = 400;

$(function(){

    $(".dropdown > li").hover(function() {
    
         var $container = $(this),
             $list = $container.find("ul"),
             $anchor = $container.find("a"),
             height = $list.height() * 1.1,       // make sure there is enough room at the bottom
             multiplier = height / maxHeight;     // needs to move faster if list is taller
        
        // need to save height here so it can revert on mouseout            
        $container.data("origHeight", $container.height());
        
        // so it can retain it's rollover color all the while the dropdown is open
        $anchor.addClass("hover");
        
        // make sure dropdown appears directly below parent list item    
        $list
            .show()
            .css({
                paddingTop: $container.data("origHeight")
            });
        
        // don't do any animation if list shorter than max
        if (multiplier > 1) {
            $container
                .css({
                    height: maxHeight,
                    overflow: "hidden"
                })
                .mousemove(function(e) {
                    var offset = $container.offset();
                    var relativeY = ((e.pageY - offset.top) * multiplier) - ($container.data("origHeight") * multiplier);
                    if (relativeY > $container.data("origHeight")) {
                        $list.css("top", -relativeY + $container.data("origHeight"));
                    };
                });
        }
        
    }, function() {
    
        var $el = $(this);
        
        // put things back to normal
        $el
            .height($(this).data("origHeight"))
            .find("ul")
            .css({ top: 0 })
            .hide()
            .end()
            .find("a")
            .removeClass("hover");
    
    });  
    
});
