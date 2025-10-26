(function($) {
  'use strict';

  // مختصات مرکز استان‌ها برای نمایش نام
  const provincePositions = {
    'khorasan-razavi': { dx: 0, dy: 0 },
    'sistan-baluchestan': { dx: -15, dy: 40 },
    'azerbaijan-west': { dx: 0, dy: 73 },
    'hormozgan': { dx: 10, dy: -20 },
    'semnan': { dx: 20, dy: 20 },
    'mazandaran': { dx: 0, dy: 5 },
    'qazvin': { dx: 3, dy: 0 },
    'tehran': { dx: 0, dy: 0 },
    'isfahan': { dx: 0, dy: 0 },
    'fars': { dx: 0, dy: 0 },
    'khuzestan': { dx: 0, dy: 0 },
    'azerbaijan-east': { dx: 0, dy: 0 },
    'kermanshah': { dx: 0, dy: 0 },
    'gilan': { dx: 0, dy: 0 },
    'bushehr': { dx: 0, dy: 0 },
    'hamedan': { dx: 0, dy: 0 },
    'chaharmahal-bakhtiari': { dx: 0, dy: 0 },
    'lorestan': { dx: 0, dy: 0 },
    'ilam': { dx: 0, dy: 0 },
    'kohgiluyeh-boyerahmad': { dx: 0, dy: 0 },
    'khorasan-north': { dx: 0, dy: 0 },
    'khorasan-south': { dx: 0, dy: 0 },
    'alborz': { dx: 0, dy: 0 },
    'ardabil': { dx: 0, dy: 0 },
    'golestan': { dx: 0, dy: 0 },
    'qom': { dx: 0, dy: 0 },
    'kurdistan': { dx: 0, dy: 0 },
    'kerman': { dx: 0, dy: 0 },
    'markazi': { dx: 0, dy: 0 },
    'yazd': { dx: 0, dy: 0 },
    'zanjan': { dx: 0, dy: 0 }
  };

  function initIranMap() {
    $('.iran-map-elementor-wrapper').each(function() {
      const $wrapper = $(this);
      const $container = $wrapper.find('.iran-map-container');
      const provincesData = $wrapper.data('provinces');
      const labelHoverColor = $wrapper.data('hover-color') || '#FFFFFF';
      
      if (!provincesData || Object.keys(provincesData).length === 0) {
        return;
      }

      // فعال کردن استان‌های انتخاب شده
      Object.keys(provincesData).forEach(function(provinceKey) {
        const $path = $container.find('.province path.' + provinceKey);
        if ($path.length) {
          $path.addClass('active');
        }
      });

      // اضافه کردن نام استان‌ها به نقشه
      Object.keys(provincesData).forEach(function(provinceKey) {
        const provinceData = provincesData[provinceKey];
        const $pathElement = $container.find('.province path.' + provinceKey);
        
        if (!$pathElement.length || !$pathElement[0].getBBox) return;

        const bbox = $pathElement[0].getBBox();
        const position = provincePositions[provinceKey] || { dx: 0, dy: 0 };
        
        // استفاده از offset های سفارشی کاربر
        const offsetX = provinceData.label_offset_x || 0;
        const offsetY = provinceData.label_offset_y || 0;
        
        const centerX = bbox.x + bbox.width / 2 + position.dx + offsetX;
        const centerY = bbox.y + bbox.height / 2 + position.dy + offsetY;

        // ساخت المنت text برای SVG - نمایش نام اصلی استان
        const svgNS = 'http://www.w3.org/2000/svg';
        const textElement = document.createElementNS(svgNS, 'text');
        textElement.textContent = provinceData.name; // نام اصلی استان
        textElement.setAttribute('x', centerX);
        textElement.setAttribute('y', centerY);
        textElement.setAttribute('class', 'city-name ' + provinceKey + '-label');

        const $svg = $pathElement.closest('svg');
        if ($svg.length) {
          $svg[0].appendChild(textElement);
        }
      });

      // رویداد هاور برای نمایش تولتیپ
      $container.find('.province path.active').hover(
        function() {
          const provinceClass = $(this).attr('class').split(' ').find(c => provincesData[c]);
          if (!provinceClass) return;

          const data = provincesData[provinceClass];
          // نمایش متن تولتیپ سفارشی و شماره تماس
          const tooltipHTML = '<span class="tooltip-name">' + data.tooltip_text + '</span>' +
                            '<span class="tooltip-phone">' + data.phone + '</span>';
          
          $container.find('.show-title').html(tooltipHTML).css('display', 'block');
          
          // تغییر رنگ نام استان
          $container.find('.' + provinceClass + '-label').css('fill', labelHoverColor);
        },
        function() {
          $container.find('.show-title').css('display', 'none').html('');
          
          const provinceClass = $(this).attr('class').split(' ').find(c => provincesData[c]);
          if (provinceClass) {
            $container.find('.' + provinceClass + '-label').css('fill', '');
          }
        }
      );

      // حرکت تولتیپ با موس
      $container.mousemove(function(e) {
        const $tooltip = $(this).find('.show-title');
        if ($tooltip.css('display') === 'block') {
          const offset = $(this).offset();
          const x = e.pageX - offset.left + 20;
          const y = e.pageY - offset.top - 10;
          $tooltip.css({
            left: x + 'px',
            top: y + 'px'
          });
        }
      });

      // ریسپانسیو برای SVG
      function resizeMap() {
        const $svg = $container.find('svg');
        const width = $container.width();
        
        if (width > 768) {
          $svg.css('height', '600px');
        } else if (width > 480) {
          $svg.css('height', '400px');
        } else {
          $svg.css('height', '300px');
        }
      }

      resizeMap();
      $(window).on('resize', resizeMap);
    });
  }

  // اجرا پس از بارگذاری DOM
  $(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/iran-map.default', function($scope) {
      initIranMap();
    });
  });

  // برای پیش‌نمایش در ویرایشگر المنتور
  $(document).ready(function() {
    if (typeof elementor !== 'undefined') {
      initIranMap();
    }
  });

})(jQuery);