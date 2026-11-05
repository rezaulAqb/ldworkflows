(function () {
  'use strict';

  var toggle = document.querySelector('.ldw-nav-toggle');
  var mobile = document.querySelector('.ldw-nav-mobile');
  if (toggle && mobile) {
    toggle.addEventListener('click', function () {
      var open = mobile.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }
})();
