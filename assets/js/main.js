/**
 * Main
 */

'use strict';

(function () {
  // Initialize menu
  //-----------------

  const layoutMenuElements = document.querySelectorAll('#layout-menu');

  layoutMenuElements.forEach((element) => {
    const menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });

    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive(false);
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  const menuTogglers = document.querySelectorAll('.layout-menu-toggle');

  menuTogglers.forEach((item) => {
    item.addEventListener('click', (event) => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  const addToggleClass = () => {
    if (!Helpers.isSmallScreen()) {
      document.querySelector('.layout-menu-toggle').classList.add('d-block');
    }
  };

  const delay = (elem, callback) => {
    let timeout = null;

    elem.onmouseenter = () => {
      timeout = setTimeout(callback, Helpers.isSmallScreen() ? 0 : 300);
    };

    elem.onmouseleave = () => {
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };

  const layoutMenu = document.getElementById('layout-menu');

  if (layoutMenu) {
    delay(layoutMenu, addToggleClass);
  }

  // Display in main menu when menu scrolls
  const menuInnerContainer = document.querySelector('.menu-inner');
  const menuInnerShadow = document.querySelector('.menu-inner-shadow');

  if (menuInnerContainer && menuInnerShadow) {
    menuInnerContainer.addEventListener('ps-scroll-y', () => {
      menuInnerShadow.style.display = (menuInnerContainer.querySelector('.ps__thumb-y').offsetTop) ? 'block' : 'none';
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach((tooltipTriggerEl) => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = (e) => {
    const accordionItem = e.target.closest('.accordion-item');
    accordionItem.classList.toggle('active', e.type === 'show.bs.collapse');
  };

  const accordionTriggerList = document.querySelectorAll('.accordion');

  accordionTriggerList.forEach((accordionTriggerEl) => {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu), return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();
