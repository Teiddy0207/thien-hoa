(function () {
  'use strict';

  function closeMenu(hamburgerMenu, mainMenu) {
    hamburgerMenu.classList.remove('active');
    mainMenu.classList.remove('active');
    hamburgerMenu.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('menu-open');
  }

  function openMenu(hamburgerMenu, mainMenu) {
    hamburgerMenu.classList.add('active');
    mainMenu.classList.add('active');
    hamburgerMenu.setAttribute('aria-expanded', 'true');
    document.body.classList.add('menu-open');
  }

  function initHamburgerMenu() {
    var hamburgerMenu = document.getElementById('hamburgerMenu');
    var mainMenu = document.getElementById('mainMenu');

    if (!hamburgerMenu || !mainMenu) return;

    hamburgerMenu.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var isOpen = hamburgerMenu.classList.contains('active') || mainMenu.classList.contains('active');
      if (isOpen) {
        closeMenu(hamburgerMenu, mainMenu);
      } else {
        openMenu(hamburgerMenu, mainMenu);
      }
    });

    mainMenu.addEventListener('click', function (event) {
      var target = event.target;
      if (target && target.tagName === 'A') {
        closeMenu(hamburgerMenu, mainMenu);
      }
    });

    document.addEventListener('click', function (event) {
      if (hamburgerMenu.contains(event.target)) return;
      if (!mainMenu.classList.contains('active')) return;
      if (mainMenu.contains(event.target)) return;
      closeMenu(hamburgerMenu, mainMenu);
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 768) {
        closeMenu(hamburgerMenu, mainMenu);
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeMenu(hamburgerMenu, mainMenu);
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHamburgerMenu);
  } else {
    initHamburgerMenu();
  }
})();
